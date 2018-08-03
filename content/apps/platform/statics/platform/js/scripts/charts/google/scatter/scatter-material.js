/*=========================================================================================
    File Name: scatter-material.js
    Description: google scatter material chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Scatter material chart
// ------------------------------

// Load the Visualization API and the corechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawScatterMaterial);

// Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
function drawScatterMaterial() {

    var data = new google.visualization.DataTable();
        data.addColumn('number', 'Hours Studied');
        data.addColumn('number', 'Final');

    // Create the data table.
    data.addRows([
        [0, 67], [1, 88], [2, 77],
        [3, 93], [4, 85], [5, 91],
        [6, 71], [7, 78], [8, 93],
        [9, 80], [10, 82],[0, 75],
        [5, 80], [3, 90], [1, 72],
        [5, 75], [6, 68], [7, 98],
        [3, 82], [9, 94], [2, 79],
        [2, 95], [2, 86], [3, 67],
        [4, 60], [2, 80], [6, 92],
        [2, 81], [8, 79], [9, 83],
        [3, 75], [1, 80], [3, 71],
        [3, 89], [4, 92], [5, 85],
        [6, 92], [7, 78], [6, 95],
        [3, 81], [0, 64], [4, 85],
        [2, 83], [3, 96], [4, 77],
        [5, 89], [4, 89], [7, 84],
        [4, 92], [9, 98]
    ]);


    // Set chart options
    var options_scatter_material = {
        title: 'Students\' Final Grades',
        subtitle: 'based on hours studied',
        height: 450,
        fontSize: 12,
        colors:['#37BC9B'],
        chartArea: {
            left: '5%',
            width: '90%',
            height: 400
        },
        vAxis: {
            title: 'Grade',
            gridlines:{
                color: '#e9e9e9',
            },
        },
        hAxis: {
            title: 'Hours Studied'
        },
        legend: {
            position: 'top',
            alignment: 'center',
            textStyle: {
                fontSize: 12
            }
        }
    };

    // Instantiate and draw our chart, passing in some options.
    var scatter1 = new google.visualization.ScatterChart(document.getElementById('scatter-material'));
    scatter1.draw(data, options_scatter_material);

}


// Resize chart
// ------------------------------

$(function () {

    // Resize chart on menu width change and window resize
    $(window).on('resize', resize);
    $(".menu-toggle").on('click', resize);

    // Resize function
    function resize() {
        drawScatterMaterial();
    }
});