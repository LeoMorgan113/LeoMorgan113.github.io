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
                <a href="../lab3/index.php"><img src="../img/Arrow_left.png" alt="Left"></a>
            </div>
            <div class="col-6" style="display:flex; justify-content: flex-end;"> 
                <a href="../lab5/index.html" ><img src="../img/Arrow_right.png" alt="Right" ></a>
            </div>
            <div class="col-12 wrapper">
                <form action="result.php" method="post">
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

                                $id = $row[0];
                                $name = $row[1];
                                $name_replace_space = str_replace(" ", "_", $name);
                                $height = $row[2];
                                $cost_veu = $row[3];
                                $cost_tower = $row[4];
                                $koef_cost = $row[5];
                                $rowToString = serialize([$id, $name_replace_space, $height, $cost_veu, $cost_tower, $koef_cost]);
                                $r = serialize([$id, $name_replace_space, $height, $cost_veu, $cost_tower, $koef_cost]);


                                $output .= '
                    <tr class="rowTable row" id="actual_' .$id.'_'.$name_replace_space.'"  >
                        <td class="col-6 col-md-1" >
                            <span class="switcher switcher-2">
                               <input type="checkbox" class="switcher-2" name="' .$id.'" value=`'.$rowToString.'`>
                               <label for="switcher-2"></label>
                            </span>
                        </td>
                        <td class="col-6 col-md-3" style="font-size: 14px;">'.$name.'</td>
                        <td class="col-6 col-md-2" style="font-size: 14px;">'.$height.'</td>
                        <td class="col-12 col-md-2" style="font-size: 14px;">'.$cost_veu. '</td>
                        <td class="col-12 col-md-2" style="font-size: 14px;">'.$cost_tower. '</td>
                        <td class="col-12 col-md-2">
                            <input class="button btn_chs" type="button" onclick="check(\'actual_'.$id.'_'.$name_replace_space.'\',\'change_'.$id.'_'.$name_replace_space.'\', \'none\', \'flex\')" value="О" name="change">
                            <form action="php/delete.php" method="post" style="display: inline;">
                                <button class="button btn_chs" type="submit" value="'.$id.'" name="delete_button">X</button>
                            </form>
                        </td>
                    </tr>
                    
                    <tr class="rowTable row" style="display: none" id="change_' .$id.'_'.$name_replace_space.'" >
                    <form action="php/change.php" method="post" >
                        <td class="col-1 col-md-1" >
                            <span class="switcher switcher-2">
                               <input type="checkbox" class="switcher-2" name="' .$id.'" value=`'.$rowToString.'`>
                               <label for="switcher-2"></label>
                            </span>
                        </td>
                        <td class="col-3 col-md-3" style="font-size: 14px;"><input name="name" required value="'.$name.'"></td>
                        <td class="col-2 col-md-2" style="font-size: 14px;"><input name="height" required value="'.$height.'"></td>
                        <td class="col-2 col-md-2" style="font-size: 14px;"><input name="cost_veu" required value="'.$cost_veu.'"></td>
                        <td class="col-2 col-md-2" style="font-size: 14px;">

                            <input name="cost_tower" value="'.$cost_tower.'">
                            </td>
                        </td>
                        
                        <td class="col-2 col-md-2">
                               <button class="button btn_add btn_chs" type="submit" value="'.$id.'" name="save_change">o</button>    
                               <button class="button btn_add btn_chs" type="button" onclick="check(\'actual_'.$id.'_'.$name_replace_space.'\',\'change_'.$id.'_'.$name_replace_space.'\', \'block\', \'none\')"  name="cancel_change">
                                x
                               </button>
                         </td>
                    </form>
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
                                <label>Ціна на одиницю скорочення викидів (ОСВ):</label><br>
                                <input type="text" name="price">$
                                <br>
                                <input class="button" type="button" value="Додати новий ВЕУ" id="add_button" onclick="display_add_device()"><br>

                                <div id="add_device" style="display: none">
                                    <form action="php/addToTable.php" method="post">
                                        <h5 style="color:#FB8B24;">Новий тип ВЕУ:</h5>
                                        <br>
                                        <label>Назва типу ВЕУ:</label>
                                        <input name="name" required>
                                        <br><br>
                                        <label>Висота:</label>
                                        <input name="height" required> м
                                        <br><br>
                                        <label>Вартість ВЕУ(без башти):</label>
                                        <input name="cost_veu" required> грн
                                        <br><br>
                                        <label>Встановити вартість башти: </label>
                                        <input name="cost_tower"  required> грн
                                        <input class="button" type="submit" value="Зберегти дані" name="submit" style="width: 20%;font-size: 13px;">
                                    </form>
                                </div>

                                <input class="button" type="submit" value="Відправити" name="submit">
                </form>

            </div>
        </div>
    </div>

    <script type="text/javascript">

        var handler = function ( event ){
          event = event || window.event;
          var target = event.target || event.srcElement;
          if ( target.nodeType == 1 && target.nodeName.toLowerCase() == "input" && target.type == "checkbox" && target.checked ) {
            var inputs = document.getElementsByTagName("input");
            for ( var i = 0; inputs[i]; i++ ) {
              if ( inputs[i].type == "checkbox" && inputs[i] != target ) {
                inputs[i].checked = false;
              }
            }
          }
        }
        if (document.addEventListener){
          document.addEventListener('click', handler, false);
        } else if (document.attachEvent){
          document.attachEvent('onclick', handler);
        }

        function check0(change){
            document.getElementById("change").style.display = change;
        }
        let inp = document.querySelectorAll('.save'),
        vals = localStorage.getItem('vals') ? localStorage.getItem('vals').split`,` : '';

        for(let i = 0; i < inp.length; i++) vals[i] ? inp[i].value = vals[i] : '';
        window.addEventListener('beforeunload',() => localStorage.setItem('vals', [...inp].map(e => e.value)) 
        );
        function check(actual, change, actual_val, change_val){
            document.getElementById(actual).style.display = actual_val;
            document.getElementById(change).style.display = change_val;
        }
        function display_add_device(){
            document.getElementById("add_device").style.display = "block";
            document.getElementById("add_button").style.display = "none";

        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/jquery-3.4.1.min.js"></script>
</body>
</html>