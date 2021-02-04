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
    <title>Lab Work №3</title>
    <link href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style_lab3.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a href="../index.html"><img src="../img/LOGO.svg" alt="Logo" class="logo"></a>
                <h1>Моделювання графіка електричного навантаження</h1>
            </div>
            <div class="col-6" style="display:inline-flex;">
                <a href="../lab2/index.html"><img src="../img/Arrow_left.png" alt="Left"></a>
            </div>
            <div class="col-6" style="display:flex; justify-content: flex-end;"> 
                <a href="../lab4/index.php" ><img src="../img/Arrow_right.png" alt="Right" ></a>
            </div>
            <div class="col-12 wrapper">
                <div id="toNewWindow">
                <h3>Для моделювання графіків електричного навантаження оберіть електроприбори та заповніть дані:</h3>
                        <?php
                        if (isset($_GET['error'])) {
                           echo "<div class='error'>Зміни не збереглися. Значення потужності для даного приладу виходить за вказані межі.</div>";
                        }
                        ?>
                        <div class="row">
                        <div class="col-12">
                            
                          
                        
                        <form action="computing.php" method="post">
                            <table class="table" bordered = "1">
                                <tr class="row main_head" style="margin:0;">
                                    <td class="d-none d-md-block col-md-1 " >Вибрати</td>
                                    <td class="d-none d-md-block col-md-3 " >Назва</td>
                                    <td class="d-none d-md-block col-md-2">Тип</td>
                                    <td class="d-none d-md-block col-md-2">Середнє значення потужності, Вт/год</td>
                                    <td class="d-none d-md-block col-md-2">Змінити</td>
                                    <td class="d-none d-md-block col-md-2">Видалити</td>
                                </tr>
                            <?php
                        header('Content-Type: text/html; charset=utf-8');
                        $query ="SELECT * FROM devices";
                        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
                        $rows = mysqli_num_rows($result); // количество полученных строк
                        $output = '';

                        if($rows) {
                            for ($i = 0 ; $i < $rows ; ++$i) {
                                $row = mysqli_fetch_row($result);
                                $r = serialize($row);
                                $id = $row[0];
                                $name = $row[1];
                                $type = $row[2];
                                $min = (int)$row[3];
                                $max = (int)$row[4];
                                $pwr = (int)$row[5];
                                $duration = $row[6];
                                $dev = $row[7];
                                $break = $row[8];
                                $rowToString = serialize($row);


                                $output .= '
                    <tr class="rowTable row" id="actual_' .$id.'_'.$name.'" xmlns="http://www.w3.org/1999/html" >
                        <td class="col-6 col-md-1" >
                            <span class="switcher switcher-2">
                               <input type="checkbox" class="switcher-2" name="' .$id.'" value=`'.$rowToString.'`>
                               <label for="switcher-2"></label>
                            </span>
                        <td class="col-6 col-md-3" style="font-size: 14px;">'.$name.'</td>
                        <td class="col-6 col-md-2" style="font-size: 14px;">'.$type.'</td>
                        <td class="col-12 col-md-2" style="font-size: 14px;">'.$pwr. '</td>
                        <td class="col-12 col-md-2">
                        <input class="button btn_chs" type="button" onclick="check(\'actual_'.$id.'_'.$name.'\',\'change_'.$id.'_'.$name.'\', \'none\', \'block\')" value="О" name="change">
                        </td>
                        <td class="col-12 col-md-2">
                            <form action="php/delete.php" method="post">
                                <button class="button btn_chs" type="submit" value="'.$id.'" name="delete_button">X</button>
                            </form>
                        </td>
                    </tr>
                 
                         <tr class="rowTable row" style="display: none" id="change_'.$id.'_'.$name.'">
                         <form action="php/change.php" method="post" >
                                <td class="col-1 col-md-1" style="width:15%;"> 
                                <span class="switcher switcher-2">
                                   <input type="checkbox" class="switcher-2" name="' .$id.'" value=`'.$rowToString.'`>
                                   <label for="switcher-2"></label>
                                </span>
                                <td class="col-2 col-md-2" style="width:15%;"><input name="name" required value="'.$name.'"></td>
                                <td class="col-3 col-md-3" style="width:30%;">
                                    <div class="styled">
                                        <select name="type" required>
                                            <option value="'.$type.'" selected>Обраний тип: '.$type.'</option>
                                            <option value="on/off">Ручне вкл/викл</option>
                                            <option value="on/auto">Ручне вкл та автоматичне викл</option>
                                            <option value="auto">Автоматичне вкл/викл</option>
                                        </select>
                                    </div>
                                </td>
                                
                                <td class="col-2 col-md-2">
                                    <p style="font-size: 14px;"> Min: <span>'.$min. '</span>
                                    Max: <span>'.$max. '</span></p>
                                    
                                    <span><label style="margin-bottom:15px;">Поточна потужність: </label><input name="power" required value="'.$pwr. '"></span><br>  ';
                                if($type === 'on/auto' || $type === 'auto'){
                                   $output .= '
                                        <span><label style="margin-bottom:15px;">Середня тривалість: </label>
                                        <input type="time" step=\'1\' required name="avr_time" value="'.$duration.'"></span><br>
                                    
                                        <span><label style="margin-bottom:15px;">Відхилення від середнього: </label>
                                        <input type="time" step=\'1\' required name="dev_time" value="'.$dev.'"></span><br>
                                   ';
                                   if($type === 'auto'){
                                      $output .= '<span><label>Перерва: </label>
                                     <input type="time" step=\'1\' required name="break_time" value="'.$break.'"><>';
                                   }

                                }

                                $output .= '</td>
                                <td class="col-2 col-md-2">
                                    <button class="button btn_add" type="submit" value="'.$id.'" name="save_change">o</button>
                                </td>
                                
                                <td class="col-2 col-md-32">
                                <button class="button btn_add" type="button" onclick="check(\'actual_'.$id.'_'.$name.'\',\'change_'.$id.'_'.$name.'\', \'block\', \'none\')"  name="cancel_change">
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
                        <input class="button" type="button" value="Додати новий прилад" id="add_button" onclick="display_add_device()"><br>

                        <div id="add_device" style="display: none">
                            <form action="php/addToTable.php" method="post">
                                <h5 style="color:#FB8B24;">Додайте новий прилад:</h5>
                                <br>
                                <label>Назва приладу :</label>
                                <input name="name" required>
                                <br><br>
                                <div class="styled">
                                    <select name='type' required id="choice_add"><option disabled selected>Виберіть тип</option>
                                        <option value='on/off'>Ручне вмикання та вимикання</option>
                                        <option value='on/auto'>Ручне вмикання та автоматичне вимикання</option>
                                        <option value='auto'>Автоматичне вмикання та вимикання</option>
                                    </select>
                                </div>
                                <br>
                                <label>Мінімальне значення потужності:</label>
                                <input name="min" required>
                                <br><br>
                                <label>Максимальне значення потужності:</label>
                                <input name="max" required>
                                <br><br>

                                <div id="time_avr" style="display: none">
                                    <label>Середня тривалість</label>
                                    <input type="time" step='1' name="avr_time">
                                </div>

                                <div id="time_dev" style="display: none">
                                    <label>Відхилення від середнього</label>
                                    <input type="time" step='1' name="dev_time">
                                </div>

                                <div id="time_break" style="display: none">
                                    <label>Перерва</label>
                                    <input type="time" step='1' name="break_time">
                                </div>
                                <input class="button" type="submit" value="Зберегти дані" name="submit" style="width: 20%;font-size: 13px;">
                            </form>
                        </div>
                        <input class="button" type="submit" value="Відправити" name="submit">
                </form>
                    </div>  
                    </div>

                    <a href="javascript:;" id="print" style="color:white;">Завантажити звіт</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/jquery-3.4.1.min.js"></script>

    <script type="text/javascript">
        function nWin() {
          var w = window.open();
          var html = $("#toNewWindow").html();

            $(w.document.body).html(html);
            w.print();
        }

        $(function() {
            $("a#print").click(nWin);
        });
        $("#choice_add").change(function(){
            if($(this).val()==="on/auto" || $(this).val()==="auto") {
                $("#time_avr").show();
                $("#time_dev").show();
            } else {
                $("#time_avr").hide();
                $("#time_dev").hide();
            }

            if($(this).val()==="auto"){
                $("#time_break").show();
            }else{
                $("#time_break").hide();
            }
        });

        function func_show(){
            document.getElementById("time_avr").style.display ="block";
        }
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