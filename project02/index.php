<?php
echo '<pre>';

use App\Analyzor;


include './vendor/autoload.php';

$str = 'x-2x^3+3x^2-4x^5+6x^5';
$str2 = '7x-5x^3+4x^2+1-4x^5+x^3';

$strA = new Analyzor();
$strA2 = new Analyzor();

$poly = $strA->start($str);
$poly2 = $strA2->start($str2);

echo 'first str : ' . $poly->toString();
echo '<br>';
echo 'second str: ' . $poly2->toString();

$x = 1;
$x2 = 2;

echo '<hr>';
echo "first str value for ($x) : " . $poly->answerForValue($x);
echo '<br>';
echo "second str value for ($x2): " . $poly2->answerForValue($x2);

echo '<hr>';
echo "first derivative : " . $poly->derivative()->toString();
echo '<br>';
echo "second derivative: " . $poly2->derivative()->toString();

echo '<hr>';
echo "str1 + str2 : " . $poly->sum($poly2)->toString();
echo '<br>';
echo "str1 - str2 : " . $poly->submission($poly2)->toString();
echo '<br>';
echo "str1 × str2 : " . $poly->multiplication($poly2)->toString();


echo '</br>';