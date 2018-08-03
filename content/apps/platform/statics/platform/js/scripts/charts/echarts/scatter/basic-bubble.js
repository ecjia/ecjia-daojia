/*=========================================================================================
    File Name: basic-bubble.js
    Description: echarts basic bubble chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Basic bubble chart
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
            var myChart = ec.init(document.getElementById('basic-bubble'));

            // Random
            function random(){
                var r = Math.round(Math.random() * 100);
                return (r * (r % 2 == 0 ? 1 : -1));
            }

            // Random Data
            function randomDataArray() {
                var d = [];
                var len = 100;
                while (len--) {
                    d.push([
                        random(),
                        random(),
                        Math.abs(random()),
                    ]);
                }
                return d;
            }
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
                    showDelay : 0,
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

                // Add custom colors
                // color: ['#99B898', '#FECEA8'],
                color: ['#673AB7', '#E91E63'],

                // Horizontal axis
                xAxis : [
                    {
                        type : 'value',
                        splitNumber: 4,
                        scale: true
                    }
                ],

                // Vertical axis
                yAxis : [
                    {
                        type : 'value',
                        splitNumber: 4,
                        scale: true
                    }
                ],

                // Add series
                 series : [
                    {
                        name:'scatter1',
                        type:'scatter',
                        symbolSize: function (value){
                            return Math.round(value[2] / 5);
                        },
                        data: randomDataArray()
                    },
                    {
                        name:'scatter2',
                        type:'scatter',
                        symbolSize: function (value){
                            return Math.round(value[2] / 5);
                        },
                        data: randomDataArray()
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