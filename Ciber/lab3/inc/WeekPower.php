<?php
$week_day = [];
$week_power = [];
foreach ($days as $value){
    array_push($week_day, $value[0]);
    array_push($week_power, round($value[1], 2));
}
?>
<script>


    var ctx = document.getElementById('WeekPower');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($week_day);?>,
            datasets: [{
                label: 'Навантаженість на добу',
                data: <?php echo json_encode($week_power);?>,
                backgroundColor: 'rgb(255, 99, 132)',
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
                        return 'Навантаженість на добу: ' + temp + ' кВт';
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
                        labelString: "День",
                        fontColor: "orange",
                        fontSize: 16
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
                        fontSize: 16

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