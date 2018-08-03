/*=========================================================================================
    File Name: line-multilevel-control.js
    Description: echarts line multilevel control chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: Pixinvent
    Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Line multilevel control chart
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
            var myChart = ec.init(document.getElementById('line-multi-level-control'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Setup grid
                grid: {
                    x: 40,
                    x2: 20,
                    y: 35,
                    y2: 25
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis'
                },

                // Add legend
                legend: {
                    data: ['Email marketing', 'Advertising alliance', 'Direct access', 'Search engine']
                },

                // Enable drag recalculate
                calculable: true,

                // Horizontal axis
                xAxis: [{
                    type: 'category',
                    boundaryGap: false,
                    data: [
                        'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'
                    ]
                }],

                // Vertical axis
                yAxis: [{
                    type: 'value'
                }],

                // Add series
                series : [
                    {
                        name:'Email marketing',
                        type:'line',
                        stack: 'Total',
                        symbol: 'none',
                        itemStyle: {
                            normal: {
                                areaStyle: {
                                    // Regional map, longitudinal gradient fill
                                    color : '#F6BB42'
                                }
                            }
                        },
                        data:[
                            120, 132, 301, 134,
                            {value:90, symbol:'droplet',symbolSize:5},
                            230, 210
                        ]
                    },
                    {
                        name:'Advertising alliance',
                        type:'line',
                        stack: 'Total',
                        smooth: true,
                        symbolSize: 8,
                        data:[
                            120, 82,
                            {
                                value:201,
                                symbol: 'star',  // Data class personalized inflection Graphics
                                symbolSize : 15,
                                itemStyle : { normal: {label : {
                                    show: true,
                                    textStyle : {
                                        fontSize : '20',
                                        fontFamily : '微软雅黑',
                                        fontWeight : 'bold'
                                    }
                                }}}
                            },
                            {
                                value:134,
                                symbol: 'none'
                            },
                            190,
                            {
                                value : 230,
                                symbol: 'emptypin',
                                symbolSize: 8
                            },
                            110
                        ]
                    },
                    {
                        name:'Direct access',
                        type:'line',
                        stack: 'Total',
                        symbol: 'arrow',
                        symbolSize: 6,
                        symbolRotate: -45,
                        itemStyle: {
                            normal: {
                                color: 'red',
                                lineStyle: {        // A line-level personalized style
                                    width: 2,
                                    type: 'dashed'
                                }
                            },
                            emphasis: {
                                color: 'blue'
                            }
                        },
                        data:[
                            320, 332, '-', 334,
                            {
                                value: 390,
                                symbol: 'star6',
                                symbolSize : 20,
                                symbolRotate : 10,
                                itemStyle: {        // Data class personalized style polyline
                                    normal: {
                                        color: 'yellowgreen'
                                    },
                                    emphasis: {
                                        color: 'orange',
                                        label : {
                                            show: true,
                                            position: 'inside',
                                            textStyle : {
                                                fontSize : '20'
                                            }
                                        }
                                    }
                                }
                            },
                            330, 320
                        ]
                    },
                    {
                        name:'Search engine',
                        type:'line',
                        symbol:'emptyCircle',
                        itemStyle: {
                            normal: {
                                lineStyle: {            // A line-level personalized style, horizontal gradient strokes
                                    width: 2,
                                    color: '#F6BB42',
                                    shadowColor : 'rgba(0,0,0,0.5)',
                                    shadowBlur: 10,
                                    shadowOffsetX: 8,
                                    shadowOffsetY: 8
                                }
                            },
                            emphasis : {
                                label : {show: true}
                            }
                        },
                        data:[
                            620, 732, 791,
                            {value:734, symbol:'emptyHeart',symbolSize:10},
                            890, 930, 820
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