/*=========================================================================================
    File Name: radar.js
    Description: Chartjs radar chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Radar chart
// ------------------------------
$(window).on("load", function(){

    //Get the context of the Chart canvas element we want to select
    var ctx = $("#radar-chart");

    // Chart Options
    var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration:500,
        legend: {
            position: 'top',
        },
        title: {
            display: true,
            text: 'Chart.js Radar Chart'
        },
        scale: {
          reverse: false,
          ticks: {
            beginAtZero: true
          }
        }
    };

    // Chart Data
    var chartData = {
        labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
        datasets: [{
            label: "My First dataset",
            backgroundColor: "rgba(245,0,87,.3)",
            borderColor: "transparent",
            pointBorderColor: "#F50057",
            pointBackgroundColor: "#FFF",
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
            pointRadius: 4,
            data: [65, 59, 80, 81, 56, 55, 40],
        }, {
            label: 'Hidden dataset',
            hidden: true,
            data: [45, 25, 16, 36, 67, 18, 76],
        }, {
            label: "My Second dataset",
            backgroundColor: "rgba(29,233,182,.6)",
            borderColor: "transparent",
            pointBorderColor: "#1DE9B6",
            pointBackgroundColor: "#FFF",
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
            pointRadius: 4,
            data: [28, 48, 40, 19, 86, 27, 78],
        },]
    };

    var config = {
        type: 'radar',

        // Chart Options
        options : chartOptions,

        data : chartData
    };

    // Create the chart
    var polarChart = new Chart(ctx, config);
});