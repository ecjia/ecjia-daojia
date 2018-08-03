/*=========================================================================================
    File Name: scatter-multilevel-control.js
    Description: echarts scatter multilevel control chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: Pixinvent
    Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Scatter multilevel control chart
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
            var myChart = ec.init(document.getElementById('scatter-multilevel-control'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Setup grid
                grid: {
                    x: 40,
                    x2: 40,
                    y: 55,
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

                // Add legend
                legend: {
                    data:['scatter1','scatter2']
                },

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
                        type : 'value'
                    }
                ],

                // Add series
                series : [
                    {
                        name:'scatter1',
                        type:'scatter',
                        symbol: 'emptyCircle', //'circle', 'rectangle', 'triangle', 'diamond', 'emptyCircle', 'emptyRectangle', 'emptyTriangle', 'emptyDiamond'
                        symbolSize: function (value){
                            if (value[0] < 2) {
                                return 2;
                            }
                            else if (value[0] < 8) {
                                return Math.round(value[2] * 3);
                            }
                            else {
                                return 20;
                            }
                        },
                        itemStyle: {
                            normal: {
                                color: '#4DB6AC',
                                borderWidth: 4,
                                label : {show: true}
                            },
                            emphasis: {
                                color: 'lightgreen',
                            }
                        },
                        data: (function () {
                            var d = [];
                            var len = 20;
                            while (len--) {
                                d.push([
                                    (Math.random()*10).toFixed(2) - 0,
                                    (Math.random()*10).toFixed(2) - 0,
                                    (Math.random()*10).toFixed(2) - 0
                                ]);
                            }
                            return d;
                        })(),
                        markPoint : {
                            data : [
                                {type : 'max', name: 'yMax'},
                                {type : 'min', name: 'yMin'},
                                {type : 'max', name: 'xMax', valueIndex : 0, symbol:'arrow',itemStyle:{normal:{borderColor:'red'}}},
                                {type : 'min', name: 'xMin', valueIndex : 0, symbol:'arrow',itemStyle:{normal:{borderColor:'red'}}}
                            ]
                        },
                        markLine : {
                            data : [
                                {type : 'average', name: 'yAverage'},
                                {type : 'average', name: 'xAverage', valueIndex : 0, itemStyle:{normal:{borderColor:'red'}}}
                            ]
                        }
                    },
                    {
                        name:'scatter2',
                        type:'scatter',
                        symbolSize: function (value){
                            return Math.round(value[2] * 3);
                        },
                        itemStyle: {
                            emphasis : {
                                label : {show: true}
                            }
                        },
                        data: (function () {
                            var d = [];
                            var len = 20;
                            while (len--) {
                                d.push([
                                    (Math.random()*10).toFixed(2) - 0,
                                    (Math.random()*10).toFixed(2) - 0,
                                    (Math.random()*10).toFixed(2) - 0
                                ]);
                            }
                            d.push({
                                value : [5,5,1000],
                                itemStyle: {
                                    normal: {
                                        borderWidth: 8,
                                        color: '#FF847C'
                                    },
                                    emphasis: {
                                        borderWidth: 10,
                                        color: '#ff4500'
                                    }
                                },
                                symbol: 'emptyTriangle',
                                symbolRotate:90,
                                symbolSize:30
                            })
                            return d;
                        })(),
                        markPoint : {
                            symbol: 'emptyCircle',
                            itemStyle:{
                                normal:{label:{position:'top'}}
                            },
                            data : [
                                {name : 'Sales', value : 1000, xAxis: 5, yAxis: 5, symbolSize:80}
                            ]
                        }
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