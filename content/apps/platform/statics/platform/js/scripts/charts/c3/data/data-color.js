/*=========================================================================================
    File Name: data-color.js
    Description: c3 data color chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: GeeksLabs
    Author URL: http://www.themeforest.net/user/geekslabs
==========================================================================================*/

// Data Color chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the data color chart, passes in the data and draws it.
    var dataColor = c3.generate({
        bindto: '#data-color',
        size: {height:400},
        // Create the data table.
        data: {
            columns: [
                ['data1', 30, 20, 50, 40, 60, 50],
                ['data2', 200, 130, 90, 240, 130, 220],
                ['data3', 300, 200, 160, 400, 250, 250]
            ],
            type: 'bar',
            colors: {
                data1: '#673AB7',
                data2: '#E91E63',
            },
            color: function (color, d) {
                // d will be 'id' when called for legends
                return d.id && d.id === 'data3' ? d3.rgb(color).darker(d.value / 150) : color;
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
        dataColor.resize();
    });
});