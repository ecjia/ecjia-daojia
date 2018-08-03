/*=========================================================================================
    File Name: multi-dimensions-chord.js
    Description: echarts multi dimensions chord chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Multi dimensions chord chart
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
            var myChart = ec.init(document.getElementById('multiple-dimensions'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Add tooltip
                tooltip : {
                    trigger: 'item',
                    formatter : function (params) {
                        if (params.name && params.name.indexOf('-') != -1) {
                            return params.name.replace('-', ' ' + params.seriesName + ' ')
                        }
                        else {
                            return params.name ? params.name : params.data.id
                        }
                    }
                },

                // Add legend
                legend : {
                    data : [
                        'United States',
                        'Syrian opposition',
                        'Assad',
                        'Iran',
                        'Cecilio',
                        'Hamas',
                        'Israel',
                        'Muslim Brotherhood',
                        'Al-Qaida',
                        'Russia',
                        'Lebanese Shiites',
                        'Turkey',
                        'Qatar',
                        'Saudi Arabia',
                        'Lebanese Sunnis',
                        '',
                        'Stand by',
                        'Opposition',
                        'Undecided'
                    ],
                    orient : 'vertical',
                    x : 'left'
                },

                // Add custom colors
                color: ['#EF5350', '#66BB6A'],

                // Enable drag recalculate
                calculable: true,

                // Add series
                series : [
                    {
                        "name": "Stand by",
                        "type": "chord",
                        "showScaleText": false,
                        "clockWise": false,
                        "data": [
                            {"name": "United States"},
                            {"name": "Syrian opposition"},
                            {"name": "Assad"},
                            {"name": "Iran"},
                            {"name": "Cecilio"},
                            {"name": "Hamas"},
                            {"name": "Israel"},
                            {"name": "Muslim Brotherhood"},
                            {"name": "Al-Qaida"},
                            {"name": "Russia"},
                            {"name": "Lebanese Shiites"},
                            {"name": "Turkey"},
                            {"name": "Qatar"},
                            {"name": "Saudi Arabia"},
                            {"name": "Lebanese Sunnis"}
                        ],
                        "matrix": [
                            [0,100,0,0,0,0,100,0,0,0,0,0,0,0,0],
                            [10,0,0,0,0,10,10,0,10,0,0,10,10,10,10],
                            [0,0,0,10,0,0,0,0,0,10,10,0,0,0,0],
                            [0,0,100,0,0,100,0,0,0,0,100,0,0,0,0],
                            [0,0,0,0,0,0,0,0,0,0,0,0,0,10,0],
                            [0,100,0,10,0,0,0,0,0,0,0,0,10,0,0],
                            [10,100,0,0,0,0,0,0,0,0,0,0,0,0,0],
                            [0,0,0,0,0,0,0,0,0,0,0,10,10,0,0],
                            [0,100,0,0,0,0,0,0,0,0,0,0,0,0,0],
                            [0,0,100,0,0,0,0,0,0,0,0,0,0,0,0],
                            [0,0,100,10,0,0,0,0,0,0,0,0,0,0,0],
                            [0,100,0,0,0,0,0,100,0,0,0,0,0,0,0],
                            [0,100,0,0,0,100,0,100,0,0,0,0,0,0,0],
                            [0,100,0,0,100,0,0,0,0,0,0,0,0,0,100],
                            [0,100,0,0,0,0,0,0,0,0,0,0,0,10,0]
                        ]
                    },
                    {
                        "name": "Opposition",
                        "type": "chord",
                        "insertToSerie": "Stand by",
                        "data": [
                            {"name": "United States"},
                            {"name": "Syrian opposition"},
                            {"name": "Assad"},
                            {"name": "Iran"},
                            {"name": "Cecilio"},
                            {"name": "Hamas"},
                            {"name": "Israel"},
                            {"name": "Muslim Brotherhood"},
                            {"name": "Al-Qaida"},
                            {"name": "Russia"},
                            {"name": "Lebanese Shiites"},
                            {"name": "Turkey"},
                            {"name": "Qatar"},
                            {"name": "Saudi Arabia"},
                            {"name": "Lebanese Sunnis"}
                        ],
                        "matrix": [
                            [0,0,100,100,0,100,0,0,100,0,0,0,0,0,0],
                            [0,0,0,10,0,0,0,0,0,10,10,0,0,0,0],
                            [10,0,0,0,0,0,10,10,10,0,0,10,10,0,10],
                            [10,100,0,0,0,0,0,0,0,0,0,0,0,0,0],
                            [0,0,0,0,0,10,0,100,0,0,0,10,10,0,0],
                            [10,0,0,0,100,0,10,0,0,0,0,0,0,0,0],
                            [0,0,100,0,0,100,0,0,0,0,0,0,0,0,0],
                            [0,0,100,0,10,0,0,0,0,0,0,0,0,10,0],
                            [10,0,100,0,0,0,0,0,0,0,0,0,0,100,0],
                            [0,100,0,0,0,0,0,0,0,0,0,0,0,0,0],
                            [0,100,0,0,0,0,0,0,0,0,0,0,0,0,0],
                            [0,0,100,0,100,0,0,0,0,0,0,0,0,0,0],
                            [0,0,100,0,100,0,0,0,0,0,0,0,0,0,0],
                            [0,0,0,0,0,0,0,100,10,0,0,0,0,0,0],
                            [0,0,100,0,0,0,0,0,0,0,0,0,0,0,0]
                        ]
                    },
                    {
                        "name": "Undecided",
                        "type": "chord",
                        "insertToSerie": "Stand by",
                        "data": [
                            {"name": "United States"},
                            {"name": "Syrian opposition"},
                            {"name": "Assad"},
                            {"name": "Iran"},
                            {"name": "Cecilio"},
                            {"name": "Hamas"},
                            {"name": "Israel"},
                            {"name": "Muslim Brotherhood"},
                            {"name": "Al-Qaida"},
                            {"name": "Russia"},
                            {"name": "Lebanese Shiites"},
                            {"name": "Turkey"},
                            {"name": "Qatar"},
                            {"name": "Saudi Arabia"},
                            {"name": "Lebanese Sunnis"}
                        ],
                        "matrix": [
                            [0,0,0,0,100,0,0,100,0,0,0,0,0,0,0],
                            [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
                            [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
                            [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
                            [10,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
                            [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
                            [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
                            [10,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
                            [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
                            [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
                            [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
                            [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
                            [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
                            [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
                            [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]
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