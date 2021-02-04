<?php

if (!isset($_POST['submit'])){
    header("Location: ../lab1_Ann/index.php?error=enterButton");
    exit();
}
if (!isset($_POST['path'])){
    header("Location: ../lab1_Ann/index.php?error=chooseCity");
    exit();
}
if(strtotime($_POST['start']) > strtotime($_POST['end'])){
    header("Location: ../lab1_Ann/index.php?errorDate=startBigEnd");
    exit();
}

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$path = $_POST['path'] . "/";
$inputFileName = $path . 'fullList.xlsx';
$city = explode('/', $path)[1];
if(!file_exists($inputFileName)){
    include "fullListLoad.php";
}



$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$spreadsheet = $reader->load($inputFileName);
$worksheet = $spreadsheet->getActiveSheet();
$highestRow = $worksheet->getHighestRow(); // e.g. 10

$time_arr = explode(":",$_POST['time'] );

$time_searching = strval((int)$time_arr[0]).":".$time_arr[1];
$date_arr = [];
$month_arr = [];
$t_arr = [];
$wind_arr = [];
$speed_arr = [];
$sun_arr = [];
$date_start = explode('-', $_POST['start']);
$date_end = explode('-', $_POST['end']);
$all_t_arr = [];
$winds_type = array(
        'Северный' => 0,
        'С-В' => 1,
        'Восточный' => 2,
        'Ю-В' => 3,
        'Южный' => 4,
        'Ю-З' => 5,
        'Западный' => 6,
        'С-З' => 7,
        'Переменный' => 8,
        'Штиль' => 9
);


$all_winds = array(
        [],[],[],[], [],[],[],[],
        [],[]
);
$month = 1;
$row = 2;

$date_start[1] = (int)$date_start[1];
$date_start[2] = (int)$date_start[2];
$date_end[1] = (int)$date_end[1];
$date_end[2] = (int)$date_end[2];
$day = 1;


while(true){
    $month = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
    $day = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
    if($day === $date_start[2] && $month === $date_start[1]){
        break;
    }else {
        $row += 48;
    }
}
$choice = $_POST['choice'];

if($choice == 'time'){
    include "inc/oneTime.php";
    $time_searching = $_POST['time'];
}elseif($choice == 'day'){
    include "inc/fullDay.php";
    $time_searching = '';
}elseif ($choice == 'time_from_to'){
    include "inc/intervalFromTo.php";
    $time_searching = $_POST['FromToStart']." - ".$_POST['FromToEnd'];
}elseif ($choice == 'time_interval'){
    include "inc/intervalTime.php";
    $time_searching = $_POST['startTime']." - ".$_POST['endTime'];
}else{
 header('/Lab1CompSystem?error=MethodIsNotChosen');
 exit();
}



sort($speed_arr);
$count_val_speed = array_count_values($speed_arr);
$speed_diagr = [];
$speed_hours_diagram = [];
while (list($key, $val) = each($count_val_speed)) {
    array_push($speed_diagr, $key);
    array_push($speed_hours_diagram, $val*0.5);
}



?>
<?php
function countInRange($numbers,$lowest,$highest){
//bounds are included, for this example
    return count(array_filter($numbers,function($number) use ($lowest,$highest){
            return ($lowest<=$number && $number <=$highest);
        })
    );
}
function generateData($all_winds, $lowest, $highest){
    for($i = 0; $i < 10; $i++){
        echo countInRange($all_winds[$i], $lowest, $highest);
        if($i < 9){
            echo ",";
        }
    }
}

function generateData1($all_winds, $lowest, $highest){
    $ret_arr = [];
    for($i = 0; $i < 9; $i++){
        array_push($ret_arr, countInRange($all_winds[$i], $lowest, $highest));
    }
    return $ret_arr;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Графіки</title>
    <link rel="stylesheet" type="text/css" href="">
    <script src="node_modules/chart.js/dist/Chart.js"></script>
    <script src="https://www.koolchart.com/demo/LicenseKey/codepen/KoolChartLicense.js"></script>
    <script src="https://www.koolchart.com/demo/KoolChart/JS/KoolChart.js"></script>
    <link rel="stylesheet" href="https://www.koolchart.com/demo/KoolChart/Assets/Css/KoolChart.css"/>
    <link rel="stylesheet" href="https://www.koolchart.com/demo/Samples/Web/sample.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@500&display=swap" rel="stylesheet">

</head>


<body>

<div class="graph_header">
    <h4>Графіки для міста: <?php echo $city?></h4>
    <h5>Дата: <?php echo $_POST['start'].' — '.$_POST['end']?></h5>
    <h5>Часовий інтервал: <?php echo $time_searching?></h5>
</div>
<canvas id="TempShow"></canvas>
<?php include "inc/TempGraph.php"; ?>
<br><br><br>

<canvas id="TempDiagram"></canvas>
<?php include "inc/TempDiagr.php"; ?>
<br><br><br>

<div id="chartHolder" style="height:750px; width:100%;"></div>
<?php include "inc/WindRose.php"?>
<br><br><br>

<canvas id="SpeedDiagram"></canvas>
<?php include "inc/SpeedDiagr.php";?>
<br><br><br>

<canvas id="SunGraph"></canvas>
<?php include "inc/SunGraph.php";?>
<br><br><br>

<canvas id="SunDiagr"></canvas>
<?php include "inc/SunDiagr.php"?>




</body>
</html>