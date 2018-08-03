/*=========================================================================================
    File Name: y-grid-lines.js
    Description: c3 y grid lines chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Y Grid Lines Chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the y grid lines chart, passes in the data and draws it.
    var yGridLines = c3.generate({
        bindto: '#y-grid-lines',
        size:{height:400},
        color: {
            pattern: ['#673AB7', '#E91E63']
        },

        // Create the data table.
        data: {
            columns: [
                ['sample', 30, 200, 100, 400, 150, 250],
                ['sample2', 1300, 1200, 1100, 1400, 1500, 1250],
            ],
            axes: {
                sample2: 'y2'
            }
        },
        axis: {
            y2: {
                show: true
            }
        },
        grid: {
            y: {
                lines: [
                    {value: 50, text: 'Lable 50 for y'},
                    {value: 1300, text: 'Lable 1300 for y2', axis: 'y2', position: 'start'},
                    {value: 350, text: 'Lable 350 for y', position: 'middle'}
                ]
            }
        }
    });


    // Resize chart on sidebar width change
    $(".menu-toggle").on('click', function() {
        yGridLines.resize();
    });
});