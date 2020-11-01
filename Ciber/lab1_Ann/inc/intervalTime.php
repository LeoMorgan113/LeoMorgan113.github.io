<?php

$time_start = $_POST['startTime'];
$time_end = $_POST['endTime'];
$step = $_POST['step'];

$diff = date("H:i", strtotime($time_end) - strtotime($time_start));

if(strtotime($time_start) >= strtotime($time_end)){
    header("Location: ../Lab1CompSystem/index.php?errorTime=startBigEnd");
    exit();
}elseif (strtotime($diff) < strtotime($step)){
    header("Location: ../Lab1CompSystem/index.php?errorTime=stepError");
    exit();
}

$temp = $time_start;
$time_interval_arr = [];
do{
    array_push($time_interval_arr, $temp);
    $temp = date("H:i", strtotime($temp) + strtotime($step));

}while(strtotime($temp) < strtotime($time_end));
if(!in_array($time_end, $time_interval_arr)){
    array_push($time_interval_arr, $time_end);
}

for ( ; $row <= $highestRow ; $row++) {

    $time = $worksheet->getCellByColumnAndRow(3, $row)->getFormattedValue();
    $day = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
    $month = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
    if($month > $date_end[1]){
        break;
    }else if($month === $date_end[1]){
        if($day > $date_end[2]){
            break;
        }
    }
    if (in_array($time, $time_interval_arr)) {
        array_push($date_arr, strval($day.'.'.$month.' time: '.$time));
        array_push($t_arr, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
        $w = $worksheet->getCellByColumnAndRow(5, $row)->getFormattedValue();
        $speed = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
        $iter = 0;

        if ($speed !== 0){
            $iter = $winds_type[strval($w)];
        }else{
            $iter = $winds_type['Штиль'];
        }
        array_push($all_winds[$iter], $worksheet->getCellByColumnAndRow(6, $row)->getValue());
        array_push($all_t_arr, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
        array_push($speed_arr, $worksheet->getCellByColumnAndRow(6, $row)->getValue());
        array_push($sun_arr, $worksheet->getCellByColumnAndRow(7, $row)->getValue());

    }


}
