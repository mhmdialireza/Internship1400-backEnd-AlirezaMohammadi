<?php
namespace App\Services;

use App\Http\Controllers\V1\Types\Mono;
use App\Http\Controllers\V1\Types\Poly;

class AnalyzingService
{
//    private Poly $poly;

//    public function __construct(Poly $poly)
//    {
//        $this->poly = $poly;
//    }

    public function getPolyFromString(string $string) :Poly
    {
        $string = $this->checkFirstOfString($string);
        $string = $this->makeSpace($string);
        $string = $this->makeCoefficientOne($string);

        $strings = $this->explodeFromSpace($string);
        $strings = $this->repairPowers($strings);
        $strings = $this->buildMonos($strings);

        $newPoly = new Poly($strings);

        $newPoly->simplify();
        $newPoly->ordering();

        return $newPoly;
    }

    private function checkFirstOfString($string)
    {
        if (
            $string[0] != '-' &&
            $string[0] != '+'
        ){
            $string = '+' . $string;
        }
        return $string;
    }

    private function makeSpace($string)
    {
        return str_replace(['-', '+'], [' -', ' +'], $string);
    }

    private function makeCoefficientOne($string)
    {
        return str_replace(['-x', '+x'], ['-1x', '+1x'], $string);
    }

    private function explodeFromSpace($string)
    {
        $strings = explode(' ', $string);
        unset($strings[0]);
        return array_values($strings);
    }

    private function repairPowers($strings)
    {
        foreach ($strings as $key => $mono) {
            if (
                strpos($mono, 'x') &&
                !strpos($mono, '^')
            ) {
                $strings[$key] = $mono . '^1';
            } elseif (!strpos($mono, 'x')) {
                $strings[$key] = $mono . 'x^0';
            }
        }
        return $strings;
    }

    private function buildMonos($strings)
    {
        $temps = [];
        foreach ($strings as $string) {
            array_push($temps, explode('x^',$string));
        }

        $monos = [];
        foreach ($temps as $temp) {
            array_push($monos, new Mono($temp[0], $temp[1]));
        }

        return $monos;
    }
}
