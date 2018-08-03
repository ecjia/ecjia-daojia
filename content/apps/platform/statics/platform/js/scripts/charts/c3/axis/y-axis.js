/*=========================================================================================
    File Name: y-axis.js
    Description: c3 y-axis chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: GeeksLabs
    Author URL: http://www.themeforest.net/user/geekslabs
==========================================================================================*/

// Y Axis chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the y axis chart, passes in the data and draws it.
    var yAxisChart = c3.generate({
        bindto: '#y-axis',
        size: {height:400},
        color: {
            pattern: ['#673AB7', '#E91E63']
        },

        // Create the data table.
        data: {
            columns: [
                ['sample', 30, 200, 100, 400, 150, 2500]
            ]
        },
        axis : {
            y : {
                tick: {
                    format: d3.format("$,")
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
        yAxisChart.resize();
    });
});