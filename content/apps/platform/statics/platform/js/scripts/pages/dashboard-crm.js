/*=========================================================================================
    File Name: dashboard-crm.js
    Description: CRM Dashboard page js
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Theme
    Version: 1.2
    Author: GeeksLabs
    Author URL: http://www.themeforest.net/user/geekslabs
==========================================================================================*/
(function(window, document, $) {
    'use strict';

    $('#deals-list-scroll, #customer-list-scroll').perfectScrollbar({
        wheelPropagation: true
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
            var fontSize = parseInt(ele.css('font-size'), 10);
            var updateFontSize = Math.ceil(fontSize * 1.65);
            style = style.replace("bold", "normal");
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

    /*********************************************
    *               Total Earnings               *
    **********************************************/
    //Get the context of the Chart canvas element we want to select
    var ctx3 = document.getElementById("earning-chart").getContext("2d");

    // Chart Options
    var earningOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetStrokeWidth : 3,
        pointDotStrokeWidth : 4,
        tooltipFillColor: "rgba(0,0,0,0.8)",
        legend: {
            display: false,
            position: 'bottom',
        },
        hover: {
            mode: 'label'
        },
        scales: {
            xAxes: [{
                display: false,
            }],
            yAxes: [{
                display: false,
                ticks: {
                    min: 0,
                    max: 7000
                },
            }]
        },
        title: {
            display: false,
            fontColor: "#FFF",
            fullWidth: false,
            fontSize: 40,
            text: '82%'
        }
    };

    // Chart Data
    var earningData = {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [{
            label: "Net Profit($)",
            data: [2800, 3500, 3600, 4800, 4600, 4200, 5000],
            backgroundColor: 'rgba(45,149,191,0.1)',
            borderColor: "transparent",
            borderWidth: 0,
            strokeColor : "#ff6c23",
            capBezierPoints: true,
            pointColor : "#fff",
            pointBorderColor: "rgba(45,149,191,1)",
            pointBackgroundColor: "#FFF",
            pointBorderWidth: 2,
            pointRadius: 4,
        }]
    };

    var earningConfig = {
        type: 'line',

        // Chart Options
        options : earningOptions,

        // Chart Data
        data : earningData
    };

    // Create the chart
    var earningChart = new Chart(ctx3, earningConfig);


    /*********************************************
    *               Deals Funnel                 *
    **********************************************/

    // Set paths
    // ------------------------------

    require.config({
        paths: {
            echarts: '../../../app-assets/vendors/js/charts/echarts'
        }
    });


    // Configuration
    // ------------------------------

    require(
        [
            'echarts',
            'echarts/chart/funnel',
            'echarts/chart/gauge',
            'echarts/chart/pie',
        ],


        // Charts setup
        function (ec) {

            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('monthly-deals-funnel'));

            // Chart Options
            // ------------------------------
            var chartOptions = {

                // Add tooltip
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b}: {c}%"
                },

                // Add legend
                legend: {
                    orient: 'horizontal',
                    x: 'left',
                    y: 0,
                    data: ['Opened', 'Lost', 'Demo', 'Contacted', 'Won', 'No Show']
                },

                // Add Custom Colors
                color: ['#0FB365', '#1EC481', '#28D094', '#48D7A4', '#94E8CA', '#BFF1DF'],

                // Enable drag recalculate
                calculable: true,

                // Add series
                series: [
                    {
                        name: 'Deals',
                        type: 'funnel',
                        funnelAlign: 'left',
                        x: '25%',
                        x2: '25%',
                        y: '17.5%',
                        width: '50%',
                        height: '80%',
                        data: [
                            {value: 100, name: 'Opened'},
                            {value: 70, name: 'Lost'},
                            {value: 60, name: 'Demo'},
                            {value: 40, name: 'Contacted'},
                            {value: 20, name: 'Won'},
                            {value: 10, name: 'No Show'},
                        ]
                    }
                ]
            };

            // Apply options
            // ------------------------------

            myChart.setOption(chartOptions);



            // Resize chart
            // ------------------------------

            $(function () {

                // Resize chart on menu width change and window resize
                $(window).on('resize', resize);
                $(".menu-toggle").on('click', resize);

                // Resize function
                function resize() {
                    setTimeout(function() {

                        // Resize chart
                        myChart.resize();
                    }, 200);
                }
            });

            /********************************************
    *               New Customer Monthly        *
            ********************************************/
            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('new-customer'));

            // Chart Options
            // ------------------------------
            var chartOptions = {

                // Add title
                title: {
                    text: 'New Customer ',
                    subtext: 'Monthly new customer report',
                    x: 'center',
                    textStyle: {
                        color: '#FFF'
                    },
                    subtextStyle: {
                        color: '#FFF'
                    }
                },

                // Add tooltip
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b}: +{c}$ ({d}%)"
                },


                color: ['#ffd775', '#ff847c', '#e84a5f', '#2a363b', '#7fd5c3', '#61a781', '#f0c75e', '#df8c7d', '#e8ed8a', '#55bcbb', '#e974b9', '#2f9395'],


                // Display toolbox
                toolbox: {
                    show: true,
                    orient: 'vertical',
                    feature: {
                        magicType: {
                            show: true,
                            title: {
                                pie: 'Switch to pies',
                                funnel: 'Switch to funnel',
                            },
                            type: ['pie', 'funnel']
                        },
                        restore: {
                            show: true,
                            title: 'Restore'
                        }
                    },
                    color: '#FFF'
                },

                // Enable drag recalculate
                calculable: true,

                // Add series
                series: [
                    {
                        name: 'Increase (brutto)',
                        type: 'pie',
                        radius: ['15%', '73%'],
                        center: ['50%', '57%'],
                        roseType: 'area',

                        itemStyle: {
                            normal: {
                                label: {
                                    textStyle: {
                                        color: '#FFF'
                                    }
                                },
                                labelLine: {
                                    lineStyle: {
                                        color: '#FFF'
                                    }
                                }
                            }
                        },

                        // Funnel
                        width: '40%',
                        height: '78%',
                        x: '30%',
                        y: '17.5%',
                        max: 450,
                        sort: 'ascending',

                        data: [
                            {value: 440, name: 'January'},
                            {value: 260, name: 'February'},
                            {value: 350, name: 'March'},
                            {value: 250, name: 'April'},
                            {value: 210, name: 'May'},
                            {value: 350, name: 'June'},
                            {value: 300, name: 'July'},
                            {value: 430, name: 'August'},
                            {value: 400, name: 'September'},
                            {value: 450, name: 'October'},
                            {value: 330, name: 'November'},
                            {value: 200, name: 'December'}
                        ],
                    }
                ]
            };

            // Apply options
            // ------------------------------

            myChart.setOption(chartOptions);


            // Resize chart
            // ------------------------------

            $(function () {

                // Resize chart on menu width change and window resize
                $(window).on('resize', resize);
                $(".menu-toggle").on('click', resize);

                // Resize function
                function resize() {
                    setTimeout(function() {

                        // Resize chart
                        myChart.resize();
                    }, 200);
                }
            });
        }
    );

    /********************************************
    *               Vector Maps                 *
    ********************************************/
    // Visitos by country visualization
    // -----------------------------------
    $('#world-map-markers').vectorMap({
      map: 'world_mill',
      zoomOnScroll: false,
      backgroundColor: '#607D8B',
      series: {
        regions: [{
          values: visitorData,
          scale: ['#78909C', '#CFD8DC'],
          normalizeFunction: 'polynomial'
        }]
      },
      onRegionTipShow: function(e, el, code){
        el.html(el.html()+' (Visitor - '+visitorData[code]+')');
      }
    });

    /*********************************************
    *               Total Products               *
    *********************************************/
    Morris.Line({
        element: 'bounce-rate',
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

    /*******************************************
    *               Monthly Revenue            *
    *******************************************/
    var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    Morris.Area({
        element: 'monthly-revenue-graph',
        data: [{
            month: '2016-01',
            total: 0,
            pipeline: 0
        }, {
            month: '2016-02',
            total: 4500,
            pipeline: 6000
        }, {
            month: '2016-03',
            total: 1500,
            pipeline: 3000
        }, {
            month: '2016-04',
            total: 4500,
            pipeline: 5500
        }, {
            month: '2016-05',
            total: 6500,
            pipeline: 4000
        }, {
            month: '2016-06',
            total: 4500,
            pipeline: 6000
        },{
            month: '2016-07',
            total: 7000,
            pipeline: 5500
        },{
            month: '2016-08',
            total: 5500,
            pipeline: 6000
        },{
            month: '2016-09',
            total: 9500,
            pipeline: 8000
        },{
            month: '2016-10',
            total: 7500,
            pipeline: 8500
        },{
            month: '2016-11',
            total: 6000,
            pipeline: 6500
        },{
            month: '2016-12',
            total: 9500,
            pipeline: 6500
        }],
        xkey: 'month',
        ykeys: ['pipeline', 'total'],
        labels: ['Pipeline', 'Total'],
        xLabelFormat: function(x) {
            var month = months[x.getMonth()];
            return month;
        },
        dateFormat: function(x) {
            var month = months[new Date(x).getMonth()];
            return month;
        },
        behaveLikeLine: true,
        ymax: 10000,
        resize: true,
        pointSize: 0,
        pointStrokeColors:['#C9BBAE', '#258e74'],
        smooth: true,
        gridLineColor: '#e3e3e3',
        numLines: 6,
        gridtextSize: 14,
        lineWidth: 0,
        fillOpacity: 0.4,
        hideHover: 'auto',
        lineColors: ['#C9BBAE', '#258e74']
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

    /****************************************
    *				Dropzone				*
    ****************************************/
    $("#dpz-single-file").dropzone({
        paramName: "file", // The name that will be used to transfer the file
        maxFiles: 1,
        init: function() {
            this.on("maxfilesexceeded", function(file) {
                this.removeAllFiles();
                this.addFile(file);
            });
        }
    });


})(window, document, jQuery);
