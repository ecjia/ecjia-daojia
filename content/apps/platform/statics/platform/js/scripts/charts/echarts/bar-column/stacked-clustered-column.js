/*=========================================================================================
    File Name: stacked-clustered-column.js
    Description: echarts stacked clustered column chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Stacked clustered column chart
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
            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('stacked-clustered-column'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Setup grid
                grid: {
                    x: 40,
                    x2: 20,
                    y: 70,
                    y2: 30
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis'
                },

                // Add legend
                legend: {
                    data: [
                        'ECharts1 - 2k Data','ECharts1 - 2w Data','ECharts1 - 20w Data','',
                        'ECharts2 - 2k Data','ECharts2 - 2w Data','ECharts2 - 20w Data'
                    ]
                },

                // Enable drag recalculate
                calculable: true,

                // Horizontal axis
                xAxis: [{
                    type : 'category',
                    data : ['Line','Bar','Scatter','K','Map']
                },
                {
                    type : 'category',
                    axisLine: {show:false},
                    axisTick: {show:false},
                    axisLabel: {show:false},
                    splitArea: {show:false},
                    splitLine: {show:false},
                    data : ['Line','Bar','Scatter','K','Map']
                }
                ],

                // Vertical axis
                yAxis: [{
                    type : 'value',
                    axisLabel:{formatter:'{value} ms'}
                }],

                // Add series
                series : [
                    {
                        name:'ECharts2 - 2k Data',
                        type:'bar',
                        itemStyle: {normal: {color:'rgba(22,211,154,1)', label:{show:true}}},
                        data:[40,155,95,75, 0]
                    },
                    {
                        name:'ECharts2 - 2w Data',
                        type:'bar',
                        itemStyle: {normal: {color:'rgba(45,206,227,1)', label:{show:true,textStyle:{color:'#27727B'}}}},
                        data:[100,200,105,100,156]
                    },
                    {
                        name:'ECharts2 - 20w Data',
                        type:'bar',
                        itemStyle: {normal: {color:'rgba(249,142,118,1)', label:{show:true,textStyle:{color:'#E87C25'}}}},
                        data:[906,911,908,778,0]
                    },
                    {
                        name:'ECharts1 - 2k Data',
                        type:'bar',
                        xAxisIndex:1,
                        itemStyle: {normal: {color:'rgba(22,211,154,0.7)', label:{show:true,formatter:function(p){return p.value > 0 ? (p.value +'\n'):'';}}}},
                        data:[96,224,164,124,0]
                    },
                    {
                        name:'ECharts1 - 2w Data',
                        type:'bar',
                        xAxisIndex:1,
                        itemStyle: {normal: {color:'rgba(45,206,227,0.7)', label:{show:true}}},
                        data:[491,2035,389,955,347]
                    },
                    {
                        name:'ECharts1 - 20w Data',
                        type:'bar',
                        xAxisIndex:1,
                        itemStyle: {normal: {color:'rgba(249,142,118,0.7)', label:{show:true,formatter:function(p){return p.value > 0 ? (p.value +'+'):'';}}}},
                        data:[3000,3000,2817,3000,0]
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