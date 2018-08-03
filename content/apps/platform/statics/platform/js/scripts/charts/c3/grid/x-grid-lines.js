/*=========================================================================================
    File Name: x-grid-lines.js
    Description: c3 x grid lines chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// X Grid Lines Chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the x grid lines chart, passes in the data and draws it.
    var xGridLines = c3.generate({
        bindto: '#x-grid-lines',
        size:{height:400},
        color: {
            pattern: ['#673AB7', '#E91E63']
        },

        // Create the data table.
        data: {
            columns: [
                ['sample', 30, 200, 100, 400, 150, 250]
            ]
        },
        grid: {
            x: {
                lines: [
                    {value: 1, text: 'Lable 1'},
                    {value: 3, text: 'Lable 3', position: 'middle'},
                    {value: 4.5, text: 'Lable 4.5', position: 'start'}
                ]
            }
        }
    });


    // Resize chart on sidebar width change
    $(".menu-toggle").on('click', function() {
        xGridLines.resize();
    });
});