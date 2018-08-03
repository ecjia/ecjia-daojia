/*=========================================================================================
    File Name: donut.js
    Description: google donut chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Donut chart
// ------------------------------

// Load the Visualization API and the corechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawDonut);

// Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
function drawDonut() {

    // Create the data table.
    var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        ['Work',     11],
        ['Eat',      2],
        ['Commute',  2],
        ['Watch TV', 2],
        ['Sleep',    7]
    ]);


    // Set chart options
    var options_donut = {
        title: 'My Daily Activities',
        height: 400,
        fontSize: 12,
        colors:['#99B898','#FECEA8', '#FF847C', '#E84A5F', '#474747'],
        pieHole: 0.55,
        chartArea: {
            left: '5%',
            width: '90%',
            height: 350
        },
    };

    // Instantiate and draw our chart, passing in some options.
    var donut = new google.visualization.PieChart(document.getElementById('donut-chart'));
    donut.draw(data, options_donut);

}


// Resize chart
// ------------------------------

$(function () {

    // Resize chart on menu width change and window resize
    $(window).on('resize', resize);
    $(".menu-toggle").on('click', resize);

    // Resize function
    function resize() {
        drawDonut();
    }
});