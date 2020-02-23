<?php

function task1(array $strings, bool $return = false): ?string
{
    $strings = array_map(function ($str) {
        return "<p>$str</p>";
    }, $strings);
    $result = implode('', $strings);
    echo $result . '<br>';
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

function getOperation(string $operator)
{
    if ('+' === $operator) {
        return function ($operand1, $operand2) {
            return $operand1 + $operand2;
        };
    } elseif ('-' === $operator) {
        return function ($operand1, $operand2) {
            return $operand1 - $operand2;
        };
    } elseif ('*' === $operator) {
        return function ($operand1, $operand2) {
            return $operand1 * $operand2;
        };
    } elseif ('/' === $operator) {
        return function ($operand1, $operand2) {
            return $operand1 / $operand2;
        };
    } else {
        throw new InvalidArgumentException(
            'Supported operators: + - * /'
        );
    }
}

function task2(string $operator, ...$numericArgs)
{
    $operation = getOperation($operator);
    $numOfArgs = count($numericArgs);
    if (!$numOfArgs) {
        throw new InvalidArgumentException(
            'You should pass at least 1 numeric argument after the operator sign<br>'
        );
    }
    validateNumericArgs($numericArgs);

    $accumulator = $numericArgs[0];
    $display = [$accumulator];
    for ($index = 1; $index < $numOfArgs; $index++) {
        $newNumber = $numericArgs[$index];
        $accumulator = $operation($accumulator, $newNumber);
        $display = array_merge($display, [$operator, $newNumber]);
    }
    $display = array_merge($display, ['=', $accumulator]);

    echo implode(' ', $display) . '<br>';
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
            $html[] = '</table><br>';
        }
    }
    echo implode('', $html);
}

function task4()
{
    echo date('d.m.Y H:i') . '<br>';
    echo strtotime('24.02.2016 00:00:00') . '<br>';
}

function task5(string $source, string $toReplace, string $replacement)
{
    echo str_replace($toReplace, $replacement, $source) . '<br>';
}

function task6(string $filePath)
{
    echo file_get_contents($filePath);
}
