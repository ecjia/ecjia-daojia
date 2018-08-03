/*=========================================================================================
    File Name: line.js
    Description: google line chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Line chart
// ------------------------------

// Load the Visualization API and the corechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawLine);

// Callback that creates and populates a data table, instantiates the line chart, passes in the data and draws it.
function drawLine() {

    // Create the data table.
    var data = google.visualization.arrayToDataTable([
        ['Year', 'Sales', 'Costs'],
        ['2010',  880,      250],
        ['2011',  530,      350],
        ['2012',  425,      650],
        ['2013',  750,      350],
        ['2014',  550,      780],
        ['2015',  880,      300]
    ]);


    // Set chart options
    var options_line = {
        height: 400,
        fontSize: 12,
        curveType: 'function',
        colors: ['#37BC9B', '#DA4453'],
        pointSize: 5,
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
    var line = new google.visualization.LineChart(document.getElementById('line-chart'));
    line.draw(data, options_line);

}


// Resize chart
// ------------------------------

$(function () {

    // Resize chart on menu width change and window resize
    $(window).on('resize', resize);
    $(".menu-toggle").on('click', resize);

    // Resize function
    function resize() {
        drawLine();
    }
});