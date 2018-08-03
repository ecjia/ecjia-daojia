/*=========================================================================================
    File Name: line.js
    Description: c3 simple line chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Line chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the line chart, passes in the data and draws it.
    var lineChart = c3.generate({
        bindto: '#data-from-url',
        size: {height:400},
        color: {
            pattern: ['#E91E63', '#00BCD4', '#673AB7']
        },

        // Create the data table.
        data: {
            url: '../../../app-assets/data/c3/c3_test.csv'
        },
        grid: {
            y: {
                show: true
            }
        },
    });

    // Instantiate and draw our chart, passing in some options.
    setTimeout(function () {
        c3.generate({
            data: {
                url: '../../../app-assets/data/c3/c3_test.json',
                mimeType: 'json'
            }
        });
    }, 1000);

    // Resize chart on sidebar width change
    $(".menu-toggle").on('click', function() {
        lineChart.resize();
    });
});