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
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lab Work №4</title>
    <link href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style_lab4.css">
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
            <div class="col-12 wrapper">
                <form action="computing.php" method="post">
                            <table class="table" bordered = "1">
                                <tr class="row main_head" style="margin:0;">
                                    <td class="d-none d-md-block col-md-1 " >Обрати</td>
                                    <td class="d-none d-md-block col-md-3 " >Назва типу ВЕУ</td>
                                    <td class="d-none d-md-block col-md-2">Висота, м</td>
                                    <td class="d-none d-md-block col-md-2">Вартість ВЕУ (без башти), грн</td>
                                    <td class="d-none d-md-block col-md-2">Вартість башти, грн</td>
                                    <td class="d-none d-md-block col-md-2">Оновити/Видалити</td>
                                </tr>
                            <?php
                        header('Content-Type: text/html; charset=utf-8');
                        $query ="SELECT * FROM veu_wind";
                        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                        $rows = mysqli_num_rows($result); // количество полученных строк
                        $output = '';

                        if($rows) {
                            for ($i = 0 ; $i < $rows ; ++$i) {
                                $row = mysqli_fetch_row($result);
                                $r = serialize($row);
                                $id = $row[0];
                                $name = $row[1];
                                $height = $row[2];
                                $cost_veu = $row[3];
                                $cost_tower = $row[4];
                                $koef_cost = $row[5];
                                $rowToString = serialize($row);


                                $output .= '
                    <tr class="rowTable row" id="actual_' .$id.'_'.$name.'" xmlns="http://www.w3.org/1999/html" >
                        <td class="col-6 col-md-1" >
                            <span class="switcher switcher-2">
                               <input type="checkbox" class="switcher-2" name="' .$id.'" value=`'.$rowToString.'`>
                               <label for="switcher-2"></label>
                            </span>
                        <td class="col-6 col-md-3" style="font-size: 14px;">'.$name.'</td>
                        <td class="col-6 col-md-2" style="font-size: 14px;">'.$height.'</td>
                        <td class="col-12 col-md-2" style="font-size: 14px;">'.$cost_veu. '</td>
                        <td class="col-12 col-md-2" style="font-size: 14px;">'.$cost_tower. '</td>
                        <td class="col-12 col-md-2">
                        <input class="button btn_chs" type="button" onclick="check(\'actual_'.$id.'_'.$name.'\',\'change_'.$id.'_'.$name.'\', \'none\', \'block\')" value="О" name="change">
                            <form action="php/delete.php" method="post" style="display: inline;">
                                <button class="button btn_chs" type="submit" value="'.$id.'" name="delete_button">X</button>
                            </form>
                        </td>
                    </tr>
                        <tr class="rowTable row" id="actual_' .$id.'_'.$name.'" xmlns="http://www.w3.org/1999/html" >
                            <td class="col-6 col-md-1" >
                                <span class="switcher switcher-2">
                                   <input type="checkbox" class="switcher-2" name="' .$id.'" value=`'.$rowToString.'`>
                                   <label for="switcher-2"></label>
                                </span>
                            <td class="col-6 col-md-3" style="font-size: 14px;"><input name="name" required value="'.$name.'"></td>
                            <td class="col-6 col-md-2" style="font-size: 14px;"><input name="height" required value="'.$height.'"></td>
                            <td class="col-12 col-md-2" style="font-size: 14px;"><input name="cost_veu" required value="'.$cost_veu.'"></td>
                            <td class="col-12 col-md-2" style="font-size: 14px;">
                                <div id="choice">

                                <input type="radio" name="choice1" value="koef_choice" onclick="check(\'block\',\'none\')">Змінити коефіціент вартості<br>
                                <div id="koef"  style="display: none"><input name="koef_cost" value="'.$koef_cost.'"></div>

                                <input type="radio" name="choice1" value="cost_choice" onclick="check(\'none\', \'block\')">Змінити вартість башти<br>

                                <div id="twr"  style="display: none"><input name="cost_tower" value="'.$cost_tower.'"> грн</div>
                                <script>
                                    function check(koef, twr){
                                        document.getElementById("koef").style.display = koef;
                                        document.getElementById("twr").style.display = twr;
                                    }
                                </script>

                                </div>
                            </td>
                            <td class="col-12 col-md-2">
                                <button class="button btn_chs" type="submit" value="'.$id.'" name="save_change">o</button>
                                <form action="php/delete.php" method="post" style="display: inline;">
                                    <button class="button btn_chs" type="submit" value="'.$id.'" name="delete_button">x</button>
                                </form>
                            </td>
                        </tr>';

                                
                            }
                            $output .= '</table>';
                            echo $output;
                            // очищаем результат
                            mysqli_free_result($result);
                        }else{
                            echo '<h6>Записів немає</h6>';
                        }
                        ?>
                        <input class="button" type="button" value="Додати новий ВЕУ" id="add_button" onclick="display_add_device()"><br>

                        <div id="add_device" style="display: none">
                            <form action="php/addToTable.php" method="post">
                                <h5 style="color:#FB8B24;">Новий тип ВЕУ:</h5>
                                <br>
                                <label>Назва типу ВЕУ:</label>
                                <input name="name" required>
                                <br><br>
                                <label>Висота:</label>
                                <input name="height" required>
                                <br><br>
                                <label>Вартість ВЕУ(без башти):</label>
                                <input name="cost_veu" required>
                                <br><br>

                                <div>

                                    <input type="radio" name="choice1" value="koef_choice" onclick="check('block','none')">Встановити коефіціент вартості башти: <br>
                                    <div id="koef0"  style="display: none"><input name="koef_cost"></div>

                                    <input type="radio" name="choice1" value="cost_choice" onclick="check('none', 'block')">Встановити вартість башти<br>

                                    <div id="twr0"  style="display: none"><input name="cost_tower"> грн</div>
                                    <script>
                                        function check(koef, twr){
                                            document.getElementById("koef0").style.display = koef;
                                            document.getElementById("twr0").style.display = twr;
                                        }
                                    </script>
                                </div>
                                <input class="button" type="submit" value="Зберегти дані" name="submit" style="width: 20%;font-size: 13px;">
                            </form>
                        </div>
                        <input class="button" type="submit" value="Відправити" name="submit">
                </form>

            
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function display_add_device(){
            document.getElementById("add_device").style.display = "block";
            document.getElementById("add_button").style.display = "none";

        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/jquery-3.4.1.min.js"></script>
</body>
</html>