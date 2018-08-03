/*=========================================================================================
    File Name: line-area.js
    Description: Dimple simple line and area charts
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Theme
    Version: 1.2
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Line & Area charts
// ------------------------------
$(window).on("load", function(){

    // Construct chart
    var line_svg = dimple.newSvg("#line-chart", "100%", 500);
    var multi_line_svg = dimple.newSvg("#multi-line-chart", "100%", 500);
    var curvy_line_svg = dimple.newSvg("#curvy-line-chart", "100%", 500);
    var multi_vert_line_svg = dimple.newSvg("#multiple-vertical-line", "100%", 500);
    var dual_measure_line_svg = dimple.newSvg("#dual-measure-line", "100%", 500);
    var area_svg = dimple.newSvg("#area-chart", "100%", 500);
    var stacked_area_svg = dimple.newSvg("#stacked-area-chart", "100%", 500);
    var vert_stacked_area_svg = dimple.newSvg("#vertical-stacked-area", "100%", 500);
    var dual_measure_area_svg = dimple.newSvg("#dual-measure-area", "100%", 500);

    // Chart setup
    // ------------------------------

    d3.tsv("../../../app-assets/data/dimple/example-data.tsv", function (data) {

        /***************************************
        *              Line Chart              *
        ***************************************/
        // Filter data
        line_data = dimple.filterData(data, "Owner", ["Aperture", "Black Mesa"]);


        // Create chart
        // ------------------------------

        // Define chart
        var lineChart = new dimple.chart(line_svg, line_data);

        // Set bounds
        lineChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        lineChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = lineChart.addCategoryAxis("x", "Month");
            x.addOrderRule("Date");

        // Vertical
        var y = lineChart.addMeasureAxis("y", "Unit Sales");

        // Construct layout
        // ------------------------------

        // Add line
        var s = lineChart
            .addSeries(null, dimple.plot.line);
            // .interpolation = "basis";

        // Assign Color
        lineChart.defaultColors = [
            new dimple.color("#673AB7"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        lineChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();




        /*********************************************
        *              Multi Line Chart              *
        *********************************************/

        // Filter data
        multi_line_data = dimple.filterData(data, "Owner", ["Aperture", "Black Mesa"]);


        // Create chart
        // ------------------------------

        // Define chart
        var multiLineChart = new dimple.chart(multi_line_svg, multi_line_data);

        // Set bounds
        multiLineChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        multiLineChart.setMargins(40, 40, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = multiLineChart.addCategoryAxis("x", "Month");
            x.addOrderRule("Date");

        // Vertical
        var y = multiLineChart.addMeasureAxis("y", "Unit Sales");


        // Construct layout
        // ------------------------------

        // Add line
        multiLineChart.addSeries("Channel", dimple.plot.line);
        multiLineChart.addLegend(0, 10, "100%", "5%", "right");

        // Assign Color
        multiLineChart.defaultColors = [
            new dimple.color("#673AB7"), // Set a deep purple fill
            new dimple.color("#E91E63"), // Set a pink fill
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        multiLineChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();




        /*********************************************
        *              Curvy Line Chart              *
        *********************************************/
        // Filter data
        curvy_line_data = dimple.filterData(data, "Owner", ["Aperture", "Black Mesa"]);


        // Create chart
        // ------------------------------

        // Define chart
        var curvyLineChart = new dimple.chart(curvy_line_svg, curvy_line_data);

        // Set bounds
        curvyLineChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        curvyLineChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = curvyLineChart.addCategoryAxis("x", "Month");
            x.addOrderRule("Date");

        // Vertical
        var y = curvyLineChart.addMeasureAxis("y", "Unit Sales");


        // Construct layout
        // ------------------------------

        // Add line
        var s = curvyLineChart
            .addSeries("Channel", dimple.plot.line)
            .interpolation = "cardinal";

        // Assign Color
        curvyLineChart.defaultColors = [
            new dimple.color("#673AB7"), // Set a deep purple fill
            new dimple.color("#E91E63"), // Set a pink fill
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        curvyLineChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();




        /*********************************************************
        *              Multiple Vertical Line Chart              *
        *********************************************************/
        // Filter data
        multi_vert_line_data = dimple.filterData(data, "Owner", ["Aperture", "Black Mesa"]);


        // Create chart
        // ------------------------------

        // Define chart
        var multiVertLineChart = new dimple.chart(multi_vert_line_svg, multi_vert_line_data);

        // Set bounds
        multiVertLineChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        multiVertLineChart.setMargins(50, 50, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = multiVertLineChart.addMeasureAxis("x", "Unit Sales");

        // Vertical
        var y = multiVertLineChart.addCategoryAxis("y", "Month");
            y.addOrderRule("Date");


        // Construct layout
        // ------------------------------

        // Add line
        multiVertLineChart.addSeries("Channel", dimple.plot.line);
        multiVertLineChart.addLegend(0, 10, "100%", "5%", "right");

        // Assign Color
        multiVertLineChart.defaultColors = [
            new dimple.color("#673AB7"), // Set a deep purple fill
            new dimple.color("#E91E63"), // Set a pink fill
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        multiVertLineChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();




        /****************************************************
        *              Dual Measure Line Chart              *
        *****************************************************/

        // Define chart
        var dualMeasureLineChart = new dimple.chart(dual_measure_line_svg, data);

        // Set bounds
        dualMeasureLineChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        dualMeasureLineChart.setMargins(40, 50, 10, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = dualMeasureLineChart.addMeasureAxis("x", "Distribution");
            x.overrideMin = 20;

        // Vertical
        var y = dualMeasureLineChart.addMeasureAxis("y", "Price");
            y.overrideMin = 50;


        // Construct layout
        // ------------------------------

        // Add line
        var s = dualMeasureLineChart.addSeries(["Month", "Owner"], dimple.plot.line);
            s.addOrderRule("Date");
            s.aggregate = dimple.aggregateMethod.avg;
            dualMeasureLineChart.addLegend(0, 10, "100%", "5%", "right");

        // Assign Color
        dualMeasureLineChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#E91E63"),
            new dimple.color("#00BCD4"),
            new dimple.color("#FF5722"),
            new dimple.color("#FFC107"),
            new dimple.color("#009688"),
            new dimple.color("#3F51B5"),
            new dimple.color("#FFEB3B"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";


        // Draw
        dualMeasureLineChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



        /***************************************
        *              Area Chart              *
        ***************************************/
        // Filter data
        area_data = dimple.filterData(data, "Owner", ["Aperture", "Black Mesa"]);


        // Create chart
        // ------------------------------

        // Define chart
        var areaChart = new dimple.chart(area_svg, area_data);

        // Set bounds
        areaChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        areaChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = areaChart.addCategoryAxis("x", "Month");
            x.addOrderRule("Date");

        // Vertical
        var y = areaChart.addMeasureAxis("y", "Unit Sales");


        // Construct layout
        // ------------------------------

        // Add area
        var s = areaChart
            .addSeries(null, dimple.plot.area);

        // Assign Color
        areaChart.defaultColors = [
            new dimple.color("#673AB7"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";


        // Draw
        areaChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();


        /***********************************************
        *              Stacked Area Chart              *
        ***********************************************/

        // Filter data
        stacked_area_data = dimple.filterData(data, "Owner", ["Aperture", "Black Mesa"]);


        // Create chart
        // ------------------------------

        // Define chart
        var stackedAreaChart = new dimple.chart(stacked_area_svg, stacked_area_data);

        // Set bounds
        stackedAreaChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        stackedAreaChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = stackedAreaChart.addCategoryAxis("x", "Month");
            x.addOrderRule("Date");

        // Vertical
        var y = stackedAreaChart.addPctAxis("y", "Unit Sales");


        // Construct layout
        // ------------------------------

        // Add area
        var s = stackedAreaChart
            .addSeries("Channel", dimple.plot.area)
            .interpolation = "basis";

        // Assign Color
        stackedAreaChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#E91E63"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        stackedAreaChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();




        /***********************************************
        *              Stacked Area Chart              *
        ***********************************************/
        // Filter data
        vert_stacked_area_data = dimple.filterData(data, "Owner", ["Aperture", "Black Mesa"]);


        // Create chart
        // ------------------------------

        // Define chart
        var vertStackedAreaChart = new dimple.chart(vert_stacked_area_svg, vert_stacked_area_data);

        // Set bounds
        vertStackedAreaChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        vertStackedAreaChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = vertStackedAreaChart.addPctAxis("x", "Unit Sales");

        // Vertical
        var y = vertStackedAreaChart.addCategoryAxis("y", "Month");
            y.addOrderRule("Date");


        // Construct layout
        // ------------------------------

        // Add area
        var s = vertStackedAreaChart
            .addSeries("Channel", dimple.plot.area)
            .interpolation = "basis";

        // Assign Color
        vertStackedAreaChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#E91E63"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Font family
        x.fontFamily = "Roboto";
        y.fontFamily = "Roboto";

        // Draw
        vertStackedAreaChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();




        /****************************************************
        *              Dual measure Area Chart              *
        ****************************************************/
        // Define chart
        var dualMeasureAreaChart = new dimple.chart(dual_measure_area_svg, data);

        // Set bounds
        dualMeasureAreaChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        dualMeasureAreaChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = dualMeasureAreaChart.addMeasureAxis("x", "Distribution");

        // Vertical
        var y = dualMeasureAreaChart.addMeasureAxis("y", "Price");


        // Construct layout
        // ------------------------------

        // Add area
        var s = dualMeasureAreaChart
            .addSeries(["SKU", "Price Tier"], dimple.plot.area)
            .interpolation = "basis";

        // Assign Color
        dualMeasureAreaChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#E91E63"),
            new dimple.color("#FF5722") // Set a blue fill
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Font family
        x.fontFamily = "Roboto";
        y.fontFamily = "Roboto";

        // Draw
        dualMeasureAreaChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();


        // Resize chart
        // ------------------------------

        // Add a method to draw the chart on resize of the window
        $(window).on('resize', resize);
        $(".menu-toggle").on('click', resize);

        // Resize function
        function resize() {
            setTimeout(function() {

                // Redraw chart
                lineChart.draw(0, true);
                multiLineChart.draw(0, true);
                curvyLineChart.draw(0, true);
                multiVertLineChart.draw(0, true);
                dualMeasureLineChart.draw(0, true);
                areaChart.draw(0, true);
                stackedAreaChart.draw(0, true);
                vertStackedAreaChart.draw(0, true);
                dualMeasureAreaChart.draw(0, true);

                // Remove axis titles
                x.titleShape.remove();
                y.titleShape.remove();
            }, 100);
        }
    });
});