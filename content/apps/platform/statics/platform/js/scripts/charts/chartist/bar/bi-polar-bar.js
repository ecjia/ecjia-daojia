/*=========================================================================================
    File Name: bi-polar-bar.js
    Description: Chartist bi-polar bar chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Bi-Polar bar chart
// ------------------------------
$(window).on("load", function(){

    var data = {
        labels: ['W1', 'W2', 'W3', 'W4', 'W5', 'W6', 'W7', 'W8', 'W9', 'W10'],
        series: [
            [1, 2, 4, 10, 6, -2, -1, -4, -8, -2]
        ]
    };

    var options = {
        high: 15,
        low: -15,
        axisX: {
            labelInterpolationFnc: function(value, index) {
                return index % 2 === 0 ? value : null;
            }
        }
    };

    new Chartist.Bar('#bipolar-bar', data, options);
});