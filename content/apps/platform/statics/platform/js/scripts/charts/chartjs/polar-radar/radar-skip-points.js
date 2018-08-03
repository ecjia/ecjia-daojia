/*=========================================================================================
    File Name: radar-skip-points.js
    Description: Chartjs radar skip points chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Radar skip points chart
// ------------------------------
$(window).on("load", function(){

    //Get the context of the Chart canvas element we want to select
    var ctx = $("#radar-skip-points");

    // Chart Options
    var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration:500,
        legend: {
            position: 'bottom',
        },
        hover: {
            mode: 'label'
        },
        scales: {
            xAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Month'
                }
            }],
            yAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Value'
                }
            }]
        },
        title: {
            display: true,
            text: 'Chart.js Line Chart - Legend'
        }
    };

    // Chart Data
    var chartData = {
        labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
        datasets: [{
            label: "Skip first dataset",
            backgroundColor: "rgba(245,0,87,.3)",
            borderColor: "transparent",
            pointBorderColor: "#F50057",
            pointBackgroundColor: "#FFF",
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
            pointRadius: 3,
            data: [NaN, 59, 80, 81, 56, 55, 40],
        }, {
            label: "Skip mid dataset",
            data: [45, 25, NaN, 36, 67, 18, 76],
            backgroundColor: "rgba(29,233,182,.6)",
            borderColor: "transparent",
            pointBorderColor: "#1DE9B6",
            pointBackgroundColor: "#FFF",
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
            pointRadius: 3,
        }, {
            label: "Skip last dataset",
            data: [28, 48, 40, 19, 86, 27, NaN],
            backgroundColor: "rgba(101,31,255,.6)",
            borderColor: "transparent",
            pointBorderColor: "#651FFF",
            pointBackgroundColor: "#FFF",
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
            pointRadius: 3,
        },]
    };

    var config = {
        type: 'radar',

        // Chart Options
        options : chartOptions,

        data : chartData
    };

    // Create the chart
    var lineChart = new Chart(ctx, config);
});