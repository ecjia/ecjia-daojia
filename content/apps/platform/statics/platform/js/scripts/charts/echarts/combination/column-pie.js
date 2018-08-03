/*=========================================================================================
    File Name: column-pie.js
    Description: echarts column pie chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Column pie chart
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
            var myChart = ec.init(document.getElementById('column-pie'));

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
                tooltip: {
                    trigger: 'axis'
                },

                // Add legend
                legend: {
                    data: ['Direct access', 'Email marketing', 'Advertising alliance', 'Video ads', 'Browser', 'Chrome', 'Firefox', 'Safari', 'Opera']
                },

                // Add custom colors
                color: ['#00A5A8', '#626E82', '#FF7D4D','#FF4558', '#28D094'],

                // Horizontal axis
                xAxis: [{
                    type: 'category',
                    splitLine : {show : false},
                    data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
                }],

                // Vertical axis
                yAxis : [
                    {
                        type : 'value',
                        position: 'right'
                    }
                ],

                // Add series
                series : [
                    {
                        name:'Direct Access',
                        type:'bar',
                        data:[320, 332, 301, 334, 390, 330, 320]
                    },
                    {
                        name:'Email marketing',
                        type:'bar',
                        tooltip : {trigger: 'item'},
                        stack: 'Advertising',
                        data:[120, 132, 101, 134, 90, 230, 210]
                    },
                    {
                        name:'Advertising alliance',
                        type:'bar',
                        tooltip : {trigger: 'item'},
                        stack: 'Advertising',
                        data:[220, 182, 191, 234, 290, 330, 310]
                    },
                    {
                        name:'Video ads',
                        type:'bar',
                        tooltip : {trigger: 'item'},
                        stack: 'Advertising',
                        data:[150, 232, 201, 154, 190, 330, 410]
                    },
                    {
                        name:'Browser',
                        type:'line',
                        data:[862, 1018, 964, 1026, 1679, 1600, 1570]
                    },

                    {
                        name:'Browser Usage',
                        type:'pie',
                        tooltip : {
                            trigger: 'item',
                            formatter: '{a} <br/>{b} : {c} ({d}%)'
                        },
                        center: [160,130],
                        radius : [0, 50],
                        itemStyle :　{
                            normal : {
                                labelLine : {
                                    length : 20
                                }
                            }
                        },
                        data:[
                            {value:1048, name:'Chrome'},
                            {value:251, name:'Firefox'},
                            {value:147, name:'Safari'},
                            {value:102, name:'Opera'}
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