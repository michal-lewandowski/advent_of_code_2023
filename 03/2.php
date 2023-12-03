<?php

declare(strict_types=1);

$rows = getAsArray();

$pairs = [];
foreach ($rows as $rowNumber => $items) {
    $currentNumber = '';
    $numberPositions = [];
    $itemsCountInRow = count($items);
    foreach ($items as $itemPosition => $item) {
        if (is_int($item)) {
            $currentNumber .= $item;
            $numberPositions[] = $itemPosition;

            if (false === is_int($items[$itemPosition+1] ?? null)) {
                $symbolCoordinates = arePositionsAdjacentToSymbol($rows, $itemsCountInRow, $rowNumber, $numberPositions);
                if (null !== $symbolCoordinates) {
                    $pairs[$symbolCoordinates][] =  (int) $currentNumber;
                }
                $currentNumber = '';
                $numberPositions  = [];
            }
        }
    }
}

$sum = 0;
foreach ($pairs as $pair) {
    if (2 !== count($pair)) {
        continue;
    }
    $sum += $pair[0]*$pair[1];
}

echo $sum.PHP_EOL;

function getAsArray(): array {
    $input = file('test.txt');
    return array_map(function(string $row) {
        return array_map(fn (string $item) => is_numeric($item) ? (int) $item : $item, str_split(rtrim($row)));
    } , $input);
}

function arePositionsAdjacentToSymbol(array $rows, int $itemsCountInRow,  int $rowNumber, array $positions) {
    $rowsToCheck = [
        $rowNumber-1 => $rowNumber > 0 ? $rows[$rowNumber-1] : null,
        $rowNumber => $rows[$rowNumber],
        $rowNumber+1 => $rowNumber !== count($rows)-1 ? $rows[$rowNumber+1] : null
    ];

    $positionsToCheck = $positions;
    if ($positions[0] !== 0) {
        $positionsToCheck[] = $positions[0] - 1;
    }

    if (end($positions) !== $itemsCountInRow - 1) {
        $positionsToCheck[] = end($positions) + 1;
    }

    foreach ($rowsToCheck as $rowNum => $row) {
        if (null === $row) {
            continue;
        }
        foreach ($positionsToCheck as $position) {
            if ('*' === $row[$position]) {
                return $rowNum."X".$position;
            }
        }
    }

    return null;
}