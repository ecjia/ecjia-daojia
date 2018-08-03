/*=========================================================================================
    File Name: line.js
    Description: Flot line chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Line chart
// ------------------------------
$(window).on("load", function(){

    var options = {
        legend: {
            show: false
        },
        grid: {
            borderWidth: 1,
            borderColor: {
                top: "#e9e9e9",
                right:"transparent",
                bottom:"transparent",
                left:"transparent",
            },
            color: '#999',
            hoverable: true,
            minBorderMargin: 20,
            labelMargin: 10,
            margin: {
                top: 8,
                bottom: 20,
                left: 20
            },
        },
        series: {
            lines: {
                show: true,
                lineWidth: 0,
                fill: true,
                fillColor: { colors: [ { opacity: 0.8 }, { opacity: 0.1 } ] }
            },
            points: {
                show: false
            },
        },
        xaxis: {
            tickLength: 0,
            tickDecimals: 0,
        },
        yaxis: {
            tickSize: 50
        },
        colors: ['#00bfc7']
    };

    var data = [{
        "label": "Europe (EU27)",
        "data": [[2011, 0], [2012, 100], [2013, 75], [2014, 175], [2015, 125], [2016, 150]]
    }];

    $.plot("#line-chart", data, options);
});