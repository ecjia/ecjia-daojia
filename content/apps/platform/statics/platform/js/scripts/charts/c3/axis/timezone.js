/*=========================================================================================
    File Name: timezone.js
    Description: c3 timezone chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: GeeksLabs
    Author URL: http://www.themeforest.net/user/geekslabs
==========================================================================================*/

// Timezone chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the timezone chart, passes in the data and draws it.
    var timezone = c3.generate({
        bindto: '#axis-timezone',
        size: {height:400},
        color: {
            pattern: ['#673AB7', '#E91E63']
        },

        // Create the data table.
        data: {
            x: 'x',
            xFormat: '%Y',
            columns: [
                ['x', '2010', '2011', '2012', '2013', '2014', '2015'],
                ['data1', 30, 200, 100, 400, 150, 250],
                ['data2', 130, 340, 200, 500, 250, 350]
            ]
        },
        axis: {
            x: {
                type: 'timeseries',
                // if true, treat x value as localtime (Default)
                // if false, convert to UTC internally
                localtime: false,
                tick: {
                    format: '%Y-%m-%d %H:%M:%S'
                }
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
        timezone.resize();
    });
});