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
            'echarts/chart/bar',
            'echarts/chart/line'
        ],

        // Charts setup
        function (ec) {

            var zrColor = require('zrender/tool/color');
            var colorList = [
              '#00A5A8', '#FF7D4D', '#FF4558','#626E82', '#28D094', '#FFC400', '#006064', '#FF1744'
            ];

            var itemStyle = {
                normal: {
                    color: function(params) {
                      if (params.dataIndex < 0) {
                        // for legend
                        return zrColor.lift(
                          colorList[colorList.length - 1], params.seriesIndex * 0.1
                        );
                      }
                      else {
                        // for bar
                        return zrColor.lift(
                          colorList[params.dataIndex], params.seriesIndex * 0.1
                        );
                      }
                    }
                }
            };

            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('multiple-series-rainbow'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Setup grid
                grid: {
                    y: 80,
                    y2: 40,
                    x2: 40
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis',
                    backgroundColor: 'rgba(255,255,255,0.7)',
                    axisPointer: {
                        type: 'shadow'
                    },
                    formatter: function(params) {
                        // for text color
                        var color = colorList[params[0].dataIndex];
                        var res = '<div style="color:' + color + '">';
                        res += '<strong>' + params[0].name + '消费（元）</strong>';
                        for (var i = 0, l = params.length; i < l; i++) {
                            res += '<br/>' + params[i].seriesName + ' : ' + params[i].value;
                        }
                        res += '</div>';
                        return res;
                    }
                },

                // Add legend
                legend: {
                    x: 'right',
                    data:['2010','2011','2012','2013']
                },

                // Add custom colors
                color: ['#EF5350', '#FECEA8', '#66BB6A'],

                // Enable drag recalculate
                calculable: true,

                // Horizontal axis
                xAxis: [
                    {
                        type: 'category',
                        data: ['Food', 'clothing', 'live', 'household equipment and supplies', 'health care', 'transport and communication', 'education and entertainment services', 'other']
                    }
                ],

                // Vertical axis
                yAxis: [
                    {
                        type: 'value'
                    }
                ],

                // Add series
                series: [
                    {
                        name: '2010',
                        type: 'bar',
                        itemStyle: itemStyle,
                        data: [4804.7,1444.3,1332.1,908,871.8,1983.7,1627.6,499.2]
                    },
                    {
                        name: '2011',
                        type: 'bar',
                        itemStyle: itemStyle,
                        data: [5506.3,1674.7,1405,1023.2,969,2149.7,1851.7,581.3]
                    },
                    {
                        name: '2012',
                        type: 'bar',
                        itemStyle: itemStyle,
                        data: [6040.9,1823.4,1484.3,1116.1,1063.7,2455.5,2033.5,657.1]
                    },
                    {
                        name: '2013',
                        type: 'bar',
                        itemStyle: itemStyle,
                        data: [6311.9,1902,1745.1,1215.1,1118.3,2736.9,2294,699.4]
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