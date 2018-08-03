/*=========================================================================================
    File Name: advance-cards.js
    Description: intialize advance cards
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: Pixinvent
    Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/
(function(window, document, $) {
    'use strict';

    /********************************************
    *               Vector Maps                 *
    ********************************************/
    $('#world-map-markers').vectorMap({
        // backgroundColor: '#00494F',
        backgroundColor: '#1DE9B6',
        zoomOnScroll: false,
        map: 'world_mill',
        scaleColors: ['#C8EEFF', '#0071A4'],
        normalizeFunction: 'polynomial',
        hoverOpacity: 0.7,
        hoverColor: false,
        markerStyle: {
            initial: {
                /*fill: '#F44336',
                stroke: '#F44336',*/
                fill: '#FF9E80',
                stroke: '#FF6E40',
                'stroke-width': 2
                /*'stroke-opacity': 0.3,
                'stroke-width': 8,*/
            },
            hover: {
                fill: '#FF6E40',
                stroke: '#FF6E40',
            },
            selected: {
                fill: '#FF3D00',
                stroke: '#FF6E40',
            },
            selectedHover: {
                fill: '#DD2C00',
                stroke: '#FF6E40',
            }
        },
        regionStyle: {
            initial: {
                // fill: '#B9E6E1',
                fill: '#A7FFEB',
            },
            hover: {
                fill: '#64FFDA'
            },
            selected: {
                fill: '#1DE9B6'
            },
            selectedHover: {
                fill: '#00BFA5'
            }
        },
        // backgroundColor: '#37474F',
        markers: [
            {latLng: [51.52, -0.14], name: 'London'},
            {latLng: [48.87, 2.34], name: 'Paris'},
            {latLng: [47.36, 8.53], name: 'Switzerland'},
            {latLng: [40.54, -3.77], name: 'Spain'},
            {latLng: [39.59, -105.19], name: 'USA'},
            {latLng: [19.67, -99.12], name: 'Mexico'},
            {latLng: [-8.37, -56.06], name: 'Brazil'},
            {latLng: [-31.17, -64.14], name: 'Argentina'},
            {latLng: [-26.20, 28.02], name: 'Johanesburg'},
            {latLng: [19.05, 72.87], name: 'Mumbai'},
            {latLng: [40.03, 116.46], name: 'Beijing'},
            {latLng: [31.27, 121.47], name: 'Shanghai'},
            {latLng: [35.739, 139.75], name: 'Japan'},
            {latLng: [-34.83, 138.60], name: 'Adelaide'},
            {latLng: [-37.77, 144.97], name: 'Melbourne'},
            {latLng: [1.3, 103.8], name: 'Singapore'},
            {latLng: [26.02, 50.55], name: 'Bahrain'},
        ]
    });

    /*******************************************
    *               Total Orders               *
    *******************************************/
    Morris.Line({
        element: 'map-total-orders',
        data: [{y: '1', a: 14, }, {y: '2', a: 12 }, {y: '3', a: 4 }, {y: '4', a: 13 }, {y: '5', a: 9 }, {y: '6', a: 14 }, {y: '7', a: 12 }, {y: '8', a: 20 }],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Likes'],
        axes: false,
        grid: false,
        behaveLikeLine: true,
        ymax: 20,
        resize: true,
        pointSize: 4,
        pointFillColors: ['#FFF'],
        pointStrokeColors: ['#FF9149'],
        smooth: false,
        numLines: 6,
        lineWidth: 2,
        lineColors: ['#FF9149'],
        hideHover: true,
        hoverCallback: function (index, options, content, row) {
            return "";
        }
    });

    /*******************************************
    *               Total Profit               *
    *******************************************/
    Morris.Line({
        element: 'map-total-profit',
        data: [{y: '1', a: 14, }, {y: '2', a: 12 }, {y: '3', a: 4 }, {y: '4', a: 13 }, {y: '5', a: 7 }, {y: '6', a: 14 }, {y: '7', a: 8 }, {y: '8', a: 20 }],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Likes'],
        axes: false,
        grid: false,
        behaveLikeLine: true,
        ymax: 20,
        resize: true,
        pointSize: 4,
        pointFillColors: ['#FFF'],
        pointStrokeColors: ['#28D094'],
        smooth: false,
        numLines: 6,
        lineWidth: 2,
        lineColors: ['#28D094'],
        hideHover: true,
        hoverCallback: function (index, options, content, row) {
            return "";
        }
    });

})(window, document, jQuery);