<script src="<?= base_url("assets/chartjs/Chart.min.js") ?>"></script>
<script src="<?= base_url("assets/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js") ?>"></script>
<script>
    function open_chart() {
        // Prepare the dataset array from incoming data
        let chart = [
            $("#data-chart").attr("data-chart1"),
            $("#data-chart").attr("data-chart2"),
            $("#data-chart").attr("data-chart3"),
            $("#data-chart").attr("data-chart4"),
            $("#data-chart").attr("data-chart5"),
            $("#data-chart").attr("data-chart6"),
            $("#data-chart").attr("data-chart7"),
            $("#data-chart").attr("data-chart8"),
            $("#data-chart").attr("data-chart9"),
            $("#data-chart").attr("data-chart10"),
            $("#data-chart").attr("data-chart11"),
            $("#data-chart").attr("data-chart12"),
            $("#data-chart").attr("data-chart13"),
            $("#data-chart").attr("data-chart14"),
            $("#data-chart").attr("data-chart15"),
            $("#data-chart").attr("data-chart16"),
            $("#data-chart").attr("data-chart17"),
            $("#data-chart").attr("data-chart18"),
            $("#data-chart").attr("data-chart19"),
        ];
        console.log(chart);

        // Get context from canvas element
        var ctx = document.getElementById('myChart').getContext('2d');
        
        // Define the X-axis labels
        const xValues = [
            "Adv. > 8 Hour",
            "Adv. 8 Hour",
            "Adv. 7 Hour",
            "Adv. 6 Hour",
            "Adv. 5 Hour",
            "Adv. 4 Hour",
            "Adv. 3 Hour",
            "Adv. 2 Hour",
            "Adv. 1 Hour",
            "Ontime",
            "1 Hour",
            "2 Hour",
            "3 Hour",
            "4 Hour",
            "5 Hour",
            "6 Hour",
            "7 Hour",
            "8 Hour",
            "> 8 Hour"
        ];

        // Create the line chart
        var plugin = 
        {
            datalabels: {
                backgroundColor: function(context) {
                    return context.dataset.backgroundColor;
                },
                borderRadius: 4,
                color: 'black',
                font: {
                    weight: 'bold',
                    size: 12,
                },
                formatter: Math,
                padding: 2
            },
            
        }
        var lineChart = new Chart(ctx, {
            type: 'line', // Define the chart type
            data: {
                labels: xValues, // X-axis labels
                datasets: [{
                    label: 'OTD', // Legend label
                    data: chart, // Data points for the chart
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Background color (under the line)
                    borderColor: 'rgba(75, 192, 192, 1)', // Line color
                    borderWidth: 2, // Line width
                    fill: true, // Fill area under the line
                    datalabels: {
                        align: 'end',
                        anchor: 'end'
                    }
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                layout: {
                    padding: {
                        left: 0,
                        right: 0,
                        top: 20,
                        bottom: 0
                    }
                },
                responsive: true, // Make the chart responsive
                plugins:plugin,
                scales: {
                    xAxes: [{
                        display: true, // Show X-axis
                        scaleLabel: {
                            display: true,
                            labelString: 'Periode' // X-axis label
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        }
                    }],
                    yAxes: [{
                        display: true, // Show Y-axis
                        scaleLabel: {
                            display: true,
                            labelString: 'Unit Delivery' // Y-axis label
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        },
                        ticks: {
                            beginAtZero: true // Start Y-axis from 0
                        }
                    }]
                }
            }
        });
    }
    open_chart();
    
    $("#periodeGraph").change(function() {
        $("#form-adjust").submit();
        $("#periodeGraph").attr("disabled",true);
    });
    
    setInterval(() => {
        location.reload();
    }, 300000);
</script>