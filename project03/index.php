<?php

use App\Analyzing\Analyzor;
use App\Operation\PolyOperation;

include './vendor/autoload.php';

$str = 'x-2x^3+3x^2-4x^5+6x^5';
$str2 = '7x-5x^3+4x^2+1-4x^5+x^3';
$str3 = 'x';

$strA = new Analyzor();
$strA2 = new Analyzor();
$strA3 = new Analyzor();

$poly = $strA->getPolyFromText($str);
$poly2 = $strA2->getPolyFromText($str2);
$poly3 = $strA3->getPolyFromText($str3);

// echo count($poly3->getMonos());
// die();

echo PHP_EOL;
echo 'first str : ' . $poly;
echo PHP_EOL;
echo 'second str: ' . $poly2;
echo PHP_EOL;


$poly->simplify();
$poly->ordering();
echo PHP_EOL;
echo 'first str : ' . $poly;
$poly2->simplify();
$poly2->ordering();
echo PHP_EOL;
echo 'second str : ' . $poly2;

$operation = new PolyOperation();

$x = 1;
$x2 = 2;

echo PHP_EOL;
echo PHP_EOL;
echo PHP_EOL;
echo "first str value for ($x) : " . $operation->answerForValue($poly, $x);
echo PHP_EOL;
echo "second str value for ($x2): " . $operation->answerForValue($poly2, $x2);
echo PHP_EOL;
echo PHP_EOL;
echo "first derivative : " . $operation->derivative($poly);
echo PHP_EOL;
echo "second derivative: " . $operation->derivative($poly2);

echo PHP_EOL;
echo PHP_EOL;
echo "str1 + str2 : " . $operation->sum($poly, $poly2);
echo PHP_EOL;
echo "str1 - str2 : " . $operation->sub($poly, $poly2);
echo PHP_EOL;
echo "str1 × str2 : " . $operation->mul($poly, $poly2);
echo PHP_EOL;