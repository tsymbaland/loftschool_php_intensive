<?php

require('src/functions.php');

$unitedString = task1([
    'Строка раз',
    'Строка два',
    'Строка еще одна',
], true);
echo $unitedString;

try {
    task2('+', 4, 3, 2, 1);
} catch (Throwable $e) {
    echo $e->getMessage() . '<br>';
}
try {
    task2('-', 4, 3, 2, 1);
} catch (Throwable $e) {
    echo $e->getMessage() . '<br>';
}
try {
    task2('*', 4, 3, 2, 1);
} catch (Throwable $e) {
    echo $e->getMessage() . '<br>';
}
try {
    task2('/', 16, 4, 2, 1);
} catch (Throwable $e) {
    echo $e->getMessage() . '<br>';
}
try {
    task2('/', 16, 4, 2, 0);
} catch (Throwable $e) {
    echo $e->getMessage() . '<br>';
}
try {
    task2('/');
} catch (Throwable $e) {
    echo $e->getMessage() . '<br>';
}
try {
    task2('=', 4, 3, 2, 1);
} catch (Throwable $e) {
    echo $e->getMessage() . '<br>';
}

try {
    task3('-1', '-1');
} catch (Throwable $e) {
    echo $e->getMessage() . '<br>';
}
try {
    task3('1', '3');
} catch (Throwable $e) {
    echo $e->getMessage() . '<br>';
}
try {
    task3('3', '3');
} catch (Throwable $e) {
    echo $e->getMessage() . '<br>';
}
try {
    task3('3', 'qwe');
} catch (Throwable $e) {
    echo $e->getMessage() . '<br>';
}

task4();

task5('Карл у Клары украл Кораллы', 'К', '');
task5('Две бутылки лимонада', 'Две', 'Три');
// Что значит "По желанию дополнить задание" ???

$filePath = 'test.txt';
file_put_contents($filePath, 'Hello again!');
task6($filePath);
