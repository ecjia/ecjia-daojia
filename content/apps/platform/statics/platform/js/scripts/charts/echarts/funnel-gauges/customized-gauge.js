/*=========================================================================================
    File Name: customized-gauge.js
    Description: echarts customized gauge chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Customized gauge chart
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
            var myChart = ec.init(document.getElementById('customized-gauge'));

            // Chart Options
            // ------------------------------
            customgaugeOptions = {

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
                        name:'Business Index',
                        type:'gauge',
                        startAngle: 180,
                        endAngle: 0,
                        center : ['50%', '90%'],    // Default global center
                        radius : 320,
                        axisLine: {            // Coordinate axis
                            lineStyle: {       // Attribute lineStyle control line style
                                width: 200
                            }
                        },
                        axisTick: {            // Axis markers
                            splitNumber: 10,   // How many segments each split segment
                            length :12,        // Attribute length Control line length
                        },
                        axisLabel: {           // Axis text labels, see axis.axisLabel
                            formatter: function(v){
                                switch (v+''){
                                    case '10': return 'Low';
                                    case '50': return 'In';
                                    case '90': return 'High';
                                    default: return '';
                                }
                            },
                            textStyle: {       // Remaining properties using the global default text style, see TEXTSTYLE
                                color: '#fff',
                                fontSize: 15,
                                fontWeight: 'bolder'
                            }
                        },
                        pointer: {
                            width:50,
                            length: '90%',
                            color: 'rgba(255, 255, 255, 0.8)'
                        },
                        title : {
                            show : true,
                            offsetCenter: [0, '-60%'],       // x, y，Unit px
                            textStyle: {       // Remaining properties using the global default text style, see TEXTSTYLE
                                color: '#fff',
                                fontSize: 30
                            }
                        },
                        detail : {
                            show : true,
                            backgroundColor: 'rgba(0,0,0,0)',
                            borderWidth: 0,
                            borderColor: '#ccc',
                            width: 100,
                            height: 40,
                            offsetCenter: [0, -40],       // x, y，Unit px
                            formatter:'{value}%',
                            textStyle: {       // The remaining properties using the global default text style, see TEXTSTYLE
                                fontSize : 50
                            }
                        },
                        data:[{value: 50, name: 'Completion rate'}]
                    }
                ]
            };

            // Apply options
            // ------------------------------

            myChart.setOption(customgaugeOptions);



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
                    customgaugeOptions.series[0].data[0].value = (Math.random()*100).toFixed(2) - 0;
                    myChart.setOption(customgaugeOptions,true);
                },2000);
            });
        }
    );
});