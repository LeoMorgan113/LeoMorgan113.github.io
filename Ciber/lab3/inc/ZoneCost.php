<?php
$zone_name = [];
$zone_value = [];

foreach ($zone as $key_v => $value){
    array_push($zone_name, $key_v);
    array_push($zone_value, round($value, 2));
}

?>
<script>
    console.log(<?php echo json_encode($day_time)?>);

    var ctx = document.getElementById('ZoneCost');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($zone_name);?>,
            datasets: [{
                label: 'Графік витрат в залежності від обранної зони',
                data: <?php echo json_encode($zone_value);?>,
                backgroundColor: 'rgb(153, 102, 255)',
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
                        return 'Витрати: ' + temp + ' грн';
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
                        labelString: "Тариф",
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
                        labelString: "Вартість, грн",
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