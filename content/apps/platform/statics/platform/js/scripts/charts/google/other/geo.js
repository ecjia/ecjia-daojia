/*=========================================================================================
    File Name: geo.js
    Description: google geo chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Geo chart
// ------------------------------

// Load the Visualization API and the corechart package.
google.load('visualization', '1.0', {'packages':['geochart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawGeo);

// Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
function drawGeo() {

    // Create the data table.
    var data = google.visualization.arrayToDataTable([
        ['Country',   'Latitude'],
        ['Algeria', 36], ['Angola', -8], ['Benin', 6], ['Botswana', -24],
        ['Burkina Faso', 12], ['Burundi', -3], ['Cameroon', 3],
        ['Canary Islands', 28], ['Cape Verde', 15],
        ['Central African Republic', 4], ['Ceuta', 35], ['Chad', 12],
        ['Comoros', -12], ['Cote d\'Ivoire', 6],
        ['Democratic Republic of the Congo', -3], ['Djibouti', 12],
        ['Egypt', 26], ['Equatorial Guinea', 3], ['Eritrea', 15],
        ['Ethiopia', 9], ['Gabon', 0], ['Gambia', 13], ['Ghana', 5],
        ['Guinea', 10], ['Guinea-Bissau', 12], ['Kenya', -1],
        ['Lesotho', -29], ['Liberia', 6], ['Libya', 32], ['Madagascar', null],
        ['Madeira', 33], ['Malawi', -14], ['Mali', 12], ['Mauritania', 18],
        ['Mauritius', -20], ['Mayotte', -13], ['Melilla', 35],
        ['Morocco', 32], ['Mozambique', -25], ['Namibia', -22],
        ['Niger', 14], ['Nigeria', 8], ['Republic of the Congo', -1],
        ['Réunion', -21], ['Rwanda', -2], ['Saint Helena', -16],
        ['São Tomé and Principe', 0], ['Senegal', 15],
        ['Seychelles', -5], ['Sierra Leone', 8], ['Somalia', 2],
        ['Sudan', 15], ['South Africa', -30], ['South Sudan', 5],
        ['Swaziland', -26], ['Tanzania', -6], ['Togo', 6], ['Tunisia', 34],
        ['Uganda', 1], ['Western Sahara', 25], ['Zambia', -15],
        ['Zimbabwe', -18]
    ]);


    // Set chart options
    var options_geo = {
        height: 600,
        fontSize: 12,
        region: '002', // Africa
        colorAxis: {colors: ['#37BC9B', '#22262f', '#DA4453']},
        backgroundColor: '#3BAFDA',
        datalessRegionColor: '#FB8A74',
        defaultColor: '#f5f5f5',
        chartArea: {
            left: '5%',
            width: '90%',
            height: 550
        },
        tooltip: {
            textStyle: {
                fontSize: 13
            }
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
    var geo = new google.visualization.GeoChart(document.getElementById('geo-chart'));
    geo.draw(data, options_geo);

}


// Resize chart
// ------------------------------

$(function () {

    // Resize chart on menu width change and window resize
    $(window).on('resize', resize);
    $(".menu-toggle").on('click', resize);

    // Resize function
    function resize() {
        drawGeo();
    }
});