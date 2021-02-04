<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;

$inputFileName = $path. '/fullList.xlsx';
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spreadsheet = $reader->load($inputFileName);
$worksheet = $spreadsheet->getActiveSheet();
$highestRow = $worksheet->getHighestRow(); // e.g. 10
$all_t_arr = [];

for ($row = 1 ; $row <= $highestRow ; $row++) {
        array_push($all_t_arr, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
}

sort($all_t_arr);
$count_val = array_count_values($all_t_arr);
$temp_diagr = [];
$temp_hours_diagram = [];
$Q_searching = 0;
$Q_i = 0;
while (list($key, $val) = each($count_val)) {
    $d_T = $key - $T_inside_build;
    $Q_searching += func($key, $k, $b, $d_T)*$val*0.5;
}
$Q_searching = $Q_searching/10;

