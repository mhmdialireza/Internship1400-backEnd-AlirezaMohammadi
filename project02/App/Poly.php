<?php

namespace App;

use App\Mono;

class Poly{
    
    private array $monos;

    function __construct(array $monos = [])
    {
        $this->monos = $monos;
    }

    public function getMonos()
    {
        return $this->monos;
    }
    
    public function addMono(Mono $mono)
    {
        array_push($this->monos, $mono);
    }

    public function makePoly(array $strings)
    {
        $temps = [];

        foreach ($strings as $string) {
            array_push($temps, explode('x^',$string));
        }

        foreach ($temps as $temp) {
            array_push($this->monos, new Mono($temp[0], $temp[1]));
        }
    }
    
    public function simplify() :void 
    {
        $indexes = [];

        foreach ($this->monos as $index1 => &$mono1) {
            foreach ($this->monos as $index2 => &$mono2) {
                if (!in_array($index1, $indexes) &&
                    !in_array($index2, $indexes) &&
                    $index1 < $index2 && 
                    $mono1->getPower() == $mono2->getPower()) {

                    $newCoefficient = $mono1->getCoefficient() + $mono2->getCoefficient();
                    $newMono = new Mono($newCoefficient, $mono1->getPower());
                    
                    $this->monos[$index1] = $newMono;

                    $indexes[] = $index2;
                }
            }
        }
        
        foreach ($this->monos as $index => $mono) {
            if (in_array($index, $indexes)) {
                unset($this->monos[$index]);
            }
        }
        
        $this->monos = array_values($this->monos);
    }

    public function ordering() :void 
    {
        foreach ($this->monos as $index1 => &$mono1) {
            foreach ($this->monos as $index2 => &$mono2) {
                if ($index1 < $index2 && 
                    $mono1->getPower() < $mono2->getPower()) {

                    $temp = $this->monos[$index1];
                    $this->monos[$index1] = $this->monos[$index2];
                    $this->monos[$index2] = $temp;
                }
            }
        }
        // var_dump($this->monos);
    }

    public function toString() :string 
    {
        
        $polyString = '';

        foreach ($this->monos as $mono) {
            $polyString .= $mono->toString();
        }
       
        return ($polyString) ? $polyString : '0' ;

    }

    public function answerForValue(float $value) :float {
        $answer = 0;
        foreach ($this->monos as $mono) {
            $answer += $mono->answerForValue($value);
        }
        return $answer;
    }

    public function derivative() :Poly {
        $newPoly = new Poly();

        foreach ($this->monos as $mono) {
            $newPoly->addMono($mono->derivative());
        }

        return $newPoly;
    }

    public function sum(Poly $poly) :Poly {

        $newPoly = new Poly();

        foreach ($this->monos as $mono) {
            $newPoly->addMono($mono);                  
        }

        foreach ($poly->monos as $mono) {
            $newPoly->addMono($mono);                  
        }

        $newPoly->simplify();
        $newPoly->ordering();
        
        return $newPoly;
    }

    public function submission(Poly $poly) :Poly {
        
        $newPoly = new Poly();

        foreach ($this->monos as $mono) {
            $newPoly->addMono($mono);    
        }
        
        foreach ($poly->monos as $mono) {
            $newMono = new Mono(-1 * $mono->getCoefficient(),$mono->getPower());
            $newPoly->addMono($newMono);                  
        }
        $newPoly->simplify();
        $newPoly->ordering();
        
        return $newPoly;
    }

    public function multiplication(Poly $poly) :Poly {
        
        $newPoly = new Poly();
        
        foreach ($this->monos as $mono1) {
            foreach ($poly->getMonos() as $mono2) {
               $newPoly->addMono($mono1->multiplication($mono2));
            }
        }

        $newPoly->simplify();
        $newPoly->ordering();

        return $newPoly;
    }
}