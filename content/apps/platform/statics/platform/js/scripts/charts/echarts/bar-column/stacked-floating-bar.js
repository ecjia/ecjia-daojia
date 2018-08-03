/*=========================================================================================
    File Name: stacked-floating-bar.js
    Description: echarts stacked floating bar chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Stacked floating bar chart
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
            var myChart = ec.init(document.getElementById('stacked-floating-bar'));

            // Placeholded Style
            var placeHoledStyle = {
                normal:{
                    barBorderColor:'rgba(0,0,0,0)',
                    color:'rgba(0,0,0,0)'
                },
                emphasis:{
                    barBorderColor:'rgba(0,0,0,0)',
                    color:'rgba(0,0,0,0)'
                }
            };

            // Data Style
            var dataStyle = {
                normal: {
                    label : {
                        show: true,
                        position: 'insideLeft',
                        formatter: '{c}%'
                    }
                }
            };

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Setup grid
                grid: {
                    x: 40,
                    x2: 40,
                    y: 80,
                    y2: 30
                },

                // Add tooltip
                tooltip : {
                    trigger: 'axis',
                    axisPointer : {            // Axis indicator axis trigger effective
                        type : 'shadow'        // The default is a straight line, optionally: 'line' | 'shadow'
                    },
                    formatter : '{b}<br/>{a0}:{c0}%<br/>{a2}:{c2}%<br/>{a4}:{c4}%<br/>{a6}:{c6}%'
                },

                // Add legend
                legend: {
                    y: 55,
                    itemGap : document.getElementById('stacked-floating-bar').offsetWidth / 8,
                    data:['GML', 'PYP','WTC', 'ZTW']
                },

                // Add custom colors
                color: ['#666EE8', '#FF9149', '#FF4961', '#2D2E4F'],

                // Enable drag recalculate
                calculable: true,

                // Horizontal axis
                xAxis: [{
                    type : 'value',
                    position: 'top',
                    splitLine: {show: false},
                    axisLabel: {show: false}
                }],

                // Vertical axis
                yAxis: [{
                    type : 'category',
                    splitLine: {show: false},
                    data : ['Chongqing', 'Tianjin', 'Shanghai', 'Beijing']
                }],

                // Add series
                series : [
                    {
                        name:'GML',
                        type:'bar',
                        stack: 'Total',
                        itemStyle : dataStyle,
                        data:[38, 50, 33, 72]
                    },
                    {
                        name:'GML',
                        type:'bar',
                        stack: 'Total',
                        itemStyle: placeHoledStyle,
                        data:[62, 50, 67, 28]
                    },
                    {
                        name:'PYP',
                        type:'bar',
                        stack: 'Total',
                        itemStyle : dataStyle,
                        data:[61, 41, 42, 30]
                    },
                    {
                        name:'PYP',
                        type:'bar',
                        stack: 'Total',
                        itemStyle: placeHoledStyle,
                        data:[39, 59, 58, 70]
                    },
                    {
                        name:'WTC',
                        type:'bar',
                        stack: 'Total',
                        itemStyle : dataStyle,
                        data:[37, 35, 44, 60]
                    },
                    {
                        name:'WTC',
                        type:'bar',
                        stack: 'Total',
                        itemStyle: placeHoledStyle,
                        data:[63, 65, 56, 40]
                    },
                    {
                        name:'ZTW',
                        type:'bar',
                        stack: 'Total',
                        itemStyle : dataStyle,
                        data:[71, 50, 31, 39]
                    },
                    {
                        name:'ZTW',
                        type:'bar',
                        stack: 'Total',
                        itemStyle: placeHoledStyle,
                        data:[29, 50, 69, 61]
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