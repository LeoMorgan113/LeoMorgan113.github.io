<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$path = $_POST['path']."/";

$spreadsheet2 = new Spreadsheet();
$sheet = $spreadsheet2->getActiveSheet();
$sheet->setCellValue('A1', 'День');
$sheet->setCellValue('B1', 'Місяць');
$sheet->setCellValue('C1', 'Час');
$sheet->setCellValue('D1', 'Температура');
$sheet->setCellValue('E1', 'Вітер-напрямок');
$sheet->setCellValue('F1', 'Вітер-швидкість');
$row_table2 = 2;


for ($i = 1; $i <= 12; $i++) {

    $month = $i;
    $inputFileName = $path . '2012-' . $i . '.xlsx';
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $spreadsheet = $reader->load($inputFileName);
    $worksheet = $spreadsheet->getActiveSheet();
    $highestRow = $worksheet->getHighestRow(); // e.g. 10
    //row = 1 is a header

    for ($row = 2; $row <= $highestRow; ++$row) {
        $day = $worksheet->getCellByColumnAndRow(1, $row)->getFormattedValue();
        $time = $worksheet->getCellByColumnAndRow(2, $row)->getFormattedValue();
        $time_next = $worksheet->getCellByColumnAndRow(2, $row + 1)->getFormattedValue();
        $t = $worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue();
        $wind = $worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue();
        $speed = $worksheet->getCellByColumnAndRow(5, $row)->getFormattedValue();
        do {
            $sheet->setCellValue('A' . $row_table2, $day);
            $sheet->setCellValue('B' . $row_table2, $month);
            $sheet->setCellValue('C' . $row_table2, $time);
            $sheet->setCellValue('D' . $row_table2, $t);
            $sheet->setCellValue('E' . $row_table2, $wind);
            $sheet->setCellValue('F' . $row_table2, $speed);
            $row_table2++;

            $time = date("H:i", strtotime($time) + strtotime('0:30'));
            $time_next = date("H:i", strtotime($time_next));

        } while (strcmp($time, $time_next) != 0);
    }

}

$writer = new Xlsx($spreadsheet2);
$filename = $path . 'fullList.xlsx';
try {
    $writer->save($filename);
} catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
    echo $e;

}
header("Location: ../index.php");

