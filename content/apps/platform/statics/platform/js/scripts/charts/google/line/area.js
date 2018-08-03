/*=========================================================================================
    File Name: area.js
    Description: google area chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Area chart
// ------------------------------

// Load the Visualization API and the corechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawArea);

// Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
function drawArea() {

    // Create the data table.
    var data = google.visualization.arrayToDataTable([
        ['Year', 'Sales', 'Costs'],
        ['2010',  880,      250],
        ['2011',  530,      350],
        ['2012',  425,      650],
        ['2013',  750,      350],
        ['2014',  550,      780],
        ['2015',  880,      300]
    ]);


    // Set chart options
    var options_area = {
        title: 'Company Performance',
        height: 400,
        fontSize: 12,
        colors:['#1DE9B6', '#FF6E40'],
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
        hAxis: {
            title: 'Year',
            titleTextStyle: {color: '#333'}
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
    var area = new google.visualization.AreaChart(document.getElementById('area-chart'));
    area.draw(data, options_area);

}


// Resize chart
// ------------------------------

$(function () {

    // Resize chart on menu width change and window resize
    $(window).on('resize', resize);
    $(".menu-toggle").on('click', resize);

    // Resize function
    function resize() {
        drawArea();
    }
});