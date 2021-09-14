<?php
namespace App\Operation;

use Exception;
use App\Types\Mono;
use App\Types\Poly;
use App\Contracts\CusotmTypeInterface;
use App\Contracts\MathOperationInterface;

class MonoOperation implements MathOperationInterface
{
    public function answerForValue(CusotmTypeInterface $mono, float $value) :float
    {   
        $this->checkType($mono);

        return $mono->getCoefficient() * ($value ** $mono->getPower());
    }
    
    public function derivative(CusotmTypeInterface $mono) :Mono 
    {
        $this->checkType($mono);

        $coefficient = $mono->getCoefficient() * $mono->getPower();
        $power = $mono->getPower() - 1;

        return new Mono($coefficient, $power);
    }

    public function sum(CusotmTypeInterface $mono1, CusotmTypeInterface $mono2) :Poly|Mono 
    {   
        $this->checkType($mono1, $mono2);

        if($mono1->getPower() != $mono2->getPower()){
            return new Poly([$mono1, $mono2]);
        }
        $coefficient = $mono1->getCoefficient() + $mono2->getCoefficient();
        return new Mono($coefficient, $mono1->getPower());
    }
    public function sub(CusotmTypeInterface $mono1, CusotmTypeInterface $mono2) :Poly|Mono
    {   
        $this->checkType($mono1, $mono2);

        if($mono1->getPower() != $mono2->getPower()){
            return new Poly([$mono1, $mono2->getNegative()]);
        }
        $coefficient = $mono1->getCoefficient() - $mono2->getCoefficient();
        return new Mono($coefficient, $mono1->getPower());
    }

    public function mul(CusotmTypeInterface $mono1, CusotmTypeInterface $mono2) :Mono 
    {     
        $this->checkType($mono1, $mono2);
  
        $coefficient = $mono1->getCoefficient() * $mono2->getCoefficient();
        $power = $mono1->getPower() + $mono2->getPower();
         
        return new Mono($coefficient, $power);
    }

    private function checkType($type1, $type2 = false)
    {
        if(
            $type1::class != 'App\Types\Mono' ||
            ($type2 && $type2::class != 'App\Types\Mono')
        ){
            throw new Exception('argument must be type of App\Types\Mono');
        }
    }
}