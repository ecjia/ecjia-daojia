/*=========================================================================================
    File Name: scatter.js
    Description: google scatter chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Scatter chart
// ------------------------------

// Load the Visualization API and the corechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawScatter);

// Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
function drawScatter() {

    // Create the data table.
    var data = google.visualization.arrayToDataTable([
        ['Age', 'Weight'],
        [ 8,      12],
        [ 4,      5.5],
        [ 11,     14],
        [ 5,      3],
        [ 3,      3.5],
        [ 6.5,    7]
    ]);


    // Set chart options
    var options_scatter = {
        title: 'Age vs. Weight comparison',
        height: 450,
        fontSize: 12,
        colors:['#37BC9B'],
        chartArea: {
            left: '5%',
            width: '90%',
            height: 400
        },
        vAxis: {
            title: 'Weight',
            gridlines:{
                color: '#e9e9e9',
                count: 10
            },
            minValue: 0,
            maxValue: 15
        },
        hAxis: {
            title: 'Age',
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
    var scatter = new google.visualization.ScatterChart(document.getElementById('scatter-chart'));
    scatter.draw(data, options_scatter);

}


// Resize chart
// ------------------------------

$(function () {

    // Resize chart on menu width change and window resize
    $(window).on('resize', resize);
    $(".menu-toggle").on('click', resize);

    // Resize function
    function resize() {
        drawScatter();
    }
});