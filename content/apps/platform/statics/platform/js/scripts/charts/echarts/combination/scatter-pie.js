/*=========================================================================================
    File Name: scatter-pie.js
    Description: echarts scatter pie chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Scatter pie chart
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
            'echarts/chart/line',
            'echarts/chart/scatter',
            'echarts/chart/pie'
        ],


        // Charts setup
        function (ec) {

            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('scatter-pie'));

            // Virtual structure with horizontal and vertical coordinates of the two sets of data
            var sData1 = (function () {
                var d = [];
                var len = 40;
                var value;
                while (len--) {
                    d.push([
                        Math.round(Math.random()*10) * (Math.round(Math.random()*10) > 5 ? 1 : -1),
                        Math.round(Math.random()*10) * (Math.round(Math.random()*10) > 5 ? 1 : -1),
                        Math.round(Math.random()*20)
                    ]);
                }
                return d;
            })();

            var sData2 = (function () {
                var d = [];
                var len = sData1.length;
                for (var i = 0; i < len; i++) {
                    d.push([
                        sData1[i][0],
                        sData1[i][1],
                        Math.round(Math.random()*15)
                    ]);
                }
                return d;
            })();

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
                    formatter: "{b} : {c} ({d}%)"
                },

                // Add custom colors
                color : ['rgba(0,165,168, 0.5)', 'rgba(255,69,88, 0.5)'],

                // Horizontal axis
                xAxis : [
                    {
                        type : 'value',
                        splitNumber: 2
                    }
                ],

                // Vertical axis
                yAxis : [
                    {
                        type : 'value',
                        splitNumber: 2
                    }
                ],

                // Animation
                animation: false,

                // Add series
                series : [
                    {
                        type:'scatter',
                        symbol: 'none',
                        data: sData1
                    },
                    {
                        type:'scatter',
                        symbol: 'none',
                        data: sData2
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

                function buildPieSeries(){
                    var xAxis = myChart.component.xAxis.getAxis(0);
                    var yAxis = myChart.component.yAxis.getAxis(0);
                    var len = sData1.length;
                    chartOptions.series = chartOptions.series.slice(0,2);
                    chartOptions.legend = {
                        data : ['Series 1', 'Series 2']
                    };
                    while (len--) {
                        chartOptions.series.push({
                            type: 'pie',
                            itemStyle : {
                                normal : {
                                    label : {
                                        show : false
                                    },
                                    labelLine : {
                                        show : false
                                    }
                                }
                            },
                            radius : sData1[len][2] + sData2[len][2],
                            center: [
                                xAxis.getCoord(sData1[len][0]),
                                yAxis.getCoord(sData1[len][1])
                            ],
                            data: [
                                {name: 'Series 1', value: sData1[len][2]},
                                {name: 'Series 2', value: sData2[len][2]}
                            ]
                        });
                    }
                    chartOptions.animation = true;
                    myChart.setOption(chartOptions, true);
                    window.onresize = buildPieSeries;
                }
                // Construct a series of pie charts instead of the original scatter Therefore,
                // we need to get out of San stippling to coordinate scattered points, setTimeout!
                setTimeout(buildPieSeries, 100);
            });
        }
    );
});