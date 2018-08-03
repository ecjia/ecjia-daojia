/*=========================================================================================
    File Name: scatter.js
    Description: Chartjs scatter chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Scatter chart
// ------------------------------
$(window).on("load", function(){

    //Get the context of the Chart canvas element we want to select
    var ctx = $("#scatter-chart");

    // Chart Options
    var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration:800,
        title: {
            display: false,
            text: 'Chart.js Scatter Chart'
        },
        scales: {
            xAxes: [{
                position: 'top',
                gridLines: {
                    zeroLineColor: "rgba(0,255,0,1)",
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                scaleLabel: {
                    display: true,
                    labelString: 'x axis'
                }
            }],
            yAxes: [{
                position: 'right',
                gridLines: {
                    zeroLineColor: "rgba(0,255,0,1)",
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                scaleLabel: {
                    display: true,
                    labelString: 'y axis'
                }
            }]
        }
    };

    // Chart Data
    var chartData = {
        datasets: [{
            label: "My First dataset",
            data: [{
                x: 65,
                y: 28,
            }, {
                x: 59,
                y: 48,
            }, {
                x: 80,
                y: 40,
            }, {
                x: 81,
                y: 19,
            }, {
                x: 56,
                y: 86,
            }, {
                x: 55,
                y: 27,
            }, {
                x: 40,
                y: 89,
            }],
            backgroundColor: "rgba(209,212,219,.3)",
            borderColor: "transparent",
            pointBorderColor: "#D1D4DB",
            pointBackgroundColor: "#FFF",
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
            pointRadius: 4,
        }, {
            label: "My Second dataset",
            data: [{
                x: 45,
                y: 17,
            }, {
                x: 25,
                y: 62,
            }, {
                x: 16,
                y: 78,
            }, {
                x: 36,
                y: 88,
            }, {
                x: 67,
                y: 26,
            }, {
                x: 18,
                y: 48,
            }, {
                x: 76,
                y: 73,
            }],
            backgroundColor: "rgba(81,117,224,.6)",
            borderColor: "transparent",
            pointBorderColor: "#5175E0",
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
    var scatterChart = new Chart(ctx, config);
});