/*=========================================================================================
    File Name: multiple-xy.js
    Description: c3 multiple-xy chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Multiple XY chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the multiple xy chart, passes in the data and draws it.
    var multipleXY = c3.generate({
        bindto: '#multiple-xy',
        size: { height: 400 },
        point: {
            r: 4
        },
        color: {
            pattern: ['#673AB7', '#E91E63']
        },

        // Create the data table.
        data: {
            xs: {
                'data1': 'x1',
                'data2': 'x2',
            },
            columns: [
                ['x1', 10, 30, 45, 50, 70, 100],
                ['x2', 30, 50, 75, 100, 120],
                ['data1', 30, 200, 100, 400, 150, 250],
                ['data2', 20, 180, 240, 100, 190]
            ]
        },
        grid: {
            y: {
                show: true
            }
        }
    });

    // Resize chart on sidebar width change
    $(".menu-toggle").on('click', function() {
        multipleXY.resize();
    });
});