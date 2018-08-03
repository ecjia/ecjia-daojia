/*=========================================================================================
    File Name: to-line.js
    Description: c3 to line trasnform chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// To Line Trasnform Chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the to line trasnform chart, passes in the data and draws it.
    var toLineTransform = c3.generate({
        bindto: '#to-line',
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
        toLineTransform.transform('line', 'data1');
    }, 1000);

    setTimeout(function () {
        toLineTransform.transform('line', 'data2');
    }, 2000);

    setTimeout(function () {
        toLineTransform.transform('bar');
    }, 3000);

    setTimeout(function () {
        toLineTransform.transform('line');
    }, 4000);

    // Resize chart on sidebar width change
    $(".menu-toggle").on('click', function() {
        toLineTransform.resize();
    });
});