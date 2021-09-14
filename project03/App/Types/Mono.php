<?php

namespace App\Types;

use App\Contracts\CusotmTypeInterface;
use App\Contracts\MonoInterface;

class Mono implements CusotmTypeInterface, MonoInterface
{
    public function __construct(
        private float $coefficient = 0, 
        private float $power = 0
    ) {}

    public function getCoefficient()
    {
        return $this->coefficient;
    }

    public function getPower()
    {
        return $this->power;
    }

    public function __toString() :string 
    {
        $coefficient = $this->coefficient;
        $power = $this->power;
        $toString = '';

        if ($coefficient == 1) {
            $toString .= '+';
            if($power == 0){
                $toString .= '1';
            }else if ($power == 1) {
                $toString .= 'x';
            } elseif ($power > 1) {
                $toString .= 'x^' . "$power";
            }
        } elseif ($coefficient == -1) {
            $toString .= '-';
            if($power == 0){
                $toString .= 1;
            }else if ($power == 1) {
                $toString .= 'x';
            } elseif ($power > 1) {
                $toString .= 'x^' . "$power";
            }
        } elseif ($coefficient < 0) {
            $toString .= "$coefficient";
            if ($power == 1) {
                $toString .= 'x';
            } elseif ($power > 1) {
                $toString .= 'x^' . "$power";
            }
        } elseif ($coefficient > 0) {
            $toString .= '+' . "$coefficient";
            if ($power == 1) {
                $toString .= 'x';
            } elseif ($power > 1) {
                $toString .= 'x^' . "$power";
            }
        }

        return $toString;
    }

    public function getNegative() :Mono
    {
        return new Mono(-1 * $this->coefficient, $this->power);
    }
}