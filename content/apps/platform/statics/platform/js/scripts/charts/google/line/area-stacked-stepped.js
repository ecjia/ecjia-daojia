/*=========================================================================================
    File Name: area-stacked-stepped.js
    Description: google area stacked stepped chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Area stack stepped chart
// ------------------------------

// Load the Visualization API and the corechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawAreaStackedStepped);

// Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
function drawAreaStackedStepped() {

    // Create the data table.
    var data = google.visualization.arrayToDataTable([
        ['Year',  'Colonial', 'Victorian', 'Robust', 'Contemporary'],
        ['2011',      5.2,        3.6,        2.8,         2       ],
        ['2012',      5.6,          4,        2.8,         3       ],
        ['2013',      7.2,        2.2,        2.2,         6       ],
        ['2014',        8,        1.7,        0.8,         4       ]
    ]);


    // Set chart options
    var options_bar = {
        height: 400,
        fontSize: 12,
        isStacked: 'relative',
        colors: ['#DA4453', '#F6BB42', '#37BC9B', '#3BAFDA'],
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
            ticks: [0, .3, .6, .9, 1],
            minValue: 0
        },
        legend: {
            position: 'top',
            alignment: 'center',
            maxLines: 3,
            textStyle: {
                fontSize: 12
            }
        }
    };

    // Instantiate and draw our chart, passing in some options.
    var bar = new google.visualization.SteppedAreaChart(document.getElementById('area-stacked-stepped'));
    bar.draw(data, options_bar);

}


// Resize chart
// ------------------------------

$(function () {

    // Resize chart on menu width change and window resize
    $(window).on('resize', resize);
    $(".menu-toggle").on('click', resize);

    // Resize function
    function resize() {
        drawAreaStackedStepped();
    }
});