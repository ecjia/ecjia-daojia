/*=========================================================================================
    File Name: whole-numbers.js
    Description: Chartist Only whole numbers line chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Only whole numbers chart
// ------------------------------
$(window).on("load", function(){

    new Chartist.Line('#whole-numbers', {
        labels: [1, 2, 3, 4, 5, 6, 7, 8],
        series: [
            [1, 2, 3, 1, -2, 0, 1, 0],
            [-2, -1, -2, -1, -3, -1, -2, -1],
            [0, 0, 0, 1, 2, 3, 2, 1],
            [3, 2, 1, 0.5, 1, 0, -1, -3]
        ]
    }, {
        high: 3,
        low: -3,
        fullWidth: true,
        // As this is axis specific we need to tell Chartist to use whole numbers only on the concerned axis
        axisY: {
            onlyInteger: true,
            offset: 20
        }
    });
});