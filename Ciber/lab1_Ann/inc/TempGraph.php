<script>
    var ctx = document.getElementById('TempShow');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($date_arr);?>,
            datasets: [{
                label: 'Температурні умови',
                data: <?php echo json_encode($t_arr);?>,
                borderWidth: 1,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)'
            }]
        },
        options: {
            scales: {
                xAxes: [{

                    scaleLabel: {
                        display: true,
                        labelString: "Дата",
                        fontColor: 'rgba(255, 99, 132, 1)',
                    },
                    ticks: {
                        beginAtZero: true
                    }
                }],
                yAxes: [{

                    scaleLabel: {
                        display: true,
                        labelString: "t, C",
                        fontColor: 'rgba(255, 99, 132, 1)',

                    },
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
