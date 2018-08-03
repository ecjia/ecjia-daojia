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
            'echarts/chart/wordCloud'
        ],


        // Charts setup
        function (ec) {

            function createRandomItemStyle() {
                return {
                    normal: {
                        color: 'rgb(' + [
                            Math.round(Math.random() * 160),
                            Math.round(Math.random() * 160),
                            Math.round(Math.random() * 160)
                        ].join(',') + ')'
                    }
                };
            }

            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('word-cloud'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Add tooltip
                tooltip: {
                    show: true
                },

                // Add series
                series: [{
                    name: 'Google Trends',
                    type: 'wordCloud',
                    size: ['80%', '80%'],
                    textRotation : [0, 45, 90, -45],
                    textPadding: 0,
                    autoSize: {
                        enable: true,
                        minSize: 14
                    },
                    data: [
                        {
                            name: "Sam S Club",
                            value: 10000,
                            itemStyle: {
                                normal: {
                                    color: 'black'
                                }
                            }
                        },
                        {
                            name: "Macys",
                            value: 6181,
                            itemStyle: createRandomItemStyle()
                        },
                        {
                            name: "Amy Schumer",
                            value: 4386,
                            itemStyle: createRandomItemStyle()
                        },
                        {
                            name: "Jurassic World",
                            value: 4055,
                            itemStyle: createRandomItemStyle()
                        },
                        {
                            name: "Charter Communications",
                            value: 2467,
                            itemStyle: createRandomItemStyle()
                        },
                        {
                            name: "Chick Fil A",
                            value: 2244,
                            itemStyle: createRandomItemStyle()
                        },
                        {
                            name: "Planet Fitness",
                            value: 1898,
                            itemStyle: createRandomItemStyle()
                        },
                        {
                            name: "Pitch Perfect",
                            value: 1484,
                            itemStyle: createRandomItemStyle()
                        },
                        {
                            name: "Express",
                            value: 1112,
                            itemStyle: createRandomItemStyle()
                        },
                        {
                            name: "Home",
                            value: 965,
                            itemStyle: createRandomItemStyle()
                        },
                        {
                            name: "Johnny Depp",
                            value: 847,
                            itemStyle: createRandomItemStyle()
                        },
                        {
                            name: "Lena Dunham",
                            value: 582,
                            itemStyle: createRandomItemStyle()
                        },
                        {
                            name: "Lewis Hamilton",
                            value: 555,
                            itemStyle: createRandomItemStyle()
                        },
                        {
                            name: "KXAN",
                            value: 550,
                            itemStyle: createRandomItemStyle()
                        },
                        {
                            name: "Mary Ellen Mark",
                            value: 462,
                            itemStyle: createRandomItemStyle()
                        },
                        {
                            name: "Farrah Abraham",
                            value: 366,
                            itemStyle: createRandomItemStyle()
                        },
                        {
                            name: "Rita Ora",
                            value: 360,
                            itemStyle: createRandomItemStyle()
                        },
                        {
                            name: "Serena Williams",
                            value: 282,
                            itemStyle: createRandomItemStyle()
                        },
                        {
                            name: "NCAA baseball tournament",
                            value: 273,
                            itemStyle: createRandomItemStyle()
                        },
                        {
                            name: "Point Break",
                            value: 265,
                            itemStyle: createRandomItemStyle()
                        }
                    ]
                }]
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