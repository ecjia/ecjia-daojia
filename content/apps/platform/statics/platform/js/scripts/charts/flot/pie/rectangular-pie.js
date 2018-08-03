/*=========================================================================================
    File Name: rectangular-pie.js
    Description: Flot rectangular pie chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Rectangular pie chart
// ------------------------------
$(window).on("load", function(){

    function labelFormatter(label, series) {
        return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
    }

    var options = {
        series: {
            pie: {
                show: true,
                radius: 500,
                label: {
                    show: true,
                    formatter: labelFormatter,
                    threshold: 0.1
                }
            }
        },
        legend: {
            show: false
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

    $.plot("#rectangular-pie-chart", data, options);
});