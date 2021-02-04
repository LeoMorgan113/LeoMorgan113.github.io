<?php
require_once "connection.php";
header('Content-Type: text/html; charset=utf-8');

if(isset($_POST['delete_button'])){

    $link = mysqli_connect($host,  $user, $password, $database, $port);
	mysqli_set_charset($link, "utf-8");
    $id = $_POST["delete_button"];

    $query ="DELETE FROM devices WHERE id = '$id'";

    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    mysqli_close($link);
	header('Location: ../index.php'); exit();

}else {
    echo "Введенные данные некорректны";
}

