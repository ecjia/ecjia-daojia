/*=========================================================================================
    File Name: thermometer.js
    Description: echarts thermometer chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Thermometer chart
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
            'echarts/chart/scatter'
        ],


        // Charts setup
        function (ec) {
            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('thermometer'));

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
                    axisPointer : {            // Pointer axis, the axis trigger effective
                        type : 'shadow'        // The default is a straight line, optionally: 'line' | 'shadow'
                    },
                    formatter: function (params){
                        return params[0].name + '<br/>'+ params[0].seriesName + ' : ' + params[0].value + '<br/>'+ params[1].seriesName + ' : ' + (params[1].value + params[0].value);
                    }
                },

                // Add legend
                legend: {
                    selectedMode:false,
                    data:['Acutal', 'Forecast']
                },

                // Add custom colors
                color: ['#F98E76', '#99B898'],

                // Enable drag recalculate
                calculable: true,

                // Horizontal axis
                xAxis: [{
                    type : 'category',
                    data : ['Cosco','CMA','APL','OOCL','Wanhai','Zim']
                }],

                // Vertical axis
                yAxis: [{
                    type : 'value',
                    boundaryGap: [0, 0.1]
                }],

                // Add series
                series : [
                    {
                        name:'Acutal',
                        type:'bar',
                        stack: 'sum',
                        barCategoryGap: '50%',
                        itemStyle: {
                            normal: {
                                color: '#F98E76',
                                barBorderColor: '#F98E76',
                                barBorderWidth: 6,
                                barBorderRadius:0,
                                label : {
                                    show: true, position: 'insideTop'
                                }
                            }
                        },
                        data:[260, 200, 220, 120, 100, 80]
                    },
                    {
                        name:'Forecast',
                        type:'bar',
                        stack: 'sum',
                        itemStyle: {
                            normal: {
                                color: '#fff',
                                barBorderColor: '#F98E76',
                                barBorderWidth: 6,
                                barBorderRadius:0,
                                label : {
                                    show: true,
                                    position: 'top',
                                    formatter: function (params) {
                                        for (var i = 0, l = chartOptions.xAxis[0].data.length; i < l; i++) {
                                            if (chartOptions.xAxis[0].data[i] == params.name) {
                                                return chartOptions.series[0].data[i] + params.value;
                                            }
                                        }
                                    },
                                    textStyle: {
                                        color: '#F98E76'
                                    }
                                }
                            }
                        },
                        data:[40, 80, 50, 80,80, 70]
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