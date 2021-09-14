<?php
namespace App\Http\Controllers\V1\Contracts;

interface CusotmTypeInterface
{
    public function __toString() :string;
    public function getNegative() :CusotmTypeInterface;
}