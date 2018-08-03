/*=========================================================================================
    File Name: line-logarithmic.js
    Description: Chartjs simple line chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Line Logarithmic chart
// ------------------------------
$(window).on("load", function(){

    //Get the context of the Chart canvas element we want to select
    var ctx = $("#line-logarithmic");

    var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        title:{
            display:true,
            text:'Chart.js Line Chart - Logarithmic'
        },
        scales: {
            xAxes: [{
                display: true,
                gridLines: {
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                scaleLabel: {
                    display: true,
                    labelString: 'x axis'
                }
            }],
            yAxes: [{
                display: true,
                gridLines: {
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                type: 'logarithmic',
                scaleLabel: {
                    display: true,
                    labelString: 'y axis'
                }
            }]
        }
    };

    var chartData = {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [{
            label: "My First dataset",
            data: [65, 59, 80, 81, 56, 55, 40],
            fill: false,
            borderDash: [5, 5],
            backgroundColor: "#FFF",
            borderColor: "#FF5722",
            pointRadius: 4,
        }, {
            label: "My Second dataset",
            data: [28, 48, 40, 19, 86, 27, 90],
            backgroundColor: "rgba(22,211,154,.5)",
            borderColor: "transparent",
            pointBorderColor: "#28D094",
            pointBackgroundColor: "#FFF",
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
            pointRadius: 4,
        }]
    };

    var config = {
        type: 'line',

        // Chart Options
        options : chartOptions,

        // Chart Data
        data : chartData
    };

    // Create the chart
    var logarithmicChart = new Chart(ctx, config);

});