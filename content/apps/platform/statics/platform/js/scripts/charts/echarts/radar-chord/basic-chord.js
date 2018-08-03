/*=========================================================================================
    File Name: basic-chord.js
    Description: echarts basic chord chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Basic chord chart
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
            'echarts/chart/radar',
            'echarts/chart/chord'
        ],


        // Charts setup
        function (ec) {
            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('basic-chord'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Add tooltip
                tooltip : {
                    trigger: 'item',
                    formatter: function (params) {
                        if (params.indicator2) { // is edge
                            return params.value.weight;
                        } else {// is node
                            return params.name
                        }
                    }
                },

                // Add legend
                legend: {
                    x: 'left',
                    data:['group1','group2', 'group3', 'group4']
                },

                // Add custom colors
                color: ['#99B898', '#FECEA8', '#FF847C', '#E84A5F'],

                // Enable drag recalculate
                calculable: true,

                // Add series
                series : [
                    {
                        type:'chord',
                        sort : 'ascending',
                        sortSub : 'descending',
                        showScale : true,
                        showScaleText : true,
                        data : [
                            {name : 'group1'},
                            {name : 'group2'},
                            {name : 'group3'},
                            {name : 'group4'}
                        ],
                        itemStyle : {
                            normal : {
                                label : {
                                    show : false
                                }
                            }
                        },
                        matrix : [
                            [11975,  5871, 8916, 2868],
                            [ 1951, 10048, 2060, 6171],
                            [ 8010, 16145, 8090, 8045],
                            [ 1013,   990,  940, 6907]
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