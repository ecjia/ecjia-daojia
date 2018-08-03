/*=========================================================================================
    File Name: simple-xy.js
    Description: c3 simple-xy chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Simple XY chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the simple xy chart, passes in the data and draws it.
    var simpleXY = c3.generate({
        bindto: '#simple-xy',
        size: { height: 400 },
        point: {
            r: 4
        },
        color: {
            pattern: ['#673AB7', '#E91E63']
        },

        // Create the data table.
        data: {
            x: 'x',
            columns: [
                ['x', 30, 50, 100, 230, 300, 310],
                ['data1', 30, 200, 100, 400, 150, 250],
                ['data2', 130, 300, 200, 300, 250, 450]
            ]
        },
        grid: {
            y: {
                show: true
            }
        }
    });

    // Instantiate and draw our chart, passing in some options.
    setTimeout(function () {
        simpleXY.load({
            columns: [
                ['data1', 100, 250, 150, 200, 100, 350]
            ]
        });
    }, 1000);

    setTimeout(function () {
        simpleXY.load({
            columns: [
                ['data3', 80, 150, 100, 180, 80, 150]
            ]
        });
    }, 1500);

    setTimeout(function () {
        simpleXY.unload({
            ids: 'data2'
        });
    }, 2000);

    // Resize chart on sidebar width change
    $(".menu-toggle").on('click', function() {
        simpleXY.resize();
    });
});