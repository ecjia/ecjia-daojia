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
            'echarts/chart/scatter',
        ],


        // Charts setup
        function (ec) {
            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('time-data'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Setup grid
                grid: {
                    x: 40,
                    x2: 40,
                    y: 55,
                    y2: 80
                },

                // Add tooltip
                tooltip : {
                    trigger: 'axis',
                    axisPointer:{
                        show: true,
                        type : 'cross',
                        lineStyle: {
                            type : 'dashed',
                            width : 1
                        }
                    }
                },

                // Data Zoom
                dataZoom: {
                    show: true,
                    start : 30,
                    end : 70
                },

                // Add legend
                legend : {
                    data : ['series1']
                },

                // Data Range
                dataRange: {
                    min: 0,
                    max: 100,
                    orient: 'horizontal',
                    y: 30,
                    x: 'center',
                    color:['lightgreen','orange'],
                    splitNumber: 5
                },

                // Add custom colors
                color: ['#00A5A8','#FF7D4D','#FF4558'],

                // Enable drag recalculate
                calculable: true,

                // Horizontal axis
                xAxis : [
                    {
                        type : 'time',
                        splitNumber:10
                    }
                ],

                // Vertical axis
                yAxis : [
                    {
                        type : 'value'
                    }
                ],

                // Animation
                animation: false,

                // Add series
                series : [
                    {
                        name:'series1',
                        type:'scatter',
                        tooltip : {
                            trigger: 'axis',
                            formatter : function (params) {
                                var date = new Date(params.value[0]);
                                return params.seriesName 
                                       + ' （'
                                       + date.getFullYear() + '-'
                                       + (date.getMonth() + 1) + '-'
                                       + date.getDate() + ' '
                                       + date.getHours() + ':'
                                       + date.getMinutes()
                                       +  '）<br/>'
                                       + params.value[1] + ', ' 
                                       + params.value[2];
                            },
                            axisPointer:{
                                type : 'cross',
                                lineStyle: {
                                    type : 'dashed',
                                    width : 1
                                }
                            }
                        },
                        symbolSize: function (value){
                            return Math.round(value[2]/10);
                        },
                        data: (function () {
                            var d = [];
                            var len = 0;
                            var now = new Date();
                            var value;
                            while (len++ < 1500) {
                                d.push([
                                    new Date(2014, 9, 1, 0, Math.round(Math.random()*10000)),
                                    (Math.random()*30).toFixed(2) - 0,
                                    (Math.random()*100).toFixed(2) - 0
                                ]);
                            }
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