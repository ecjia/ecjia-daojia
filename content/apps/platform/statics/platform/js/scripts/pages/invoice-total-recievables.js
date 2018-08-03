/*=========================================================================================
    File Name: invoice-total-recievables.js
    Description: Invoice Total Recievable Pie Chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Basic pie chart
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
            var myChart = ec.init(document.getElementById('invoice-total-recievables'));


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
                    text: 'Total Receivables',
                    subtext: '$ 2100.00',
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
                    formatter: "{a} <br/>{b}: ({d}%)"
                },

                // Add legend
                legend: {
                    orient: 'vertical',
                    x: document.getElementById('invoice-total-recievables').offsetWidth / 2,
                    y: 30,
                    x: '55%',
                    itemGap: 15,
                    data: ['Current', 'Overdue by 1-15 days', 'Overdue by 16-30 days', 'Overdue by 31-45 days' , 'Overdue by 45+ days']
                },

                // Add custom colors
                color: ['#99B898', '#FECEA8', '#FF847C', '#E84A5F','#b95462'],

                // Add series
                series: [
                    {
                        name: '$ 1200.00',
                        type: 'pie',
                        clockWise: false,
                        radius: ['75%', '90%'],
                        itemStyle: dataStyle,
                        data: [
                            {
                                value: 58,
                                name: 'Current'
                            },
                            {
                                value: 42,
                                name: 'invisible',
                                itemStyle: placeHolderStyle
                            }
                        ]
                    },
                    {
                        name: '$ 450.00',
                        type:'pie',
                        clockWise: false,
                        radius: ['60%', '75%'],
                        itemStyle: dataStyle,
                        data: [
                            {
                                value: 21,
                                name: 'Overdue by 1-15 days'
                            },
                            {
                                value: 79,
                                name: 'invisible',
                                itemStyle: placeHolderStyle
                            }
                        ]
                    },
                    {
                        name: '$ 250.00',
                        type: 'pie',
                        clockWise: false,
                        radius: ['45%', '60%'],
                        itemStyle: dataStyle,
                        data: [
                            {
                                value: 11,
                                name: 'Overdue by 16-30 days'
                            },
                            {
                                value: 89,
                                name: 'invisible',
                                itemStyle: placeHolderStyle
                            }
                        ]
                    },
                    {
                        name: '$ 150.00',
                        type: 'pie',
                        clockWise: false,
                        radius: ['30%', '45%'],
                        itemStyle: dataStyle,
                        data: [
                            {
                                value: 7,
                                name: 'Overdue by 31-45 days'
                            },
                            {
                                value: 93,
                                name: 'invisible',
                                itemStyle: placeHolderStyle
                            }
                        ]
                    },
                    {
                        name: '$ 50.00',
                        type: 'pie',
                        clockWise: false,
                        radius: ['15%', '30%'],
                        itemStyle: dataStyle,
                        data: [
                            {
                                value: 2,
                                name: 'Overdue by 45+ days'
                            },
                            {
                                value: 98,
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