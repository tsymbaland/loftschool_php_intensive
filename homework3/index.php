<?php

require('src/functions.php');

echo '<pre>';
echo '-------------------------------------- <br>';
echo ' # 1<br>';
echo '-------------------------------------- <br>';
makeOrdersReport('data.xml');


echo '-------------------------------------- <br>';
echo ' # 2<br>';
echo '-------------------------------------- <br>';
$jsonPathTpl = 'output%s.json';
$jsonPath1 = sprintf($jsonPathTpl, '');
$jsonPath2 = sprintf($jsonPathTpl, '2');
$original = [
    [
        'name' => 'Johnny',
        'age' => 29,
        'preferences' => [
            'fruit' => 'orange',
            'color' => 'orange',
        ],
    ],
    [
        'name' => 'Olivia',
        'age' => 21,
        'preferences' => [
            'fruit' => 'banana',
            'color' => 'yellow',
        ],
    ],
];
saveIntoJsonFile($original, $jsonPath1);
$modified = readFromJsonFile($jsonPath1);
if (round(rand(0, 1))) {
    unset($modified[0]['name']);
    $modified[0]['age'] = round(rand(20, 28));
    $modified[0]['preferences']['fruit'] = 'apple';
    echo "Original array has been modified!<br>";
} else {
    echo "Original array stayed the same!<br>";
}
saveIntoJsonFile($modified, $jsonPath2);
$contents1 = readFromJsonFile($jsonPath1);
$contents2 = readFromJsonFile($jsonPath2);
$diff = array_diff_assoc($contents1[0], $contents2[0] ?? []);
$diff = array_merge(
    $diff,
    array_diff_assoc($contents1[1], $contents2[1] ?? [])
);
$diff = array_merge(
    $diff,
    array_diff_assoc(
        $contents1[0]['preferences'],
        ($contents2[0] ?? [])['preferences'] ?? []
    )
);
$diff = array_merge(
    $diff,
    array_diff_assoc(
        $contents1[1]['preferences'],
        ($contents2[1] ?? [])['preferences'] ?? []
    )
);
echo ' >>>>>>>>>>>>>>> Original:<br>';
var_dump($contents1);
echo ' >>>>>>>>>>>>>>> Modified:<br>';
var_dump($contents2);
echo ' >>>>>>>>>>>>>>> Diff:<br>';
var_dump($diff);