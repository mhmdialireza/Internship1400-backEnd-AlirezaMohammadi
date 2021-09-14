<?php
namespace App\Traits;

use Illuminate\Http\Request;
use App\Http\Controllers\V1\Types\Mono;
use App\Http\Controllers\V1\Types\Poly;
use App\Http\Controllers\V1\Analyzing\Analyzor;
use App\Http\Controllers\V1\Operation\PolyOperation;

trait BaseResponse
{
    private Analyzor $analyzor;
    private PolyOperation $polyOperation;

    public function __construct()
    {
        $this->analyzor = new Analyzor();
        $this->polyOperation = new PolyOperation();
    }

    protected function isValidString(string|null $string)
    {
        if(
            $string &&
            strlen($string) == 1 &&
            ($string == '-' || $string == '+')
        ){
            return false;
        }

        preg_match('/((([\+\-])(?![\+\-]))?\d?((x(?!x)(?!\d))((\^(?=\d))((\d)(?!x)))?)?)+/',$string,$matchs);
        if($matchs[0] != $string){
            return false;
        }

        if (
            $string[0] != '-' &&
            $string[0] != '+'
        ){
            $string = '+' . $string;
        }

        $string = str_replace(['-', '+'], [' -', ' +'], $string);

        $strings = explode(' ', $string);

        unset($strings[0]);
        $strings = array_values($strings);

        foreach ($strings as $string) {
            if(substr_count($string,'x')>1){
                return false;
            }
        }
        return true;
    }

    protected function makePolyByRequestMonos(Request $request, string $monosName = 'monos') :Poly
    {
        $poly = new Poly();
        foreach ($request->$monosName as $mono) {
            $poly->addMono(new Mono($mono['coefficient'],$mono['power']));
        }
        $poly->simplify();
        $poly->ordering();
        return $poly;
    }

    private function getArrayMonos(Poly $poly) :array
    {
        $monos = [];
        foreach ($poly->getMonos() as $mono) {
            $monos[] = [
                'coefficient' => $mono->getCoefficient(),
                'power' => $mono->getPower()
            ];
        }
        return $monos;
    }

    public function checkSimplifyAndOrdering(Request $request, Poly $poly)
    {
        if($request->simplify ?? 0)
        {
            $poly->simplify();
        }

        if($request->ordering ?? 0)
        {
            $poly->ordering();
        }
    }
}
