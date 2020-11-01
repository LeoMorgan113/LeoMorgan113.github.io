<?php
sort($all_t_arr);
$count_val = array_count_values($all_t_arr);
$temp_diagr = [];
$temp_hours_diagram = [];
while (list($key, $val) = each($count_val)) {
    array_push($temp_diagr, $key);
    array_push($temp_hours_diagram, $val*0.5);
}

?>
<script>
    var ctx = document.getElementById('TempDiagram');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($temp_diagr);?>,
            datasets: [{
                label: 'Тривалість температурних режимів',
                data: <?php echo json_encode($temp_hours_diagram);?>,
                backgroundColor: 'rgba(39,162,37, 0.7)',
                borderColor: 'rgba(23,87,23, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                xAxes: [{

                    scaleLabel: {
                        display: true,
                        labelString: "t, C",
                        fontColor: "green",
                    },
                    ticks: {
                        beginAtZero: true
                    }
                }],
                yAxes: [{

                    scaleLabel: {
                        display: true,
                        labelString: "год",
                        fontColor: "green",

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