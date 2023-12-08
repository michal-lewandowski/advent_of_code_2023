<?php

declare(strict_types=1);
[$instructions, $nodes] = getAsArray();
$startingNodes = getStartingNodes($nodes);

$currentInstructionStep = 0;
$stepsCount = 0;
$lcm = 1;

foreach ($startingNodes as $node) {
    $currentNode = $node;
    while (false === str_ends_with($currentNode, 'Z')) {
        $stepsCount++;
        $step = $instructions[$currentInstructionStep];
        $step = 'L' === $step ? 0 : 1;

        $currentNode = $nodes[$currentNode][$step];

        $currentInstructionStep = $currentInstructionStep === count($instructions)-1 ? 0 : $currentInstructionStep+1;
    }

    $lcm = gmp_lcm($lcm, $stepsCount);
    $stepsCount = 0;
}

echo $lcm . PHP_EOL;

function getAsArray(): array
{
    $input = file('test_2.txt');
    $instructions = str_split(trim($input[0]));

    $nodes = [];
    foreach (array_slice($input, 2) as $node) {
        preg_match("/([0-9A-Z]{3}) = \(([0-9A-Z]{3}), ([0-9A-Z]{3})\)/", $node, $nodeMatches);
        $nodes[$nodeMatches[1]] = [$nodeMatches[2], $nodeMatches[3]];
    }

    return [$instructions, $nodes];
}

function getStartingNodes(array $nodes): array
{
    return array_filter(
        array_map(fn(string $nodeName) => str_ends_with($nodeName, "A") ? $nodeName : null, array_keys($nodes)),
        fn($nodeName) => null !== $nodeName
    );
}
