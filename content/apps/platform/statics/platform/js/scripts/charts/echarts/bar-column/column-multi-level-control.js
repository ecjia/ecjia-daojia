/*=========================================================================================
    File Name: column-multi-level-control.js
    Description: echarts column multi level control chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Column multi level control chart
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
            var myChart = ec.init(document.getElementById('column-multilevel-control'));

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

                // Add legend
                legend: {
                    data: ['Email marketing', 'Advertising alliance', 'Direct access', 'Search engine']
                },

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
                        name:'E-mail marketing',
                        type:'bar',
                        itemStyle: {        // Personalized style-level, longitudinal gradient fill
                            barBorderColor:'red',
                            barBorderWidth: 5,
                            color : (function (){
                                var zrColor = require('zrender/tool/color');
                                return zrColor.getLinearGradient(
                                    0, 400, 0, 300,
                                    [[0, 'green'],[1, 'yellow']]
                                );
                            })(),
                            emphasis: {
                                barBorderWidth: 5,
                                barBorderColor:'green',
                                color: (function (){
                                    var zrColor = require('zrender/tool/color');
                                    return zrColor.getLinearGradient(
                                        0, 400, 0, 300,
                                        [[0, 'red'],[1, 'orange']]
                                    );
                                })(),
                                label : {
                                    show : true,
                                    position : 'top',
                                    formatter : "{a} {b} {c}",
                                    textStyle : {
                                        color: 'blue'
                                    }
                                }
                            }
                        },
                        data:[220, 232, 101, 234, 190, 330, 210]
                    },
                    {
                        name:'Advertising Alliance',
                        type:'bar',
                        stack: 'Total',
                        data:[120, '-', 451, 134, 190, 230, 110]
                    },
                    {
                        name:'Direct access',
                        type:'bar',
                        stack: 'Total',
                        itemStyle: {                // Series level personalization
                            normal: {
                                barBorderWidth: 6,
                                barBorderColor:'tomato',
                                color: 'red'
                            },
                            emphasis: {
                                barBorderColor:'red',
                                color: 'blue'
                            }
                        },
                        data:[
                            320, 332, 100, 334,
                            {
                                value: 390,
                                symbolSize : 10,   // Level of personalized data
                                itemStyle: {
                                    normal: {
                                        color :'lime'
                                    },
                                    emphasis: {
                                        color: 'skyBlue'
                                    }
                                }
                            },
                            330, 320
                        ]
                    },
                    {
                        name:'Search engine',
                        type:'bar',
                        barWidth: 40,                   // Series level personalized, cylindrical width
                        itemStyle: {
                            normal: {                   // Series level personalization, horizontal gradient fill
                                borderRadius: 5,
                                color : (function (){
                                    var zrColor = require('zrender/tool/color');
                                    return zrColor.getLinearGradient(
                                        0, 0, 1000, 0,
                                        [[0, 'rgba(30,144,255,0.8)'],[1, 'rgba(138,43,226,0.8)']]
                                    )
                                })(),
                                label : {
                                    show : true,
                                    textStyle : {
                                        fontSize : '20',
                                        fontFamily : '微软雅黑',
                                        fontWeight : 'bold'
                                    }
                                }
                            }
                        },
                        data:[
                            620, 732,
                            {
                                value: 701,
                                itemStyle : { normal: {label : {position: 'inside'}}}
                            },
                            734, 890, 930, 820
                        ],
                        markLine : {
                            data : [
                                {type : 'average', name : 'Average'},
                                {type : 'max'},
                                {type : 'min'}
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