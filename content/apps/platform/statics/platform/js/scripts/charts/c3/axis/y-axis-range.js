/*=========================================================================================
    File Name: y-axis-range.js
    Description: c3 y-axis range chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Y Axis Range chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the y axis range chart, passes in the data and draws it.
    var yAxisRange = c3.generate({
        bindto: '#range-y-axis',
        size: {height:400},
        color: {
            pattern: ['#673AB7', '#E91E63']
        },

        // Create the data table.
        data: {
            columns: [
                ['sample', 30, 200, 100, 400, 150, 250]
            ]
        },
        axis: {
            y: {
                max: 400,
                min: -400,
                // Range includes padding, set 0 if no padding needed
                // padding: {top:0, bottom:0}
            }
        },
        grid: {
            y: {
                show: true
            }
        },
    });

    // Resize chart on sidebar width change
    $(".menu-toggle").on('click', function() {
        yAxisRange.resize();
    });
});