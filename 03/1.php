<?php

declare(strict_types=1);

$rows = getAsArray();

$sum = 0;
foreach ($rows as $rowNumber => $items) {
    $currentNumber = '';
    $numberPositions = [];
    $itemsCountInRow = count($items);
    foreach ($items as $itemPosition => $item) {
        if (is_int($item)) {
            $currentNumber .= (string) $item;
            $numberPositions[] = $itemPosition;

            if (false === is_int($items[$itemPosition+1] ?? null)) {
                if (arePositionsAdjacentToSymbol($rows, $itemsCountInRow, $rowNumber, $numberPositions)) {
                    $sum += (int) $currentNumber;
                }
                $currentNumber = '';
                $numberPositions  = [];
            }
        }
    }
}
echo $sum.PHP_EOL;

function getAsArray(): array {
    $input = file('test.txt');
    return array_map(function(string $row) {
        return array_map(fn (string $item) => is_numeric($item) ? (int) $item : $item, str_split(rtrim($row)));
    } , $input);
}

function arePositionsAdjacentToSymbol(array $rows, int $itemsCountInRow,  int $row, array $positions) {
    $rowAbove = $row > 0 ? $rows[$row-1] : null;
    $middleRow = $rows[$row];
    $rowBelow = $row !== count($rows)-1 ? $rows[$row+1] : null;

    $positionsToCheck = $positions;
    if ($positions[0] !== 0) {
        $positionsToCheck[] = $positions[0] - 1;
    }

    if (end($positions) !== $itemsCountInRow - 1) {
        $positionsToCheck[] = end($positions) + 1;
    }

    foreach ([$rowAbove, $middleRow, $rowBelow] as $row) {
        if (null === $row) {
            continue;
        }
        foreach ($positionsToCheck as $position) {
            if ('.' !== $row[$position] && false === is_numeric($row[$position])) {
                return true;
            }
        }
    }

    return false;
}