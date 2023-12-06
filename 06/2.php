<?php

declare(strict_types=1);

$input = file('test.txt');
preg_match("/Time:\s*(.*)/", $input[0], $timeMatches);
preg_match("/Distance:\s*(.*)/", $input[1], $distancesMatches);

$time = (int) str_replace(" ", "", $timeMatches[1]);
$record = (int) str_replace(" ", "", $distancesMatches[1]);

$result = 0;
$waysOfBeatingRecord = 0;
for ($buttonHoldTime = 0; $buttonHoldTime < $time; $buttonHoldTime++) {
    $travelSpeed = $buttonHoldTime;
    $travelTime = $time - $buttonHoldTime;
    if ((int) $travelSpeed * (int) $travelTime > $record) {
        $result++;
    }
}

echo $result . PHP_EOL;
