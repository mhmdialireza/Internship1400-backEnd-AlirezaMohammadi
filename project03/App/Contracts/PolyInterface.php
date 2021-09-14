<?php
namespace App\Contracts;

use App\Types\Mono;

interface PolyInterface
{
    public function getMonos();
    public function addMono(Mono $mono);
    public function simplify();
    public function ordering();
}