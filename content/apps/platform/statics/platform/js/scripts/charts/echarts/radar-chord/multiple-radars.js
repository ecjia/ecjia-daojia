/*=========================================================================================
    File Name: multiple-radars.js
    Description: echarts multiple radars chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Multiple radars chart
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
            var myChart = ec.init(document.getElementById('multiple-radars'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Add tooltip
                tooltip: {
                    trigger: 'axis'
                },

                // Add legend
                legend: {
                    x : 'center',
                    data:['Certain software', 'A staple phone', 'The fruit of a mobile phone', 'precipitation', 'evaporation']
                },

                // Add polar
                polar : [
                    {
                        indicator : [
                            {text : 'Brands', max  : 100},
                            {text : 'Content', max  : 100},
                            {text : 'Availability', max  : 100},
                            {text : 'Features', max  : 100}
                        ],
                        center : ['20%',200],
                        radius : 150
                    },
                    {
                        indicator : [
                            {text : 'Exterior', max  : 100},
                            {text : 'Photograph', max  : 100},
                            {text : 'System', max  : 100},
                            {text : 'Performance', max  : 100},
                            {text : 'Screen', max  : 100}
                        ],
                        radius : 150
                    },
                    {
                        indicator : (function (){
                            var res = [];
                            for (var i = 1; i <= 12; i++) {
                                res.push({text:i+'month',max:100});
                            }
                            return res;
                        })(),
                        center : ['80%', 200],
                        radius : 150
                    }
                ],

                // Add custom colors
                // color: ['#99B898', '#FECEA8', '#FF847C', '#E84A5F', '#2A363B'],

                // Enable drag recalculate
                calculable: true,

                // Add series
                series : [
                    {
                        type: 'radar',
                         tooltip : {
                            trigger: 'item'
                        },
                        itemStyle: {normal: {areaStyle: {type: 'default'}}},
                        data : [
                            {
                                value : [60,73,85,40],
                                name : 'Certain software'
                            }
                        ]
                    },
                    {
                        type: 'radar',
                        polarIndex : 1,
                        data : [
                            {
                                value : [85, 90, 90, 95, 95],
                                name : 'A staple phone'
                            },
                            {
                                value : [95, 80, 95, 90, 93],
                                name : 'A mobile phone fruit'
                            }
                        ]
                    },
                    {
                        type: 'radar',
                        polarIndex : 2,
                        itemStyle: {normal: {areaStyle: {type: 'default'}}},
                        data : [
                            {
                                name : 'Precipitation',
                                value : [2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 75.6, 82.2, 48.7, 18.8, 6.0, 2.3],
                            },
                            {
                                name:'Evaporation',
                                value:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 35.6, 62.2, 32.6, 20.0, 6.4, 3.3]
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