/*=========================================================================================
    File Name: category-scatter.js
    Description: echarts category scatter chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Category scatter chart
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
            var myChart = ec.init(document.getElementById('category-scatter'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Setup grid
                grid: {
                    x: 40,
                    x2: 40,
                    y: 65,
                    y2: 25
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
                    data : ['series1', 'series2']
                },

                // Data Range
                dataRange: {
                    min: 0,
                    max: 100,
                    orient: 'horizontal',
                    y: 30,
                    x: 'center',
                    //text:['高','低'],           // 文本，默认为数值文本
                    color:['lightgreen','orange'],
                    splitNumber: 5
                },
                // Add custom colors
                color: ['#666EE8', '#FF4961'],

                // Horizontal axis
                xAxis : [
                    {
                        type : 'category',
                        axisLabel: {
                            formatter : function(v) {
                                return 'Category' + v
                            }
                        },
                        data : function (){
                            var list = [];
                            var len = 0;
                            while (len++ < 500) {
                                list.push(len);
                            }
                            return list;
                        }()
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
                            trigger: 'item',
                            formatter : function (params) {
                                return params.seriesName + ' （'  + 'Category' + params.value[0] + '）<br/>'
                                       + params.value[1] + ', ' 
                                       + params.value[2]; 
                            },
                            axisPointer:{
                                show: true
                            }
                        },
                        symbolSize: function (value){
                            return Math.round(value[2]/10);
                        },
                        data: (function () {
                            var d = [];
                            var len = 0;
                            var value;
                            while (len++ < 500) {
                                d.push([
                                    len,
                                    (Math.random()*30).toFixed(2) - 0,
                                    (Math.random()*100).toFixed(2) - 0
                                ]);
                            }
                            return d;
                        })()
                    },
                    {
                        name:'series2',
                        type:'scatter',
                        tooltip : {
                            trigger: 'item',
                            formatter : function (params) {
                                return params.seriesName + ' （'  + 'Category' + params.value[0] + '）<br/>'
                                       + params.value[1] + ', ' 
                                       + params.value[2]; 
                            },
                            axisPointer:{
                                show: true
                            }
                        },
                        symbolSize: function (value){
                            return Math.round(value[2]/10);
                        },
                        data: (function () {
                            var d = [];
                            var len = 0;
                            var value;
                            while (len++ < 500) {
                                d.push([
                                    len,
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