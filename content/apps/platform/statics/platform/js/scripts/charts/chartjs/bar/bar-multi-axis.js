/*=========================================================================================
    File Name: bar-multi-axis.js
    Description: Chartjs bar multi axis chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Bar multi axis chart
// ------------------------------
$(window).on("load", function(){

    //Get the context of the Chart canvas element we want to select
    var ctx = $("#bar-multi-axis");

    // Chart Options
    var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration:500,
        hoverMode: 'label',
        stacked: false,
        title:{
            display:false,
            text:"Chart.js Bar Chart - Multi Axis"
        },
        scales: {
            xAxes: [{
                type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                display: true,
                position: "top",
                id: "x-axis-1",
                gridLines: {
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                scaleLabel: {
                    display: true,
                }
            }, {
                type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                display: true,
                position: "bottom",
                id: "x-axis-2",
                gridLines: {
                    drawOnChartArea: false
                }
            }],
            yAxes: [{
                display: true,
                gridLines: {
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                scaleLabel: {
                    display: true,
                }
            }]
        }
    };

    // Chart Data
    var chartData = {
        labels: ["January", "February", "March", "April", "May"],
        datasets: [{
            label: "My First dataset",
            data: [45, -19, -32, 48, -56],
            backgroundColor: "#5175E0",
            hoverBackgroundColor: "rgba(81,117,224,.8)",
            borderColor: "transparent",
            xAxisID: "x-axis-1",
        }, {
            label: "My Second dataset",
            data: [28, -48, 40, -19, 66],
            backgroundColor: "#28D094",
            hoverBackgroundColor: "rgba(22,211,154,.8)",
            borderColor: "transparent",
            xAxisID: "x-axis-2",
        },
        {
            label: "My Third dataset",
            data: [-40, 25, -16, -36, 57],
            backgroundColor: "#F98E76",
            hoverBackgroundColor: "rgba(249,142,118,.8)",
            borderColor: "transparent",
            xAxisID: "x-axis-1",
        }]
    };

    var config = {
        type: 'horizontalBar',

        // Chart Options
        options : chartOptions,

        data : chartData
    };

    // Create the chart
    var lineChart = new Chart(ctx, config);
});