<?php

// you can put our phrase here Manually
$polynomial;

// set from index.php
$polynomial = $_GET['polynomial'] ?? $polynomial;

// make space before '+' & '-'
$polynomial = str_replace(['-', '+'], [' -', ' +'], $polynomial);

// make array by polynomial (member type:string)
$polynomialArr = explode(' ', $polynomial);

foreach ($polynomialArr as &$monomial) {

    //remove 'x' from array and convert to float
    $monomial = floatval(str_replace('x', '', $monomial));
}

// now we have array with float member
// array_sum help us to find sum of all members in array
// and finally concat with 'x' to get our answer
echo array_sum($polynomialArr) . 'x';