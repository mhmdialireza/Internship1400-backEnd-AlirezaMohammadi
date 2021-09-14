<?php
namespace App\Http\Controllers\V1\Types;

use App\Contracts\CusotmTypeInterface;
use App\Http\Controllers\V1\Types\Mono;

class Poly implements CusotmTypeInterface
{
    function __construct(
        private array $monos = []
    ) {}

    public function getMonos()
    {
        return $this->monos;
    }
    
    public function addMono(Mono $mono)
    {
        array_push($this->monos, $mono);
    }
    
    public function setMonos(array $monos)
    {
        $this->monos = $monos;
    }

    public function simplify() 
    {
        foreach ($this->monos as $index1 => &$mono1) {
            foreach ($this->monos as $index2 => &$mono2) {
                if (
                    $mono1 &&
                    $mono2 &&
                    $index1 < $index2 && 
                    $mono1->getPower() == $mono2->getPower()
                ){
                    $newCoefficient = $mono1->getCoefficient() + $mono2->getCoefficient();
                    $mono1 = new Mono($newCoefficient, $mono1->getPower());
                    $mono2 = null;
                }
            }
        }
        $this->monos = array_values(array_filter($this->monos));
    }

    public function ordering() 
    {
        foreach ($this->monos as $index1 => &$mono1) {
            foreach ($this->monos as $index2 => &$mono2) {
                if (
                    $index1 < $index2 && 
                    $mono1->getPower() < $mono2->getPower()
                ) {
                    $temp = $mono1;
                    $mono1 = $mono2;
                    $mono2 = $temp;
                }
            }
        }
    }

    public function __toString() 
    {
        $polyString = '';
        foreach ($this->monos as $mono) {
            $polyString .= $mono;
        }
        return ($polyString) ? $polyString : '0' ;
    }

    public function getNegative() :Poly
    {
        $negativePoly = new Poly();

        foreach ($this->monos as $mono) {
            $negativePoly->monos[] = $mono->getNegative();
        }

        return $negativePoly;
    }
}