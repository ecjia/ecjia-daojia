/*=========================================================================================
    File Name: doughnut-infographic.js
    Description: echarts doughnut infographic chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Doughnut infographic chart
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
            var myChart = ec.init(document.getElementById('doughnut-infographic'));


            // Data style
            var dataStyle = {
                normal: {
                    label: {show: false},
                    labelLine: {show: false}
                }
            };

            // Placeholder style
            var placeHolderStyle = {
                normal: {
                    color: 'rgba(0,0,0,0)',
                    label: {show: false},
                    labelLine: {show: false}
                },
                emphasis: {
                    color: 'rgba(0,0,0,0)'
                }
            };

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Add title
                title: {
                    text: 'Are you happy?',
                    subtext: 'Utrecht, Netherlands',
                    x: 'center',
                    y: 'center',
                    itemGap: 10,
                    textStyle: {
                        color: 'rgba(30,144,255,0.8)',
                        fontSize: 19,
                        fontWeight: '500'
                    }
                },

                // Add tooltip
                tooltip: {
                    show: true,
                    formatter: "{a} <br/>{b}: {c} ({d}%)"
                },

                // Add legend
                legend: {
                    orient: 'vertical',
                    x: document.getElementById('doughnut-infographic').offsetWidth / 2,
                    y: 30,
                    x: '55%',
                    itemGap: 15,
                    data: ['60% Definitely yes','30% Could be better','10% Not at the moment']
                },

                // Add custom colors
                color: ['#00A5A8', '#FF4558', '#28D094'],

                // Add series
                series: [
                    {
                        name: '1',
                        type: 'pie',
                        clockWise: false,
                        radius: ['75%', '90%'],
                        itemStyle: dataStyle,
                        data: [
                            {
                                value: 60,
                                name: '60% Definitely yes'
                            },
                            {
                                value: 40,
                                name: 'invisible',
                                itemStyle: placeHolderStyle
                            }
                        ]
                    },

                    {
                        name: '2',
                        type:'pie',
                        clockWise: false,
                        radius: ['60%', '75%'],
                        itemStyle: dataStyle,
                        data: [
                            {
                                value: 30, 
                                name: '30% Could be better'
                            },
                            {
                                value: 70,
                                name: 'invisible',
                                itemStyle: placeHolderStyle
                            }
                        ]
                    },

                    {
                        name: '3',
                        type: 'pie',
                        clockWise: false,
                        radius: ['45%', '60%'],
                        itemStyle: dataStyle,
                        data: [
                            {
                                value: 10, 
                                name: '10% Not at the moment'
                            },
                            {
                                value: 90,
                                name: 'invisible',
                                itemStyle: placeHolderStyle
                            }
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