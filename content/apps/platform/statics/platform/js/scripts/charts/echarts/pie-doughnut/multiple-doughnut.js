/*=========================================================================================
    File Name: multiple-doughnut.js
    Description: echarts multiple doughnut chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Multiple doughnut chart
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
            'echarts/chart/pie',
            'echarts/chart/funnel'
        ],


        // Charts setup
        function (ec) {
            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('multiple-doughnut'));

            // Top text label
            var labelTop = {
                normal: {
                    label: {
                        show: true,
                        position: 'center',
                        formatter: '{b}\n',
                        textStyle: {
                            baseline: 'middle',
                            fontWeight: 300,
                            fontSize: 15
                        }
                    },
                    labelLine: {
                        show: false
                    }
                }
            };

            // Format bottom label
            var labelFromatter = {
                normal: {
                    label: {
                        formatter: function (params) {
                            return '\n\n' + (100 - params.value) + '%';
                        }
                    }
                }
            };

            // Bottom text label
            var labelBottom = {
                normal: {
                    color: '#eee',
                    label: {
                        show: true,
                        position: 'center',
                        textStyle: {
                            baseline: 'middle'
                        }
                    },
                    labelLine: {
                        show: false
                    }
                },
                emphasis: {
                    color: 'rgba(0,0,0,0)'
                }
            };

            // Set inner and outer radius
            // var radius = [60, 75];
            var radius = [45, 60];
            // Chart Options
            // ------------------------------
            chartOptions = {

                // Add title
                title: {
                    text: 'The Application World',
                    subtext: 'from global web index',
                    x: 'center'
                },

                // Add legend
                legend: {
                    x: 'center',
                    y: '56%',
                    data: ['GoogleMaps', 'Facebook', 'Youtube', 'Google+', 'Weixin', 'Twitter', 'Skype', 'Messenger', 'Whatsapp', 'Instagram']
                },

                // Add custom colors
                color: ['#20A464', '#4A66A0', '#DE2925','#DD5044', '#99B898', '#4B9CD8', '#50A5E6', '#FF6024', '#50CA5F', '#DD366F'],

                // Add series
                series: [
                    {
                        type: 'pie',
                        center: ['10%', '32.5%'],
                        radius: radius,
                        itemStyle: labelFromatter,
                        data: [
                            {name: 'other', value: 46, itemStyle: labelBottom},
                            {name: 'GoogleMaps', value: 54,itemStyle: labelTop}
                        ]
                    },
                    {
                        type: 'pie',
                        center: ['30%', '32.5%'],
                        radius: radius,
                        itemStyle: labelFromatter,
                        data: [
                            {name: 'other', value: 56, itemStyle: labelBottom},
                            {name: 'Facebook', value: 44,itemStyle: labelTop}
                        ]
                    },
                    {
                        type: 'pie',
                        center: ['50%', '32.5%'],
                        radius: radius,
                        itemStyle: labelFromatter,
                        data: [
                            {name: 'other', value: 65, itemStyle: labelBottom},
                            {name: 'Youtube', value: 35,itemStyle: labelTop}
                        ]
                    },
                    {
                        type: 'pie',
                        center: ['70%', '32.5%'],
                        radius: radius,
                        itemStyle: labelFromatter,
                        data: [
                            {name: 'other', value: 70, itemStyle: labelBottom},
                            {name: 'Google+', value: 30,itemStyle: labelTop}
                        ]
                    },
                    {
                        type: 'pie',
                        center: ['90%', '32.5%'],
                        radius: radius,
                        itemStyle: labelFromatter,
                        data: [
                            {name:'other', value:73, itemStyle: labelBottom},
                            {name:'Weixin', value:27,itemStyle: labelTop}
                        ]
                    },
                    {
                        type: 'pie',
                        center: ['10%', '82.5%'],
                        radius: radius,
                        itemStyle: labelFromatter,
                        data: [
                            {name: 'other', value: 78, itemStyle: labelBottom},
                            {name: 'Twitter', value: 22,itemStyle: labelTop}
                        ]
                    },
                    {
                        type: 'pie',
                        center: ['30%', '82.5%'],
                        radius: radius,
                        itemStyle: labelFromatter,
                        data: [
                            {name: 'other', value: 78, itemStyle: labelBottom},
                            {name: 'Skype', value: 22,itemStyle: labelTop}
                        ]
                    },
                    {
                        type: 'pie',
                        center: ['50%', '82.5%'],
                        radius: radius,
                        itemStyle: labelFromatter,
                        data: [
                            {name: 'other', value: 78, itemStyle: labelBottom},
                            {name: 'Messenger', value: 22,itemStyle: labelTop}
                        ]
                    },
                    {
                        type: 'pie',
                        center: ['70%', '82.5%'],
                        radius: radius,
                        itemStyle: labelFromatter,
                        data: [
                            {name: 'other', value: 83, itemStyle: labelBottom},
                            {name: 'Whatsapp', value: 17,itemStyle: labelTop}
                        ]
                    },
                    {
                        type: 'pie',
                        center: ['90%', '82.5%'],
                        radius: radius,
                        itemStyle: labelFromatter,
                        data: [
                            {name:'other', value:89, itemStyle: labelBottom},
                            {name:'Instagram', value:11,itemStyle: labelTop}
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