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
            'echarts/chart/k',
            'echarts/chart/eventRiver'
        ],


        // Charts setup
        function (ec) {

            var legendName = [];
            for (var i = 0, l = eventRiver2Data.length; i < l; i++) {
                legendName.push(eventRiver2Data[i].name);
                eventRiver2Data[i].itemStyle = {
                    normal: {
                        label: {
                            show:false
                        }
                    },
                    emphasis: {
                        label: {
                            show:false
                        }
                    }
                }
            }

            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('event-river'));

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
                    trigger: 'item',
                    enterable: true
                },

                // Add legend
                legend: {
                    data: legendName
                },

                // Add custom colors
                color: ['#EF5350', '#FECEA8', '#66BB6A'],

                // Enable drag recalculate
                calculable: true,

                // Horizontal axis
                xAxis : [
                    {
                        type : 'time',
                        boundaryGap: [0.05,0.1]
                    }
                ],

                // Add series
                series : eventRiver2Data
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