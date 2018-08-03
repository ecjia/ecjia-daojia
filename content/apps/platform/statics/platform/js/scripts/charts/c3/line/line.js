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
        bindto: '#line-chart',
        size: { height: 400 },
        point: {
            r: 4
        },
        color: {
            pattern: ['#673AB7', '#E91E63']
        },
        data: {
            columns: [
                ['data1', 30, 200, 100, 400, 150, 250],
                ['data2', 50, 20, 10, 40, 15, 25]
            ]
        },
        grid: {
            y: {
                show: true,
                stroke: '#ff0'
            }
        }
    });

    // Instantiate and draw our chart, passing in some options.
    setTimeout(function () {
        lineChart.load({
            columns: [
                ['data1', 230, 190, 300, 500, 300, 400]
            ]
        });
    }, 1000);

    setTimeout(function () {
        lineChart.load({
            columns: [
                ['data3', 130, 150, 200, 300, 200, 100]
            ]
        });
    }, 1500);

    setTimeout(function () {
        lineChart.unload({
            ids: 'data1'
        });
    }, 2000);

    // Resize chart on sidebar width change
    $(".menu-toggle").on('click', function() {
        lineChart.resize();
    });
});