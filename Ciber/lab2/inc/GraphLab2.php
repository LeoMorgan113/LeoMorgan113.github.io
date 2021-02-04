<script>
    var chartColors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(231,233,237)'
    };
   

    var color = Chart.helpers.color;
    var ctx = document.getElementById('GraphTemp2');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($x_array_default);?>,
            datasets: [{
                label: 'Температурні умови за замовченням',
                fill: false,
                data: <?php echo json_encode($y_array_default);?>,
                borderWidth: 3,
                backgroundColor: 'white',
                borderColor: color(chartColors.orange).alpha(0.8).rgbString()
            }, {
                label: 'Температурні умови',
                fill: false,
                data: <?php echo json_encode($y_array);?>,
                    borderWidth: 3,
                    backgroundColor: 'white',
                    borderColor: color(chartColors.purple).alpha(0.8).rgbString()
                    }]

        },
        options: {
            tooltips:{
                callbacks: {
                    title: function(tooltipItem, data) {
                      return  'Температура: ' + data['labels'][tooltipItem[0]['index']] + ' °C';
                    },
                    label: function(tooltipItem, data) {
                        var temp = data['datasets'][0]['data'][tooltipItem['index']]
                        return 'Потужність тепловтрат: ' + temp + ' кВт';
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
                    scaleLabel: {
                        display: true,
                        labelString: "Зовнішня температурна, °C",
                        fontColor: 'white',
                        fontSize: 20
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
                    }
                }]
            }
        }
    });
    
    
</script>
