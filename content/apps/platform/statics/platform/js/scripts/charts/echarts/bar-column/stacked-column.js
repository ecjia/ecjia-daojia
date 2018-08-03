/*=========================================================================================
    File Name: stacked-column.js
    Description: echarts stacked column chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Stacked column chart
// ------------------------------

$(window).on("load", function(){

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
            'echarts/chart/bar',
            'echarts/chart/line'
        ],


        // Charts setup
        function (ec) {
            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('stacked-column'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Setup grid
                grid: {
                    x: 40,
                    x2: 40,
                    y: 45,
                    y2: 25
                },

                // Add tooltip
                tooltip : {
                    trigger: 'axis',
                    axisPointer : {            // Axis indicator axis trigger effective
                        type : 'shadow'        // The default is a straight line, optionally: 'line' | 'shadow'
                    }
                },

                // Add legend
                legend: {
                    data: [ 'Direct access', 'Email marketing', 'Advertising alliance', 'Video ads', 'Search engine', 'Google', 'Safari', 'Opera', 'Firefox']
                },

                // Add custom colors
                color: ['#666EE8', '#FF9149', '#FF9966', '#FA8E57', '#FF637b', '#5175E0', '#A147F0', '#28D094', '#BABFC7'],

                // Enable drag recalculate
                calculable: true,

                // Horizontal axis
                xAxis: [{
                    type: 'category',
                    data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                }],

                // Vertical axis
                yAxis: [{
                    type: 'value',
                }],

                // Add series
                series : [
                    {
                        name:'Direct access',
                        type:'bar',
                        data:[320, 332, 301, 334, 390, 330, 320]
                    },
                    {
                        name:'Email marketing',
                        type:'bar',
                        stack: 'advertising',
                        data:[120, 132, 101, 134, 90, 230, 210]
                    },
                    {
                        name:'Advertising alliance',
                        type:'bar',
                        stack: 'advertising',
                        data:[220, 182, 191, 234, 290, 330, 310]
                    },
                    {
                        name:'Video ads',
                        type:'bar',
                        stack: 'advertising',
                        data:[150, 232, 201, 154, 190, 330, 410]
                    },
                    {
                        name:'Search engine',
                        type:'bar',
                        data:[862, 1018, 964, 1026, 1679, 1600, 1570],
                        markLine : {
                            itemStyle:{
                                normal:{
                                    lineStyle:{
                                        type: 'dashed'
                                    }
                                }
                            },
                            data : [
                                [{type : 'min'}, {type : 'max'}]
                            ]
                        }
                    },
                    {
                        name:'Google',
                        type:'bar',
                        barWidth : 12,
                        stack: 'search engine',
                        data:[620, 732, 701, 734, 1090, 1130, 1120]
                    },
                    {
                        name:'Safari',
                        type:'bar',
                        stack: 'search engine',
                        data:[120, 132, 101, 134, 290, 230, 220]
                    },
                    {
                        name:'Opera',
                        type:'bar',
                        stack: 'search engine',
                        data:[60, 72, 71, 74, 190, 130, 110]
                    },
                    {
                        name:'Firefox',
                        type:'bar',
                        stack: 'search engine',
                        data:[62, 82, 91, 84, 109, 110, 120]
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
});