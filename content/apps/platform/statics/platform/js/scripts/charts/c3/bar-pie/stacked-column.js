/*=========================================================================================
    File Name: stacked-column.js
    Description: c3 stacked column chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Stacked Column Chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the stacked column chart, passes in the data and draws it.
    var stackedColumnChart = c3.generate({
        bindto: '#stacked-column',
        size: {height:400},
        color: {
            pattern: ['#99B898','#FECEA8', '#FF847C', '#E84A5F']
        },

        // Create the data table.
        data: {
            columns: [
                ['data1', -30, 200, 200, 400, -150, 250],
                ['data2', 130, 100, -100, 200, -150, 50],
                ['data3', -230, 200, 200, -300, 250, 250]
            ],
            type: 'bar',
            groups: [
                ['data1', 'data2']
            ]
        },
        grid: {
            y: {
                show: true
            }
        },
    });

    // Instantiate and draw our chart, passing in some options.
    setTimeout(function () {
        stackedColumnChart.groups([['data1', 'data2', 'data3']]);
    }, 1000);

    setTimeout(function () {
        stackedColumnChart.load({
            columns: [['data4', 100, -50, 150, 200, -300, -100]]
        });
    }, 1500);

    setTimeout(function () {
        stackedColumnChart.groups([['data1', 'data2', 'data3', 'data4']]);
    }, 2000);

    // Resize chart on sidebar width change
    $(".menu-toggle").on('click', function() {
        stackedColumnChart.resize();
    });
});