<?php
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