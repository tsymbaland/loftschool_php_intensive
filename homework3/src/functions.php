<?php

function makeHeader(string $text, ?int $level = 1): string
{
    if ($level < 1) {
        $level = 1;
    } elseif ($level > 3) {
        $level = 3;
    }

    return "<h$level>$text</h$level>";
}

function camelize(string $text, ?string $delimeter = ' '): string
{
    $words = array_map(
        'ucfirst',
        explode($delimeter, $text)
    );

    return implode('', $words);
}

function makeHtmlTable(SimpleXMLElement $cfg): string
{
    $table = ['<table border="2">'];
    $header = ['<thead>'];
    $row = ['<tr>'];
    foreach ($cfg as $param => $value) {
        $header[] = "<th>$param</th>";
        $row[] = "<td>$value</td>";
    }
    $row[] = '</tr>';
    $header[] = '</thead>';

    return implode(
        '',
        array_merge($table, $header, $row, ['</table>'])
    );
}

function makeOrdersReport(string $filePath)
{
    $xml = new SimpleXMLElement(file_get_contents($filePath));
    $reportParts = [];
    foreach (['Purchase Order Number', 'Order Date'] as $attr) {
        $camelized = camelize($attr);
        /** @var SimpleXMLElement $attrXml */
        $attrXml = $xml->attributes()->$camelized;
        $attrValue = $attrXml->__toString();
        $reportParts[] = "<b>$attr: $attrValue</b>";
    }

    $addressesCounter = 1;
    $itemsCounter = 1;
    /**
     * @var string $orderParam
     * @var SimpleXMLElement $paramXml
     */
    foreach ($xml as $orderParam => $paramXml) {
        if ('Address' === $orderParam) {
            $type = $paramXml->attributes()->Type;
            $reportParts[] = makeHeader("Address #$addressesCounter ($type)", 3);
            $reportParts[] = makeHtmlTable($paramXml);
            $addressesCounter++;
        } elseif ('Items' === $orderParam) {
            $reportParts[] = '<hr>';
            foreach ($paramXml as $itemXml) {
                $partNumber = $itemXml->attributes()->PartNumber;
                $reportParts[] = makeHeader("Item #$itemsCounter ($partNumber)", 3);
                $reportParts[] = makeHtmlTable($itemXml);
                $itemsCounter++;
            }
        } elseif ('DeliveryNotes' === $orderParam) {
            $zero = 0;
            $note = $paramXml->$zero->__toString();
            $reportParts[] = '<hr>';
            $reportParts[] = "<i><b>Note:</b> $note</i>";
        }
    }
    echo '<pre>';
    echo implode('<br>', $reportParts);
}


function saveIntoJsonFile(array $arr, string $filePath)
{
    file_put_contents($filePath, json_encode($arr));
}

function readFromJsonFile(string $filePath): array
{
    return json_decode(file_get_contents($filePath), true);
}


function getArrayOfRandomInts(int $size): array
{
    $result = [];
    if ($size < 0) {
        $size = 0;
    }
    for ($i = 1; $i <= $size; $i++) {
        $result[] = round(rand(1, 100));
    }

    return $result;
}