/*=========================================================================================
    File Name: donut.js
    Description: Morris donut chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Donut chart
// ------------------------------
$(window).on("load", function(){

    Morris.Donut({
        element: 'donut-chart',
        data: [{
            label: "Custard",
            value: 25
        }, {
            label: "Frosted",
            value: 40
        }, {
            label: "Jam",
            value: 25
        }, {
            label: "Sugar",
            value: 10
        }, ],
        resize: true,
        colors: ['#00A5A8', '#FF7D4D', '#FF4558','#626E82']
    });
});