<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('UTC');

if(isset($_POST['name']) && isset($_POST['type'])&& isset($_POST['min']) && isset($_POST['max'])) {

    require_once "connection.php";
    $link = mysqli_connect($host,  $user, $password, $database, $port);
    mysqli_set_charset($link, "utf8");

    $name = $_POST['name'];
    $type = $_POST['type'];
    $min = $_POST['min'];
    $max = $_POST['max'];
    $pwr = ($min+$max)/2;
    $avr_time = null;
    $dev_time = null;
    $break_time = null;
    if($type === "on/auto" || $type ==="auto"){
        if(isset($_POST['avr_time'])){
            $avr_time = $_POST['avr_time'];
        }
        if(isset($_POST['dev_time'])){
            $dev_time = $_POST['dev_time'];
        }
    }


    if($type ==="auto" && isset($_POST['break_time'])){
        $break_time = $_POST['break_time'];
    }
    $query = "INSERT INTO devices VALUES(NULL, '$name','$type', '$min', '$max', '$pwr', '$avr_time', '$dev_time', '$break_time')";

    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    mysqli_close($link);
    header('Location: ../index.php'); exit();
}else {
    echo "Введенные данные некорректны";

}



