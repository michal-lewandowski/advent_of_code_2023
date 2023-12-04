<?php

declare(strict_types=1);

$scratchcards = getAsArray();

$sum = 0;
foreach ($scratchcards as $scratchcard) {
    $scratchcardPoints = count($scratchcard['matching']) > 0 ? 1 : 0;
    for ($i = 1; $i < count($scratchcard['matching']); $i++) {
        $scratchcardPoints *= 2;
    }
    $sum += $scratchcardPoints;
}

echo $sum.PHP_EOL;

function getAsArray(): array {
    $input = file('test.txt');
    $cards = [];
    foreach ($input as $row) {
        preg_match("/Card\s*([0-9]*): (.*)\s\| (.*)\s/", $row, $matches);
        $winning = array_filter(explode(' ', trim($matches[2])), fn($elem) => $elem != '');
        $picked = array_filter(explode(' ', trim($matches[3])), fn($elem) => $elem != '');

        $cards[$matches[1]] = [
            'winning' => $winning,
            'picked' => $picked,
            'matching' => array_intersect($winning, $picked)
        ];
    }

    return $cards;
}