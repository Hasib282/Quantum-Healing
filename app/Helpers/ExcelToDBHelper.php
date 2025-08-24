<?php

    // Convert Excel date to Php date
    if (!function_exists('excelDateToPhp')) {
        function excelDateToPhp($excelDate) {
            if (!is_numeric($excelDate)) {
                return $excelDate; // Already a string, just return as-is
            }
            // Excel stores days since 1899-12-30
            $unixDate = ($excelDate - 25569) * 86400; 
            if ($unixDate <= 0) {
                return $excelDate; // Probably not a date
            }
            return gmdate("Y-m-d", $unixDate); 
        }
    }  // End Method




    if (!function_exists('readXlsxRaw')) {
        // Read Excel Data
        function readXlsxRaw($filePath)
        {
            $zip = new \ZipArchive;
            $rows = [];

            if ($zip->open($filePath) === true) {
                // Load shared strings
                $sharedStrings = [];
                if (($sharedStringsXML = $zip->getFromName('xl/sharedStrings.xml')) !== false) {
                    $xml = simplexml_load_string($sharedStringsXML);
                    
                    foreach ($xml->si as $string) {
                        $text = '';
                        if (isset($string->t)) {
                            $text = (string)$string->t;
                        } else {
                            foreach ($string->r as $run) {
                                $text .= (string)$run->t;
                            }
                        }
                        $sharedStrings[] = $text;
                    }
                }
                
                // Load first sheet
                $sheetXML = $zip->getFromName('xl/worksheets/sheet1.xml');
                $sheet = simplexml_load_string($sheetXML);
                $isHeader = true;

                $rows = [];
                foreach ($sheet->sheetData->row as $row) {
                    $cells = [];
                    $lastCol = 0;

                    foreach ($row->c as $c) {
                        // Convert Excel column (A,B,C..) to index
                        preg_match('/([A-Z]+)/', (string)$c['r'], $matches);
                        $col = $matches[1];
                        $colIndex = 0;
                        foreach (str_split($col) as $char) {
                            $colIndex = $colIndex * 26 + (ord($char) - 64);
                        }
                        // Fill skipped empty columns
                        while ($lastCol < $colIndex - 1) {
                            $cells[] = "";
                            $lastCol++;
                        }
                        
                        // Get cell value
                        $value = (string)$c->v;
                        if (isset($c['t']) && (string)$c['t'] === 's') {
                            $value = $sharedStrings[(int)$value] ?? '';
                        }
                        
                        $cells[] = $value;
                        $lastCol = $colIndex;
                    }
                    
                    $rows[] = $cells;
                }

                $zip->close();
            }

            return $rows;
        }  
    }   // End Method



    