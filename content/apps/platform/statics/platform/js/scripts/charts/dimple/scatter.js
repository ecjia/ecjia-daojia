/*=========================================================================================
    File Name: scatter.js
    Description: Dimple scatter chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Theme
    Version: 1.2
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Scatter chart
// ------------------------------
$(window).on("load", function(){

    // Construct chart
	var scatter_chart_svg               = dimple.newSvg("#scatter-chart", "100%", 500);
	var vertical_lollipop_scatter_svg   = dimple.newSvg("#vertical-lollipop-scatter", "100%", 500);
	var horizontal_lollipop_scatter_svg = dimple.newSvg("#horizontal-lollipop-scatter", "100%", 500);
	var dot_matrix_svg                  = dimple.newSvg("#dot-matrix", "100%", 500);


    // Chart setup
    // ------------------------------

    d3.tsv("../../../app-assets/data/dimple/example-data.tsv", function (data) {

		/************************************
		*			Scatter Chart 			*
		************************************/
		// Filter data
        scatter_chart_data = dimple.filterData(data, "Date", "01/12/2012");


        // Create chart
        // ------------------------------

        // Define chart
        var scatterChartChart = new dimple.chart(scatter_chart_svg, scatter_chart_data);

        // Set bounds
        scatterChartChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        scatterChartChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = scatterChartChart.addMeasureAxis("x", "Unit Sales");

        // Vertical
        var y = scatterChartChart.addMeasureAxis("y", "Operating Profit");

        // Construct layout
        // ------------------------------

        // Add bubble
        scatterChartChart.addSeries(["SKU", "Channel"], dimple.plot.bubble);

        // Assign Color
        scatterChartChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#E91E63"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        scatterChartChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



		/********************************************************
		*			Vertical Lollipop Scatter Chart 			*
		********************************************************/
		// Define chart
        var verticalLollipopScatterChart = new dimple.chart(vertical_lollipop_scatter_svg, data);

        // Set bounds
        verticalLollipopScatterChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        verticalLollipopScatterChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = verticalLollipopScatterChart.addCategoryAxis("x", "Month");
            x.addOrderRule("Date");

        // Vertical
        var y = verticalLollipopScatterChart.addMeasureAxis("y", "Unit Sales");

        // Construct layout
        // ------------------------------

        // Add bubble
        var s = verticalLollipopScatterChart.addSeries("Channel", dimple.plot.bubble);

        // Assign Color
        verticalLollipopScatterChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#E91E63"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        verticalLollipopScatterChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



		/********************************************************
		*			Horizontal Lollipop Scatter Chart 			*
		********************************************************/
		// Define chart
        var horizontalLollipopScatterChart = new dimple.chart(horizontal_lollipop_scatter_svg, data);

        // Set bounds
        horizontalLollipopScatterChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        horizontalLollipopScatterChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = horizontalLollipopScatterChart.addMeasureAxis("x", "Unit Sales");

        // Vertical
        var y = horizontalLollipopScatterChart.addCategoryAxis("y", "Month");
            y.addOrderRule("Date");

        // Construct layout
        // ------------------------------

        // Add bubble
        var s = horizontalLollipopScatterChart.addSeries("Channel", dimple.plot.bubble);

        // Assign Color
        horizontalLollipopScatterChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#E91E63"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        horizontalLollipopScatterChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



		/****************************************
		*			Dot Matrix Chart 			*
		****************************************/
		// Define chart
        var dotMatrixChart = new dimple.chart(dot_matrix_svg, data);

        // Set bounds
        dotMatrixChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        dotMatrixChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = dotMatrixChart.addCategoryAxis("x", ["Channel", "Price Tier"]);

        // Vertical
        var y = dotMatrixChart.addCategoryAxis("y", "Owner");

        // Construct layout
        // ------------------------------

        // Add bubble
        var s = dotMatrixChart.addSeries("Price Tier", dimple.plot.bubble);

        // Assign Color
        dotMatrixChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#E91E63"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        dotMatrixChart.draw();

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
                scatterChartChart.draw(0, true);
				verticalLollipopScatterChart.draw(0, true);
				horizontalLollipopScatterChart.draw(0, true);
				dotMatrixChart.draw(0, true);

                // Remove axis titles
                x.titleShape.remove();
                y.titleShape.remove();
            }, 100);
        }
    });
});