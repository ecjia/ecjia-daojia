/*=========================================================================================
    File Name: invoice-sales-and-expenses.js
    Description: Invoice yearly sales and expenses bar chart.
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: GeeksLabs
    Author URL: http://www.themeforest.net/user/geekslabs
==========================================================================================*/

// invoice-sales-and-expenses
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
            var myChart = ec.init(document.getElementById('sales-and-expenses'));

            // Chart Options
            // ------------------------------
            chartOptions = {

                // Setup grid
                grid: {
                    x: 40,
                    x2: 40,
                    y: 35,
                    y2: 25
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis'
                },

                // Add legend
                legend: {
                    data: ['Total Sales', 'Total Receipts', 'Total Expenses']
                },

                // Add custom colors
                color: ['#3BAFDA','#37BC9B', '#F6BB42'],

                // Enable drag recalculate
                calculable: true,

                // Horizontal axis
                xAxis: [{
                    type: 'category',
                    data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                }],

                // Vertical axis
                yAxis: [{
                    type: 'value'
                }],

                // Add series
                series: [
                    {
                        name: 'Total Sales',
                        type: 'bar',
                        data: [1000, 1800, 1200, 0, 2000, 1500, 700, 900, 1600, 1400, 1550, 1800],
                    },
                    {
                        name: 'Total Receipts',
                        type: 'bar',
                        data: [850, 1650, 1000, 0, 1850, 1350, 450, 0, 1500, 900, 1250, 1500],
                    },
                    {
                        name: 'Total Expenses',
                        type: 'bar',
                        data: [50, 150, 100, 10, 850, 350, 0, 60, 250, 90, 120, 230],
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