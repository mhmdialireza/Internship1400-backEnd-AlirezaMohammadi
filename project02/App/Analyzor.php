<?php
namespace App;

use App\Poly;

class Analyzor {

    private string $inputText;
    private array $strings;
    
    public function start(string $inputText) :Poly {
        $this->inputText = $inputText;

        $this->checkFirstOfString();
        $this->makeSpace();
        $this->makeCoefficientOne();
        $this->explodeFromSpace();
        $this->prepareMono();

        $poly = new Poly();
        
        $poly->makePoly($this->strings);
        $poly->simplify();
        $poly->ordering();

        return $poly;
    }

    public function checkFirstOfString() {
        if ($this->inputText[0] != '-' && $this->inputText[0] != '+'){
            $this->inputText = '+' . $this->inputText;
        } 
    }

    public function makeSpace() {
        $this->inputText = str_replace(['-', '+'], [' -', ' +'], $this->inputText);
    }

    public function makeCoefficientOne() {
        $this->inputText = str_replace(['-x', '+x'], ['-1x', '+1x'], $this->inputText);
    }

    public function explodeFromSpace() {
        $this->strings = explode(' ', $this->inputText);
        unset($this->strings[0]);
        $this->strings = array_values($this->strings); 
    }

    public function prepareMono() {
        foreach ($this->strings as $key => $mono) {
            if (strpos($mono, 'x') && !strpos($mono, '^')) {
                $this->strings[$key] = $mono . '^1';
            } elseif (!strpos($mono, 'x')) {
                $this->strings[$key] = $mono . 'x^0';
            }
        }
    } 
}