/*=========================================================================================
    File Name: wormhole.js
    Description: echarts wormhole chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Wormhole chart
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
            var myChart = ec.init(document.getElementById('wormhole'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Add tooltip
                tooltip : {
                    trigger: 'item',
                    backgroundColor : 'rgba(0,0,250,0.2)'
                },

                // Add legend
                legend: {
                    // orient : 'vertical',
                    //x : 'center',
                    data: function (){
                        var list = [];
                        for (var i = 1; i <=28; i++) {
                            list.push(i + 2000);
                        }
                        return list;
                    }()
                },

                // Add polar
                polar : [
                   {
                       indicator : [
                           { text: 'IE8-', max: 400},
                           { text: 'IE9+', max: 400},
                           { text: 'Safari', max: 400},
                           { text: 'Firefox', max: 400},
                           { text: 'Chrome', max: 400}
                        ],
                        center : ['50%', 240],
                        radius : 150
                    }
                ],

                // Add custom colors
                color: ['#FF4961'],

                // Enable drag recalculate
                calculable: true,

                // Add series
                series : (function (){
                    var series = [];
                    for (var i = 1; i <= 28; i++) {
                        series.push({
                            name:'Browser (data purely fictional)',
                            type:'radar',
                            symbol:'none',
                            itemStyle: {
                                normal: {
                                    lineStyle: {
                                      width:1
                                    }
                                },
                                emphasis : {
                                    areaStyle: {color:'rgba(0,250,0,0.3)'}
                                }
                            },
                            data:[
                              {
                                value:[
                                    (40 - i) * 10,
                                    (38 - i) * 4 + 60,
                                    i * 5 + 10,
                                    i * 9,
                                    i * i /2
                                ],
                                name:i + 2000
                              }
                            ]
                        });
                    }
                    return series;
                })()
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