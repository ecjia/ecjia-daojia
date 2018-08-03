/*=========================================================================================
    File Name: line-multi-axis.js
    Description: Chartjs multi axis line chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Line multi axis chart
// ------------------------------
$(window).on("load", function(){

    //Get the context of the Chart canvas element we want to select
    var ctx = $("#line-multi-axis");

    var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        hoverMode: 'label',
        stacked: false,
        title:{
            display:true,
            text:'Chart.js Line Chart - Multi Axis'
        },
        scales: {
            xAxes: [{
                display: true,
                gridLines: {
                    offsetGridLines: false,
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                scaleLabel: {
                    display: true,
                    // labelString: 'x axis'
                }
            }],
            yAxes: [{
                type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                display: true,
                gridLines: {
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                position: "left",
                id: "y-axis-1",
            }, {
                type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                display: true,
                position: "right",
                id: "y-axis-2",

                // grid line settings
                gridLines: {
                    drawOnChartArea: false, // only want the grid lines for one axis to show up
                    color: "#f3f3f3",
                    drawTicks: false,
                },
            }],
        }
    };

    var chartData = {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [{
            label: "My First dataset",
            data: [15, 45, -17, -42, 55, -24, 18],
            yAxisID: "y-axis-1",
            backgroundColor: "rgba(209,212,219,.4)",
            borderColor: "transparent",
            pointBorderColor: "#D1D4DB",
            pointBackgroundColor: "#FFF",
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
            pointRadius: 4,
        }, {
            label: "My Second dataset",
            data: [-26, 44, 16, 42, -38, -9, 46],
            yAxisID: "y-axis-2",
            backgroundColor: "rgba(81,117,224,.7)",
            borderColor: "transparent",
            pointBorderColor: "#5175E0",
            pointBackgroundColor: "#FFF",
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
            pointRadius: 4,
        }]
    };

    var config = {
        type: 'line',

        // Chart Options
        options: chartOptions,

        // Chart Data
        data : chartData
    };

    // Create the chart
    var multiAxisChart = new Chart(ctx, config);
});