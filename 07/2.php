<?php

declare(strict_types=1);

$cards = getAsArray();

$setsTypes = ['highestCard' => [], 'pair' => [], 'twoPair' => [], 'threeOfKind' => [], 'fullHouse' => [], 'fourOfKind' => [], 'fiveOfKind' => []];
$sort = ['2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, 'T' => 10, 'J' => 1, 'Q' => 12, 'K' => 13, 'A' => 14];

foreach ($cards as $card) {
    $set = [];
    foreach (count_chars(getJockerizedSet($card['set']), 1) as $i => $count) {
        $set[chr($i)] = $count;
    }
    $setsTypes[getSetType($set)][] = ['set' => $card['set'], 'bet' => $card['bet']];
}

foreach ($setsTypes as $type => &$sets) {
    usort($sets, function (array $set1, array $set2) use ($sort) {
        $splitted1 = str_split($set1['set']);
        $splitted2 = str_split($set2['set']);
        for ($i = 0; $i <= 4; $i++) {
            if ($sort[$splitted1[$i]] > $sort[$splitted2[$i]]) {
                return 1;
            }
            if ($sort[$splitted1[$i]] < $sort[$splitted2[$i]]) {
                return -1;
            }
        }
    });
    $setsTypes[$type] = $sets;
}

$i = 0;
$result = 0;
foreach ($setsTypes as $sets1) {
    foreach ($sets1 as $set) {
        ++$i;
        $result += $set['bet'] * $i;
    }
}

echo $result . PHP_EOL;

function getAsArray(): array {
    $input = file('test.txt');
    $cards = array_map(fn($cards) => explode(' ', trim($cards)), $input);
    $result = [];
    foreach ($cards as $card) {
        $result[] = ['set' => $card[0], 'bet' => (int) $card[1]];
    }
    return  $result;
}

function getJockerizedSet(string $set): string {
    $charsCount = count_chars($set, 1);
    if (str_contains($set, 'J')) {
        if (1 === count($charsCount) && "J" === chr(array_key_first($charsCount))) {
            return $set;
        }
        arsort($charsCount);

        $replace = "J" !== chr(array_key_first($charsCount)) ? chr(array_key_first($charsCount)) : chr(array_keys($charsCount)[1]);
        $set = str_replace('J', $replace, $set);
    }
    return $set;
}

function getSetType(array $set): string {
    if (5 === count($set)) {
        return 'highestCard';
    } elseif (4 === count($set)) {
        return 'pair';
    } elseif (3 === count($set)) {
        return in_array(3, $set) ? 'threeOfKind' : 'twoPair';
    } elseif (2 === count($set)) {
        return in_array(4, $set) ? 'fourOfKind' : 'fullHouse';
    } else {
        return 'fiveOfKind';
    }
}

