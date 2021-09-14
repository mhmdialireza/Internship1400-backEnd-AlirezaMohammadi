<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Controllers\V1\Types\Mono;
use App\Http\Controllers\V1\Types\Poly;

class PolyService
{
//    public function __construct(
//        private Poly $poly
//    ){}

    public function makePolyByRequestMonos(array $monos) :Poly
    {
        $newPoly = new Poly();
        foreach ($monos as $mono) {
            $newPoly->addMono(new Mono($mono['coefficient'],$mono['power']));
        }
        return $newPoly;
    }

    public function makePolyByRequestMonos2(Request $request, string $monosName = 'monos') :Poly
    {
        $newPoly = new Poly();
        foreach ($request->$monosName as $mono) {
            $newPoly->addMono(new Mono($mono['coefficient'],$mono['power']));
        }
        return $newPoly;
    }

    public function getArrayMonos(Poly $poly) :array
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
}
