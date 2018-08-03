/*=========================================================================================
    File Name: diff.js
    Description: google diff chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Diff chart
// ------------------------------

// Load the Visualization API and the corechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawDiff);

// Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
function drawDiff() {

    // Create the data table.
    var oldData = google.visualization.arrayToDataTable([
        ['Name', 'Popularity'],
        ['Aaron', 250],
        ['Allena', 4200],
        ['Benjamin', 2900],
        ['Phillip', 8200],
        ['Maegan', 2800],
        ['Kelvin', 4200],
        ['Renetta', 900],
        ['Nickolas', 6200]
    ]);

    var newData = google.visualization.arrayToDataTable([
        ['Name', 'Popularity'],
        ['Aaron', 370],
        ['Allena', 600],
        ['Benjamin', 4500],
        ['Phillip', 6200],
        ['Maegan', 5200],
        ['Kelvin', 9600],
        ['Renetta', 1200],
        ['Nickolas', 3400]
    ]);

    var barChartDiff = new google.visualization.BarChart(document.getElementById('diff-chart'));

    // Set chart options
    var options_diff = {
        height: 600,
        fontSize: 12,
        colors: ['#DA4453'],
        chartArea: {
            left: '5%',
            width: '90%',
            height: 550
        },
        vAxis: {
            title: 'Popularity',
            gridlines:{
                color: '#e9e9e9',
                count: 10
            },
            minValue: 0
        },
        legend: {
            position: 'top',
            alignment: 'end',
            textStyle: {
                fontSize: 12
            }
        }
    };

    // Instantiate and draw our chart, passing in some options.
    var diffData = barChartDiff.computeDiff(oldData, newData);
    barChartDiff.draw(diffData, options_diff);

}


// Resize chart
// ------------------------------

$(function () {

    // Resize chart on menu width change and window resize
    $(window).on('resize', resize);
    $(".menu-toggle").on('click', resize);

    // Resize function
    function resize() {
        drawDiff();
    }
});