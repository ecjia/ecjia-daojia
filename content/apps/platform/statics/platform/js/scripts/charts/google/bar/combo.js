/*=========================================================================================
    File Name: combo.js
    Description: google combo bar chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Combo chart
// ------------------------------

// Load the Visualization API and the corechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawCombo);

// Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
function drawCombo() {

    // Create the data table.
    var data = google.visualization.arrayToDataTable([
       ['Month', 'Bolivia', 'Ecuador', 'Madagascar', 'Papua New Guinea', 'Rwanda', 'Average'],
       ['2004/05',  165,      938,         522,             998,           450,      614.6],
       ['2005/06',  135,      1120,        599,             1268,          288,      682],
       ['2006/07',  157,      1167,        587,             807,           397,      623],
       ['2007/08',  139,      1110,        615,             968,           215,      609.4],
       ['2008/09',  136,      691,         629,             1026,          366,      569.6]
    ]);


    // Set chart options
    var options_bar = {
        title : 'Monthly Coffee Production by Country',
        seriesType: 'bars',
        series: {5: {type: 'line'}},
        colors: ['#99B898','#FECEA8', '#FF847C', '#E84A5F', '#474747'],
        height: 450,
        fontSize: 12,
        chartArea: {
            left: '5%',
            width: '90%',
            height: 350
        },
        vAxis: {
            title: 'Cups',
            gridlines:{
                color: '#e9e9e9',
                count: 5
            },
            minValue: 0
        },
        hAxis: {
            title: 'Month',
            gridlines:{
                color: '#e9e9e9',
                count: 5
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
    var bar = new google.visualization.ComboChart(document.getElementById('combo-chart'));
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
        drawCombo();
    }
});