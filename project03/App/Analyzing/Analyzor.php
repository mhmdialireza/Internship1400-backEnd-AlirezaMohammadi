<?php
namespace App\Analyzing;

use App\Types\Mono;
use App\Types\Poly;
use App\Analyzing\RebuildString;

class Analyzor {
    public function __construct(
        private array $strings = []
    ){}
    
    public function getPolyFromText(string $text) :Poly 
    {
        $text = (new RebuildString())->getNewString($text);

        $this->explodeFromSpace($text);
        $this->repairPowers();
        
        $poly = new Poly($this->buildMonos());

        return $poly;
    }

    private function explodeFromSpace($text) 
    {
        $this->strings = explode(' ', $text);
        unset($this->strings[0]);
        $this->strings = array_values($this->strings); 
    }

    private function repairPowers() 
    {
        foreach ($this->strings as $key => $mono) {
            if (
                strpos($mono, 'x') && 
                !strpos($mono, '^')
            ) {
                $this->strings[$key] = $mono . '^1';
            } elseif (!strpos($mono, 'x')) {
                $this->strings[$key] = $mono . 'x^0';
            }
        }
    } 

    private function buildMonos()
    {
        $temps = [];
        foreach ($this->strings as $string) {
            array_push($temps, explode('x^',$string));
        }
        
        $monos = [];
        foreach ($temps as $temp) {
            array_push($monos, new Mono($temp[0], $temp[1]));
        }

        return $monos;
    }
}