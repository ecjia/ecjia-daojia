/*=========================================================================================
    File Name: bar-column.js
    Description: Dimple bar & column charts
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Theme
    Version: 1.2
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Bar & Column charts
// ------------------------------
$(window).on("load", function(){

	// Construct chart
	var bar_svg                 = dimple.newSvg("#bar-chart", "100%", 500);
	var stacked_bar_svg         = dimple.newSvg("#stacked-bar", "100%", 500);
	var stacked_grouped_bar_svg = dimple.newSvg("#stacked-grouped-bar", "100%", 500);
	var floating_bar_svg        = dimple.newSvg("#floating-bars", "100%", 500);
	var column_svg              = dimple.newSvg("#column-chart", "100%", 500);
	var column_stacked_svg      = dimple.newSvg("#column-stacked", "100%", 500);
	var column_grouped_svg      = dimple.newSvg("#column-grouped", "100%", 500);
	var marimekko_svg           = dimple.newSvg("#marimekko-chart", "100%", 500);
	var block_matrix_svg        = dimple.newSvg("#block-matrix", "100%", 500);

	// Chart setup
    // ------------------------------

    d3.tsv("../../../app-assets/data/dimple/example-data.tsv", function (data) {


		/********************************
		*			Bar Chart 			*
		********************************/
		// Define chart
        var barChart = new dimple.chart(bar_svg, data);

        // Set bounds
        barChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        barChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = barChart.addMeasureAxis("x", "Unit Sales");

        // Vertical
        var y = barChart.addCategoryAxis("y", "Month");
            y.addOrderRule("Date");

        // Construct layout
        // ------------------------------

        // Add bar
        var s = barChart
            .addSeries(null, dimple.plot.bar);

        // Assign Color
        barChart.defaultColors = [
            new dimple.color("#673AB7"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        barChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



        /****************************************
		*			Stacked Bar Chart 			*
		****************************************/
		// Define chart
        var stackedBarChart = new dimple.chart(stacked_bar_svg, data);

        // Set bounds
        stackedBarChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        stackedBarChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = stackedBarChart.addMeasureAxis("x", "Unit Sales");

        // Vertical
        var y = stackedBarChart.addCategoryAxis("y", "Month");
            y.addOrderRule("Date");

        // Construct layout
        // ------------------------------

        // Add bar
        stackedBarChart.addSeries("Channel", dimple.plot.bar);


        // Assign Color
        stackedBarChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#E91E63"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        stackedBarChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



        /************************************************
		*			Stacked Grouped Bar Chart 			*
		************************************************/

        // Define chart
        var stackedGroupedBarChart = new dimple.chart(stacked_grouped_bar_svg, data);

        // Set bounds
        stackedGroupedBarChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        stackedGroupedBarChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = stackedGroupedBarChart.addPctAxis("x", "Unit Sales");

        // Vertical
        var y = stackedGroupedBarChart.addCategoryAxis("y", ["Price Tier", "Channel"]);

        // Construct layout
        // ------------------------------

        // Add line
        stackedGroupedBarChart.addSeries("Owner", dimple.plot.bar);

        // Assign Color
        stackedGroupedBarChart.defaultColors = [
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
        stackedGroupedBarChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



        /****************************************
		*			Floating Bar Chart 			*
		****************************************/
		// Define chart
        var floatingBarChart = new dimple.chart(floating_bar_svg, data);

        // Set bounds
        floatingBarChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        floatingBarChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = floatingBarChart.addMeasureAxis("x", "Unit Sales");

        // Vertical
        var y = floatingBarChart.addCategoryAxis("y", "Month");
            y.addOrderRule("Date");

        // Construct layout
        // ------------------------------

        // Add line
        var s = floatingBarChart.addSeries("Channel", dimple.plot.bar);
            s.stacked = false;

        // Assign Color
        floatingBarChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#E91E63"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";


        // Draw
        floatingBarChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



        /************************************
		*			Column Chart 			*
		************************************/
		// Define chart
        var columnChart = new dimple.chart(column_svg, data);

        // Set bounds
        columnChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        columnChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = columnChart.addCategoryAxis("x", "Month");
            x.addOrderRule("Date");

        // Vertical
        var y = columnChart.addMeasureAxis("y", "Unit Sales");

        // Construct layout
        // ------------------------------

        // Add bar
        var s = columnChart
            .addSeries(null, dimple.plot.bar);

        // Assign Color
        columnChart.defaultColors = [
            new dimple.color("#673AB7"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        columnChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



        /********************************************
		*			Column Stacked Chart 			*
		********************************************/
		// Define chart
        var columnStackedChart = new dimple.chart(column_stacked_svg, data);

        // Set bounds
        columnStackedChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        columnStackedChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = columnStackedChart.addCategoryAxis("x", "Month");
            x.addOrderRule("Date");

        // Vertical
        var y = columnStackedChart.addMeasureAxis("y", "Unit Sales");

        // Construct layout
        // ------------------------------

        // Add bar
        columnStackedChart.addSeries("Channel", dimple.plot.bar);

        // Assign Color
        columnStackedChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#E91E63"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";


        // Draw
        columnStackedChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



        /********************************************
		*			Column Grouped Chart 			*
		********************************************/
		// Define chart
        var columnGroupedChart = new dimple.chart(column_grouped_svg, data);

        // Set bounds
        columnGroupedChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        columnGroupedChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = columnGroupedChart.addCategoryAxis("x", ["Price Tier", "Channel"]);

        // Vertical
        var y = columnGroupedChart.addPctAxis("y", "Unit Sales");

        // Construct layout
        // ------------------------------

        // Add bar
        var s = columnGroupedChart.addSeries("Owner", dimple.plot.bar);

        // Assign Color
        columnGroupedChart.defaultColors = [
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
        columnGroupedChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



		/****************************************
		*			Marimekko Chart 			*
		****************************************/
		// Define chart
        var marimekkoChart = new dimple.chart(marimekko_svg, data);

        // Set bounds
        marimekkoChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        marimekkoChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = marimekkoChart.addPctAxis("x", "Unit Sales", "Channel");

        // Vertical
        var y = marimekkoChart.addPctAxis("y", "Unit Sales");

        // Construct layout
        // ------------------------------

        // Add bar
        var s = marimekkoChart.addSeries("Owner", dimple.plot.bar);

        // Assign Color
        marimekkoChart.defaultColors = [
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
        marimekkoChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



		/****************************************
		*			Block Matrix Chart 			*
		****************************************/
		// Define chart
        var blockMatrixChart = new dimple.chart(block_matrix_svg, data);

        // Set bounds
        blockMatrixChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        blockMatrixChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = blockMatrixChart.addCategoryAxis("x", ["Channel", "Price Tier"]);

        // Vertical
        var y = blockMatrixChart.addCategoryAxis("y", "Owner");

        // Construct layout
        // ------------------------------

        // Add line
        var s = blockMatrixChart.addSeries("Price Tier", dimple.plot.bar);

        // Assign Color
        blockMatrixChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#E91E63"),
            new dimple.color("#FF5722"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        blockMatrixChart.draw();

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
                barChart.draw(0, true);
                stackedBarChart.draw(0, true);
                stackedGroupedBarChart.draw(0, true);
                floatingBarChart.draw(0, true);
                columnChart.draw(0, true);
                columnStackedChart.draw(0, true);
                columnGroupedChart.draw(0, true);
                marimekkoChart.draw(0, true);
                blockMatrixChart.draw(0, true);

                // Remove axis titles
                x.titleShape.remove();
                y.titleShape.remove();
            }, 100);
        }
    });
});