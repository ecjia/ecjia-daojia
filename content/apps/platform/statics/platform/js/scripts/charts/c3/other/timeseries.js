/*=========================================================================================
    File Name: timeseries.js
    Description: c3 timeseries chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Timeseries chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the timeseries chart, passes in the data and draws it.
    var timeseriesChart = c3.generate({
        bindto: '#timeseries',
        size: { height: 400 },
        color: {
            pattern: ['#E91E63', '#00BCD4', '#673AB7']
        },

        // Create the data table.
        data: {
            x: 'x',
    //        xFormat: '%Y%m%d', // 'xFormat' can be used as custom format of 'x'
            columns: [
                ['x', '2013-01-01', '2013-01-02', '2013-01-03', '2013-01-04', '2013-01-05', '2013-01-06'],
    //            ['x', '20130101', '20130102', '20130103', '20130104', '20130105', '20130106'],
                ['data1', 30, 200, 100, 400, 150, 250],
                ['data2', 130, 340, 200, 500, 250, 350]
            ]
        },
        axis: {
            x: {
                type: 'timeseries',
                tick: {
                    format: '%Y-%m-%d'
                }
            }
        },
        grid: {
            y: {
                show: true
            }
        }
    });

    // Instantiate and draw our chart, passing in some options.
    setTimeout(function () {
        timeseriesChart.load({
            columns: [
                ['data3', 400, 500, 450, 700, 600, 500]
            ]
        });
    }, 1000);

    // Resize chart on sidebar width change
    $(".menu-toggle").on('click', function() {
        timeseriesChart.resize();
    });
});