<script>
    var ctx = document.getElementById('SpeedDiagram');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($speed_diagr);?>,
            datasets: [{
                label: 'Тривалість режимів вітрової активності',
                data: <?php echo json_encode($speed_hours_diagram);?>,
                backgroundColor: 'rgba(66,86,162, 0.5)',
                borderColor: 'rgba(38,50,96, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                xAxes: [{

                    scaleLabel: {
                        display: true,
                        labelString: "Швидкість, м/с",
                        fontColor: 'rgba(38,50,96, 1)',
                    },
                    ticks: {
                        beginAtZero: true
                    }
                }],
                yAxes: [{

                    scaleLabel: {
                        display: true,
                        labelString: "Год",
                        fontColor: 'rgba(38,50,96, 1)',

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