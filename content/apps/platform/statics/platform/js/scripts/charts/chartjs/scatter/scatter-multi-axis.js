/*=========================================================================================
    File Name: scatter-multi-axis.js
    Description: Chartjs multi axis chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Scatter multi axis chart
// ------------------------------
$(window).on("load", function(){

    //Get the context of the Chart canvas element we want to select
    var ctx = $("#scatter-multi-axis");

    // Chart Options
    var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration:800,
        hoverMode: 'single',
        title: {
            display: true,
            text: 'Chart.js Scatter Chart - Multi Axis'
        },
        scales: {
            xAxes: [{
                position: "bottom",
                gridLines: {
                    zeroLineColor: "rgba(0,0,0,1)",
                    color: "#f3f3f3",
                    drawTicks: false,
                }
            }],
            yAxes: [{
                type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                display: true,
                position: "left",
                id: "y-axis-1",
                gridLines: {
                    zeroLineColor: "rgba(0,0,0,.1)",
                    color: "#f3f3f3",
                    drawTicks: false,
                },
            }, {
                type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                display: true,
                position: "right",
                reverse: true,
                id: "y-axis-2",

                // grid line settings
                gridLines: {
                    drawOnChartArea: false, // only want the grid lines for one axis to show up
                },
            }],
        }
    };

    // Chart Data
    var chartData = {
        datasets: [{
            label: "My First dataset",
            xAxisID: "x-axis-1",
            yAxisID: "y-axis-1",
            data: [{
                x: 65,
                y: -28,
            }, {
                x: -59,
                y: 48,
            }, {
                x: -80,
                y: 40,
            }, {
                x: 81,
                y: -19,
            }, {
                x: -56,
                y: 86,
            }, {
                x: 55,
                y: -27,
            }, {
                x: -40,
                y: 89,
            }],
            backgroundColor: "rgba(81,117,224,.6)",
            borderColor: "transparent",
            pointBorderColor: "#5175E0",
            pointBackgroundColor: "#FFF",
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
            pointRadius: 4,
        }, {
            label: "My Second dataset",
            xAxisID: "x-axis-1",
            yAxisID: "y-axis-2",
            data: [{
                x: 45,
                y: -17,
            }, {
                x: -25,
                y: 62,
            }, {
                x: -16,
                y: 78,
            }, {
                x: 36,
                y: -68,
            }, {
                x: 67,
                y: -26,
            }, {
                x: -18,
                y: 48,
            }, {
                x: 76,
                y: -73,
            }],
            backgroundColor: "rgba(209,212,219,.4)",
            borderColor: "transparent",
            pointBorderColor: "#D1D4DB",
            pointBackgroundColor: "#FFF",
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
            pointRadius: 4,
        }]
    };

    var config = {
        type: 'scatter',

        // Chart Options
        options : chartOptions,

        data : chartData
    };

    // Create the chart
    var scatterMultiAxisChart = new Chart(ctx, config);
});