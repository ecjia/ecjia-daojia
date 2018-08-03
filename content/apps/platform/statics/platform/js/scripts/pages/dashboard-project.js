/*=========================================================================================
    File Name: dashboard-project.js
    Description: Project dashboard
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Theme
    Version: 1.2
    Author: GeeksLabs
    Author URL: http://www.themeforest.net/user/geekslabs
==========================================================================================*/
(function(window, document, $) {
    'use strict';

    /******************************************
    *               Total Likes               *
    ******************************************/
    Morris.Area({
        element: 'morris-likes',
        data: [{y: '1', a: 14, }, {y: '2', a: 12 }, {y: '3', a: 4 }, {y: '4', a: 9 }, {y: '5', a: 3 }, {y: '6', a: 6 }, {y: '7', a: 11 }, {y: '8', a: 10 }, {y: '9', a: 13 }, {y: '10', a: 9 }, {y: '11', a: 14 },{y: '12', a: 11 }, {y: '13', a: 16 }, {y: '14', a: 20 }, {y: '15', a: 15 }],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Likes'],
        axes: false,
        grid: false,
        behaveLikeLine: true,
        ymax: 20,
        resize: true,
        pointSize: 0,
        smooth: true,
        numLines: 6,
        lineWidth: 2,
        fillOpacity: 0.1,
        lineColors: ['#967ADC'],
        hideHover: true,
        hoverCallback: function (index, options, content, row) {
            return "";
        }
    });

    /*********************************************
    *               Total Comments               *
    *********************************************/
    Morris.Area({
        element: 'morris-comments',
        data: [{y: '1', a: 15, }, {y: '2', a: 20 }, {y: '3', a: 16 }, {y: '4', a: 11 }, {y: '5', a: 14 }, {y: '6', a: 9 }, {y: '7', a: 13 }, {y: '8', a: 10 }, {y: '9', a: 11 }, {y: '10', a: 6 }, {y: '11', a: 3 },{y: '12', a: 9 }, {y: '13', a: 4 }, {y: '14', a: 12 }, {y: '15', a: 14 }],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Comments'],
        axes: false,
        grid: false,
        behaveLikeLine: true,
        ymax: 20,
        resize: true,
        pointSize: 0,
        smooth: true,
        numLines: 6,
        lineWidth: 2,
        fillOpacity: 0.1,
        lineColors: ['#37BC9B'],
        hideHover: true,
        hoverCallback: function (index, options, content, row) {
            return "";
        }
    });

    /******************************************
    *               Total Views               *
    ******************************************/
    Morris.Area({
        element: 'morris-views',
        data: [{y: '1', a: 14, }, {y: '2', a: 12 }, {y: '3', a: 4 }, {y: '4', a: 9 }, {y: '5', a: 3 }, {y: '6', a: 6 }, {y: '7', a: 11 }, {y: '8', a: 10 }, {y: '9', a: 13 }, {y: '10', a: 9 }, {y: '11', a: 14 },{y: '12', a: 11 }, {y: '13', a: 16 }, {y: '14', a: 20 }, {y: '15', a: 15 }],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Views'],
        axes: false,
        grid: false,
        behaveLikeLine: true,
        ymax: 20,
        resize: true,
        pointSize: 0,
        smooth: true,
        numLines: 6,
        lineWidth: 2,
        fillOpacity: 0.1,
        lineColors: ['#DA4453'],
        hideHover: true,
        hoverCallback: function (index, options, content, row) {
            return "";
        }
    });

    /***********************************************************
    *                    Projects Task Status                  *
    ***********************************************************/
    //Get the context of the Chart canvas element we want to select
    var ctx2 = $("#line-stacked-area");

    // Chart Options
    var userPageVisitOptions = {
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
                    max: 100,
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
    var userPageVisitData = {
        labels: ["January", "February", "March", "April", "May", "June", "July", "August"],
        datasets: [
        {
            label: "Android",
            data: [0, 35, 5, 70, 35, 80, 45, 90],
            backgroundColor: 'transparent',
            borderColor: "#1DE9B6",
            borderWidth: 4,
            pointColor : "#fff",
            pointBorderColor: "#1DE9B6",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 4,
            pointHoverBorderWidth: 4,
            pointRadius: 5
        },{
            label: "iOS",
            data: [5, 60, 15, 45, 15, 50, 20, 55],
            backgroundColor: 'transparent',
            borderColor: "#FF6E40",
            borderDash: [5, 5],
            borderWidth: 4,
            pointColor : "#fff",
            pointBorderColor: "#FF6E40",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 4,
            pointHoverBorderWidth: 4,
            pointRadius: 5
        }]
    };

    var userPageVisitConfig = {
        type: 'line',
        // Chart Options
        options : userPageVisitOptions,
        // Chart Data
        data : userPageVisitData
    };

    // Create the chart
    var stackedAreaChart = new Chart(ctx2, userPageVisitConfig);

    /****************************************************
    *               Employee Satisfaction               *
    ****************************************************/
    //Get the context of the Chart canvas element we want to select
    var ctx1 = document.getElementById("emp-satisfaction").getContext("2d");

    // Create Linear Gradient
    var white_gradient = ctx1.createLinearGradient(0, 0, 0,400);
    white_gradient.addColorStop(0, 'rgba(255,255,255,0.5)');
    white_gradient.addColorStop(1, 'rgba(255,255,255,0)');

    // Chart Options
    var empSatOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetStrokeWidth : 3,
        pointDotStrokeWidth : 4,
        tooltipFillColor: "rgba(0,0,0,0.8)",
        legend: {
            display: false,
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
                    max: 85
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
    var empSatData = {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [{
            label: "Employees",
            data: [28, 35, 36, 48, 46, 42, 60],
            backgroundColor: white_gradient,
            borderColor: "rgba(255,255,255,1)",
            borderWidth: 2,
            strokeColor : "#FF6C23",
            pointColor : "#fff",
            pointBorderColor: "rgba(255,255,255,1)",
            pointBackgroundColor: "#3BAFDA",
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
            pointRadius: 5,
        }]
    };

    var empSatconfig = {
        type: 'line',

        // Chart Options
        options : empSatOptions,

        // Chart Data
        data : empSatData
    };

    // Create the chart
    var areaChart = new Chart(ctx1, empSatconfig);


     /*****************************************************
    *               Grouped Card Statistics              *
    *****************************************************/
    var rtl = false;
    if($('html').data('textdirection') == 'rtl')
        rtl = true;

    $(".knob").knob({
        rtl: rtl,
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

    /*******************************************
    *               Mobile Sales               *
    ********************************************/
    Morris.Bar({
        element: 'completed-project',
        data: [{device: 'UI', earning: 1835 }, {device: 'Web', earning: 2356 }, {device: 'APP', earning: 1459 }, {device: 'UX', earning: 1289 }, {device: 'SEO', earning: 1647 }],
        xkey: 'device',
        ykeys: ['earning'],
        labels: ['Sales'],
        barGap: 6,
        barSizeRatio: 0.3,
        gridTextColor: '#FFF',
        gridLineColor: '#FFF',
        goalLineColors: '#000',
        numLines: 4,
        gridtextSize: 14,
        resize: true,
        barColors: ['#FFF'],
        xLabelAngle: 35,
        hideHover: 'auto',
    });


    /********************************************
    *               Project invoices            *
    ********************************************/
    Morris.Area({
        element: 'project-invoices',
        data: [ {
            quarter: '2016 Q1',
            paid: 140,
            unpaid: 120
        }, {
            quarter: '2016 Q2',
            paid: 105,
            unpaid: 240
        }, {
            quarter: '2016 Q3',
            paid: 190,
            unpaid: 140
        }, {
            quarter: '2016 Q4',
            paid: 230,
            unpaid: 250
        }],
        xkey: 'quarter',
        ykeys: ['paid', 'unpaid'],
        labels: ['paid', 'Unpaid'],
        axes: false,
        behaveLikeLine: true,
        ymax: 300,
        resize: true,
        pointSize: 0,
        pointStrokeColors:['#C9BBAE', '#DA4453'],
        smooth: false,
        gridLineColor: '#e3e3e3',
        numLines: 6,
        gridtextSize: 14,
        lineWidth: 0,
        fillOpacity: 0.4,
        hideHover: 'auto',
        lineColors: ['#C9BBAE', '#DA4453']
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
        gridTextColor: '#fff',
        gridLineColor: '#fff',
        numLines: 5,
        gridtextSize: 14,
        resize: true,
        barColors: ['#fff'],
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

})(window, document, jQuery);
