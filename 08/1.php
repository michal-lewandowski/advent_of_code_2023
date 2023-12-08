<?php

declare(strict_types=1);
[$instructions, $nodes] = getAsArray();
$stepsCount = 0;
$currentInstructionStep = 0;
$currentNode = 'AAA';
while ('ZZZ' !== $currentNode) {
    $stepsCount++;
    $step = $instructions[$currentInstructionStep];
    $step = 'L' === $step ? 0 : 1;
    $currentNode = $nodes[$currentNode][$step];
    if (count($instructions)-1 === $currentInstructionStep) {
        $currentInstructionStep = 0;
    } else {
        $currentInstructionStep++;
    }
}
echo $stepsCount . PHP_EOL;

function getAsArray(): array
{
    $input = file('test_1.txt');
    $instructions = str_split(trim($input[0]));

    $nodes = [];
    foreach (array_slice($input, 2) as $node) {
        preg_match("/([A-Z]{3}) = \(([A-Z]{3}), ([A-Z]{3})\)/", $node, $nodeMatches);
        $nodes[$nodeMatches[1]] = [$nodeMatches[2], $nodeMatches[3]];
    }

    return [$instructions, $nodes];
}
