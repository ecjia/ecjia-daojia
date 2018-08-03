/*=========================================================================================
    File Name: pie.js
    Description: Flot pie chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Pie chart
// ------------------------------
$(window).on("load", function(){

    var options = {
        series: {
            pie: {
                show: true
            }
        },
        colors: ['#FFC400', '#FF7D4D', '#FF4558','#626E82', '#28D094', '#00A5A8']
    };

    var data = [
        { label: "Series1",  data: 50},
        { label: "Series2",  data: 70},
        { label: "Series3",  data: 60},
        { label: "Series4",  data: 90},
        { label: "Series5",  data: 80},
        { label: "Series6",  data: 110}
    ];

    $.plot("#simple-pie-chart", data, options);
});