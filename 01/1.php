<?php

declare(strict_types=1);

$strings = file('test.txt');

$numbers = array_map(function (string $string): int {
    $number = preg_replace("/[^0-9]/", "", $string);
    return (int) ($number[0].$number[strlen($number)-1]);

}, $strings);

echo array_sum($numbers).PHP_EOL;