/*=========================================================================================
    File Name: spline.js
    Description: c3 spline chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Spline chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the spline chart, passes in the data and draws it.
    var splineChart = c3.generate({
        bindto: '#spline-chart',
        size: { height: 400 },
        point: {
            r: 4
        },
        color: {
            pattern: ['#673AB7', '#E91E63']
        },

        // Create the data table.
        data: {
            columns: [
                ['data1', 30, 200, 100, 400, 150, 250],
                ['data2', 130, 100, 140, 200, 150, 50]
            ],
            type: 'spline'
        },
        grid: {
            y: {
                show: true
            }
        }
    });

    // Resize chart on sidebar width change
    $(".menu-toggle").on('click', function() {
        splineChart.resize();
    });
});