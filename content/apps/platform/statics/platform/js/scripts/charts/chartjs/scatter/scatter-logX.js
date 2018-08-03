/*=========================================================================================
    File Name: scatter-logX.js
    Description: Chartjs scatter logX chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Scatter logX chart
// ------------------------------
$(window).on("load", function(){

    //Get the context of the Chart canvas element we want to select
    var ctx = $("#scatter-logx");

    // Chart Options
    var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration:800,
        title: {
            display: false,
            text: 'Chart.js Scatter Chart - Logarithmic X-Axis'
        },
        scales: {
            xAxes: [{
                type: 'logarithmic',
                position: 'bottom',
                ticks: {
                    userCallback: function(tick) {
                        var remain = tick / (Math.pow(10, Math.floor(Chart.helpers.log10(tick))));
                        if (remain === 1 || remain === 2 || remain === 5) {
                            return tick.toString() + "Hz";
                        }
                        return '';
                    },
                },
                gridLines: {
                    zeroLineColor: "rgba(0,0,0,.1)",
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                scaleLabel: {
                    labelString: 'Frequency',
                    display: true,
                }
            }],
            yAxes: [{
                type: 'linear',
                ticks: {
                    userCallback: function(tick) {
                        return tick.toString() + "dB";
                    }
                },
                gridLines: {
                    zeroLineColor: "rgba(81,117,224,1)",
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                scaleLabel: {
                    labelString: 'Voltage',
                    display: true
                }
            }]
        }
    };

    // Chart Data
    var chartData = {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [{
            label: "V(node2)",
            data: [
                {
                    x: 1,
                    y: -1.711e-2,
                }, {
                    x: 1.26,
                    y: -2.708e-2,
                }, {
                    x: 1.58,
                    y: -4.285e-2,
                }, {
                    x: 2.0,
                    y: -6.772e-2,
                }, {
                    x: 2.51,
                    y: -1.068e-1,
                }, {
                    x: 3.16,
                    y: -1.681e-1,
                }, {
                    x: 3.98,
                    y: -2.635e-1,
                }, {
                    x: 5.01,
                    y: -4.106e-1,
                }, {
                    x: 6.31,
                    y: -6.339e-1,
                }, {
                    x: 7.94,
                    y: -9.659e-1,
                }, {
                    x: 10.00,
                    y: -1.445,
                }, {
                    x: 12.6,
                    y: -2.110,
                }, {
                    x: 15.8,
                    y: -2.992,
                }, {
                    x: 20.0,
                    y: -4.102,
                }, {
                    x: 25.1,
                    y: -5.429,
                }, {
                    x: 31.6,
                    y: -6.944,
                }, {
                    x: 39.8,
                    y: -8.607,
                }, {
                    x: 50.1,
                    y: -1.038e1,
                }, {
                    x: 63.1,
                    y: -1.223e1,
                }, {
                    x: 79.4,
                    y: -1.413e1,
                }, {
                    x: 100.00,
                    y: -1.607e1,
                }, {
                    x: 126,
                    y: -1.803e1,
                }, {
                    x: 158,
                    y: -2e1,
                }, {
                    x: 200,
                    y: -2.199e1,
                }, {
                    x: 251,
                    y: -2.398e1,
                }, {
                    x: 316,
                    y: -2.597e1,
                }, {
                    x: 398,
                    y: -2.797e1,
                }, {
                    x: 501,
                    y: -2.996e1,
                }, {
                    x: 631,
                    y: -3.196e1,
                }, {
                    x: 794,
                    y: -3.396e1,
                }, {
                    x: 1000,
                    y: -3.596e1,
                }
            ],
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
    var scatterLogXChart = new Chart(ctx, config);
});