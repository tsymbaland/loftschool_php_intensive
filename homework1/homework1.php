<?php

// 1 ///////////////////////////////////////////////////////
$name = 'Gregory Tsymbal';
$age = 28;
echo "Меня зовут: $name" . PHP_EOL;
echo "Мне $age лет" . PHP_EOL;
echo "\"“!|/’”\\" . PHP_EOL;
// 2 ///////////////////////////////////////////////////////
CONST NUM_OF_PICS_TOTAL = 80;
CONST NUM_OF_PICS_MARKER = 23;
CONST NUM_OF_PICS_PENCIL = 40;
$numOfPicsPencil = NUM_OF_PICS_TOTAL -
    NUM_OF_PICS_MARKER -
    NUM_OF_PICS_PENCIL;
// 3 ///////////////////////////////////////////////////////
$age = rand();
$minAge = 1;
$lowerThreshold = 18;
$upperThreshold = 65; /*злободневненько*/
if ($lowerThreshold <= $age && $age <= $upperThreshold) {
    echo "Вам еще работать и работать" . PHP_EOL;
} elseif ($age > $upperThreshold) {
    echo "Вам пора на пенсию" . PHP_EOL;
} elseif ($minAge <= $age && $age <= $lowerThreshold - 1) {
    echo "Вам ещё рано работать" . PHP_EOL;
} else {
    echo "Неизвестный возраст" . PHP_EOL;
}
// 4 ///////////////////////////////////////////////////////
$day = rand();
switch ($day) {
    case 1:
    case 2:
    case 3:
    case 4:
    case 5:
        echo "Это рабочий день" . PHP_EOL;
        break;
    case 6:
    case 7:
        echo "Это выходной день" . PHP_EOL;
        break;
    default:
        echo "Неизвестный день" . PHP_EOL;
        break;
}
// 5 ///////////////////////////////////////////////////////
$bmw = [
    'model' => 'X5',
    'speed' => 120,
    'doors' => 5,
    'year' => '2015',
];
$toyota = [
    'model' => 'Shmoyota',
    'speed' => 110,
    'doors' => 7,
    'year' => '2017',
];
$opel = [
    'model' => 'Shmopel',
    'speed' => 115,
    'doors' => 3,
    'year' => '2013',
];
foreach ([$bmw, $toyota, $opel] as $car) {
    echo implode(' ', $car) . PHP_EOL;
}
// 6 ///////////////////////////////////////////////////////
$html = [];
for ($i = 1; $i <= 10; $i++) {
    if ($i === 1) {
        $html[] = '<table>';
    }
    $html[] = '<tr>';
    for ($j = 1; $j <= 10; $j++) {
        $result = $i * $j;
        $modI = $i % 2;
        $modJ = $j % 2;
        $left = '';
        $right = '';
        if ($modI && $modJ) {
            $left = '[';
            $right = ']';
        } elseif (!$modI && !$modJ) {
            $left = '(';
            $right = ')';
        }
        $html[] = "<td>{$left}{$result}{$right}</td>";
    }
    $html[] = '</tr>';
    if ($i === 10) {
        $html[] = '</table>';
    }
}
$html = implode('', $html);
echo $html . PHP_EOL;