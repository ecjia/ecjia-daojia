/*=========================================================================================
    File Name: basic-gauge.js
    Description: echarts basic gauge chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Basic gauge chart
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
            var myChart = ec.init(document.getElementById('basic-gauge'));

            // Chart Options
            // ------------------------------
            basicgaugeOptions = {

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
                        detail : {formatter:'{value}%'},
                        data:[{value: 50, name: 'Completion rate'}]
                    }
                ]
            };

            // Apply options
            // ------------------------------

            myChart.setOption(basicgaugeOptions);



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
                    basicgaugeOptions.series[0].data[0].value = (Math.random()*100).toFixed(2) - 0;
                    myChart.setOption(basicgaugeOptions, true);
                },2000);
            });
        }
    );
});