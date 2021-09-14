<?php

namespace App;

class Mono {

    private float $coefficient;
    private float $power;

    public function __construct($coefficient, $power)
    {
        $this->coefficient = $coefficient;
        $this->power = $power;
    }

    public function getCoefficient()
    {
        return $this->coefficient;
    }

    public function getPower()
    {
        return $this->power;
    }

    public function toString() :string {
        $coefficient = $this->coefficient;
        $power = $this->power;

        $answer = '';

        if ($coefficient == 1) {
            $answer .= '+';
            if($power == 0){
                $answer .= '1';
            }else if ($power == 1) {
                $answer .= 'x';
            } elseif ($power > 1) {
                $answer .= 'x^' . "$power";
            }
        } elseif ($coefficient == -1) {
            $answer .= '-';
            if($power == 0){
                $answer .= 1;
            }else if ($power == 1) {
                $answer .= 'x';
            } elseif ($power > 1) {
                $answer .= 'x^' . "$power";
            }
        } elseif ($coefficient < 0) {
            $answer .= "$coefficient";
            if ($power == 1) {
                $answer .= 'x';
            } elseif ($power > 1) {
                $answer .= 'x^' . "$power";
            }
        } elseif ($coefficient > 0) {
            $answer .= '+' . "$coefficient";
            if ($power == 1) {
                $answer .= 'x';
            } elseif ($power > 1) {
                $answer .= 'x^' . "$power";
            }
        }

        return $answer;
    }

    public function answerForValue(float $value) :float {
        return $this->coefficient * ($value ** $this->power);
    }

    public function derivative() :Mono {
        $coefficient = $this->coefficient * $this->power;
        $power = $this->power - 1;

        return (new Mono($coefficient, $power));
    }

    public function multiplication(Mono $a) :Mono 
    {
        $coefficient = $this->getCoefficient() * $a->getCoefficient();
        $power = $this->getPower() + $a->getPower();
         
        return new Mono($coefficient, $power);
     }
}