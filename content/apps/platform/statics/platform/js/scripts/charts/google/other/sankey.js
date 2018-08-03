/*=========================================================================================
    File Name: sankey.js
    Description: google sankey chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Sankey chart
// ------------------------------

// Load the Visualization API and the corechart package.
google.load('visualization', '1.0', {'packages':['sankey']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawSankey);

// Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
function drawSankey() {

    // Create the data table.
    var data = new google.visualization.DataTable();
        data.addColumn('string', 'From');
        data.addColumn('string', 'To');
        data.addColumn('number', 'Weight');
        data.addRows([
            [ 'Brazil', 'Portugal', 5 ],
            [ 'Brazil', 'France', 1 ],
            [ 'Brazil', 'Spain', 1 ],
            [ 'Brazil', 'England', 1 ],
            [ 'Canada', 'Portugal', 1 ],
            [ 'Canada', 'France', 5 ],
            [ 'Canada', 'England', 1 ],
            [ 'Mexico', 'Portugal', 1 ],
            [ 'Mexico', 'France', 1 ],
            [ 'Mexico', 'Spain', 5 ],
            [ 'Mexico', 'England', 1 ],
            [ 'USA', 'Portugal', 1 ],
            [ 'USA', 'France', 1 ],
            [ 'USA', 'Spain', 1 ],
            [ 'USA', 'England', 5 ],
            [ 'Portugal', 'Angola', 2 ],
            [ 'Portugal', 'Senegal', 1 ],
            [ 'Portugal', 'Morocco', 1 ],
            [ 'Portugal', 'South Africa', 3 ],
            [ 'France', 'Angola', 1 ],
            [ 'France', 'Senegal', 3 ],
            [ 'France', 'Mali', 3 ],
            [ 'France', 'Morocco', 3 ],
            [ 'France', 'South Africa', 1 ],
            [ 'Spain', 'Senegal', 1 ],
            [ 'Spain', 'Morocco', 3 ],
            [ 'Spain', 'South Africa', 1 ],
            [ 'England', 'Angola', 1 ],
            [ 'England', 'Senegal', 1 ],
            [ 'England', 'Morocco', 2 ],
            [ 'England', 'South Africa', 7 ],
            [ 'South Africa', 'China', 5 ],
            [ 'South Africa', 'India', 1 ],
            [ 'South Africa', 'Japan', 3 ],
            [ 'Angola', 'China', 5 ],
            [ 'Angola', 'India', 1 ],
            [ 'Angola', 'Japan', 3 ],
            [ 'Senegal', 'China', 5 ],
            [ 'Senegal', 'India', 1 ],
            [ 'Senegal', 'Japan', 3 ],
            [ 'Mali', 'China', 5 ],
            [ 'Mali', 'India', 1 ],
            [ 'Mali', 'Japan', 3 ],
            [ 'Morocco', 'China', 5 ],
            [ 'Morocco', 'India', 1 ],
            [ 'Morocco', 'Japan', 3 ]
        ]);

    var colors = ['#a6cee3', '#b2df8a', '#fb9a99', '#fdbf6f',
                  '#cab2d6', '#ffff99', '#1f78b4', '#33a02c'];

    // Set chart options
    var options_sankey = {
        height: 600,
        fontSize: 12,
        sankey: {
            node: {
                colors: colors,
                label: {
                    fontSize: 14,
                    color: '#22262f',
                    bold: true,
                },
            },
            link: {
                colorMode: 'gradient',
                colors: colors
            }
        },
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
        vAxis: {
            gridlines:{
                color: '#E4EBF1',
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
    var sankey = new google.visualization.Sankey(document.getElementById('sankey-chart'));
    sankey.draw(data, options_sankey);

}


// Resize chart
// ------------------------------

$(function () {

    // Resize chart on menu width change and window resize
    $(window).on('resize', resize);
    $(".menu-toggle").on('click', resize);

    // Resize function
    function resize() {
        drawSankey();
    }
});