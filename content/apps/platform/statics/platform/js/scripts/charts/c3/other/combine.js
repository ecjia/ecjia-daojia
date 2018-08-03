/*=========================================================================================
    File Name: combine.js
    Description: c3 combine chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Combine chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the line chart, passes in the data and draws it.
    var combineChart = c3.generate({
        bindto: '#combine-chart',
        size: { height: 400 },
        color: {
            pattern: ['#99B898','#FECEA8', '#E84A5F', '#2A363B', '#FF847C', '#F6BB42'],
        },

        // Create the data table.
        data: {
            columns: [
                ['data1', 30, 20, 50, 40, 60, 50],
                ['data2', 200, 130, 90, 240, 130, 220],
                ['data3', 300, 200, 160, 400, 250, 250],
                ['data4', 200, 130, 90, 240, 130, 220],
                ['data5', 130, 120, 150, 140, 160, 150],
                ['data6', 90, 70, 20, 50, 60, 120],
            ],
            type: 'bar',
            types: {
                data3: 'spline',
                data4: 'line',
                data6: 'area',
            },
            groups: [
                ['data1','data2']
            ]
        }
    });

    // Resize chart on sidebar width change
    $(".menu-toggle").on('click', function() {
        combineChart.resize();
    });
});