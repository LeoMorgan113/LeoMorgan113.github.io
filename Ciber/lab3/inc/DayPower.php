<?php
$day_time = [];
$day_power = [];

foreach ($temp_duration as $key_v => $value){
    array_push($day_time, $key_v);
    array_push($day_power, round($value, 2));
}

?>
<script>
    console.log(<?php echo json_encode($day_time)?>);

    var ctx = document.getElementById(<?php echo "'DayPower_$iter'" ?>);
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($day_time);?>,
            datasets: [{
                label: '<?php echo $device_name?>',
                data: <?php echo json_encode($day_power);?>,
                backgroundColor: 'rgb(255, 205, 86)',
                borderWidth: 3
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
                            return '<?php echo $device_name?>: ' + temp + ' кВт';
                        }
                    },
                    titleFontSize: 14,
                    titleFontColor: 'rgb(88, 252, 236)',
                    bodyFontSize: 12,
                    displayColors: false
                },
            scales: {
                xAxes: [{
                    gridLines: {
                            zeroLineColor: "white",
                            zeroLineWidth: 2
                        },
                    scaleLabel: {
                        display: true,
                        labelString: "<?php echo $device_name?>, день та час роботи",
                        fontColor: "orange",
                        fontSize: 16,
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
                        labelString: "Значення потужності, кВт",
                        fontColor: "orange",
                        fontSize: 16,

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