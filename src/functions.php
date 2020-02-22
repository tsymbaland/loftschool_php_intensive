<?php

function task1(array $strings, bool $return = false): ?string
{
    $strings = array_map(function ($str) {
        return "<p>$str</p>";
    }, $strings);
    $result = implode('', $strings);
    echo $result . PHP_EOL;
    if ($return) {
        return $result;
    }
}

function validateNumericArgs($numericArgs)
{
    foreach ($numericArgs as $arg) {
        if (!is_numeric($arg)) {
            throw new InvalidArgumentException(
                'All passed operands should be numeric'
            );
        }
    }
}

function task2(string $operator)
{
    $numericArgs = func_get_args();
    array_shift($numericArgs);
    validateNumericArgs($numericArgs);

    if ('+' === $operator) {
        $initialValue = 0;
        $operation = function ($operand1, $operand2) {
            return $operand1 + $operand2;
        };
    } elseif ('-' === $operator) {
        $initialValue = count($numericArgs) ? $numericArgs[0] : 0;
        $operation = function ($operand1, $operand2) {
            return $operand1 - $operand2;
        };
    } elseif ('*' === $operator) {
        $initialValue = 1;
        $operation = function ($operand1, $operand2) {
            return $operand1 * $operand2;
        };
    } else {
        throw new InvalidArgumentException(
            'Supported operators: + - *'
        );
    }

    $result = array_reduce($numericArgs, function ($acc, $arg) use ($operation) {
        return $operation($acc, $arg);
    }, $initialValue);
    echo $result . PHP_EOL;
}

function task3(int $cols, int $rows)
{
    if ($cols < 1 || $rows < 1) {
        throw new InvalidArgumentException(
            "You should provide correct values for numbers of both rows and colums ($cols and $rows provided)"
        );
    }

    $html = [];
    for ($row = 1; $row <= $rows; $row++) {
        if ($row === 1) {
            $html[] = '<table>';
        }
        $html[] = '<tr>';
        for ($col = 1; $col <= $cols; $col++) {
            $result = $row * $col;
            $html[] = "<td>$result</td>";
        }
        $html[] = '</tr>';
        if ($row === $rows) {
            $html[] = '</table>';
        }
    }
    $html = implode('', $html);
    echo $html . PHP_EOL;
}

function task4()
{
    echo date('d.m.Y H:i') . PHP_EOL;
    echo strtotime('24.02.2016 00:00:00') . PHP_EOL;
}

function task5(string $source, string $toReplace, string $replacement)
{
    echo str_replace($toReplace, $replacement, $source) . PHP_EOL;
}

function task6(string $filePath)
{
    echo file_get_contents($filePath);
}
