/*=========================================================================================
    File Name: bubble.js
    Description: google bubble chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Bubble chart
// ------------------------------

// Load the Visualization API and the corechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawBubble);

// Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
function drawBubble() {

    // Create the data table.
    var data = google.visualization.arrayToDataTable([
        ['ID', 'Life Expectancy', 'Fertility Rate', 'Region',     'Population'],
        ['CAN',    80.66,              1.67,      'North America',  83739900],
        ['DEU',    79.84,              1.36,      'Europe',         81902307],
        ['DNK',    78.6,               1.24,      'Europe',         65230956],
        ['EGY',    72.73,              2.78,      'Middle East',    79716203],
        ['GBR',    80.05,              2,         'Europe',         61801570],
        ['IRN',    72.49,              1.7,       'Middle East',    73137148],
        ['IRQ',    68.09,              4.77,      'Middle East',    81090763],
        ['ISR',    81.55,              2.96,      'Middle East',    7485600],
        ['RUS',    68.6,               1.54,      'Europe',         141850000],
        ['USA',    78.09,              2.05,      'North America',  307007000]
    ]);


    // Set chart options
    var options_bubble = {
        height: 450,
        fontSize: 12,
        colors: ['#009688', '#3F51B5', '#FF5722'],
        chartArea: {
            left: '5%',
            width: '90%',
            height: 400
        },
        vAxis: {
            title: 'Fertility Rate',
            titleTextStyle: {
                fontSize: 13,
                italic: false
            },
            gridlines:{
                color: '#e9e9e9',
                count: 10
            },
            minValue: 0
        },
        bubble: {
          textStyle: {
            auraColor: 'none',
            color: '#fff'
          },
          stroke: '#fff'
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
    var bubble = new google.visualization.BubbleChart(document.getElementById('bubble-chart'));
    bubble.draw(data, options_bubble);

}


// Resize chart
// ------------------------------

$(function () {

    // Resize chart on menu width change and window resize
    $(window).on('resize', resize);
    $(".menu-toggle").on('click', resize);

    // Resize function
    function resize() {
        drawBubble();
    }
});