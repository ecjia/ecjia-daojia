/*=========================================================================================
    File Name: to-area.js
    Description: c3 to area transform chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// To Area Transform chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the to area transform chart, passes in the data and draws it.
    var toAreaTransform = c3.generate({
        bindto: '#to-area',
        size: {height:400},
        color: {
            pattern: ['#673AB7', '#E91E63']
        },

        // Create the data table.
        data: {
            columns: [
                ['data1', 30, 200, 100, 400, 150, 250],
                ['data2', 130, 100, 140, 200, 150, 50]
            ],
            type: 'bar'
        },
        grid: {
            y: {
                show: true
            }
        }
    });

    // Instantiate and draw our chart, passing in some options.
    setTimeout(function () {
        toAreaTransform.transform('area', 'data1');
    }, 1000);

    setTimeout(function () {
        toAreaTransform.transform('area', 'data2');
    }, 2000);

    setTimeout(function () {
        toAreaTransform.transform('bar');
    }, 3000);

    setTimeout(function () {
        toAreaTransform.transform('area');
    }, 4000);

    // Resize chart on sidebar width change
    $(".menu-toggle").on('click', function() {
        toAreaTransform.resize();
    });
});