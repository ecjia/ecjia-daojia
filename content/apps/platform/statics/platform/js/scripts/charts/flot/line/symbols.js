/*=========================================================================================
    File Name: symbols.js
    Description: Flot symbols chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Symbols chart
// ------------------------------
$(window).on("load", function(){

    function generate(offset, amplitude) {

        var res = [];
        var start = 0, end = 10;

        for (var i = 0; i <= 50; ++i) {
            var x = start + i / 50 * (end - start);
            res.push([x, amplitude * Math.sin(x + offset)]);
        }

        return res;
    }

    var data = [
        { data: generate(2, 1.8), points: { symbol: "circle" } },
        { data: generate(3, 1.5), points: { symbol: "square" } },
        { data: generate(4, 0.9), points: { symbol: "diamond" } },
        { data: generate(6, 1.4), points: { symbol: "triangle" } },
        { data: generate(7, 1.1), points: { symbol: "cross" } }
    ];

    $.plot("#symbols", data, {
        series: {
            points: {
                show: true,
                radius: 3
            }
        },
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
            hoverable: true
        },
        colors: ['#00A5A8', '#626E82', '#FF7D4D','#FF4558', '#1B2942']
    });
});