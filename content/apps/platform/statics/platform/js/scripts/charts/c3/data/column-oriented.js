/*=========================================================================================
    File Name: column-oriented.js
    Description: c3 column oriented chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Column Oriented Chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the column oriented chart, passes in the data and draws it.
    var columnOriented = c3.generate({
        bindto: '#column-oriented',
        size: {height:400},
        color: {
            pattern: ['#E91E63', '#00BCD4', '#673AB7']
        },

        // Create the data table.
        data: {
            columns: [
                ['data1', 30, 20, 50, 40, 60, 50],
                ['data2', 200, 130, 90, 240, 130, 220],
                ['data3', 300, 200, 160, 400, 250, 250]
            ]
        },
        grid: {
            y: {
                show: true
            }
        },
    });

    // Resize chart on sidebar width change
    $(".menu-toggle").on('click', function() {
        columnOriented.resize();
    });
});