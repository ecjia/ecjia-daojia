/*=========================================================================================
    File Name: category-axis.js
    Description: c3 category axis chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Category Axis Chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the category axis chart, passes in the data and draws it.
    var categoryAxis = c3.generate({
        bindto: '#category-axis',
        size: {height:400},
        color: {
            pattern: ['#673AB7', '#E91E63']
        },

        // Create the data table.
        data: {
            columns: [
                ['data1', 30, 200, 100, 400, 150, 250, 50, 100, 250]
            ]
        },
        axis: {
            x: {
                type: 'category',
                categories: ['cat1', 'cat2', 'cat3', 'cat4', 'cat5', 'cat6', 'cat7', 'cat8', 'cat9']
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
        categoryAxis.resize();
    });
});