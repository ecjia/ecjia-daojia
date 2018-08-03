/*=========================================================================================
    File Name: radar-multi-level-control.js
    Description: echarts radar multilevel control chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Radar multilevel control chart
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
            'echarts/chart/radar',
            'echarts/chart/chord'
        ],


        // Charts setup
        function (ec) {
            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('radar-multilevel-control'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Add tooltip
                tooltip: {
                    trigger: 'axis'
                },

                // Add legend
                legend: {
                    x : 'left',
                    data:['Figure I','Figure II','Figure III']
                },

                // Add polar
                 polar : [
                    {
                        indicator : [
                            { text : 'Indicator 1' },
                            { text : 'Indicator 2' },
                            { text : 'Indicator 3' },
                            { text : 'Indicator 4' },
                            { text : 'Indicator 5' }
                        ],
                        center : ['50%',240],
                        radius : 150,
                        startAngle: 90,
                        splitNumber: 8,
                        name : {
                            formatter:'【{value}】',
                            textStyle: {color:'red'}
                        },
                        scale: true,
                        type: 'circle',
                        axisLine: {
                            show: true,
                            lineStyle: {
                                color: '#99B898',
                                width: 2,
                                type: 'solid'
                            }
                        },
                        axisLabel: {
                            show: true,
                            // formatter: null,
                            textStyle: {
                                color: '#ccc'
                            }
                        },
                        splitArea : {
                            show : true,
                            areaStyle : {
                                color: ['rgba(153,184,152,0.6)','rgba(255,132,124,0.6)']
                            }
                        },
                        splitLine : {
                            show : true,
                            lineStyle : {
                                width : 2,
                                color : '#FECEA8'
                            }
                        }
                    }
                ],

                // Enable drag recalculate
                calculable: true,

                // Add series
                series : [
                    {
                        name: 'Radar Chart',
                        type: 'radar',
                        itemStyle: {
                            emphasis: {
                                lineStyle: {
                                    width: 4
                                }
                            }
                        },
                        data : [
                            {
                                value : [100, 8, 0.40, -80, 2000],
                                name : 'Figure I',
                                symbol: 'star5',
                                symbolSize: 4,
                                itemStyle: {
                                    normal: {
                                        lineStyle: {
                                            type: 'dashed'
                                        }
                                    }
                                }
                            },
                            {
                                value : [10, 3, 0.20, -100, 1000],
                                name : 'Figure II',
                                itemStyle: {
                                    normal: {
                                        areaStyle: {
                                            type: 'default'
                                        }
                                    }
                                }
                            },
                            {
                                value : [20, 3, 0.3, -13.5, 3000],
                                name : 'Figure III',
                                symbol: 'none',
                                itemStyle: {
                                    normal: {
                                        lineStyle: {
                                            type: 'dotted'
                                        }
                                    }
                                }
                            }
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