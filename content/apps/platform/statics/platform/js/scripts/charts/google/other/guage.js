/*=========================================================================================
    File Name: guage.js
    Description: google guage chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: GeeksLabs
    Author URL: http://www.themeforest.net/user/geekslabs
==========================================================================================*/

// Guage chart
// ------------------------------

// Load the Visualization API and the corechart package.
google.load('visualization', '1.0', {'packages':['gauge']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawGuage);

// Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
function drawGuage() {

    // Create the data table.
    var net_data = google.visualization.arrayToDataTable([
        ['Label', 'Value'],
        ['Memory', 80],
        ['CPU', 55],
        ['Network', 68]
    ]);

    var earn_data = google.visualization.arrayToDataTable([
        ['Label', 'Value'],
        ['Gross', 80],
        ['Tax', 25],
        ['Net', 55]
    ]);


    // Set chart options
    var options_network_guage = {
        fontSize: 12,
        redFrom: 90,
        redTo: 100,
        yellowFrom:75,
        yellowTo: 90,
        minorTicks: 5,
        chartArea: {
            left: '5%',
            width: '90%',
            height: 350
        }
    };

    var options_earning_guage = {
        fontSize: 12,
        redFrom: 90,
        redTo: 100,
        yellowFrom:75,
        yellowTo: 90,
        minorTicks: 5,
        chartArea: {
            left: '5%',
            width: '90%',
            height: 350
        }
    };

    // Instantiate and draw our chart, passing in some options.
    var net_guage = new google.visualization.Gauge(document.getElementById('guage-network-chart'));
    net_guage.draw(net_data, options_network_guage);

    var earn_guage = new google.visualization.Gauge(document.getElementById('guage-earning-chart'));
    earn_guage.draw(earn_data, options_earning_guage);



    setInterval(function() {
        net_data.setValue(0, 1, 40 + Math.round(60 * Math.random()));
        net_guage.draw(net_data, options_network_guage);

        earn_data.setValue(0, 1, 40 + Math.round(60 * Math.random()));
        earn_guage.draw(earn_data, options_earning_guage);
    }, 13000);
    setInterval(function() {
        net_data.setValue(1, 1, 40 + Math.round(60 * Math.random()));
        net_guage.draw(net_data, options_network_guage);

        earn_data.setValue(1, 1, 40 + Math.round(60 * Math.random()));
        earn_guage.draw(earn_data, options_earning_guage);
    }, 5000);
    setInterval(function() {
        net_data.setValue(2, 1, 60 + Math.round(20 * Math.random()));
        net_guage.draw(net_data, options_network_guage);

        earn_data.setValue(2, 1, 60 + Math.round(20 * Math.random()));
        earn_guage.draw(earn_data, options_earning_guage);
    }, 26000);

}


// Resize chart
// ------------------------------

$(function () {

    // Resize chart on menu width change and window resize
    $(window).on('resize', resize);
    $(".menu-toggle").on('click', resize);

    // Resize function
    function resize() {
        drawGuage();
    }
});