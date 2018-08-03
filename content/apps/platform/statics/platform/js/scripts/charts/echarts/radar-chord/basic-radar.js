/*=========================================================================================
    File Name: basic-radar.js
    Description: echarts basic radar chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Basic radar chart
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
            var myChart = ec.init(document.getElementById('basic-radar'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Add tooltip
                tooltip: {
                    trigger: 'axis'
                },

                // Add legend
                legend: {
                    orient : 'vertical',
                    x : 'right',
                    y : 'bottom',
                    data:['Allocated Budget','Actual Spending']
                },

                // Add polar
                polar : [
                   {
                       indicator : [
                           { text: 'sales', max: 6000},
                           { text: 'Administration', max: 16000},
                           { text: 'Information Techology', max: 30000},
                           { text: 'Customer Support', max: 38000},
                           { text: 'Development', max: 52000},
                           { text: 'Marketing', max: 25000}
                        ]
                    }
                ],

                // Add custom colors
                color: ['#666EE8', '#FF4961'],

                // Enable drag recalculate
                calculable: true,

                // Add series
                series : [
                    {
                        name: 'Budget vs spending',
                        type: 'radar',
                        data : [
                            {
                                value : [4300, 10000, 28000, 35000, 50000, 19000],
                                name : 'Allocated Budget'
                            },
                             {
                                value : [5000, 14000, 28000, 31000, 42000, 21000],
                                name : 'Actual Spending'
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