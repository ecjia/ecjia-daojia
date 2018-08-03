/*=========================================================================================
    File Name: polar.js
    Description: Chartjs polar chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Polar chart
// ------------------------------
$(window).on("load", function(){

    //Get the context of the Chart canvas element we want to select
    var ctx = $("#polar-skip-points");

    // Chart Options
    var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration:500,
        legend: {
            position: 'top',
        },
        title: {
            display: false,
            text: 'Chart.js Polar Area Chart'
        },
        scale: {
          ticks: {
            beginAtZero: true
          },
          reverse: false
        },
        animation: {
            animateRotate: false
        }
    };

    // Chart Data
    var chartData = {
        labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding"],
        datasets: [{
            label: "Skip first dataset",
            backgroundColor: [
                '#00A5A8', '#626E82', '#FF7D4D','#FF4558', '#28D094'
            ],
            data: [NaN, 59, 36, 81, 28],
        }]
    };

    var config = {
        type: 'polarArea',

        // Chart Options
        options : chartOptions,

        data : chartData
    };

    // Create the chart
    var polarChart = new Chart(ctx, config);
});