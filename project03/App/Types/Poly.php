<?php
namespace App\Types;

use App\Contracts\CusotmTypeInterface;
use App\Contracts\PolyInterface;
use App\Types\Mono;

class Poly implements CusotmTypeInterface, PolyInterface
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
    
    public function simplify() 
    {
        for ($i=0; $i < count($this->monos); $i++) { 
            for ($j=$i+1; $j < count($this->monos); $j++) { 
                if (
                    $this->monos[$i] &&
                    $this->monos[$j] &&
                    $this->monos[$i]->getPower() == $this->monos[$j]->getPower()
                ){
                    $newCoefficient = $this->monos[$i]->getCoefficient() + $this->monos[$j]->getCoefficient();
                    $this->monos[$i] = new Mono($newCoefficient, $this->monos[$i]->getPower());
                    $this->monos[$j] = null;
                }
            }
        }
        $this->monos = array_values(array_filter($this->monos));
    }

    public function ordering() 
    {
        for ($i=0; $i < count($this->monos); $i++) { 
            for ($j=$i+1; $j < count($this->monos); $j++) { 
                if (
                    $this->monos[$i]->getPower() < $this->monos[$j]->getPower()
                ) {
                    $temp = $this->monos[$i];
                    $this->monos[$i] = $this->monos[$j];
                    $this->monos[$j] = $temp;
                }
            }
        }
    }

    public function __toString() :string 
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