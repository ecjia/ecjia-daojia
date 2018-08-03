/*=========================================================================================
    File Name: area-stacked.js
    Description: google area stacked chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Area Stacked chart
// ------------------------------

// Load the Visualization API and the corechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawAreaStacked);

// Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
function drawAreaStacked() {

    // Create the data table.
    var data = google.visualization.arrayToDataTable([
        ['Year', 'Product1', 'Product2', 'Product3', 'Product4'],
        ['2010',  880,      1200,        1500,       1800],
        ['2011',  530,      850,          750,        960],
        ['2012',  425,      650,          450,        350],
        ['2013',  750,      350,          820,        670],
        ['2014',  550,      780,         1220,        980],
        ['2015',  880,      300,         1340,       1240]
    ]);


    // Set chart options
    var options_area_stacked = {
        title: 'Company Performance',
        height: 400,
        fontSize: 12,
        curveType: 'function',
        colors: ['#DA4453', '#F6BB42', '#37BC9B', '#3BAFDA'],
        isStacked: true,
        pointSize: 5,
        areaOpacity: 0.5,
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
    var area = new google.visualization.AreaChart(document.getElementById('area-stacked'));
    area.draw(data, options_area_stacked);

}


// Resize chart
// ------------------------------

$(function () {

    // Resize chart on menu width change and window resize
    $(window).on('resize', resize);
    $(".menu-toggle").on('click', resize);

    // Resize function
    function resize() {
        drawAreaStacked();
    }
});