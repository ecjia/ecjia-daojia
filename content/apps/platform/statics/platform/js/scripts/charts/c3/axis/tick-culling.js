/*=========================================================================================
    File Name: tick-culling.js
    Description: c3 tick culling chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Tick Culling chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the tick culling chart, passes in the data and draws it.
    var tickCulling = c3.generate({
        bindto: '#tick-culling',
        size: {height:400},
        color: {
            pattern: ['#673AB7', '#E91E63']
        },

        // Create the data table.
        data: {
            columns: [
                ['sample', 30, 200, 100, 400, 150, 250, 30, 200, 100, 400, 150, 250, 30, 200, 100, 400, 150, 250, 200, 100, 400, 150, 250]
            ]
        },
        axis: {
            x: {
                type: 'category',
                tick: {
                    culling: {
                        max: 4 // the number of tick texts will be adjusted to less than this value
                    }
                    // for normal axis, default on
                    // for category axis, default off
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
        tickCulling.resize();
    });
});