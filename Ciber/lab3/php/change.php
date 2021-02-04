<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('UTC');

if(isset($_POST['save_change'])){
    require_once "connection.php";
    $id = $_POST['save_change'];
    $min = $_POST['min'];
    $max = $_POST['max'];
    $power = $_POST['power'];

    if($power > $max || $power < $min){
        header("Location: ../index.php?error=errorPower");
        exit();

    }


    $link = mysqli_connect($host,  $user, $password, $database, $port);
    mysqli_set_charset($link, "utf8");
    print_r($_POST);

    $name_value = $_POST['name'];
    $type_value = $_POST['type'];
    $duration = null;
    $dev = null;
    $break = null;
    $sql = '';

    if($type_value === 'on/auto' || $type_value === "auto"){
        $duration=$_POST['avr_time'];
        $dev=$_POST['dev_time'];
        if($type_value==="auto"){
            $break=$_POST['break_time'];
        }
    }


    $sql = "UPDATE devices SET name_head='$name_value', type_head='$type_value', min_pwr=$min, max_pwr=$max, curr_val_pwr=$power, avr_time='$duration', dev_time='$dev',break_time='$break' WHERE id=$id";
    $result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));

    mysqli_close($link);
    header('Location: ../index.php');
    exit();

}