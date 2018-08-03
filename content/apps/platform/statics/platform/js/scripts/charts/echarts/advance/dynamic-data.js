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

            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('dynamic-data'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Add Tooltip
                tooltip : {
                    trigger: 'axis'
                },

                // Add Legend
                legend: {
                    data:['Latest price', 'Pre-order queue']
                },

                // Add custom colors
                color: ['#FF4558', '#00A5A8'],

                // Add Toolbook
                toolbox: {
                    show : true,
                    feature : {
                        mark : {show: true},
                        dataView : {show: true, readOnly: false},
                        magicType : {show: true, type: ['line', 'bar']},
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },

                // Data Zoom
                dataZoom : {
                    show : false,
                    start : 0,
                    end : 100
                },

                // Horizontal  Axis
                xAxis : [
                    {
                        type : 'category',
                        boundaryGap : true,
                        data : (function (){
                            var now = new Date();
                            var res = [];
                            var len = 10;
                            while (len--) {
                                res.unshift(now.toLocaleTimeString().replace(/^\D*/,''));
                                now = new Date(now - 2000);
                            }
                            return res;
                        })()
                    },
                    {
                        type : 'category',
                        boundaryGap : true,
                        data : (function (){
                            var res = [];
                            var len = 10;
                            while (len--) {
                                res.push(len + 1);
                            }
                            return res;
                        })()
                    }
                ],

                // Vertical Axis
                yAxis : [
                    {
                        type : 'value',
                        scale: true,
                        name : 'Price',
                        boundaryGap: [0.2, 0.2]
                    },
                    {
                        type : 'value',
                        scale: true,
                        name : 'Futures volume',
                        boundaryGap: [0.2, 0.2]
                    }
                ],

                // Add series
                series : [
                    {
                        name:'Pre-order queue',
                        type:'bar',
                        xAxisIndex: 1,
                        yAxisIndex: 1,
                        data:(function (){
                            var res = [];
                            var len = 10;
                            while (len--) {
                                res.push(Math.round(Math.random() * 1000));
                            }
                            return res;
                        })()
                    },
                    {
                        name:'Latest price',
                        type:'line',
                        data:(function (){
                            var res = [];
                            var len = 10;
                            while (len--) {
                                res.push((Math.random()*10 + 5).toFixed(1) - 0);
                            }
                            return res;
                        })()
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

                var lastData = 11;
                var axisData;
                clearInterval(timeTicket);
                var timeTicket = setInterval(function (){
                    lastData += Math.random() * ((Math.round(Math.random() * 10) % 2) == 0 ? 1 : -1);
                    lastData = lastData.toFixed(1) - 0;
                    axisData = (new Date()).toLocaleTimeString().replace(/^\D*/,'');

                    // Dynamic Data Interface addData
                    myChart.addData([
                        [
                            0,        // Index Series
                            Math.round(Math.random() * 1000), // Add data
                            true,     // If new data is inserted from the head of the queue
                            false     // Whether to increase the queue length, false then delete the original custom data, deleting the tail end into the team, the tail is inserted deleted teams head
                        ],
                        [
                            1,        // Index Series
                            lastData, // Add data
                            false,    // If new data is inserted from the head of the queue
                            false,    // Whether to increase the queue length, false then delete the original custom data, deleting the tail end into the team, the tail is inserted deleted teams head
                            axisData  // Axis label
                        ]
                    ]);
                }, 2100);
            });
        }
    );
});