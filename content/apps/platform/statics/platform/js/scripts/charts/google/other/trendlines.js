/*=========================================================================================
    File Name: trendlines.js
    Description: google horizontal trendlines chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Trendlines chart
// ------------------------------

// Load the Visualization API and the corechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawTrendlines);

// Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
function drawTrendlines() {

    // Create the data table.
    var data = google.visualization.arrayToDataTable([
        ['Week', 'Bugs', 'Tests'],
        [1, 125, 20],
        [2, 176, 30],
        [3, 75, 47],
        [4, 149, 60],
        [5, 94, 75],
        [6, 192, 82],
        [7, 63, 88],
        [8, 101, 95]
    ]);


    // Set chart options
    var options_trendlines = {
        height: 400,
        fontSize: 12,
        colors: ['#673AB7', '#E91E63'],
        trendlines: {
            0: {
                labelInLegend: 'Bug line',
                visibleInLegend: true,
            },
            1: {
                labelInLegend: 'Test line',
                visibleInLegend: true,
            }
        },
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
    var trendlines = new google.visualization.ColumnChart(document.getElementById('trendlines'));
    trendlines.draw(data, options_trendlines);

}


// Resize chart
// ------------------------------

$(function () {

    // Resize chart on menu width change and window resize
    $(window).on('resize', resize);
    $(".menu-toggle").on('click', resize);

    // Resize function
    function resize() {
        drawTrendlines();
    }
});