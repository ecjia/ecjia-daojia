/*=========================================================================================
    File Name: tornado.js
    Description: echarts tornado chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Tornado chart
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
            var myChart = ec.init(document.getElementById('tornado'));

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
                    axisPointer : {            // Pointer axis, the axis trigger effective
                        type : 'shadow'        // Default is linear, optionally: 'line' | 'shadow'
                    }
                },

                // Add legend
                legend: {
                    data:['Profit', 'Expenditure', 'Income']
                },

                // Add custom colors
                color: ['#00A5A8', '#FF7D4D','#FF4558'],

                // Enable drag recalculate
                calculable: true,

                // Horizontal axis
                xAxis : [
                    {
                        type : 'value'
                    }
                ],

                // Vertical axis
                yAxis : [
                    {
                        type : 'category',
                        axisTick : {show: false},
                        data: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
                    }
                ],

                // Add series
                series : [
                    {
                        name:'Profit',
                        type:'bar',
                        itemStyle : { normal: {label : {show: true, position: 'inside'}}},
                        data:[200, 170, 240, 244, 200, 220, 210]
                    },
                    {
                        name:'Expenditure',
                        type:'bar',
                        stack: '总量',
                        barWidth : 5,
                        itemStyle: {normal: {
                            label : {show: true}
                        }},
                        data:[320, 302, 341, 374, 390, 450, 420]
                    },
                    {
                        name:'Income',
                        type:'bar',
                        stack: '总量',
                        itemStyle: {normal: {
                            label : {show: true, position: 'left'}
                        }},
                        data:[-120, -132, -101, -134, -190, -230, -210]
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