<?php

declare(strict_types=1);

const DIGITS_NAME = ['one' => 'o1e', 'two' => 't2o', 'three' => 't3e', 'four' => 'f4r', 'five' => 'f5e', 'six' => 's6x', 'seven' => 's7n', 'eight' => 'e8t', 'nine' => 'n9e'];

$numbers = array_map(function (string $string): int {
    foreach (DIGITS_NAME as $key => $value) {
        $string = str_replace($key, $value, $string);
    }
    $number = preg_replace("/[^0-9]/", "", $string);
    $result = (int) ($number[0].$number[strlen($number)-1]);

    return $result;

}, file('test.txt'));

echo array_sum($numbers).PHP_EOL;