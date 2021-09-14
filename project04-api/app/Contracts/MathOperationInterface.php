<?php
namespace App\Contracts;

use App\Contracts\CusotmTypeInterface;

interface MathOperationInterface
{
    public function answerForValue(CusotmTypeInterface $cusotmTypeInterface, float $value) :float;
    public function derivative(CusotmTypeInterface $cusotmTypeInterface);
    public function sum(CusotmTypeInterface $cusotmTypeInterface1, CusotmTypeInterface $cusotmTypeInterface2);
    public function sub(CusotmTypeInterface $cusotmTypeInterface1, CusotmTypeInterface $cusotmTypeInterface2);
    public function mul(CusotmTypeInterface $cusotmTypeInterface1, CusotmTypeInterface $cusotmTypeInterface2);
}