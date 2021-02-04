<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('UTC');

if(isset($_POST['name']) && isset($_POST['height'])&& isset($_POST['cost_veu']) && (isset($_POST['cost_tower']) || isset($_POST['koef_cost']))) {

    require_once "connection.php";
    $link = mysqli_connect($host,  $user, $password, $database, $port);
    mysqli_set_charset($link, "utf8");

    $id = $_POST['save_change'];
    $name = $_POST['name'];
    $height = $_POST['height'];
    $cost_veu = $_POST['cost_veu'];
    $cost_tower = $_POST['cost_tower'];
    $koef_cost = null;



    $query = "INSERT INTO veu_wind VALUES(NULL, '$name', '$height', '$cost_veu', '$cost_tower', '$koef_cost')";

    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    mysqli_close($link);
    header('Location: ../index.php'); exit();
}else {
    echo "Введенные данные некорректны";

}



