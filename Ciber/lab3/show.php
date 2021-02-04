

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Результати</title>
    <link href="https://fonts.googleapis.com/css2?family=El+Messiri:wght@500&display=swap" rel="stylesheet">

    <script src="../lab1_Ann/node_modules/chart.js/dist/Chart.js"></script>
    <script src="https://www.koolchart.com/demo/LicenseKey/codepen/KoolChartLicense.js"></script>
    <script src="https://www.koolchart.com/demo/KoolChart/JS/KoolChart.js"></script>
    <link rel="stylesheet" href="https://www.koolchart.com/demo/KoolChart/Assets/Css/KoolChart.css"/>
    <link rel="stylesheet" href="https://www.koolchart.com/demo/Samples/Web/sample.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>

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
                <a href="../lab3/index.php"><img src="../img/Arrow_left.png" alt="Left"></a>
            </div>
            <div class="col-6" style="display:flex; justify-content: flex-end;"> 
                <a href="../lab4/index.html" ><img src="../img/Arrow_right.png" alt="Right" ></a>
            </div>
            <div class="col-12 wrapper">
                <div id="toNewWindow">
                <h1>Результати електричного навантаження домівки</h1>
                <?php
require '../lab1_Ann/vendor/autoload.php';
        $zone = [
            "Однозонний" => 0,
            "Двозонний" => 0,
            "Трьохзонний" => 0
        ];

        $zone_1 = 0.9;
        $arr_2_zone = [
            ['00:00', 0.45, 0.45],
            ['07:00', 0.45, 0.9],
            ['23:00', 0.9, 0.45],
            ['23:59', 0.45, 0.45]
        ];

        $arr_3_zone = [
            ['00:00', 0.36, 0.36],
            ['07:00', 0.36, 0.9],
            ['08:00', 0.9, 1.35],
            ['11:00', 1.35, 0.9],
            ['20:00', 0.9, 1.35],
            ['22:00', 1.35, 0.9],
            ['23:00', 0.9, 0.36],
            ['23:59',0.36, 0.36]
        ];

        $power_sorted_by_days = [0, 0, 0, 0, 0, 0, 0];

        function CountZonePowerCost($start, $end, $pwr, $arr_zone){
            $return_value = 0;
         /*   $start = strtotime($start);
            $end = strtotime($end);
           */ for($i = 0; $i < sizeof($arr_zone)-1; $i++){
                $start_comp_beg = strtotime($arr_zone[$i][0]);
                $start_comp_end = strtotime($arr_zone[$i+1][0]);
                if($start >= $start_comp_beg && $start <= $start_comp_end){
                    if($end >= $start_comp_beg && $end <= $start_comp_end){
                        $return_value += ($end - $start)*$pwr*$arr_zone[$i][2];
                        return $return_value;
                    }else{
                        for($j = $i+1; $j < sizeof($arr_zone)-1; $j++){
                            $end_comp_beg = strtotime($arr_zone[$j][0]);
                            $end_comp_end = strtotime($arr_zone[$j+1][0]);
                            if($end > $end_comp_end){
                                $return_value += ($end_comp_end - $end_comp_beg)*$pwr*$arr_zone[$j][2];
                            }else{
                                $return_value += ($end - $end_comp_beg)*$pwr*$arr_zone[$j][2];
                                return $return_value;
                            }
                        }
                    }
                }else{
                    continue;
                }
            }
        }


        $days = [
            "'Monday'"=> ["Понеділок", 0],
            "'Tuesday'"=> ["Вівторок", 0],
            "'Wednesday'" => ["Середа", 0],
            "'Thursday'"=> ["Четвер", 0],
            "'Friday'" => ["П'ятниця", 0],
            "'Saturday'"=> ["Субота", 0],
            "'Sunday'" => ["Неділя", 0]
        ];
        $temp_duration  = [];
        $iter = 0;
        $device_name = '';



        while (list($key, $val) = each($_POST['valueAuto'])) {
            $pwr = $val["'power'"];
            $sum_pwr = 0;
            $duration = $val["'duration'"];
            $dev_duration = $val["'dev_dur'"];
            $break_duration = $val["'break_dur'"];
            $duration_arr = [];
            $device_name = $val["'name'"];
            $sign = [-1,0, 1];
            $begin = new DateTime('2020-11-23');
            $end = new DateTime('2020-11-30');

            $i = explode(":", date("H:i:s", strtotime($duration)+strtotime($break_duration)));
            $in = $i[0]." hours ".$i[1]." minutes ".$i[2]." seconds";
            $interval = DateInterval::createFromDateString($in);
            $period = new DatePeriod($begin, $interval, $end);

            foreach ($period as $dt) {
                $day = $dt->format("l");
                $start = $dt->format("H:i:s");
                $end = date("H:i:s", strtotime($start) + strtotime($duration) + $sign[rand(0, 2)]*strtotime($dev_duration));
                $diff = strtotime($end) - strtotime($start);

                if(strtotime($end) < strtotime($start)){
                    $diff = (strtotime($end) - strtotime('00:00:00')) + (strtotime('23:59:59') - strtotime($start));
                }
                $power_time = ($pwr/3600)*$diff;
                $sum_pwr += $power_time;

                $key_for_array = $days["'$day'"][0].", ".$start."-".$end;
                $duration_arr[$key_for_array] = $power_time;
                $days["'$day'"][1] += $power_time;
                $zone["Однозонний"] += $power_time * $zone_1;
                $zone["Двозонний"] += CountZonePowerCost(strtotime($start), strtotime($end), $pwr/3600, $arr_2_zone);
                $zone["Трьохзонний"] += CountZonePowerCost(strtotime($start), strtotime($end), $pwr/3600, $arr_3_zone);
            }

            $temp_duration = $duration_arr;
            echo "<canvas id='DayPower_".$iter."'></canvas>";
            include "inc/DayPower.php";
            echo "<br><br>";
            $iter +=1;
        }


        while (list($key, $val) = each($_POST['valueOnAuto'])) {
            $pwr = 0;
            $sum_pwr = 0;
            $duration = 0;
            $dev_duration = 0;
            $duration_arr = [];

            $sign = [-1,0, 1];
            while(list($key_values, $val_full_list) = each($val)){

                if($key_values === "'power'") {
                    $pwr = $val_full_list;
                }else if($key_values === "'duration'"){
                    $duration = $val_full_list;
                }else if($key_values === "'name'"){
                    $device_name = $val_full_list;
                }else if($key_values === "'dev_dur'"){
                    $dev_duration = $val_full_list;
                } else if($key_values === "'time_values'"){
                    while(list($key_day_arr, $val_day_times_arr) = each($val_full_list)){
                        while(list($key_time, $val_time_start) = each($val_day_times_arr["'start'"])){
                            //в цьому циклі я перебираю кожне значення в дні, закріплений за даним приладом

                            $time = strtotime($duration) + $sign[rand(0, 2)]*strtotime($dev_duration);
                            $end = date("H:i:s", strtotime($val_time_start) + $time);
                            $power_time = ($pwr/3600)*(strtotime($end) - strtotime($val_time_start));
                            $sum_pwr += $power_time;

                            $temp = date("H:i:s", $time);

                            $key_for_array = $days[$key_day_arr][0].", ".$val_time_start."-".$end;
                            $duration_arr[$key_for_array] = $power_time;
                            $days[$key_day_arr][1] += $power_time;
                            $zone["Однозонний"] += $power_time * $zone_1;
                            $zone["Двозонний"] += CountZonePowerCost(strtotime($val_time_start), strtotime($end), $pwr/3600, $arr_2_zone);
                            $zone["Трьохзонний"] += CountZonePowerCost(strtotime($val_time_start), strtotime($end), $pwr/3600, $arr_3_zone);

                        }
                    }
                }

            }
            $temp_duration = $duration_arr;
            echo "<canvas id='DayPower_".$iter."'></canvas>";
            include "inc/DayPower.php";
            echo "<br><br>";
            $iter +=1;
        }

        while (list($key, $val) = each($_POST['valueOnOff'])) {
            $pwr = 0;
            $sum_pwr = 0;
            $duration_arr = [];

            while(list($key_values, $val_full_list) = each($val)){

              if($key_values === "'power'") {
                  $pwr = $val_full_list;
              }else if($key_values === "'name'"){
                  $device_name = $val_full_list;
              }else if($key_values === "'time_values'"){
                  while(list($key_day_arr, $val_day_times_arr) = each($val_full_list)){
                      //в цьому циклі я перебираю кожен день, закріплений за даним приладом

                      $duration_sum = strtotime('00:00');
                      while(list($key_time, $val_time_start) = each($val_day_times_arr["'start'"])){

                          //в цьому циклі я перебираю кожне значення в дні, закріплений за даним приладом
                          $time = strtotime($val_day_times_arr["'end'"][$key_time]) - strtotime($val_time_start);
                          $temp = date("H:i:s", $time);
                          $power_time = ($pwr/3600)*$time;
                          $sum_pwr += $power_time;

                          $key_for_array = $days[$key_day_arr][0].", ".$val_time_start."-".$val_day_times_arr["'end'"][$key_time];
                          $duration_arr[$key_for_array] = $power_time;
                          $days[$key_day_arr][1] += $power_time;
                          $zone["Однозонний"] += $power_time * $zone_1;
                          $zone["Двозонний"] += CountZonePowerCost(strtotime($val_time_start), strtotime($end), $pwr/3600, $arr_2_zone);
                          $zone["Трьохзонний"] += CountZonePowerCost(strtotime($val_time_start), strtotime($val_day_times_arr["'end'"][$key_time]), $pwr/3600, $arr_3_zone);
                      }
                  }
              }

            }
            $temp_duration = $duration_arr;
            echo "<canvas id='DayPower_".$iter."'></canvas>";
            include "inc/DayPower.php";
            echo "<br><br>";
            $iter +=1;
        }

?>
                <h3>Навантаженість на добу</h3>
                <canvas id="WeekPower"></canvas>

                <?php include "inc/WeekPower.php"; ?>
                <br><br><br>

                <!-- <?php
                // foreach ($zone as $k => $v){
                //     echo "Zone: $k  Value: $v<br>";
                // }
                ?> -->
                <h3>Графік витрат в залежності від обранної зони</h3>
                <canvas id="ZoneCost"></canvas>
                <?php include "inc/ZoneCost.php"; ?>
                <br><br><br>
            </div>
            <a href="#" id="downloadPdf" style="color:#fff;">Завантажити звіт</a>
            <br><br>
            <a href="Звіт_ЛР3_Шерепа_Корявікова.docx" download style="color:#FB8B24;">Завантажити звіт до ПЗ</a>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript">
        $('#downloadPdf').click(function(event) {
              // get size of report page
              var reportPageHeight = $('body').innerHeight();
              var reportPageWidth = $('body').innerHeight();
              console.log(reportPageHeight);
              console.log('width');
              console.log(reportPageWidth);
              // create a new canvas object that we will populate with all other canvas objects
              var pdfCanvas = $('<canvas />').attr({
                id: "canvaspdf",
                width: reportPageWidth,
                height: reportPageHeight
              });
              
              // keep track canvas position
              var pdfctx = $(pdfCanvas)[0].getContext('2d');
              var pdfctxX = 0;
              var pdfctxY = 0;
              var buffer = 100;
              
              // for each chart.js chart
              $("canvas").each(function(index) {
                // get the chart height/width
                var canvasHeight = $(this).innerHeight();
                var canvasWidth = $(this).innerWidth();
                
                // draw the chart into the new canvas
                pdfctx.drawImage($(this)[0], pdfctxX, pdfctxY, canvasWidth, canvasHeight);
                pdfctxX += canvasWidth + buffer;
                
                // our report page is in a grid pattern so replicate that in the new canvas
                if (index % 4 === 1) {
                  pdfctxX = 0;
                  pdfctxY += canvasHeight + buffer;
                }
              });
              
              // create new pdf and add our new canvas as an image
              var pdf = new jsPDF('l', 'pt', [reportPageWidth, reportPageHeight]);
              pdf.addImage($(pdfCanvas)[0], 'PNG', 0, 0);
              
              // download the pdf
              pdf.save('Report_lab3.pdf');
            });
    </script>   
</body>
</html>