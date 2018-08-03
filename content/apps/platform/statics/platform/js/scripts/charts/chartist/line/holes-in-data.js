/*=========================================================================================
    File Name: holes-in-data.js
    Description: Chartist holes in data line chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Holes in data line chart
// ------------------------------
$(window).on("load", function(){

    var chart = new Chartist.Line('#holes-in-data', {
        labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
        series: [
            [5, 5, 10, 8, 7, 5, 4, null, null, null, 10, 10, 7, 8, 6, 9],
            [10, 15, null, 12, null, 10, 12, 15, null, null, 12, null, 14, null, null, null],
            [null, null, null, null, 3, 4, 1, 3, 4,  6,  7,  9, 5, null, null, null]
        ]
    }, {
        fullWidth: true,
        chartPadding: {
            right: 10
        },
        low: 0
    });
});