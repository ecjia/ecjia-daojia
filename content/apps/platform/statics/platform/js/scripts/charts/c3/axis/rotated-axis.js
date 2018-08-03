/*=========================================================================================
    File Name: rotated-axis.js
    Description: c3 rotated axis chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Rotated Axis Chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the rotated axis chart, passes in the data and draws it.
    var rotatedAxis = c3.generate({
        bindto: '#rotated-axis',
        size: {height:400},
        color: {
            pattern: ['#673AB7', '#E91E63']
        },

        // Create the data table.
        data: {
            columns: [
                ['data1', 30, 200, 100, 400, 150, 250],
                ['data2', 50, 20, 10, 40, 15, 25]
            ],
            types: {
                data1: 'bar',
            }
        },
        axis: {
            rotated: true
        },
        grid: {
            y: {
                show: true
            }
        },
    });

    // Resize chart on sidebar width change
    $(".menu-toggle").on('click', function() {
        rotatedAxis.resize();
    });
});