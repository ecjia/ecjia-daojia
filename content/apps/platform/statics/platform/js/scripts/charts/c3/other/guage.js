/*=========================================================================================
    File Name: guage.js
    Description: c3 guage chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Guage chart
// ------------------------------
$(window).on("load", function(){

    // Callback that creates and populates a data table, instantiates the guage chart, passes in the data and draws it.
    var guageChart = c3.generate({
        bindto: '#gauge-chart',
        // Create the data table.
        data: {
            columns: [
                ['data', 91.4]
            ],
            type: 'gauge',
            onclick: function (d, i) { console.log("onclick", d, i); },
            onmouseover: function (d, i) { console.log("onmouseover", d, i); },
            onmouseout: function (d, i) { console.log("onmouseout", d, i); }
        },
        gauge: {
    //        label: {
    //            format: function(value, ratio) {
    //                return value;
    //            },
    //            show: false // to turn off the min/max labels.
    //        },
    //    min: 0, // 0 is default, //can handle negative min e.g. vacuum / voltage / current flow / rate of change
    //    max: 100, // 100 is default
    //    units: ' %',
    //    width: 39 // for adjusting arc thickness
        },
        color: {
            pattern: ['#2196F3', '#3F51B5', '#673AB7', '#9C27B0'], // the three color levels for the percentage values.
            threshold: {
    //            unit: 'value', // percentage is default
    //            max: 200, // 100 is default
                values: [30, 60, 90, 100]
            }
        },
        size: {
            height: 250
        }
    });

    setTimeout(function () {
        guageChart.load({
            columns: [['data', 10]]
        });
    }, 1000);

    setTimeout(function () {
        guageChart.load({
            columns: [['data', 50]]
        });
    }, 2000);

    setTimeout(function () {
        guageChart.load({
            columns: [['data', 70]]
        });
    }, 3000);

    setTimeout(function () {
        guageChart.load({
            columns: [['data', 0]]
        });
    }, 4000);

    setTimeout(function () {
        guageChart.load({
            columns: [['data', 100]]
        });
    }, 5000);

    // Resize chart on sidebar width change
    $(".menu-toggle").on('click', function() {
        guageChart.resize();
    });
});