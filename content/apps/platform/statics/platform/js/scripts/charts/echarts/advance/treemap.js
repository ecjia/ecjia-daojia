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
            'echarts/chart/treemap',
        ],


        // Charts setup
        function (ec) {
            // Initialize chart
            // ------------------------------
            var myChart = ec.init(document.getElementById('tree-map'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Add tooltip
                tooltip : {
                    trigger: 'item',
                    formatter: "{b}: {c}"
                },

                // Enable drag recalculate
                calculable: true,

                // Add series
                series : [
                    {
                        name:'Phone share',
                        type:'treemap',
                        itemStyle: {
                            normal: {
                                label: {
                                    show: true,
                                    formatter: "{b}"
                                },
                                borderWidth: 1,
                                borderColor: '#FFF'
                            },
                            emphasis: {
                                label: {
                                    show: true
                                },
                                color: '#cc99cc',
                                borderWidth: 3,
                                borderColor: '#996699'
                            }
                        },
                        data:[
                            {
                                name: 'Samsung',
                                itemStyle: {
                                    normal: {
                                        color: '#99B898',
                                    }
                                },
                                value: 6,
                                children: [
                                    {
                                        name: 'Galaxy S4',
                                        value: 2
                                    },
                                    {
                                        name: 'Galaxy S5',
                                        value: 3
                                    },
                                    {
                                        name: 'Galaxy S6',
                                        value: 3
                                    },
                                    {
                                        name: 'Galaxy Tab',
                                        value: 1
                                    }
                                ]
                            },
                            {
                                name: 'HTC',
                                itemStyle: {
                                    normal: {
                                        color: '#FECEA8',
                                    }
                                },
                                value: 4,
                                children: [
                                    {
                                        name: 'HTC M8',
                                        value: 6
                                    },
                                    {
                                        name: 'HTC M9',
                                        value: 6
                                    },
                                    {
                                        name: 'HTC M10',
                                        value: 4
                                    }
                                ]
                            },
                            {
                                name: 'Apple',
                                itemStyle: {
                                    normal: {
                                        color: '#FF847C',
                                    }
                                },
                                value: 4,
                                children: [
                                    {
                                        name: 'iPhone 5s',
                                        value: 6
                                    },
                                    {
                                        name: 'iPhone 6',
                                        value: 3
                                    },
                                    {
                                        name: 'iPhone 6+',
                                        value: 3
                                    }
                                ]
                            },
                            {
                                name: 'Meizu',
                                itemStyle: {
                                    normal: {
                                        color: '#E84A5F',
                                    }
                                },
                                value: 1,
                                children: [
                                    {
                                        name: 'MX4',
                                        itemStyle: {
                                            normal: {
                                                color: '#ccccff',
                                            }
                                        },
                                        value: 6
                                    },
                                    {
                                        name: 'MX3',
                                        itemStyle: {
                                            normal: {
                                                color: '#99ccff',
                                            }
                                        },
                                        value: 6
                                    },
                                    {
                                        name: 'Blue Charm note',
                                        itemStyle: {
                                            normal: {
                                                color: '#9999cc',
                                            }
                                        },
                                        value: 4
                                    },
                                    {
                                        name: 'MX4 pro',
                                        itemStyle: {
                                            normal: {
                                                color: '#99cccc',
                                            }
                                        },
                                        value: 3
                                    }
                                ]
                            },
                            {
                                name: 'Huawei',
                                itemStyle: {
                                    normal: {
                                        color: '#ECE473',
                                    }
                                },
                                value: 2
                            },
                            {
                                name: 'Association',
                                itemStyle: {
                                    normal: {
                                        color: '#F9D423',
                                    }
                                },
                                value: 2
                            },
                            {
                                name: 'ZTE',
                                itemStyle: {
                                    normal: {
                                        color: '#F6903D',
                                    }
                                },
                                value: 1,
                                children: [
                                    {
                                        name: 'V5',
                                        value: 16
                                    },
                                    {
                                        name: 'Nubian',
                                        value: 6
                                    },
                                    {
                                        name: 'Functional machine',
                                        value: 4
                                    },
                                    {
                                        name: 'Yang Qing',
                                        value: 4
                                    },
                                    {
                                        name: 'Star',
                                        value: 4
                                    },
                                    {
                                        name: "Children's Machine",
                                        value: 1
                                    }
                                ]
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