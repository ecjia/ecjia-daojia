/*=========================================================================================
    File Name: column-stacked.js
    Description: google stacked column bar chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Stacked column bar chart
// ------------------------------

// Load the Visualization API and the corechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawColumnStacked);

// Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
function drawColumnStacked() {

    // Create the data table.
    var data = google.visualization.arrayToDataTable([
        ['Genre', 'Fantasy & Sci Fi', 'Romance', 'Mystery/Crime', 'General', 'Western', { role: 'annotation' } ],
        ['2000', 10, 15, 25, 35, 45, ''],
        ['2010', 12, 20, 25, 32, 36, ''],
        ['2020', 5, 24, 20, 34, 17, ''],
        ['2030', 18, 25, 30, 25, 24, ''],
        ['2040', 16, 22, 23, 28, 15, ''],
        ['2050', 8, 26, 20, 42, 30, ''],
        ['2060', 24, 17, 24, 35, 14, '']
    ]);


    // Set chart options
    var options_column_stacked = {
        height: 400,
        fontSize: 12,
        colors: ['#99B898','#FECEA8', '#FF847C', '#E84A5F', '#474747'],
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
    var bar = new google.visualization.ColumnChart(document.getElementById('stacked-column-chart'));
    bar.draw(data, options_column_stacked);

}


// Resize chart
// ------------------------------

$(function () {

    // Resize chart on menu width change and window resize
    $(window).on('resize', resize);
    $(".menu-toggle").on('click', resize);

    // Resize function
    function resize() {
        drawColumnStacked();
    }
});