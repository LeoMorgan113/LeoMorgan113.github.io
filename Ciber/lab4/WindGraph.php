    <script>
       // console.log(<?php echo json_encode($speed_arr_inter)?>);

        var ctx = document.getElementById('Wind');
        var myChart = new Chart(ctx, {
            type: 'line',
            fill: false,
            data: {
                labels: <?php echo json_encode($speed_arr_inter)?>,
                datasets: [{
                    label: '<?php echo $speed_arr_inter?>',
                    data: <?php echo json_encode($power_inter);?>,
                    borderColor: 'rgb(255, 205, 86)',
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
                              return 'Швидкість вітру: '+ data['labels'][tooltipItem[0]['index']] + ' м/с';
                            },
                            label: function(tooltipItem, data) {
                                var temp = data['datasets'][0]['data'][tooltipItem['index']]
                                return 'Потужність: ' + temp + ' кВт';
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
                            labelString: "Швидкість вітру, м/с",
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