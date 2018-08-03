/*=========================================================================================
    File Name: pie-diff-invert.js
    Description: google pie diff invert chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Pie diff invert chart
// ------------------------------

// Load the Visualization API and the corechart package.
google.load('visualization', '1.0', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawPieDiffInvert);

// Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
function drawPieDiffInvert() {

    // Create the data table.

    // Old data
    var oldData = google.visualization.arrayToDataTable([
        ['Major', 'Degrees'],
        ['Business', 256070], ['Education', 108034],
        ['Social Sciences & History', 127101], ['Health', 81863],
        ['Psychology', 74194]
    ]);

    // New data
    var newData = google.visualization.arrayToDataTable([
        ['Major', 'Degrees'],
        ['Business', 358293], ['Education', 101265],
        ['Social Sciences & History', 172780], ['Health', 129634],
        ['Psychology', 97216]
    ]);


    // Set chart options
    var options_diff_invert = {
        title: 'My Daily Activities',
        height: 400,
        fontSize: 12,
        colors:['#99B898','#FECEA8', '#FF847C', '#E84A5F', '#474747'],
        chartArea: {
            left: '5%',
            width: '90%',
            height: 350
        },
        diff: {
            oldData: {
                inCenter: false,
            }
        }
    };

    // Instantiate and draw our chart, passing in some options.
    var pieDiffRadius = new google.visualization.PieChart(document.getElementById('pie-diff-invert'));

    // Set data
    var diffData = pieDiffRadius.computeDiff(oldData, newData);

    pieDiffRadius.draw(diffData, options_diff_invert);

}


// Resize chart
// ------------------------------

$(function () {

    // Resize chart on menu width change and window resize
    $(window).on('resize', resize);
    $(".menu-toggle").on('click', resize);

    // Resize function
    function resize() {
        drawPieDiffInvert();
    }
});