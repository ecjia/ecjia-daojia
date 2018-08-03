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
            strokeColor : "#ff6c23",
            pointColor : "#fff",
            pointBorderColor: "rgba(255,255,255,1)",
            pointBackgroundColor: "#1E9FF2",
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



    /***********************************************************
    *               New User - Page Visist Stats               *
    ***********************************************************/
    //Get the context of the Chart canvas element we want to select
    var ctx2 = document.getElementById("line-stacked-area").getContext("2d");

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
                display: true,
                gridLines: {
                    color: "rgba(255,255,255, 0.3)",
                    drawTicks: true,
                    drawBorder: false,
                    zeroLineColor:'#FFF'
                },
                ticks: {
                    display: true,
                },
            }],
            yAxes: [{
                display: true,
                gridLines: {
                    color: "rgba(0,0,0, 0.07)",
                    drawTicks: false,
                    drawBorder: false,
                    drawOnChartArea: true
                },
                ticks: {
                    display: false,
                    maxTicksLimit: 5
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
        labels: ["2010", "2011", "2012", "2013", "2014", "2015", "2016","2017"],
        datasets: [{
            label: "iOS",
            data: [0, 5, 22, 14, 28, 12, 24, 0],
            backgroundColor: "rgba(255,117,136, 0.7)",
            borderColor: "transparent",
            pointBorderColor: "transparent",
            pointBackgroundColor: "transparent",
            pointRadius: 2,
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
        },{
            label: "Windows",
            data: [0, 8, 30, 15, 12, 21, 14, 0],
            backgroundColor: "rgba(255,168,125,0.9)",
            borderColor: "transparent",
            pointBorderColor: "transparent",
            pointBackgroundColor: "transparent",
            pointRadius: 2,
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
        }, {
            label: "Android",
            data: [0, 20, 10, 45, 20, 36, 21, 0],
            backgroundColor: "rgba(22,211,154,0.7)",
            borderColor: "transparent",
            pointBorderColor: "transparent",
            pointBackgroundColor: "transparent",
            pointRadius: 2,
            pointBorderWidth: 2,
            pointHoverBorderWidth: 2,
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
                    max: 70
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
            label: "My First dataset",
            data: [28, 35, 36, 48, 46, 42, 60],
            backgroundColor: 'rgba(255,117,136,0.1)',
            borderColor: "transparent",
            borderWidth: 0,
            strokeColor : "#ff6c23",
            capBezierPoints: true,
            pointColor : "#fff",
            pointBorderColor: "rgba(255,117,136,1)",
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


    /*************************************************
    *               Posts Visits Ratio               *
    *************************************************/
    //Get the context of the Chart canvas element we want to select
    var ctx4 = $("#posts-visits");

    // Chart Options
    var PostsVisitsOptions = {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
            position: 'top',
            labels: {
                boxWidth: 10,
                fontSize: 14
            },
        },
        hover: {
            mode: 'label'
        },
        scales: {
            xAxes: [{
                display: true,
                gridLines: {
                    lineWidth: 2,
                    color: "rgba(0, 0, 0, 0.05)",
                    zeroLineWidth: 2,
                    zeroLineColor: "rgba(0, 0, 0, 0.05)",
                    drawTicks: false,
                },
                ticks: {
                    fontSize: 14,
                }
            }],
            yAxes: [{
                display: false,
                ticks: {
                    min: 0,
                    max: 100
                }
            }]
        },
        title: {
            display: false,
            text: 'Chart.js Line Chart - Legend'
        }
    };

    // Chart Data
    var postsVisitsData = {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: "Visits",
            data: [32, 25, 45, 30, 60, 40, 72, 52, 80, 60, 92, 70],
            lineTension: 0,
            fill: false,
            // borderDash: [5, 5],
            borderColor: "#28D094",
            pointBorderColor: "#28D094",
            pointBackgroundColor: "#FFF",
            pointBorderWidth: 3,
            pointRadius: 6,
        }, {
            label: "Posts",
            data: [12, 10, 25, 15, 35, 22, 42, 28, 50, 32, 58, 28],
            lineTension: 0,
            fill: false,
            borderColor: "#FF4961",
            pointBorderColor: "#FF4961",
            pointBackgroundColor: "#FFF",
            pointBorderWidth: 3,
            pointRadius: 6,
        }]
    };

    var postsVisitsConfig = {
        type: 'line',

        // Chart Options
        options : PostsVisitsOptions,

        data : postsVisitsData
    };

    // Create the chart
    var postsVisitsChart = new Chart(ctx4, postsVisitsConfig);


    /*******************************************
    *               Global Sales               *
    *******************************************/

    //Get the context of the Chart canvas element we want to select
    var ctx5 = document.getElementById("global-sales").getContext("2d");

    // Create Linear Gradient
    var white_gradient2 = ctx1.createLinearGradient(0, 0, 0,400);
    white_gradient2.addColorStop(0, 'rgba(248, 238, 44, 1)');
    white_gradient2.addColorStop(0.6, 'rgba(255, 162, 0, 1)');
    white_gradient2.addColorStop(1, 'rgba(243, 97, 0, 1)');

    // Chart Options
    var gloablSalesOptions = {
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration:500,
        legend: {
            display: false,
            position: 'top',
        },
        title: {
            display: false,
            text: 'Chart.js Bar Chart'
        },
        scales: {
            xAxes: [{
                display: true,
                id: "barline",
                // barPercentage: 0.9,
                categoryPercentage: 0.6,
                stacked: true,
                gridLines: {
                    display: false,
                    drawTicks: false,
                    drawBorder: false
                },
                ticks: {
                    fontSize: 14,
                    fontColor: '#FFF'
                }
            },{
                display: true,
                type: 'category',
                id: "fmv",
                categoryPercentage: 0.6,
                gridLines: {
                    display: false,
                    offsetGridLines: true,
                    drawBorder: false
                },
                stacked: true,
                ticks: {
                    fontSize: 14,
                    fontColor: 'transparent'
                }
            }],
            yAxes: [{
                display: true,
                gridLines: {
                    lineWidth: 1,
                    color: "rgba(255,255,255, 0.2)",
                    zeroLineWidth: 0,
                    zeroLineColor: "transparent",
                    drawTicks: false,
                    drawBorder: false
                },
                ticks: {
                    fontColor: '#FFF',
                    min: 0,
                    max: 3000
                }
            }]
        },
    };

    // Chart Data
    var globalSalesData = {
        labels: ["2011", "2012", "2013", "2014", "2015", "2016"],
        datasets: [{
            type: 'bar',
            xAxisID: 'fmv',
            label: "My First dataset",
            data: [1459, 1265, 2047, 1878, 2312, 2289],
            backgroundColor: white_gradient2,
            // backgroundColor: "rgba(255,255,255,.6)",
            hoverBackgroundColor: white_gradient2,
            // borderColor: "rgba(102,144,100,.6)"
        },{
            type: 'bar',
            xAxisID: 'barline',
            label: "My Second dataset",
            data: [3000, 3000, 3000, 3000, 3000, 3000],
            backgroundColor: "rgba(0,0,0,0.10)",
            hoverBackgroundColor: "rgba(0,0,0,0.10)",
            // borderColor: "rgba(102,144,100,.6)"
        }]
    };

    var globalSalesConfig = {
        type: 'bar',

        // Chart Options
        options : gloablSalesOptions,

        data : globalSalesData
    };

    // Create the chart
    var globalSalesChart = new Chart(ctx5, globalSalesConfig);


    /****************************************************
    *               Yearly Revenue Comparision          *
    ****************************************************/
    //Get the context of the Chart canvas element we want to select
    var ctx6 = $("#revenue-comparision");

    // Chart Options
    var revenueComparisionOptions = {
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration:500,
        hoverMode: 'label',
        stacked: false,
        legend: {
            display: false,
            position: 'top',
        },
        title:{
            display:false,
            text:"Chart.js Bar Chart - Multi Axis"
        },
        scales: {
            xAxes: [{
                type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                display: true,
                position: "top",
                id: "x-axis-1",
                gridLines: {
                    color: 'rgba(255, 255, 255, 0.3)',
                    zeroLineColor: '#FFF'
                },
                ticks:{
                    fontColor: '#FFF',
                }
            }, {
                type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                display: true,
                position: "bottom",
                id: "x-axis-2",
                gridLines: {
                    color: 'rgba(255, 255, 255, 0.3)',
                    drawOnChartArea: false,
                    zeroLineColor: '#FFF'
                },
                ticks:{
                    fontColor: '#FFF',
                }
            }],
            yAxes:[{
                display: true,
                gridLines: {
                    color: 'rgba(255, 255, 255, 0.3)',
                    drawTicks: false,
                },
                ticks:{
                    fontColor: '#FFF',
                }
            }]
        }
    };

    // Chart Data
    var revenueComparisionData = {
        labels: ["January", "February", "March", "April", "May"],
        datasets: [{
            label: "My First dataset",
            data: [45, -19, 34, 48, -56],
            backgroundColor: "#B9F2E1",
            // hoverBackgroundColor: "rgba(153,184,152,.8)",
            xAxisID: "x-axis-1",
        }, {
            label: "My Second dataset",
            data: [-28, 40, -28, -56, 48],
            backgroundColor: "#FF6275",
            // hoverBackgroundColor: "rgba(254,206,168,.8)",
            xAxisID: "x-axis-2",
        }]
    };

    var revenueComparisionConfig = {
        type: 'horizontalBar',

        // Chart Options
        options : revenueComparisionOptions,

        data : revenueComparisionData
    };

    // Create the chart
    var revenueComparisionChart = new Chart(ctx6, revenueComparisionConfig);



    /************************************************
    *               Sales Growth Rate               *
    ************************************************/
    Morris.Area({
        element: 'sales-growth-chart',
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
        lineColors: ['#FF9149'],
        hideHover: 'auto',
    });


    /*******************************************
    *               Mobile Sales               *
    ********************************************/
    Morris.Bar({
        element: 'mobile-sales',
        data: [{device: 'iPhone 7', sales: 1835 }, {device: 'Note 7', sales: 2356 }, {device: 'Mi5', sales: 1459 }, {device: 'Moto Z', sales: 1289 }, {device: 'Lenovo X3', sales: 1647 }, {device: 'OnePlus 3', sales: 2156 }],
        xkey: 'device',
        ykeys: ['sales'],
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
        barColors: ['#1f9ff3'],
        hideHover: 'auto',
    });



    /*****************************************************
    *               Advertisement Expenses               *
    *****************************************************/
    //Get the context of the Chart canvas element we want to select
    var ctx7 = $("#advertisement-expense");

    // Chart Options
    var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration:500,
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
                scaleLabel: {
                    display: true,
                    labelString: 'Month'
                }
            }],
            yAxes: [{
                display: true,
            }]
        },
        title: {
            display: false,
            text: 'Radar Chart'
        }
    };

    // Chart Data
    var chartData = {
        labels: ["Radio", "TV", "Movie", "Show", "Banner", "Internet", "Newspaper"],
        datasets: [{
            label: "Samsung Galaxy S7",
            borderColor: "rgba(22,211,154,1)",
            backgroundColor: "rgba(22,211,154,.7)",
            pointBackgroundColor: "rgba(22,211,154,1)",
            data: [NaN, 59, 80, 81, 56, 55, 40],
        }, {
            label: "iPhone 7",
            data: [45, 25, NaN, 36, 67, 18, 76],
            borderColor: "rgba(255,117,136,1)",
            backgroundColor: "rgba(255,117,136,.7)",
            pointBackgroundColor: "rgba(255,117,136,1)",
            hoverPointBackgroundColor: "#fff",
            pointHighlightStroke: "rgba(255,117,136,1)",
        }, {
            label: "One Plus 3",
            data: [28, 48, 40, 19, 86, 27, NaN],
            borderColor: "rgba(255,168,125,1)",
            backgroundColor: "rgba(255,168,125,.7)",
            pointBackgroundColor: "rgba(255,168,125,1)",
            hoverPointBackgroundColor: "#fff",
            pointHighlightStroke: "rgba(255,168,125,1)",
        },]
    };

    var config = {
        type: 'radar',

        // Chart Options
        options: chartOptions,

        data: chartData
    };

    // Create the chart
    var lineChart = new Chart(ctx7, config);


    /*************************************************
    *               Cost Revenue Stats               *
    *************************************************/
    new Chartist.Line('#cost-revenue', {
        labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
        series: [
            [
                {meta:'Revenue', value: 5},
                {meta:'Revenue', value: 3},
                {meta:'Revenue', value: 6},
                {meta:'Revenue', value: 3},
                {meta:'Revenue', value: 8},
                {meta:'Revenue', value: 5},
                {meta:'Revenue', value: 8},
                {meta:'Revenue', value: 12},
                {meta:'Revenue', value: 7},
                {meta:'Revenue', value: 14},
             
            ]
        ]
    }, {
        low: 0,
        high: 18,
        fullWidth: true,
        showArea: true,
        showPoint: true,
        showLabel: false,
        axisX: {
            showGrid: false,
            showLabel: false,
            offset: 0
        },
        axisY: {
            showGrid: false,
            showLabel: false,
            offset: 0
        },
        chartPadding: 0,
        plugins: [
            Chartist.plugins.tooltip()
        ]
    }).on('draw', function(data) {
        if (data.type === 'area') {
            data.element.attr({
                'style': 'fill: #28D094; fill-opacity: 0.2'
            });
        }
        if (data.type === 'line') {
            data.element.attr({
                'style': 'fill: transparent; stroke: #28D094; stroke-width: 4px;'
            });
        }
        if (data.type === 'point') {
            var circle = new Chartist.Svg('circle', {
              cx: [data.x], cy:[data.y], r:[7],
            }, 'ct-area-circle');
             data.element.replace(circle);
        }
    });


})(window, document, jQuery);