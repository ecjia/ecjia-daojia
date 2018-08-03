/*=========================================================================================
    File Name: series-types.js
    Description: Flot series types chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: Pixinvent
    Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Series types chart
// ------------------------------
$(window).on("load", function(){

    var d1 = [];
    for (var i = 0; i < 14; i += 0.5) {
        d1.push([i, Math.sin(i)]);
    }

    var d2 = [[0, 3], [4, 8], [8, 5], [9, 13]];

    var d3 = [];
    for (var i = 0; i < 14; i += 0.5) {
        d3.push([i, Math.cos(i)]);
    }

    var d4 = [];
    for (var i = 0; i < 14; i += 0.1) {
        d4.push([i, Math.sqrt(i * 10)]);
    }

    var d5 = [];
    for (var i = 0; i < 14; i += 0.5) {
        d5.push([i, Math.sqrt(i)]);
    }

    var d6 = [];
    for (var i = 0; i < 14; i += 0.5 + Math.random()) {
        d6.push([i, Math.sqrt(2*i + Math.sin(i) + 5)]);
    }

    $.plot("#series-types", [{
        data: d1,
        lines: { show: true, fill: true }
    }, {
        data: d2,
        bars: { show: true }
    }, {
        data: d3,
        points: { show: true }
    }, {
        data: d4,
        lines: { show: true }
    }, {
        data: d5,
        lines: { show: true },
        points: { show: true }
    }, {
        data: d6,
        lines: { show: true, steps: true }
    }],{
        grid: {
            borderWidth: 1,
            borderColor: "#e9e9e9",
            color: '#999',
            minBorderMargin: 20,
            labelMargin: 10,
            margin: {
                top: 8,
                bottom: 20,
                left: 20
            },
        },
        xaxis: {
            tickLength: 0,
            tickDecimals: 0,
        },
        yaxis: {
            tickSize: 5
        },
        colors: ['#00A5A8', '#FF7D4D', '#FF4961','#F25E75', '#626E82']
    });
});