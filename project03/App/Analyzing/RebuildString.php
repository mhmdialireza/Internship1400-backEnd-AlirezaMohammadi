<?php
namespace App\Analyzing;

class RebuildString
{
    public function getNewString(String $string) :string
    {
        $this->string = $string;

        $this->checkFirstOfString();
        $this->makeSpace();
        $this->makeCoefficientOne();

        return $this->string;
    }

    private function checkFirstOfString() 
    {
        if (
            $this->string[0] != '-' && 
            $this->string[0] != '+'
        ){
            $this->string = '+' . $this->string;
        } 
    }

    private function makeSpace() 
    {
        $this->string = str_replace(['-', '+'], [' -', ' +'], $this->string);
    }

    private function makeCoefficientOne() 
    {
        $this->string = str_replace(['-x', '+x'], ['-1x', '+1x'], $this->string);
    }
}