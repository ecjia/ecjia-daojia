/*=========================================================================================
    File Name: irregular-bar.js
    Description: echarts irregular bar chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Irregular bar chart
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
            var myChart = ec.init(document.getElementById('irregular-bar'));

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
                    axisPointer:{
                        show: true,
                        type : 'cross',
                        lineStyle: {
                            type : 'dashed',
                            width : 1
                        }
                    },
                    formatter : function (params) {
                        return params.seriesName + ' : [ '+ params.value[0] + ', ' + params.value[1] + ' ]';
                    }
                },

                // Add legend
                legend: {
                    data:['Data 1','Data 2']
                },

                // Add custom colors
                color: ['#666EE8', '#FF4961'],

                // Enable drag recalculate
                calculable : true,

                // Horizontal axis
                xAxis : [
                    {
                        type : 'value'
                    }
                ],

                // Vertical axis
                yAxis : [
                    {
                        type : 'value',
                        axisLine: {
                            lineStyle: {
                                color: '#dc143c'
                            }
                        }
                    }
                ],

                // Add series
                series : [
                    {
                        name:'Data 1',
                        type:'bar',
                        data:[
                            [1.5, 10], [5, 7], [8, 8], [12, 6], [11, 12], [16, 9], [14, 6], [17, 4], [19, 9]
                        ],
                        markPoint : {
                            data : [
                                // The vertical axis, the default
                                {type : 'max', name: 'Max',symbol: 'emptyCircle', itemStyle:{normal:{color:'#dc143c',label:{position:'top'}}}},
                                {type : 'min', name: 'Min',symbol: 'emptyCircle', itemStyle:{normal:{color:'#dc143c',label:{position:'bottom'}}}},
                                // 横轴
                                {type : 'max', name: 'Max', valueIndex: 0, symbol: 'emptyCircle', itemStyle:{normal:{color:'#1e90ff',label:{position:'right'}}}},
                                {type : 'min', name: 'Min', valueIndex: 0, symbol: 'emptyCircle', itemStyle:{normal:{color:'#1e90ff',label:{position:'left'}}}}
                            ]
                        },
                        markLine : {
                            data : [
                                // 纵轴，默认
                                {type : 'max', name: 'Max', itemStyle:{normal:{color:'#dc143c'}}},
                                {type : 'min', name: 'Min', itemStyle:{normal:{color:'#dc143c'}}},
                                {type : 'average', name : 'Average', itemStyle:{normal:{color:'#dc143c'}}},
                                // 横轴
                                {type : 'max', name: 'Max', valueIndex: 0, itemStyle:{normal:{color:'#1e90ff'}}},
                                {type : 'min', name: 'Min', valueIndex: 0, itemStyle:{normal:{color:'#1e90ff'}}},
                                {type : 'average', name : 'Average', valueIndex: 0, itemStyle:{normal:{color:'#1e90ff'}}}
                            ]
                        }
                    },
                    {
                        name:'Data 2',
                        type:'bar',
                        barHeight:10,
                        data:[
                            [1, 2], [2, 3], [4, 4], [7, 5], [11, 11], [18, 15]
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
        }
    );
});