<?php

declare(strict_types=1);

$gamesInput = file('test.txt');
$games = [];

foreach ($gamesInput as $game) {
    preg_match("/Game ([0-9]*): (.*)/m", $game, $matches);
    $gameNum = (int) $matches[1];
    $rounds = explode('; ', $matches[2]);
    $picks = [];
    foreach ($rounds as $roundKey => $round) {
        $round = explode(', ', $round);

        foreach ($round as $key  => $option) {
            preg_match("/([0-9]*) (.*)/m", $option, $roundMatches);
            $picks[$roundKey][$roundMatches[2]] = (int) $roundMatches[1];
        }
    }
    $games[$gameNum][] = $picks;

}

$sum = 0;
foreach ($games as $gameNum => $rounds) {
    $isGamePossible = true;

    foreach ($rounds as $round) {
        foreach ($round as $roundPicks) {
            $red = $roundPicks['red'] ?? 0;
            $green = $roundPicks['green'] ?? 0;
            $blue = $roundPicks['blue'] ?? 0;
            if ($red > 12 || $green > 13 || $blue > 14) {
                $isGamePossible = false;
                break;
            }
        }

        if ($isGamePossible) {
            $sum += $gameNum;
        };
    }
}

echo $sum . PHP_EOL;