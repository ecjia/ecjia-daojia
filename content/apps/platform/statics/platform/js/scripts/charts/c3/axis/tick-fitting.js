/*=========================================================================================
    File Name: tick-fitting.js
    Description: c3 tick fitting chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Tick fitting chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the tick fitting chart, passes in the data and draws it.
    var tickFitting = c3.generate({
        bindto: '#tick-fitting',
        size: {height:400},
        color: {
            pattern: ['#673AB7', '#E91E63']
        },

        // Create the data table.
        data: {
            x: 'x',
            columns: [
                ['x', '2013-10-31', '2013-12-31', '2014-01-31', '2014-02-28'],
                ['sample', 30, 100, 400, 150],
            ]
        },
        axis : {
            x : {
                type : 'timeseries',
                tick: {
                    fit: true,
                    format: "%e %b %y"
                }
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
        tickFitting.resize();
    });
});