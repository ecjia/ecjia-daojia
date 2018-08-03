/*=========================================================================================
    File Name: bubble-color.js
    Description: google bubble color by number chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Bubble Color chart
// ------------------------------

// Load the Visualization API and the corechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawBubbleColor);

// Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
function drawBubbleColor() {

    // Create the data table.
    var data = google.visualization.arrayToDataTable([
        ['ID', 'X', 'Y', 'Temperature'],
        ['',   80,  167,      120],
        ['',   79,  136,      130],
        ['',   78,  184,      50],
        ['',   72,  278,      230],
        ['',   81,  200,      210],
        ['',   72,  170,      100],
        ['',   68,  477,      80]
    ]);


    // Set chart options
    var options_bubble_color = {
        height: 450,
        fontSize: 12,
        colorAxis: {colors: ['#FECEA8', '#F6BB42']},
        chartArea: {
            left: '5%',
            width: '90%',
            height: 400
        },
        vAxis: {
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
    var bubble = new google.visualization.BubbleChart(document.getElementById('bubble-color-chart'));
    bubble.draw(data, options_bubble_color);

}


// Resize chart
// ------------------------------

$(function () {

    // Resize chart on menu width change and window resize
    $(window).on('resize', resize);
    $(".menu-toggle").on('click', resize);

    // Resize function
    function resize() {
        drawBubbleColor();
    }
});