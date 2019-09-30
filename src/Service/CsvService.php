<?php

namespace Temper\Service;

use ParseCsv\Csv;

class CsvService
{
    /**
     * @param string $path
     * @return array
     */
    public function getContents(string $path): array
    {
        $csv = new Csv();
        $csv->offset = 1;
        $csv->delimiter = ';';
        $csv->parse($path);

        return $csv->data;
    }
}
