<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
function lastDay($month){
    if ($month == 2){
        return 29;
    }else if($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12){
        return 31;
    }else{
        return 30;
    }
}


$inputFileName = $_POST['path'];

$path = explode("/",$_POST['path']);
print_r($path);
$spreadsheet2 = new Spreadsheet();
$sheet = $spreadsheet2->getActiveSheet();

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
$reader->setInputEncoding('CP1252');
$reader->setDelimiter(',');
$reader->setEnclosure('');
$reader->setSheetIndex(0);

$spreadsheet = $reader->load($inputFileName);
$worksheet = $spreadsheet->getActiveSheet();
$highestRow = $worksheet->getHighestRow(); // e.g. 10
$sheetData   = $spreadsheet->getActiveSheet()->toArray();
//2
//1 - header

$sheet->setCellValue('A1', 'День');
$sheet->setCellValue('B1', 'Місяць');
$sheet->setCellValue('C1', 'Час');
$sheet->setCellValue('D1', 'Знач. сонячної інс.');

$row_table2 = 2;
$flag = true;
for ($row = 2; $row <= $highestRow; ++$row) {
    $r = $sheetData[$row];
    $data = explode("/", $r[0]);
    $day = (int)$data[1];
    $month = (int)$data[0];
    $time = $r[1];
    if ($time == '24:00'){
        if($day == 31 && $month == 12){
            break;
        }else {
            $time = '00:00';
            $data_next = explode("/", $sheetData[$row + 1][0]);
            if ($day == lastDay($month)) {
                $month = (int)$data_next[0];
            }
            $day = (int)$data_next[1];
        }
    }

    $time_next = date("H:i", strtotime($sheetData[$row+1][1]));

    $value = $r[2];
    do {
        $sheet->setCellValue('A' . $row_table2, $day);
        $sheet->setCellValue('B' . $row_table2, $month);
        $sheet->setCellValue('C' . $row_table2, $time);
        $sheet->setCellValue('D' . $row_table2, $value);
        $row_table2++;

        $time = date("H:i", strtotime($time) + strtotime('0:30'));

    } while (strcmp($time, $time_next) != 0);



}



$writer = new Xlsx($spreadsheet2);
$filename = 'csv/sun_'.explode('.', $path[1])[0].'.xlsx';
try {
    $writer->save($filename);
} catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
    echo $e;

}

echo "Successfully saved";