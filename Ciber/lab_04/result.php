<?php
error_reporting(0);
require_once "php/connection.php";
header('Content-Type: text/html; charset=utf-8');

$link = mysqli_connect($host,  $user, $password, $database, $port);
if (!$link) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

mysqli_set_charset($link, "utf8");
    
    $id = $_POST['save_change'];
    $name = $_POST['name'];
    $height = $_POST['height'];
    $cost_veu = $_POST['c_veu'];
    $cost_tower = $_POST['c_tower'];
    $koef_cost = $_POST['koef'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lab Work №4</title>
    <link href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style_lab5.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a href="../index.html"><img src="../img/LOGO.svg" alt="Logo" class="logo"></a>
                <h1>Визначення ефективності впровадження вітроенергетичної установки для потреб енергозабезпечення об’єкта</h1>
            </div>
            <div class="col-6" style="display:inline-flex;">
                <a href="../lab3/index.html"><img src="../img/Arrow_left.png" alt="Left"></a>
            </div>
            <div class="col-6" style="display:flex; justify-content: flex-end;"> 
                <a href="../lab5/index.html" ><img src="../img/Arrow_right.png" alt="Right" ></a>
            </div>
            <div class="col-12 wrapper" style="text-align: left;">
                <p>Тип ВЕУ: <?php echo $name ?></p>
                <p>Висота башти: <?php echo $height ?></p>
                <p>Вартість ВЕУ(без башти): <?php echo $cost_veu ?></p>
                <p>Вартість башти: <?php echo $cost_tower ?></p>
                <p>Обсяг генерування електричної енергії: </p>
                <p>Обсяг скорочення викидів: </p>
                <p>Дохід: </p>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/jquery-3.4.1.min.js"></script>
</body>
</html>