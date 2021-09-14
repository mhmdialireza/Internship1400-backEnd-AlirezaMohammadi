<?php
namespace App\Operation;

use App\Contracts\CusotmTypeInterface;
use App\Contracts\MathOperationInterface;
use App\Types\Poly;
use App\Operation\MonoOperation;
use Exception;

class PolyOperation implements MathOperationInterface
{
    private MonoOperation $monoOperation;

    function __construct()
    {
        $this->monoOperation = new MonoOperation();
    }

    public function answerForValue(CusotmTypeInterface $poly, float $value) :float 
    {  
        $this->checkType($poly);

        $answer = 0;
        foreach ($poly->getMonos() as $mono) {
            $answer += $this->monoOperation->answerForValue($mono, $value);
        }
        return $answer;    
    }

    public function derivative(CusotmTypeInterface $poly) :Poly 
    {
        $this->checkType($poly);

        $derivativePoly = new Poly();

        foreach ($poly->getMonos() as $mono) {
            $derivativePoly->addMono($this->monoOperation->derivative($mono));
        }

        return $derivativePoly;
    }

    public function sum(CusotmTypeInterface $poly1, CusotmTypeInterface $poly2) :Poly 
    {
        $this->checkType($poly1, $poly2);

        $newPoly = new Poly([...$poly1->getMonos(), ...$poly2->getMonos()]);

        $newPoly->simplify();
        
        return $newPoly;
    }

    public function sub(CusotmTypeInterface $poly1, CusotmTypeInterface $poly2) :Poly 
    {        
        $this->checkType($poly1, $poly2);

        $newPoly = new Poly([...$poly1->getMonos(), ...$poly2->getNegative()->getMonos()]);

        $newPoly->simplify();
        
        return $newPoly;
    }

    public function mul(CusotmTypeInterface $poly1, CusotmTypeInterface $poly2) :Poly 
    {
        $this->checkType($poly1, $poly2);

        $newPoly = new Poly();

        foreach ($poly1->getMonos() as $mono1) {
            foreach ($poly2->getMonos() as $mono2) {
               $newPoly->addMono($this->monoOperation->mul($mono1, $mono2));
            }
        }

        $newPoly->simplify();

        return $newPoly;
    }

    private function checkType($type1, $type2 = false)
    {
        if(
            $type1::class != 'App\Types\Poly' ||
            ($type2 && $type2::class != 'App\Types\Poly')
        ){
            throw new Exception('argument must be type of App\Types\Poly');
        }
    }
}