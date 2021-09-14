<?php

namespace App\Sevices;

use App\Http\Controllers\V1\Types\Mono;
use App\Http\Controllers\V1\Types\Poly;

class AnalyzingService
{
    public function getPolyFromText(string $text): Poly
    {
        $text = $this->checkFirstOfString($text);
        $text = $this->makeSpace($text);
        $text = $this->makeCoefficientOne($text);
        $array = $this->explodeFromSpace($text);
        $array = $this->repairPowers($array);
        $array = $this->buildMonos($array);

        $poly  = new Poly($array);
        $poly->simplify();
        $poly->ordering();

        return $poly;
    }

    private function explodeFromSpace(string $string) :array
    {
        $strings = explode(' ', $string);
        unset($strings[0]);
        return array_values($strings);
    }

    private function repairPowers(array $strings) :array
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

    private function buildMonos(array $strings) :array
    {
        $temps = [];
        foreach ($strings as $string) {
            array_push($temps, explode('x^', $string));
        }

        $monos = [];
        foreach ($temps as $temp) {
            array_push($monos, new Mono($temp[0], $temp[1]));
        }

        return $monos;
    }

    private function checkFirstOfString(string $string)
    {
        if (
            $string[0] != '-' &&
            $string[0] != '+'
        ) {
            $string = '+' . $string;
        }
        return $string;
    }

    private function makeSpace(string $string) :string
    {
        return str_replace(['-', '+'], [' -', ' +'], $string);
    }

    private function makeCoefficientOne(string $string) :string
    {
        return str_replace(['-x', '+x'], ['-1x', '+1x'], $string);
    }
}
