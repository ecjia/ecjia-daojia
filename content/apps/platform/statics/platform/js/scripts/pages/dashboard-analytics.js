/*=========================================================================================
    File Name: dashboard-analytics.js
    Description: Analytics Dashboard
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Theme
    Version: 1.2
    Author: GeeksLabs
    Author URL: http://www.themeforest.net/user/geekslabs
==========================================================================================*/
(function(window, document, $) {
    'use strict';

    $('#audience-list-scroll').perfectScrollbar({
        wheelPropagation: true
    });

    $("#sp-bar-total-cost").sparkline([5,6,7,8,9,10,12,13,15,14,13,12,10,9,8,10,12,14,15,16,17,14,12,11,10,8], {
        type: 'bar',
        width: '100%',
        height: '30px',
        barWidth: 2,
        barSpacing: 4,
        barColor: '#FF5722'
    });

    $("#sp-tristate-bar-total-revenue").sparkline([1,1,0,1,-1,-1,1,-1,0,0,1,1,0,-1,1,-1], {
        type: 'tristate',
        height: '30',
        posBarColor: '#00BCD4',
        negBarColor: '#E91E63',
        barWidth: 4,
        barSpacing: 5,
        zeroAxis: false
    });

    /***********************************************************
    *               New User - Page Visist Stats               *
    ***********************************************************/
    //Get the context of the Chart canvas element we want to select
    // var ctx2 = document.getElementById("visitors-graph").getContext("2d");
    // var ctx2 = document.getElementById("visitors-graph").getContext("2d");

    //Get the context of the Chart canvas element we want to select
    var ctx = $("#visitors-graph");

    // Chart Options
    var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
            display: false
        },
        hover: {
            mode: 'label'
        },
        scales: {
            xAxes: [{
                display: true,
                gridLines: {
                    color: "#f3f3f3",
                    drawTicks: false,
                }
            }],
            yAxes: [{
                display: true,
                gridLines: {
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                ticks: {
                    display: true,
                    maxTicksLimit: 5
                }
            }]
        },
        title: {
            display: false,
        }
    };

    // Chart Data
    var chartData = {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [{
            label: "My First dataset",
            data: [0, 5, 22, 14, 28, 12, 24, 0],
            fill: false,
            borderColor: "#FF4961",
            pointBorderColor: "#FF4961",
            pointBackgroundColor: "#FFF",
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
            pointRadius: 4,
        }, {
            label: "My Second dataset",
            data: [0, 8, 30, 15, 12, 21, 14, 0],
            fill: false,
            borderColor: "#00A5A8",
            pointBorderColor: "#00A5A8",
            pointBackgroundColor: "#FFF",
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
            pointRadius: 4,
        }, {
            label: "My Third dataset - No bezier",
            data: [0, 20, 10, 45, 20, 36, 21, 0],
            fill: false,
            borderColor: "#FF7D4D",
            pointBorderColor: "#FF7D4D",
            pointBackgroundColor: "#FFF",
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
            pointRadius: 4,
        }]
    };

    var config = {
        type: 'line',

        // Chart Options
        options : chartOptions,

        data : chartData
    };

    // Create the chart
    var lineChart = new Chart(ctx, config);


    /********************************************
    *               Vector Maps                 *
    ********************************************/
    // Sessions data
    // -----------------------------------
    $('#world-map-markers').vectorMap({
      map: 'world_mill',
      backgroundColor: '#fff',
      zoomOnScroll: false,
      series: {
        regions: [{
          values: visitorData,
          scale: ['#97E1CE', '#37BC9B'],
          normalizeFunction: 'polynomial'
        }]
      },
      onRegionTipShow: function(e, el, code){
        el.html(el.html()+' (Visitor - '+visitorData[code]+')');
      }
    });

    /********************************************
    *           Sessions by Browser             *
    ********************************************/
    Morris.Donut({
        element: 'sessions-browser-donut-chart',
        data: [{
            label: "Chrome",
            value: 3500
        }, {
            label: "Firefox",
            value: 2500
        }, {
            label: "Safari",
            value: 2000
        }, {
            label: "Opera",
            value: 1000
        },{
            label: "Internet Explorer",
            value: 500
        } ],
        resize: true,
        colors: ['#F6BB42', '#37BC9B', '#3BAFDA', '#DA4453', '#967ADC']
    });

    /***********************************************************
    *               New User - Page Visist Stats               *
    ***********************************************************/
    //Get the context of the Chart canvas element we want to select
    var ctxLineStackedArea = document.getElementById("line-stacked-area").getContext("2d");

    // Chart Options
    var lineStackedAreaOptions = {
        responsive: true,
        maintainAspectRatio: false,
        pointDotStrokeWidth : 4,
        legend: {
            display: false,
            labels: {
                fontColor: '#FFF',
                boxWidth: 10,
            },
            position: 'top',
        },
        hover: {
            mode: 'label'
        },
        scales: {
            xAxes: [{
                display: false,
            }],
            yAxes: [{
                display: true,
                gridLines: {
                    color: "rgba(255,255,255, 0.3)",
                    drawTicks: false,
                    drawBorder: false
                },
                ticks: {
                    display: false,
                    min: 0,
                    max: 70,
                    maxTicksLimit: 4
                },
            }]
        },
        title: {
            display: false,
            text: 'Chart.js Line Chart - Legend'
        },
    };

    // Chart Data
    var lineStackedAreaData = {
        labels: ["2010", "2011", "2012", "2013", "2014", "2015"],
        datasets: [{
            label: "iOS",
            data: [0, 10, 5, 26, 12, 20],
            backgroundColor: "#eeda54",
            borderColor: "#eeda54",
            pointBorderColor: "#eeda54",
            pointBackgroundColor: "#eeda54",
            pointRadius: 2,
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
        },{
            label: "Windows",
            data: [0, 20, 20, 30, 26, 32],
            backgroundColor: "rgba(166,100,255,0.8)",
            borderColor: "transparent",
            pointBorderColor: "transparent",
            pointBackgroundColor: "transparent",
            pointRadius: 2,
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
        }, {
            label: "Android",
            data: [0, 30, 15, 40, 38, 45],
            backgroundColor: "#40cae4",
            borderColor: "#40cae4",
            pointBorderColor: "#40cae4",
            pointBackgroundColor: "#40cae4",
            pointRadius: 2,
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
        }]
    };

    var lineStackedAreaConfig = {
        type: 'line',

        // Chart Options
        options : lineStackedAreaOptions,

        // Chart Data
        data : lineStackedAreaData
    };

    // Create the chart
    var lineStackedArea = new Chart(ctxLineStackedArea, lineStackedAreaConfig);

    /************************************************
    *                  Bounce Rate                   *
    ************************************************/
    Morris.Area({
        element: 'bounce-rate',
        data: [{y: '2010', a: 28, }, {y: '2011', a: 40 }, {y: '2012', a: 36 }, {y: '2013', a: 48 }, {y: '2014', a: 32 }, {y: '2015', a: 42 }, {y: '2016', a: 30 }],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Sales'],
        behaveLikeLine: true,
        ymax: 60,
        resize: true,
        pointSize: 0,
        smooth: true,
        gridTextColor: '#bfbfbf',
        gridLineColor: '#c3c3c3',
        numLines: 6,
        gridtextSize: 14,
        lineWidth: 2,
        fillOpacity: 0.6,
        lineColors: ['#F6BB42'],
        hideHover: 'auto',
    });

    // Area chart
    // ------------------------------

    Morris.Area({
        element: 'area-chart',
        data: [{
            year: '2016-12-01',
            AvgSessionDuration: 0,
            PagesSession: 0
        }, {
            year: '2016-12-02',
            AvgSessionDuration: 150,
            PagesSession: 90
        }, {
            year: '2016-12-03',
            AvgSessionDuration: 140,
            PagesSession: 120
        }, {
            year: '2016-12-04',
            AvgSessionDuration: 105,
            PagesSession: 240
        }, {
            year: '2016-12-05',
            AvgSessionDuration: 190,
            PagesSession: 140
        }, {
            year: '2016-12-06',
            AvgSessionDuration: 230,
            PagesSession: 250
        },{
            year: '2016-12-07',
            AvgSessionDuration: 270,
            PagesSession: 190
        }],
        xkey: 'year',
        ykeys: ['AvgSessionDuration', 'PagesSession'],
        labels: ['Avg. Session Duration', 'Pages/Session'],
        behaveLikeLine: true,
        ymax: 300,
        resize: true,
        pointSize: 0,
        pointStrokeColors:['#C9BBAE', '#F44336'],
        smooth: false,
        gridLineColor: '#e3e3e3',
        numLines: 6,
        gridtextSize: 14,
        lineWidth: 0,
        fillOpacity: 0.6,
        hideHover: 'auto',
        lineColors: ['#C9BBAE', '#F44336']
    });

    // Total Sales
    $("#sp-line-total-sales").sparkline([14,12,4,9,3,6,11,10,13,9,14,11,16,20,15], {
        type: 'line',
        width: '100%',
        height: '100px',
        lineColor: '#00BCD4',
        fillColor: '#00BCD4',
        spotColor: '',
        minSpotColor: '',
        maxSpotColor: '',
        highlightSpotColor: '',
        highlightLineColor: '',
        chartRangeMin: 0,
        chartRangeMax: 20,
    });

    $("#sp-bar-total-sales").sparkline([5,6,7,8,9,10,12,13,15,14,13,12,10,9,8,10,12,14,15,16,17,14,12,11,10,8], {
        type: 'bar',
        width: '100%',
        height: '30px',
        barWidth: 2,
        barSpacing: 4,
        barColor: '#00BCD4'
    });

    $("#sp-stacked-bar-total-sales").sparkline([ [8,10], [12,8], [9,14], [8,11], [10,13], [7,11], [8,14], [9,12], [10,11], [12,14], [8,12], [9,12], [9,14] ], {
        type: 'bar',
        width: '100%',
        height: '30px',
        barWidth: 4,
        barSpacing: 6,
        stackedBarColor: ['#FF5722', '#009688']
    });

    $("#sp-tristate-bar-total-sales").sparkline([1,1,0,1,-1,-1,1,-1,0,0,1,1,0,-1,1,-1], {
        type: 'tristate',
        height: '30',
        posBarColor: '#009688',
        negBarColor: '#FF5722',
        barWidth: 4,
        barSpacing: 5,
        zeroAxis: false
    });

    /********************************************
    *               Monthly Sales               *
    ********************************************/
    Morris.Bar({
        element: 'monthly-sales',
        data: [{month: 'Jan', sales: 1835 }, {month: 'Feb', sales: 2356 }, {month: 'Mar', sales: 1459 }, {month: 'Apr', sales: 1289 }, {month: 'May', sales: 1647 }, {month: 'Jun', sales: 2156 }, {month: 'Jul', sales: 1835 }, {month: 'Aug', sales: 2356 }, {month: 'Sep', sales: 1459 }, {month: 'Oct', sales: 1289 }, {month: 'Nov', sales: 1647 }, {month: 'Dec', sales: 2156 }],
        xkey: 'month',
        ykeys: ['sales'],
        labels: ['Sales'],
        barGap: 4,
        barSizeRatio: 0.3,
        gridTextColor: '#bfbfbf',
        gridLineColor: '#e3e3e3',
        numLines: 5,
        gridtextSize: 14,
        resize: true,
        barColors: ['#967ADC'],
        hideHover: 'auto',
    });

    /*****************************************************
    *               Grouped Card Statistics              *
    *****************************************************/
    var rtl = false;
    if($('html').data('textdirection') == 'rtl')
        rtl = true;

    $(".knob").knob({
        rtl:rtl,
        draw: function() {
            var ele = this.$;
            var style = ele.attr('style');
            style = style.replace("bold", "normal");
            var fontSize = parseInt(ele.css('font-size'), 10);
            var updateFontSize = Math.ceil(fontSize * 1.65);
            style = style + "font-size: " +updateFontSize+"px;";
            var icon = ele.attr('data-knob-icon');
            ele.hide();
            $('<i class="knob-center-icon '+icon+'"></i>').insertAfter(ele).attr('style',style);

            // "tron" case
            if (this.$.data('skin') == 'tron') {

                this.cursorExt = 0.3;

                var a = this.arc(this.cv), // Arc
                    pa, // Previous arc
                    r = 1;

                this.g.lineWidth = this.lineWidth;

                if (this.o.displayPrevious) {
                    pa = this.arc(this.v);
                    this.g.beginPath();
                    this.g.strokeStyle = this.pColor;
                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, pa.s, pa.e, pa.d);
                    this.g.stroke();
                }

                this.g.beginPath();
                this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, a.s, a.e, a.d);
                this.g.stroke();

                this.g.lineWidth = 2;
                this.g.beginPath();
                this.g.strokeStyle = this.o.fgColor;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                this.g.stroke();

                return false;
            }
        }
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
        delay:3500,
        arrows: false,
        nav: false,
        infinite: true
    });

})(window, document, jQuery);