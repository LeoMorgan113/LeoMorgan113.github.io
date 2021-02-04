<?php

error_reporting(0);
function func($x, $k_in, $b_in, $d_T_in=0){
    return ($k_in*($x+$d_T_in) + $b_in);
}


$q_tepl = $_POST['q_tepl'];//Питомі тепловтрати будівлі
$get_inf_reg = explode('@', $_POST['temp_region']);

$temp_region = (int)$get_inf_reg[0];// t регіон
$path = $get_inf_reg[1];

$T_inside_build = $_POST['T_inside_build'];//Розрахункова температура в середині будівлі

$q_sqr = $_POST['sqr'];//Опалювальна площа

$N_people = $_POST['N_people'];//Кількість людей

$T_input_water = $_POST['T_input_water'];//Температура вхідної води
$T_end_bak = $_POST['T_end_bak'];//Кінцева температура бака

$T_water_shower = $_POST['T_water_shower'];//Температура води при прийомі душу
$N_shower = $_POST['N_shower'];//Кількість прийомів душу
$q_aver_shower = 40;//Середній обсяг води в душі — в середньому 30 - 50 літрів

$T_water_bath = $_POST['T_water_bath'];//Температура води при прийомі ванни
$N_bath = $_POST['N_bath'];//Кількість прийомів ванни
$q_aver_bath = 170;//Середній обсяг води в ванній — в середньому 140-200 літрів

$type_choice = $_POST['choice1'];
$duration = $_POST['duration'];//Задаємо тривалість для розрахунку потужність
$power = $_POST['power'];//Задаємо потужність для розрахунку тривалості


$g = $_POST['gas'];
$c = $_POST['coal'];
$e = $_POST['electric'];
$w = $_POST['wood'];
$b = $_POST['briquette'];
$h = $_POST['heating'];

$tarif = [$g, $c, $e, $w, $b, $h];

$q_shower = $N_shower*$q_aver_shower;
$q_bath = $N_bath*$q_aver_bath;

$Q_T_shower = $q_shower*(($T_water_shower - $T_input_water)/($T_end_bak - $T_input_water));
$Q_T_bath =$q_bath*(($T_water_bath - $T_input_water)/($T_end_bak - $T_input_water));

$p = 998.23; // густина води при температурі 60 С
$Q_hot_water = ($Q_T_shower + $Q_T_bath)/$p; //м3/добу

$w_hot_water = 1.163 * $Q_hot_water*($T_end_bak - $T_input_water); // кВт*год, енергія для нагріву

if($type_choice == "power_choice"){
    $power = $w_hot_water/$duration; //потужність нагрівача
}else if($type_choice == "duration_choice"){
    $duration = $w_hot_water/$power;
}

$x1 = 20;
$x2 = $temp_region;
$y1 = 0;
$y2 = $q_tepl*$q_sqr;

$k = round(($y2-$y1)/($x2 - $x1)/1000, 3);
$b = round((-1*$x1*$y2 + $y1*$x1 + $y1*$x2 + $y1*$x1)/($x2-$x1)/1000, 3);



$x = (int)$_POST['temp_region'];
$d_T = $x1 - $T_inside_build;

$iter = $x;
$x_array_default = [];
$y_array_default = [];
$y_array = [];

while($iter < $x1){
    array_push($x_array_default, $iter);
    $iter += 1;
}

foreach ($x_array_default as $x){
    array_push($y_array_default, func($x, $k, $b));
    array_push($y_array, func($x, $k, $b, $d_T));
}

include "graph.php";

$gas = round(0.1075*$Q_searching*$g, 2);
$coal = round(0.1792*$Q_searching*$c/1000, 2);
$electric = round($Q_searching*$e, 2);
$wood = round(0.287*$Q_searching*$w/1000, 2);
$briquette = round(0.1953*$Q_searching*$b/10, 2);
$heating = round($Q_searching*0.00086*$h, 2);

$heat_data = [$gas, $coal, $electric, 
    $wood, $briquette, $heating];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Результат виконання</title>
    <link rel="stylesheet" type="text/css" href="">
    <script src="../lab1_Ann/node_modules/chart.js/dist/Chart.js"></script>
    <script src="https://www.koolchart.com/demo/LicenseKey/codepen/KoolChartLicense.js"></script>
    <script src="https://www.koolchart.com/demo/KoolChart/JS/KoolChart.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.koolchart.com/demo/KoolChart/Assets/Css/KoolChart.css"/>
    <link rel="stylesheet" href="https://www.koolchart.com/demo/Samples/Web/sample.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <link href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@500&display=swap" rel="stylesheet">

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a href="../index.html"><img src="../img/LOGO.svg" alt="Logo" class="logo"></a>
                <h1>Теплотехнічні характеристики будівлі, потреба у тепловій енергії на опалення, ГВП та вентилювання</h1>
            </div>
            <div class="col-6" style="display:inline-flex;">
                <a href="index.html"><img src="../img/Arrow_left.png" alt="Left"></a>
            </div>
            <div class="col-6" style="display:flex; justify-content: flex-end;"> 
                <a href="../lab3/index.php" ><img src="../img/Arrow_right.png" alt="Right" ></a>
            </div>


            <div class="col-12" style="text-align: center;" id="btn">
                <a href="javascript:genScreenshot()" ><button >Сформувати звіт</button></a>
            </div>
            <div class="col-12 gr" style="margin-top: 50px;">
                
                <canvas id="GraphTemp2"></canvas>
                <?php include "inc/GraphLab2.php"; ?>
                <br><br><br>
            <div class="offset-2 col-8 wrapper">
                <div class="book">
                    <ul>
                        <li>
                          <div>Залежність тепловтрат від температури</div>
                          <div></div>
                          <div><?php echo "Q = $k*t + $b<br><br>"; ?></div>
                        </li>
                        <li id="pwr">
                          <div>Потужність нагрівача</div>
                          <div></div>
                          <div><?php echo round($power, 3) ?> кВт</div>
                        </li>
                        <li id="dur">
                          <div>Тривалість нагріву</div>
                          <div></div>
                          <div><?php echo round($duration, 2) ?> годин</div>
                        </li>
                        <li>
                          <div>Витрати енегрії на опалення за визначений період</div>
                          <div></div>
                          <div><?php echo round($w_hot_water, 3)?> кВт·год</div>
                        </li>
                        <li>
                          <div>Загальний обсяг спожитої енергії на опалення та ГВП</div>
                          <div></div>
                          <div><?php echo round($Q_searching, 3)?> кВт·год</div>
                        </li>
                        <hr>
                        <li>
                          <div>Найвигідніше використовувати брикетні котли</div>
                          <div></div>
                          <div><?php echo $briquette?> грн</div>
                        </li>
                   </ul>
                </div>
            
                <hr>
                <div class="thx">Дякуємо, що обрали нашу компанію!</div>
                <div class="thx">Гарного дня!</div>
                <a href="../index.html"><img src="../img/LOGO.svg" alt="Logo" class="logo_min"></a>
            </div>
        
            <div class="col-12">
                <h2>Загальний обсяг спожитої енергії на опалення та ГВП</h2>
                <canvas id="GraphTemp3"></canvas>
                <br><br><br>
        </div>    
    </div>  

            <div class="col-12 cl">
                <h3>Пропонуємо вам обрати котли для опалення вашої домівки</h3>
                <script async src="https://cse.google.com/cse.js?cx=b52b4d808dc4f3de9"></script>
                <div class="gcse-search"></div>
            <br><br>
            <a href="Звіт_ЛР2_Шерепа_Корявікова.docx" download style="color:#FB8B24; text-align: center;">Завантажити звіт до ПЗ</a>
            <br><br>
            </div>

        </div>
    </div>
    <script>
    function genScreenshot() {
        html2canvas($('.gr'), {
        onrendered: function(canvas) {
          
        if (navigator.userAgent.indexOf("MSIE ") > 0 || 
                        navigator.userAgent.match(/Trident.*rv\:11\./)){
            var blob = canvas.msToBlob();
            window.navigator.msSaveBlob(blob,'Test file.png');
        }
        else   {
            $('.container').attr('href', canvas.toDataURL("image/png"));
            doc = new jsPDF({
                pagesplit: true,
            });
            
            var width = doc.internal.pageSize.width;
            var height = doc.internal.pageSize.height;
            doc.setFillColor(204, 204, 204,0);
            doc.rect(0, 0, 1000, 1000, "F");
            doc.addImage(canvas.toDataURL("image/png"), 'JPEG', 0, 0, width-20, height);
            doc.save('ExportFile.pdf');
        }
          
          
          }
        });
    }
        var chartColors = {
            red: 'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(75, 192, 192)',
            blue: 'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)'
        };
        var tarif = <?php echo json_encode($tarif);?>;
        let name = ["грн/м³", "грн/т", "грн/кВт·год", "грн/т", "грн/т", "грн/Гкал"];
        var heat = ['Газовий котел', 'Вугільний котел', 'Електричний котел', 'Дерев`яний котел', 'Брикетний котел', 'Централізоване опалення'];

        var ctx = document.getElementById('GraphTemp3');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: heat,
                datasets: [{
                    label: 'Витрати, грн',
                    fill: false,
                    data: <?php echo json_encode($heat_data);?>,
                    borderWidth: 3,
                    backgroundColor: [
                         color('rgb(255, 99, 132)').alpha(0.8).rgbString(),
                         color('rgb(255, 159, 64)').alpha(0.8).rgbString(),
                         color('rgb(255, 205, 86)').alpha(0.8).rgbString(),
                         color('rgb(75, 192, 192)').alpha(0.8).rgbString(),
                         color('rgb(54, 162, 235)').alpha(0.8).rgbString(),
                         color('rgb(153, 102, 255)').alpha(0.8).rgbString()
                    ],
                    fontSize: 18
                }]
            },
            options: {
                legend: {
                    display: false
                },
                tooltips:{
                    callbacks: {
                        title: function(tooltipItem, data) {
                          return data['labels'][tooltipItem[0]['index']];
                        },
                        label: function(tooltipItem, data) {
                            var temp = data['datasets'][0]['data'][tooltipItem['index']]
                            return 'Витрати: ' + temp + 'грн';
                        },
                        afterLabel: function(tooltipItem, data) {
                            console.log();
                            return 'Тариф: ' + tarif[tooltipItem['index']] + ' ' +name[tooltipItem['index']];
                        }
                    },
                    titleFontSize: 16,
                    titleFontColor: 'rgb(88, 252, 236)',
                    bodyFontSize: 14,
                    displayColors: false
                },
                scales: {
                    xAxes: [{

                        gridLines: {
                            zeroLineColor: "white",
                            zeroLineWidth: 2
                        },
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            zeroLineColor: "white",
                            zeroLineWidth: 2,
                            color: "white",
                            borderDash: [2, 5]
                        },
                        scaleLabel: {
                            display: true,
                            labelString: "Q, кВт",
                            fontSize: 20,
                            fontColor: 'white'
                        },
                        ticks: {
                            fontSize: 14
                        }
                    }]
                }
            }
        });
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/jquery-3.4.1.min.js"></script>
   
</body>
<html>