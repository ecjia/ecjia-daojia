/*=========================================================================================
    File Name: bubble.js
    Description: Chartjs bubble chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Bubble chart
// ------------------------------
$(window).on("load", function(){

    //Get the context of the Chart canvas element we want to select
    var ctx = $("#bubble-chart");

    var randomScalingFactor = function() {
       return (Math.random() > 0.5 ? 1.0 : -1.0) * Math.round(Math.random() * 100);
    };

    // Chart Options
    var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            xAxes: [{
                display: true,
                gridLines: {
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                scaleLabel: {
                    display: true,
                    labelString: 'Month'
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
                    labelString: 'Value'
                }
            }]
        },
        title:{
            display:false,
            text:'Chart.js Bubble Chart'
        }
    };

    // Chart Data
    var chartData = {
        animation: {
            duration: 10000
        },
        datasets: [{
            label: "Medicine 1",
            backgroundColor: "#64FFDA",
            borderColor: "#64FFDA",
            data: [
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
            ]
        }, {
            label: "Medicine 2",
            backgroundColor: "#FF4081",
            borderColor: "#FF4081",
            data: [
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
            ]
        },{
            label: "Medicine 3",
            backgroundColor: "#7C4DFF",
            borderColor: "#7C4DFF",
            data: [
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
            ]
        }, {
            label: "Medicine 4",
            backgroundColor: "#FF6E40",
            borderColor: "#FF6E40",
            data: [
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
            ]
        },{
            label: "Medicine 5",
            backgroundColor: "#FFFF00",
            borderColor: "#FFFF00",
            data: [
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
                { x: randomScalingFactor(), y: randomScalingFactor(), r: Math.abs(randomScalingFactor()) / 5},
            ]
        }]
    };

    var config = {
        type: 'bubble',

        // Chart Options
        options : chartOptions,

        data : chartData
    };

    // Create the chart
    var bubbleChart = new Chart(ctx, config);

    // Randomize bubble chart data
    window.setInterval(function(){
        var zero = Math.random() < 0.2 ? true : false;
        colors = ["#64FFDA","#FF4081","#7C4DFF","#FF6E40","#FFEA00"];
        $.each(chartData.datasets, function(i, dataset) {
            dataset.backgroundColor = colors[i];
            dataset.borderColor = colors[i];
            dataset.data = dataset.data.map(function() {
                return {
                    x: randomScalingFactor(),
                    y: randomScalingFactor(),
                    r: Math.abs(randomScalingFactor()) / 5,
                };
            });
        });
        bubbleChart.update();
    },2000);
});