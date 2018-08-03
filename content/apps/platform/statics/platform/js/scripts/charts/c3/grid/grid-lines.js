/*=========================================================================================
    File Name: grid-lines.js
    Description: c3 grid lines chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Grid Lines chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the grid lines chart, passes in the data and draws it.
    var gridLines = c3.generate({
        bindto: '#grid-lines',
        size:{height:400},
        color: {
            pattern: ['#673AB7', '#E91E63']
        },

        // Create the data table.
        data: {
            columns: [
                ['sample', 30, 200, 100, 400, 150, 250, 120, 200]
            ]
        },
        grid: {
            x: {
                show: true
            },
            y: {
                show: true
            }
        }
    });

    // Resize chart on sidebar width change
    $(".menu-toggle").on('click', function() {
        gridLines.resize();
    });
});