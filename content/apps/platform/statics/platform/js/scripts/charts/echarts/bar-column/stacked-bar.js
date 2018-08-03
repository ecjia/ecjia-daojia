/*=========================================================================================
    File Name: stacked-bar.js
    Description: echarts stacked bar chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Stacked bar chart
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
            var myChart = ec.init(document.getElementById('stacked-bar'));

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
                    axisPointer : {            // Axis indicator axis trigger effective
                        type : 'shadow'        // The default is a straight line, optionally: 'line' | 'shadow'
                    }
                },

                // Add legend
                legend: {
                    data: ['Direct access', 'Email marketing', 'Advertising alliance', 'Video ads', 'Search Engine']
                },

                // Add custom colors
                color: ['#666EE8', '#FF9149', '#FF4961', '#2D2E4F', '#98A4B8'],

                // Horizontal axis
                xAxis: [{
                    type: 'value',
                }],

                // Vertical axis
                yAxis: [{
                    type: 'category',
                    data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                }],

                // Add series
                series : [
                    {
                        name:'Direct access',
                        type:'bar',
                        stack: 'Total',
                        itemStyle : { normal: {label : {show: true, position: 'insideRight'}}},
                        data:[320, 302, 301, 334, 390, 330, 320]
                    },
                    {
                        name:'Email marketing',
                        type:'bar',
                        stack: 'Total',
                        itemStyle : { normal: {label : {show: true, position: 'insideRight'}}},
                        data:[120, 132, 101, 134, 90, 230, 210]
                    },
                    {
                        name:'Advertising alliance',
                        type:'bar',
                        stack: 'Total',
                        itemStyle : { normal: {label : {show: true, position: 'insideRight'}}},
                        data:[220, 182, 191, 234, 290, 330, 310]
                    },
                    {
                        name:'Video ads',
                        type:'bar',
                        stack: 'Total',
                        itemStyle : { normal: {label : {show: true, position: 'insideRight'}}},
                        data:[150, 212, 201, 154, 190, 330, 410]
                    },
                    {
                        name:'Search Engine',
                        type:'bar',
                        stack: 'Total',
                        itemStyle : { normal: {label : {show: true, position: 'insideRight'}}},
                        data:[820, 832, 901, 934, 1290, 1330, 1320]
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