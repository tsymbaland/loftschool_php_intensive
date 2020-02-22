<?php

//require_once 'homework1.php';
require('src/functions.php');

$unitedString = task1([
    'Функция должна принимать массив строк и выводить каждую строку в отдельном параграфе',
    'Если в функцию передан второй параметр true, то возвращать (через return) результат в виде одной объединенной строки.'
], true);
var_dump($unitedString);

task2('+', 4, 3, 2, 1);
task2('-', 4, 3, 2, 1);
task2('*', 4, 3, 2, 1);
try {
    task2('=', 4, 3, 2, 1);
} catch (Throwable $e) {
    echo $e . PHP_EOL;
}

try {
    task3('-1', '-1');
} catch (Throwable $e) {
    echo $e . PHP_EOL;
}
task3('1', '3');
task3('3', '3');

task4();

task5('Карл у Клары украл Кораллы', 'К', '');
task5('Две бутылки лимонада', 'Две', 'Три');
// Что значит "По желанию дополнить задание" ???

$filePath = 'test.txt';
file_put_contents($filePath, 'Hello again!');
task6($filePath);
