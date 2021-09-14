<?php
namespace App\Services;

class ValidationService
{
    public function isValid(string $string)
    {
        if(
            $string &&
            strlen($string) == 1 &&
            ($string == '-' || $string == '+')
        ){
            return false;
        }

        preg_match('/((([\+\-])(?![\+\-]))?\d?((x(?!x)(?!\d))((\^(?=\d))((\d)(?!x)))?)?)+/',$string,$matchs);
        if($matchs[0] != $string){
            return false;
        }

        if (
            $string[0] != '-' && 
            $string[0] != '+'
        ){
            $string = '+' . $string;
        } 

        $string = str_replace(['-', '+'], [' -', ' +'], $string);

        $strings = explode(' ', $string);
        
        unset($strings[0]);
        $strings = array_values($strings); 
        
        foreach ($strings as $string) {
            if(substr_count($string,'x')>1){
                return false;
            }
        }
        return true;
    }
}