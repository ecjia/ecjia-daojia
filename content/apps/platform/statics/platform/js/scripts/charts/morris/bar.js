/*=========================================================================================
    File Name: bar.js
    Description: Morris bar chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Bar chart
// ------------------------------
$(window).on("load", function(){

    Morris.Bar({
        element: 'bar-chart',
        data: [{
                y: '2016',
                a: 650,
                b: 420
            }, {
                y: '2015',
                a: 540,
                b: 380
            }, {
                y: '2014',
                a: 480,
                b: 360
            }, {
                y: '2013',
                a: 320,
                b: 390
            }
        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Data 1', 'Data 2'],
        barGap: 6,
        barSizeRatio: 0.35,
        smooth: true,
        gridLineColor: '#e3e3e3',
        numLines: 5,
        gridtextSize: 14,
        fillOpacity: 0.4,
        resize: true,
        barColors: ['#00A5A8', '#FF7D4D']
    });
});