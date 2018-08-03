/*=========================================================================================
    File Name: area.js
    Description: Morris area chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Area chart
// ------------------------------
$(window).on("load", function(){

    Morris.Area({
        element: 'area-chart',
        data: [{
            year: '2010',
            iphone: 0,
            samsung: 0
        }, {
            year: '2011',
            iphone: 150,
            samsung: 90
        }, {
            year: '2012',
            iphone: 140,
            samsung: 120
        }, {
            year: '2013',
            iphone: 105,
            samsung: 240
        }, {
            year: '2014',
            iphone: 190,
            samsung: 140
        }, {
            year: '2015',
            iphone: 230,
            samsung: 250
        },{
            year: '2016',
            iphone: 270,
            samsung: 190
        }],
        xkey: 'year',
        ykeys: ['iphone', 'samsung'],
        labels: ['iPhone', 'Samsung'],
        behaveLikeLine: true,
        ymax: 300,
        resize: true,
        pointSize: 0,
        pointStrokeColors:['#BABFC7', '#5175E0'],
        smooth: false,
        gridLineColor: '#e3e3e3',
        numLines: 6,
        gridtextSize: 14,
        lineWidth: 0,
        fillOpacity: 0.8,
        hideHover: 'auto',
        lineColors: ['#BABFC7', '#5175E0']
    });
});