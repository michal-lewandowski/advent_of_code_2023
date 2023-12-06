<?php

declare(strict_types=1);

$timesRecords = getAsArray();

var_dump($timesRecords);

$result = 1;
foreach ($timesRecords as $time => $record) {
    $waysOfBeatingRecord = 0;
    for ($buttonHoldTime = 0; $buttonHoldTime < $time; $buttonHoldTime++) {
        $travelSpeed = $buttonHoldTime;
        $travelTime = $time - $buttonHoldTime;
        if ((int) $travelSpeed * (int) $travelTime > $record) {
            $waysOfBeatingRecord++;
        }
        echo $travelSpeed.' '.$travelTime.PHP_EOL;
    }
    $result *= $waysOfBeatingRecord;
}

echo $result . PHP_EOL;
function getAsArray(): array {
    $input = file('test.txt');
    preg_match("/Time:\s*(.*)/", $input[0], $timeMatches);

    $times = array_filter(explode(" ", $timeMatches[1]), fn($match) => $match !== "");
    preg_match("/Distance:\s*(.*)/", $input[1], $distancesMatches);
    $records = array_filter(explode(" ", $distancesMatches[1]), fn($match) => $match !== "");

    return array_combine($times, $records);
}