/*=========================================================================================
    File Name: bar.js
    Description: Flot bar chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Bar chart
// ------------------------------
$(window).on("load", function(){

    var data = [ ["January", 10], ["February", 8], ["March", 4], ["April", 13], ["May", 17], ["June", 9] ];

    $.plot("#bar-chart", [ data ], {
        series: {
            bars: {
                show: true,
                barWidth: 0.6,
                align: "center",
                lineWidth: 0,
                fill: true,
                fillColor: { colors: [ { opacity: 0.2 }, { opacity: 0.8 } ] }
            }
        },
        xaxis: {
            mode: "categories",
            tickLength: 0
        },
        yaxis: {
            tickSize: 4
        },
        grid: {
            borderWidth: 1,
            borderColor: "transparent",
            color: '#999',
            minBorderMargin: 20,
            labelMargin: 10,
            margin: {
                top: 8,
                bottom: 20,
                left: 20
            },
        },
        colors: ['#5175E0']
    });

});