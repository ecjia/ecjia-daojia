/*=========================================================================================
    File Name: scatter-line.js
    Description: echarts scatter line chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Scatter line chart
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
            'echarts/chart/line',
            'echarts/chart/scatter',
            'echarts/chart/pie'
        ],


        // Charts setup
        function (ec) {

            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('scatter-line'));

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
                tooltip: {
                    trigger: 'axis'
                },

                // Add custom colors
                // color: ['#EF5350', '#66BB6A'],

                // Enable drag recalculate
                calculable: true,

                // Data Range
                dataRange: {
                    min: 0,
                    max: 100,
                    orient: 'horizontal',
                    y: 'top',
                    color: ['#00A5A8','#FF7D4D'],
                    splitNumber: 5
                },
                // Horizontal axis
                xAxis : [
                    {
                        type : 'category',
                        boundaryGap : false,
                        data : function (){
                            var list = [];
                            for (var i = 1; i <= 30; i++) {
                                list.push('2013-03-' + i);
                            }
                            return list;
                        }()
                    },
                    {
                        type : 'value',
                        scale : true,
                        splitNumber: 29,
                        axisLabel: {show:false},
                        splitLine: {show:false}
                    }
                ],

                // Vertical axis
                 yAxis : [
                    {
                        type : 'value'
                    },
                    {
                        type : 'value'
                    }
                ],

                // Animation
                animation: false,

                // Add series
                series : [
                    {
                        name:'Scatter',
                        type:'scatter',
                        tooltip : {
                            trigger: 'item',
                            formatter : function (params) {
                                return '2013-03-' + params.value[0] + '<br/>'
                                       + params.seriesName + ' : ' 
                                       + params.value[1] + ', ' 
                                       + params.value[2]; 
                            }
                        },
                        yAxisIndex:1,
                        xAxisIndex:1,
                        symbol: 'circle',
                        symbolSize: function (value){
                            return Math.round(value[2]/10);
                        },
                        data: (function () {
                            var d = [];
                            var len = 200;
                            var value;
                            while (len--) {
                                d.push([
                                    Math.round(Math.random()*29) + 1,
                                    (Math.random()*30).toFixed(2) - 0,
                                    (Math.random()*100).toFixed(2) - 0
                                ]);
                            }
                            return d;
                        })()
                    },
                    {
                        name:'Line',
                        type:'line',
                        data:function (){
                            var list = [];
                            for (var i = 1; i <= 30; i++) {
                                list.push(Math.round(Math.random()* 30));
                            }
                            return list;
                        }()
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