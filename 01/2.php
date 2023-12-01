<?php

declare(strict_types=1);

const DIGITS_NAME = ['one' => 'on1ne', 'two' => 'tw2wo', 'three' => 'thre3hree', 'four' => 'fou4our', 'five' => 'fi5ive', 'six' => 'si6ix', 'seven' => 'seve7even', 'eight' => 'eigh8ight', 'nine' => 'nin9ine'];
$strings = file('test.txt');


$numbers = array_map(function (string $string): int {
    foreach (DIGITS_NAME as $key => $value) {
        $string = str_replace($key, $value, $string);
    }
    $number = preg_replace("/[^0-9]/", "", $string);
    $result = (int) ($number[0].$number[strlen($number)-1]);

    return $result;

}, $strings);

echo array_sum($numbers);