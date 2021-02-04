<?php
error_reporting(0);
include "graph.php";

// echo "<br><br>Точки швидкостей<br><br>";
// print_r($speed_diagr);//точки швидкості
// echo "Тривалість швидкостей<br><br><br>";
// print_r($speed_hours_diagram);//відповідні тривавлості

$name = $format_POST_array[0][1];
$height = $format_POST_array[0][2];
$cost_veu = $format_POST_array[0][3];
$cost_tower = $format_POST_array[0][4];
$koef_cost = $format_POST_array[0][5];


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lab Work №4</title>
    <link href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@500&display=swap" rel="stylesheet">
    <script src="../lab1_Ann/node_modules/chart.js/dist/Chart.js"></script>
    <script src="https://www.koolchart.com/demo/LicenseKey/codepen/KoolChartLicense.js"></script>
    <script src="https://www.koolchart.com/demo/KoolChart/JS/KoolChart.js"></script>
    <link rel="stylesheet" href="https://www.koolchart.com/demo/KoolChart/Assets/Css/KoolChart.css"/>
    <link rel="stylesheet" href="https://www.koolchart.com/demo/Samples/Web/sample.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
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
                <a href="../lab3/index.php"><img src="../img/Arrow_left.png" alt="Left"></a>
            </div>
            <div class="col-6" style="display:flex; justify-content: flex-end;"> 
                <a href="../lab5/index.html" ><img src="../img/Arrow_right.png" alt="Right" ></a>
            </div>

            <div class="col-12" style="text-align: center;" >
                <a href="javascript:genScreenshot()" id="btn">Сформувати звіт</a>
            </div>
            <div class="col-12 wrapper">
                <canvas id="Wind"></canvas>
                <?php include "WindGraph.php"; ?>
                <div style="text-align: left; margin-left: 375px;">
                    <p>Тип ВЕУ:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $name ?></p>
                    <p>Висота башти:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $height ?> м</p>
                    <p>Вартість ВЕУ(без башти):&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cost_veu ?> грн</p>
                    <p>Вартість башти:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cost_tower ?> грн</p>
                    <p>Обсяг генерування електричної енергії:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sum ?> кВт*год</p>
                    <p>Обсяг скорочення викидів:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $co2 ?> тон</p>
                    <p>Дохід:&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $money ?> $</p>
                </div>
                

                
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function genScreenshot() {
            html2canvas($('.wrapper'), {
                onrendered: function(canvas) {
                if (navigator.userAgent.indexOf("MSIE ") > 0 || 
                                navigator.userAgent.match(/Trident.*rv\:11\./)){
                    var blob = canvas.msToBlob();
                    window.navigator.msSaveBlob(blob,'Test file.png');
                }
                else   {
                    $('.container').attr('href', canvas.toDataURL("image/png"));
                    doc = new jsPDF("l", "mm", "a4");
                    var width = doc.internal.pageSize.width;
                    var height = doc.internal.pageSize.height;
                    doc.setFillColor(204, 204, 204,0);
                    doc.rect(0, 0, 1000, 1000, "F");
                    doc.addImage(canvas.toDataURL("image/png"), 'PNG', 40, 10, 220, 190);
                    doc.save('ExportFile.pdf');
                }
            }
        });
    }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/jquery-3.4.1.min.js"></script>
</body>
</html>