/*=========================================================================================
    File Name: basic-filled-radar.js
    Description: echarts basic filled radar chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Basic filled radar chart
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
            var myChart = ec.init(document.getElementById('basic-filled-radar'));

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
                    data:['Ronaldo','Shevchenko']
                },

                // Add polar
                polar : [
                    {
                        indicator : [
                            {text : 'Attack', max  : 100},
                            {text : 'Defence', max  : 100},
                            {text : 'Fitness', max  : 100},
                            {text : 'Speed', max  : 100},
                            {text : 'Power', max  : 100},
                            {text : 'Skill', max  : 100}
                        ],
                        radius : 130
                    }
                ],

                // Add custom colors
                color: ['#666EE8', '#FF4961'],

                // Enable drag recalculate
                calculable: true,

                // Add series
                series : [
                    {
                        name: 'Players fully live data',
                        type: 'radar',
                        itemStyle: {
                            normal: {
                                areaStyle: {
                                    type: 'default'
                                }
                            }
                        },
                        data : [
                            {
                                value : [97, 42, 88, 94, 90, 86],
                                name : 'Shevchenko'
                            },
                            {
                                value : [97, 32, 74, 95, 88, 92],
                                name : 'Ronaldo'
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