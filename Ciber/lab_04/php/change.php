<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('UTC');

if(isset($_POST['save_change'])){
    require_once "connection.php";
    $id = $_POST['save_change'];
    $name = $_POST['name'];
    $height = $_POST['height'];
    $cost_veu = $_POST['c_veu'];
    $cost_tower = $_POST['c_tower'];
    $koef_cost = $_POST['koef'];


    $link = mysqli_connect($host,  $user, $password, $database, $port);
    mysqli_set_charset($link, "utf8");
    print_r($_POST);

    $sql = '';


    $sql = "UPDATE veu_wind SET name = $name, height ='$height', cost_veu = $cost_veu, cost_tower = $cost_tower, koef_cost = $koef_cost WHERE id=$id";
    $result = mysqli_query($link, $sql) or die("Ошибка " . mysqli_error($link));

    mysqli_close($link);
    header('Location: ../index.php');
    exit();

}