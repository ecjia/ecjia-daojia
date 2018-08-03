/*=========================================================================================
    File Name: advance-cards.js
    Description: intialize advance cards
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Theme
    Version: 1.2
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
// Stacked column chart
// ------------------------------

$(window).on("load", function(){


    $('#recent-orders').perfectScrollbar({
        wheelPropagation: true
    });


    Morris.Area({
        element: 'smooth-area-chart',
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
        pointStrokeColors:['#BABFC7', '#5ad5b6'],
        smooth: true,
        gridLineColor: '#e3e3e3',
        numLines: 6,
        gridtextSize: 14,
        lineWidth: 0,
        fillOpacity: 0.8,
        hideHover: 'auto',
        lineColors: ['#BABFC7', '#5ad5b6']
    });

    /*******************************************
    *               Mobile Sales               *
    ********************************************/
    Morris.Bar({
        element: 'mobile-sales',
        data: [{device: 'a', sales: 1835 }, {device: 'b', sales: 2356 }, {device: 'c', sales: 1459 }, {device: 'd', sales: 1289 }, {device: 'e', sales: 1647 }, {device: 'f', sales: 2156 }, {device: 'g', sales: 1879 }, {device: 'h', sales: 2011 }],
        xkey: 'device',
        ykeys: ['sales'],
        labels: ['Sales'],
        barGap: 8,
        barSizeRatio: 0.2,
        gridTextColor: '#607D8B',
        gridLineColor: '#ccc',
        goalLineColors: '#000',
        numLines: 4,
        gridtextSize: 14,
        resize: true,
        barColors: ['#3BAFDA'],
        // xLabelAngle: 35,
        hideHover: 'auto',
    });


    /********************************************
    *               Vector Maps                 *
    ********************************************/
    $('#world-map-markers').vectorMap({
        // backgroundColor: '#00494F',
        backgroundColor: '#91EBD4',
        zoomOnScroll: false,
        map: 'world_mill',
        zoomOnScroll: false,
        scaleColors: ['#C8EEFF', '#0071A4'],
        normalizeFunction: 'polynomial',
        hoverOpacity: 0.7,
        hoverColor: false,
        markerStyle: {
            initial: {
                /*fill: '#F44336',
                stroke: '#F44336',*/
                fill: '#FB8C00',
                stroke: '#FF5F3D',
                'stroke-width': 2
                /*'stroke-opacity': 0.3,
                'stroke-width': 8,*/
            },
            hover: {
                fill: '#FF5F3D',
                stroke: '#FF5F3D',
            },
            selected: {
                fill: '#FF5F3D',
                stroke: '#FF5F3D',
            },
            selectedHover: {
                fill: '#FF5F3D',
                stroke: '#FF5F3D',
            }
        },
        regionStyle: {
            initial: {
                // fill: '#B9E6E1',
                fill: '#FFF',
            },
            hover: {
                fill: '#FFCBC0'
            },
            selected: {
                fill: '#FFCBC0'
            },
            selectedHover: {
                fill: '#FFB4A4'
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

    /*********************************************
    *               Total Products               *
    *********************************************/
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
        pointStrokeColors: ['#FF6E40'],
        smooth: false,
        numLines: 6,
        lineWidth: 2,
        lineColors: ['#FF6E40'],
        hideHover: 'auto',
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
        pointStrokeColors: ['#1DE9B6'],
        smooth: false,
        numLines: 6,
        lineWidth: 2,
        lineColors: ['#1DE9B6'],
        hideHover: 'auto',
    });

    /************************************************************
    *               Social Cards Content Slider                 *
    ************************************************************/
    // RTL Support
    var rtl = false;
    if($('html').data('textdirection') == 'rtl'){
        rtl = true;
    }
    if(rtl === true)
        $(".tweet-slider").attr('dir', 'rtl');
    if(rtl === true)
        $(".fb-post-slider").attr('dir', 'rtl');

    // Tweet Slider
    $(".tweet-slider").unslider({
        autoplay: true,
        arrows: false,
        nav: false,
        infinite: true
    });

    // FB Post Slider
    $(".fb-post-slider").unslider({
        autoplay: true,
        delay: 3500,
        arrows: false,
        nav: false,
        infinite: true
    });

});
