/*=========================================================================================
    File Name: large-scale-scatter.js
    Description: echarts large scale scatter chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Large scale scatterchart
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
            'echarts/chart/scatter'
        ],


        // Charts setup
        function (ec) {
            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('large-scale-scatter'));

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
                    showDelay : 0,
                    axisPointer:{
                        show: true,
                        type : 'cross',
                        lineStyle: {
                            type : 'dashed',
                            width : 1
                        }
                    }
                },

                // Add legend
                legend: {
                    data:['sin','cos']
                },

                // Add custom colors
                color: ['#1DE9B6', '#FF4081'],

                // Horizontal axis
                xAxis : [
                    {
                        type : 'value',
                        scale:true
                    }
                ],

                // Vertical axis
                yAxis : [
                    {
                        type : 'value',
                        scale:true
                    }
                ],

                // Add series
                series : [
                    {
                        name:'sin',
                        type:'scatter',
                        large: true,
                        data: (function () {
                            var d = [];
                            var len = 10000;
                            var x = 0;
                            while (len--) {
                                x = (Math.random() * 10).toFixed(3) - 0;
                                d.push([
                                    x,
                                    //Math.random() * 10
                                    (Math.sin(x) - x * (len % 2 ? 0.1 : -0.1) * Math.random()).toFixed(3) - 0
                                ]);
                            }
                            //console.log(d)
                            return d;
                        })()
                    },
                    {
                        name:'cos',
                        type:'scatter',
                        large: true,
                        data: (function () {
                            var d = [];
                            var len = 10000;
                            var x = 0;
                            while (len--) {
                                x = (Math.random() * 10).toFixed(3) - 0;
                                d.push([
                                    x,
                                    //Math.random() * 10
                                    (Math.cos(x) - x * (len % 2 ? 0.1 : -0.1) * Math.random()).toFixed(3) - 0
                                ]);
                            }
                            //console.log(d)
                            return d;
                        })()
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