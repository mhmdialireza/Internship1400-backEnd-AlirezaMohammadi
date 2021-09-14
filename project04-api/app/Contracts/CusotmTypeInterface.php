<?php
namespace App\Contracts;

interface CusotmTypeInterface
{
    public function __toString() :string;
    public function getNegative() :CusotmTypeInterface;
}