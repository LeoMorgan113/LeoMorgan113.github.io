<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>LabWork№1</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@500&display=swap" rel="stylesheet">
</head>
<body>

<div class="wrapper">

    <form action="graphics.php" method="post">

        <h1>
            Аналіз метеорологічних даних регіону
        </h1>
        <h5 align="right">Шерепи Анни, ТІ-81</h5>
        <?php

        if(isset($_GET['error'])){
            echo "<div class='error'>Виберіть місто</div>";
        }
        if(isset($_GET['errorDate'])){
            if($_GET['errorDate'] == 'startBigEnd'){
                echo "<div class='error'>Дата початку повинна бути меншою або рівною дати кінця</div>";
            }
        }
        if(isset($_GET['errorTime'])){
            if($_GET['errorTime'] == 'startBigEnd'){
                echo "<div class='error'>Початок відліку повинен бути меншим кінця</div>";
            }else if($_GET['errorTime'] == 'stepError'){
                echo "<div class='error'>Вибрано великий крок</div>";
            }

        }
        ?>
        <div class="styled">

            <?php
            $directories = glob("databases" . '/*', GLOB_ONLYDIR);
            echo "<select name='path'>
            <option disabled selected>Виберіть місто</option>";

            foreach ($directories as $d){
                $city = explode('/', $d)[1];
                echo "<option value='".$d."'>".$city."</option>";
            }

            ?>
            </select>
        </div>

        <table class="choice_table" align="center">
            <tr>
                <th class="text_int" align="center">Початок</th>
                <th class="text_int" align="center">Кінець</th>
            </tr>
            <tr>
                <td><input type="date" value="2012-01-01" min="2012-01-01" max="2012-12-31" name="start"></td>
                <td><input type="date" value="2012-12-31" min="2012-01-01" max="2012-12-31" name="end"></td>
            </tr>

            <tr>
                <td colspan="2" align="center">
                    <div id="timeDiv" style="display: none" class="text_int">
                        Вибрати конкретний час
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <div id="timeDiv1" style="display: none">
                        <span onclick="Down('myTime')" class="arrow">&#8595</span>
                        <input type="time" id="myTime" value="12:00" readonly name="time">
                        <span onclick="Up('myTime')" class="arrow">&#8593</span>
                    </div>
                </td>
            </tr>

            <tr>
                <td align="center">
                    <div id="timeFromToStart" class="text_int" style="display: none"> З</div>
                </td>
                <td align="center">
                    <div id="timeFromToEnd"class="text_int" style="display: none">По</div>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <div id="timeFromTo1" style="display: none">
                        <span onclick="Down('FromToStart')" class="arrow">&#8595</span>
                        <input id="FromToStart" type="time" name="FromToStart" value="12:00" readonly>
                        <span onclick="Up('FromToStart')" class="arrow">&#8593</span>
                    </div>
                </td>

                <td align="center">
                    <div id="timeFromTo2" style="display: none">
                        <span onclick="Down('FromToEnd')" class="arrow">&#8595</span>
                        <input id="FromToEnd" type="time" name="FromToEnd" value="12:00" readonly>
                        <span onclick="Up('FromToEnd')" class="arrow">&#8593</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div id="timeFromTo3" style="display: none">
                        <select class="styled_step" name='stepFromTo'>
                            <option disabled selected>Виберіть крок</option>
                            <option value='0:30'>00:30</option>
                            <option value='01:00'>01:00</option>
                            <option value='02:00'>02:00</option>
                            <option value='03:00'>03:00</option>

                        </select>
                    </div>
                </td>
            </tr>

            <tr>
                <td align="center">
                    <div id="timeIntervalDivStart" class="text_int" style="display: none">З</div>
                </td>
                <td align="center">
                    <div id="timeIntervalDivEnd" class="text_int" style="display: none">По</div></td>
            </tr>
            <tr>
                <td align="center">
                    <div id="timeIntervalDiv1" style="display: none">
                        <span onclick="Down('Start')" class="arrow">&#8595</span>
                        <input id="Start" type="time" name="startTime" value="12:00" readonly>
                        <span onclick="Up('Start')" class="arrow">&#8593</span>
                    </div>
                </td>

                <td align="center">
                    <div id="timeIntervalDiv2" style="display: none">
                        <span onclick="Down('End')" class="arrow">&#8595</span>
                        <input id="End" type="time" name="endTime" value="12:00" readonly>
                        <span onclick="Up('End')" class="arrow">&#8593</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div id="timeIntervalDiv3" style="display: none">
                        <select class="styled_step" name='step'>
                            <option disabled selected>Виберіть крок</option>
                            <option value='0:30'>00:30</option>
                            <option value='01:00'>01:00</option>
                            <option value='02:00'>02:00</option>
                            <option value='03:00'>03:00</option>

                        </select>
                    </div>
                </td>
            </tr>


        </table>

        <input type="radio" name="choice" value="time" onclick="check('block','none', 'none')">Вибрати конкретний час<Br>

        <input type="radio" name="choice" value="time_from_to" onclick="check('none', 'block', 'none')">Вказати точно час початку та кінця<Br>

        <input type="radio" name="choice" value="time_interval" onclick="check('none', 'none', 'block')">Вибрати повторний щоденний інтервал<Br>

        <input type="radio" name="choice" value="day" onclick="check('none', 'none', 'none')">Отримати дані за весь день<Br>


        <script type="text/javascript">
            function check(time, fromTo, interval){
                document.getElementById("timeDiv").style.display = time;
                document.getElementById("timeDiv1").style.display = time;

                document.getElementById("timeFromTo1").style.display = fromTo;
                document.getElementById("timeFromTo2").style.display = fromTo;
                document.getElementById("timeFromTo3").style.display = fromTo;
                document.getElementById("timeFromToStart").style.display = fromTo;
                document.getElementById("timeFromToEnd").style.display = fromTo;

                document.getElementById("timeIntervalDiv1").style.display = interval;
                document.getElementById("timeIntervalDiv2").style.display = interval;
                document.getElementById("timeIntervalDiv3").style.display = interval;
                document.getElementById("timeIntervalDivStart").style.display = interval;
                document.getElementById("timeIntervalDivEnd").style.display = interval;

            }
            function Up(id) {
                document.getElementById(id).stepUp(30);
                var time = document.getElementById(id);
                if(time.value === "23:59"){
                    time.value = "00:00";
                }
            }
            function Down(id) {
                var time = document.getElementById(id);
                if(time.value === "00:00"){
                    time.value = "23:30";
                }else{
                    document.getElementById(id).stepDown(30);
                }
            }
        </script>
        <p><input class="button" type="submit" value="Отримати дані" name="submit"></p>
    </form>
</div>
</body>
</html>
