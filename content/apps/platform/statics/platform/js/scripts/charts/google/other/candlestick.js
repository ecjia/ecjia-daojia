/*=========================================================================================
    File Name: candlestick.js
    Description: google candlestick chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Candlestick chart
// ------------------------------

// Load the Visualization API and the corechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawCandlestick);

// Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
function drawCandlestick() {

    // Create the data table.
    var data = google.visualization.arrayToDataTable([
        ['Mon', 20, 28, 38, 45],
        ['Tue', 31, 38, 55, 66],
        ['Wed', 50, 55, 77, 80],
        ['Thu', 77, 77, 66, 50],
        ['Fri', 68, 66, 22, 15],
        ['Sat', 68, 66, 22, 15],
        ['Sun', 68, 66, 22, 15],
        // Treat first row as data as well.
    ], true);


    // Set chart options
    var options_candlestick = {
        height: 400,
        fontSize: 12,
        colors: ['#DA4453'],
        candlestick: {
            risingColor: {
                fill: '#DA4453',
                stroke: '#DA4453'
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
    var candlestick = new google.visualization.CandlestickChart(document.getElementById('candlestick-chart'));
    candlestick.draw(data, options_candlestick);

}


// Resize chart
// ------------------------------

$(function () {

    // Resize chart on menu width change and window resize
    $(window).on('resize', resize);
    $(".menu-toggle").on('click', resize);

    // Resize function
    function resize() {
        drawCandlestick();
    }
});