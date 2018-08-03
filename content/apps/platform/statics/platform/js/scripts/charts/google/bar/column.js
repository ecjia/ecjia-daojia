/*=========================================================================================
    File Name: column.js
    Description: google column bar chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Column chart
// ------------------------------

// Load the Visualization API and the corechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawColumn);

// Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
function drawColumn() {

    // Create the data table.
    var data = google.visualization.arrayToDataTable([
        ['Year', 'Sales', 'Costs'],
        ['2011',  880,      250],
        ['2012',  730,      300],
        ['2013',  960,      450],
        ['2014',  1340,     430],
        ['2015',  1560,     540]
    ]);


    // Set chart options
    var options_column = {
        height: 400,
        fontSize: 12,
        colors:['#2494be','#F6B75A'],
        chartArea: {
            left: '5%',
            width: '90%',
            height: 350
        },
        vAxis: {
            gridlines:{
                color: '#e9e9e9',
                count: 10
            },
            minValue: 0
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
    var bar = new google.visualization.ColumnChart(document.getElementById('column-chart'));
    bar.draw(data, options_column);

}


// Resize chart
// ------------------------------

$(function () {

    // Resize chart on menu width change and window resize
    $(window).on('resize', resize);
    $(".menu-toggle").on('click', resize);

    // Resize function
    function resize() {
        drawColumn();
    }
});