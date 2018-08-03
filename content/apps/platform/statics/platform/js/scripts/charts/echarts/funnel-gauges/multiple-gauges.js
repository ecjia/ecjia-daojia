/*=========================================================================================
    File Name: multiple-gauge.js
    Description: echarts multiple gauge chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Multiple gauge chart
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
            'echarts/chart/funnel',
            'echarts/chart/gauge'
        ],


        // Charts setup
        function (ec) {

            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('multiple-gauge'));

            // Chart Options
            // ------------------------------
            multigaugeOptions = {

                // Add tooltip
                tooltip : {
                    formatter: "{a} <br/>{b} : {c}%"
                },

                // Add toolbox
                toolbox: {
                    show : true,
                    feature : {
                        mark : {show: true},
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },

                // Enable drag recalculate
                calculable: true,

                // Add series
                series : [
                    {
                        name:'Speed',
                        type:'gauge',
                        z: 3,
                        min:0,
                        max:220,
                        splitNumber:11,
                        axisLine: {            // Coordinate axis
                            lineStyle: {       // Attribute lineStyle control line style
                                width: 10
                            }
                        },
                        axisTick: {            // Axis small marker
                            length :15,        // Attribute length Control line length
                            lineStyle: {       // Attribute lineStyle control line style
                                color: 'auto'
                            }
                        },
                        splitLine: {           // Divider
                            length :20,         // Attribute length Control line length
                            lineStyle: {       // Attribute lineStyle (see lineStyle) control line style
                                color: 'auto'
                            }
                        },
                        title : {
                            textStyle: {       // Remaining properties using the global default text style, see TEXTSTYLE
                                fontWeight: 'bolder',
                                fontSize: 20,
                                fontStyle: 'italic'
                            }
                        },
                        detail : {
                            textStyle: {       // Remaining properties using the global default text style, see TEXTSTYLE
                                fontWeight: 'bolder'
                            }
                        },
                        data:[{value: 40, name: 'km/h'}]
                    },
                    {
                        name:'Rotating speed',
                        type:'gauge',
                        center : ['15%', '55%'],    // Default global center
                        radius : '50%',
                        min:0,
                        max:7,
                        endAngle:45,
                        splitNumber:7,
                        axisLine: {            // Coordinate axis
                            lineStyle: {       // Attribute lineStyle control line style
                                width: 8
                            }
                        },
                        axisTick: {            // Axis small marker
                            length :12,        // Attribute length Control line length
                            lineStyle: {       // Attribute lineStyle control line style
                                color: 'auto'
                            }
                        },
                        splitLine: {           // Divider
                            length :20,         // Attribute length Control line length
                            lineStyle: {       // Attribute lineStyle (see lineStyle) control line style
                                color: 'auto'
                            }
                        },
                        pointer: {
                            width:5
                        },
                        title : {
                            offsetCenter: [0, '-30%'],       // X, y, units px
                        },
                        detail : {
                            textStyle: {       // Remaining properties using the global default text style, see TEXTSTYLE
                                fontWeight: 'bolder'
                            }
                        },
                        data:[{value: 1.5, name: 'x1000 r/min'}]
                    },
                    {
                        name:'Fuel meter',
                        type:'gauge',
                        center : ['85%', '50%'],    // Default global center
                        radius : '50%',
                        min:0,
                        max:2,
                        startAngle:135,
                        endAngle:45,
                        splitNumber:2,
                        axisLine: {            // Coordinate axis
                            lineStyle: {       // Attribute lineStyle control line style
                                color: [[0.2, '#ff4500'],[0.8, '#48b'],[1, '#228b22']], 
                                width: 8
                            }
                        },
                        axisTick: {            // Axis small marker
                            splitNumber:5,
                            length :10,        // Attribute length Control line length
                            lineStyle: {       // Attribute lineStyle control line style
                                color: 'auto'
                            }
                        },
                        axisLabel: {
                            formatter:function(v){
                                switch (v + '') {
                                    case '0' : return 'E';
                                    case '1' : return 'Gas';
                                    case '2' : return 'F';
                                }
                            }
                        },
                        splitLine: {           // Divider
                            length :15,         // Attribute length Control line length
                            lineStyle: {       // Attribute lineStyle (see lineStyle) control line style
                                color: 'auto'
                            }
                        },
                        pointer: {
                            width:2
                        },
                        title : {
                            show: false
                        },
                        detail : {
                            show: false
                        },
                        data:[{value: 0.5, name: 'gas'}]
                    },
                    {
                        name:'Meter',
                        type:'gauge',
                        center : ['85%', '50%'],    // Default global center
                        radius : '50%',
                        min:0,
                        max:2,
                        startAngle:315,
                        endAngle:225,
                        splitNumber:2,
                        axisLine: {            // Coordinate axis
                            lineStyle: {       // Attribute lineStyle control line style
                                color: [[0.2, '#ff4500'],[0.8, '#48b'],[1, '#228b22']], 
                                width: 8
                            }
                        },
                        axisTick: {            // Axis small marker
                            show: false
                        },
                        axisLabel: {
                            formatter:function(v){
                                switch (v + '') {
                                    case '0' : return 'H';
                                    case '1' : return 'Water';
                                    case '2' : return 'C';
                                }
                            }
                        },
                        splitLine: {           // Divider
                            length :15,         // Attribute length Control line length
                            lineStyle: {       // Attribute lineStyle (see lineStyle) control line style
                                color: 'auto'
                            }
                        },
                        pointer: {
                            width:2
                        },
                        title : {
                            show: false
                        },
                        detail : {
                            show: false
                        },
                        data:[{value: 0.5, name: 'gas'}]
                    }
                ]
            };

            // Apply options
            // ------------------------------

            myChart.setOption(multigaugeOptions);



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

                clearInterval(timeTicket);
                var timeTicket = setInterval(function (){
                    multigaugeOptions.series[0].data[0].value = (Math.random()*100).toFixed(2) - 0;
                    multigaugeOptions.series[1].data[0].value = (Math.random()*7).toFixed(2) - 0;
                    multigaugeOptions.series[2].data[0].value = (Math.random()*2).toFixed(2) - 0;
                    multigaugeOptions.series[3].data[0].value = (Math.random()*2).toFixed(2) - 0;
                    myChart.setOption(multigaugeOptions,true);
                },2000);
            });
        }
    );
});