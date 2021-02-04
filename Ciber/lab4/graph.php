<?php

require '../lab1_Ann/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
$format_POST_array = [];
while (list($key, $val) = each($_POST)) {
    if ($key === "submit"){
        break;
    }
    $val_arr = unserialize(str_replace('`', '', $val));

    array_push($format_POST_array, $val_arr);
}
// echo "<br><br>Result post<br>";
// print_r($format_POST_array);


$path = '../lab1_Ann/databases/Kyiv';
$inputFileName = $path. '/fullList.xlsx';


//тут читаю з першої таблиці і шукаю часовий інтервал
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spreadsheet = $reader->load($inputFileName);
$worksheet = $spreadsheet->getActiveSheet();
$highestRow = $worksheet->getHighestRow(); // e.g. 10

$speed_arr = [];
for ($row = 2 ; $row <= $highestRow ; $row++) {
    array_push($speed_arr, $worksheet->getCellByColumnAndRow(6, $row)->getValue());
}


sort($speed_arr);
$height = $format_POST_array[0][2];
$count_val_speed = array_count_values($speed_arr);
$speed_diagr = [];
$speed_new = [];
$speed_hours_diagram = [];
while (list($key, $val) = each($count_val_speed)) {
    array_push($speed_diagr, $key);
    array_push($speed_new, round($key*(pow(($height/10), 0.14)), 3));
    array_push($speed_hours_diagram, $val*0.5);
}

// print_r($speed_new);
// echo "<br><br>";
// print_r($speed_hours_diagram);


// echo "<br><br>";
// Тут читаю із інтерполяційних талиць
$windtable = $format_POST_array[0][1].'.xlsx';
$price = $_POST['price'];
//echo $windtable;

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spreadsheet = $reader->load($windtable);
$worksheet = $spreadsheet->getActiveSheet();
$highestRow = $worksheet->getHighestRow(); // e.g. 10

$speed_arr_inter = [];
$power_inter = [];
$sum_power = 0;
for ($row = 2 ; $row <= $highestRow ; $row++) {
    array_push($speed_arr_inter, round($worksheet->getCellByColumnAndRow(1, $row)->getValue(), 2));
    array_push($power_inter, round($worksheet->getCellByColumnAndRow(2, $row)->getValue(), 2));
}
$array = [];
for ($i = 0; $i<count($speed_arr_inter); $i++) {
    $array[strval($speed_arr_inter[$i])] = $power_inter[$i];
}
// print_r($array);

$power_new = [];
$max = max(array_keys($array));
foreach ($speed_new as $value){

    foreach ($array as $key2 => $value2){
        if($value <= $key2) {
            array_push($power_new, $value2);
            break;
        }else if($value >= $max){
            array_push($power_new, $array[$max]);
            break;
        }

    }

}
// echo "<br><br>Power: ";

// print_r($power_new);

//Виведу значення
// echo "Interpol wind: <br><br>";
// print_r($speed_arr_inter);

// echo "Interpol power: <br><br>";
// print_r($power_inter);
for($i=0; $i<count($speed_new); $i++){
    $sum_power += $speed_new[$i]*$power_new[$i];
}
// echo "<br>Sum: ".$sum_power;
$sum = round($sum_power, 2);

// echo "\nInterpol power: <br><br>";
// print_r($sum);

$co2 = round($sum*0.000943, 2);
$money = round($price*$co2, 3);
?>



