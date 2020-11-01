<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$path = $_POST['path']."/";
$inputFileName = $path .'fullList.xlsx';

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spreadsheet = $reader->load($inputFileName);
$worksheet = $spreadsheet->getActiveSheet();
$highestRow = $worksheet->getHighestRow(); // e.g. 10


$time_searching = '12:00';
$day_arr = [];
$month_arr =[];
$t_arr = [];
$wind_arr = [];
$speed_arr = [];


for ($row = 2; $row <= $highestRow; ++$row) {
    $time = $worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue();
    if($time == $time_searching){
        array_push( $day_arr, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
        array_push( $month_arr, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
        array_push( $t_arr, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
        $wind = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
        if($wind == null){
            $wind = 'null';
        }
        array_push( $wind_arr, $wind);
        array_push( $speed_arr, $worksheet->getCellByColumnAndRow(6, $row)->getValue());

    }
}




