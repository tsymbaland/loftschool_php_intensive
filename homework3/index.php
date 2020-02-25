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


echo '-------------------------------------- <br>';
echo ' # 3<br>';
echo '-------------------------------------- <br>';
$randoms = getArrayOfRandomInts(round(rand(50, 100)));
$delimeter = ';';
$handle = fopen('randoms.csv', 'w');
fputcsv($handle, $randoms, $delimeter);
fclose($handle);
$handle = fopen('randoms.csv', 'r');
$csvRows = [];
while ($row = fgetcsv($handle, 1024 * 100, $delimeter)) {
    $csvRows[] = $row;
}
fclose($handle);
$sumOfEvens = array_reduce($csvRows, function ($sum, $row) {
    $rowSum = array_reduce($row, function ($subSum, $number) {
        if (!($number % 2)) {
            $subSum += $number;
        }

        return $subSum;
    }, 0);

    return $sum + $rowSum;
}, 0);
echo "Sum of evens from .csv-file = $sumOfEvens<br>";

echo '-------------------------------------- <br>';
echo ' # 4<br>';
echo '-------------------------------------- <br>';
$url = 'https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revisions&rvprop=content&format=json';
$data = readFromJsonFile($url);
$targetPageData = $data['query']['pages']['15580374'];
echo "Title: {$targetPageData['title']}<br>";
echo "PageID: {$targetPageData['pageid']}<br>";
