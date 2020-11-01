<?php
$step = 20;
$max_val = max($sun_arr);
$min_val = min($sun_arr);
if($min_val != 0 ){
    $min_val = $min_val - ($min_val%$step);
}
$arr_sun_range = range($min_val, $max_val, $step);
array_push($arr_sun_range, $arr_sun_range[sizeof($arr_sun_range)-1]+$step);

$arr_sun_hours = [];

for($i = 0; $i < sizeof($arr_sun_range) - 1; $i++){
    $val = countInRange($sun_arr, $arr_sun_range[$i]+0.1, $arr_sun_range[$i+1])*0.5;
    array_push($arr_sun_hours, $val);
}
?>

<script>
    var ctx = document.getElementById('SunDiagr');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($arr_sun_range);?>,
            datasets: [{
                label: 'Тривалість режимів сонячної активності',
                data: <?php echo json_encode($arr_sun_hours);?>,
                backgroundColor: 'rgba(255,238,0,0.5)',
                borderColor: 'rgba(255,238,0,1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                xAxes: [{

                    scaleLabel: {
                        display: true,
                        labelString: "Bт/м2",
                        fontColor: 'rgb(0,0,0)'
                    },
                    ticks: {
                        beginAtZero: true
                    }
                }],
                yAxes: [{

                    scaleLabel: {
                        display: true,
                        labelString: "Год",
                        fontColor: 'rgb(0,0,0)'
                    },
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        },
        showTooltips: true,
        onAnimationComplete: function () {

            var ctx = this.chart.ctx;
            ctx.font = this.scale.font;
            ctx.fillStyle = this.scale.textColor
            ctx.textAlign = "center";
            ctx.textBaseline = "bottom";

            this.datasets.forEach(function (dataset) {
                dataset.bars.forEach(function (bar) {
                    ctx.fillText(bar.value, bar.x, bar.y - 5);
                });
            })
        }
    });


</script>



