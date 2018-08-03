/*=========================================================================================
    File Name: to-bar.js
    Description: c3 to bar transform chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// To Bar Transform Chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the to bar transform chart, passes in the data and draws it.
    var toBarTransform = c3.generate({
        bindto: '#to-bar',
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
            type: 'line'
        },
        grid: {
            y: {
                show: true
            }
        }
    });

    // Instantiate and draw our chart, passing in some options.
    setTimeout(function () {
        toBarTransform.transform('bar', 'data1');
    }, 1000);

    setTimeout(function () {
        toBarTransform.transform('bar', 'data2');
    }, 2000);

    setTimeout(function () {
        toBarTransform.transform('line');
    }, 3000);

    setTimeout(function () {
        toBarTransform.transform('bar');
    }, 4000);

    // Resize chart on sidebar width change
    $(".menu-toggle").on('click', function() {
        toBarTransform.resize();
    });
});