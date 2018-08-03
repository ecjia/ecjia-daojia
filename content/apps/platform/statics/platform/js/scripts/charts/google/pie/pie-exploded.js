/*=========================================================================================
    File Name: pie-expolded.js
    Description: google pie exploded chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Pie exploded chart
// ------------------------------

// Load the Visualization API and the corechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawPieExploded);

// Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
function drawPieExploded() {

    // Create the data table.
    var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        ['Work',     10],
        ['Eat',      1.5],
        ['Commute',  2.5],
        ['Watch TV', 3],
        ['Sleep',    7]
    ]);


    // Set chart options
    var options_bar = {
        title: 'My Daily Activities',
        height: 400,
        fontSize: 12,
        colors:['#99B898','#FECEA8', '#FF847C', '#E84A5F', '#474747'],
        chartArea: {
            left: '5%',
            width: '90%',
            height: 350
        },
        slices: {
            1: {offset: 0.15},
            3: {offset: 0.1},
            4: {offset: 0.12},
            5: {offset: 0.1}
        }
    };

    // Instantiate and draw our chart, passing in some options.
    var bar = new google.visualization.PieChart(document.getElementById('pie-exploded'));
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
        drawPieExploded();
    }
});