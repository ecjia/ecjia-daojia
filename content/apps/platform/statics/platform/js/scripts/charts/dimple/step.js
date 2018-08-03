/*=========================================================================================
    File Name: step.js
    Description: Dimple step charts
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Theme
    Version: 1.2
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Step charts
// ------------------------------
$(window).on("load", function(){

    // Construct chart
	var single_step_line_svg            = dimple.newSvg("#single-step-line", "100%", 500);
	var multiple_step_line_svg          = dimple.newSvg("#multiple-step-line", "100%", 500);
	var grouped_multiple_step_line_svg  = dimple.newSvg("#grouped-multiple-step-line", "100%", 500);
	var multiple_vertical_step_line_svg = dimple.newSvg("#multiple-vertical-step-line", "100%", 500);
	var grouped_vertical_step_line_svg  = dimple.newSvg("#grouped-vertical-step-line", "100%", 500);
	var single_step_area_svg            = dimple.newSvg("#single-step-area", "100%", 500);
	var multiple_step_area_svg          = dimple.newSvg("#multiple-step-area", "100%", 500);
	var grouped_step_area_svg           = dimple.newSvg("#grouped-step-area", "100%", 500);
	var vertical_step_area_svg          = dimple.newSvg("#vertical-step-area", "100%", 500);
	var grouped_vertical_step_area_svg  = dimple.newSvg("#grouped-vertical-step-area", "100%", 500);


	// Chart setup
    // ------------------------------

    d3.tsv("../../../app-assets/data/dimple/example-data.tsv", function (data) {

		/************************************************
		*			Single Step Line Chart 				*
		************************************************/
        // Filter data
        data = dimple.filterData(data, "Owner", ["Aperture", "Black Mesa"]);


        // Create chart
        // ------------------------------

        // Define chart
        var singleStepLineChart = new dimple.chart(single_step_line_svg, data);

        // Set bounds
        singleStepLineChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        singleStepLineChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = singleStepLineChart.addCategoryAxis("x", "Month");
            x.addOrderRule("Date");

        // Vertical
        var y = singleStepLineChart.addMeasureAxis("y", "Unit Sales");

        // Construct layout
        // ------------------------------

        // Add line
        var s = singleStepLineChart.addSeries(null, dimple.plot.line);
            s.interpolation = "step";

        // Assign Color
        singleStepLineChart.defaultColors = [
            new dimple.color("#673AB7"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        singleStepLineChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



        /************************************************
		*			Multiple Step Line Chart 			*
		************************************************/
		// Filter data
        data = dimple.filterData(data, "Owner", ["Aperture", "Black Mesa"]);


        // Create chart
        // ------------------------------

        // Define chart
        var multipleStepLineChart = new dimple.chart(multiple_step_line_svg, data);

        // Set bounds
        multipleStepLineChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        multipleStepLineChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = multipleStepLineChart.addCategoryAxis("x", "Month");
            x.addOrderRule("Date");

        // Vertical
        var y = multipleStepLineChart.addMeasureAxis("y", "Unit Sales");

        // Construct layout
        // ------------------------------

        // Add line
        var s = multipleStepLineChart.addSeries("Channel", dimple.plot.line);
            s.interpolation = "step";

        // Assign Color
        multipleStepLineChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#F50057"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        multipleStepLineChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



		/************************************************************
		*			Grouped Multiple Step Line Chart 				*
		************************************************************/
		// Filter data
        data = dimple.filterData(data, "Owner", ["Aperture", "Black Mesa"]);


        // Create chart
        // ------------------------------

        // Define chart
        var groupedMultipleStepLineChart = new dimple.chart(grouped_multiple_step_line_svg, data);

        // Set bounds
        groupedMultipleStepLineChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        groupedMultipleStepLineChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = groupedMultipleStepLineChart.addCategoryAxis("x", "Month");
            x.addOrderRule("Date");

        // Vertical
        var y = groupedMultipleStepLineChart.addMeasureAxis("y", "Unit Sales");

        // Construct layout
        // ------------------------------

        // Add line
        var s = groupedMultipleStepLineChart.addSeries(["Brand"], dimple.plot.line);
            s.interpolation = "step";
            s.barGap = 0.05;

        // Assign Color
        groupedMultipleStepLineChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#F50057"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        groupedMultipleStepLineChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



		/************************************************************
		*			Multiple Vertical Step Line Chart 				*
		************************************************************/
		// Filter data
        data = dimple.filterData(data, "Owner", ["Aperture", "Black Mesa"]);


        // Create chart
        // ------------------------------

        // Define chart
        var multipleVerticalStepLineChart = new dimple.chart(multiple_vertical_step_line_svg, data);

        // Set bounds
        multipleVerticalStepLineChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        multipleVerticalStepLineChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = multipleVerticalStepLineChart.addMeasureAxis("x", "Unit Sales");

        // Vertical
        var y = multipleVerticalStepLineChart.addCategoryAxis("y", "Month");
            y.addOrderRule("Date");

        // Construct layout
        // ------------------------------

        // Add line
        var s = multipleVerticalStepLineChart.addSeries("Channel", dimple.plot.line);
            s.interpolation = "step";

        // Assign Color
        multipleVerticalStepLineChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#F50057"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        multipleVerticalStepLineChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



		/************************************************************
		*			Grouped Vertical Step Line Chart 				*
		************************************************************/
		// Filter data
        data = dimple.filterData(data, "Owner", ["Aperture", "Black Mesa"]);


        // Create chart
        // ------------------------------

        // Define chart
        var groupedVerticalStepLineChart = new dimple.chart(grouped_vertical_step_line_svg, data);

        // Set bounds
        groupedVerticalStepLineChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        groupedVerticalStepLineChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = groupedVerticalStepLineChart.addMeasureAxis("x", "Unit Sales");

        // Vertical
        var y = groupedVerticalStepLineChart.addCategoryAxis("y", ["Owner", "Month"]);
            y.addGroupOrderRule("Date");

        // Construct layout
        // ------------------------------

        // Add line
        var s = groupedVerticalStepLineChart.addSeries("Owner", dimple.plot.line);
            s.interpolation = "step";
            s.barGap = 0.05;

        // Assign Color
        groupedVerticalStepLineChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#F50057"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        groupedVerticalStepLineChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



		/************************************************
		*			Single Step Area Chart 				*
		************************************************/
		// Filter data
        data = dimple.filterData(data, "Owner", ["Aperture", "Black Mesa"]);


        // Create chart
        // ------------------------------

        // Define chart
        var singleStepAreaChart = new dimple.chart(single_step_area_svg, data);

        // Set bounds
        singleStepAreaChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        singleStepAreaChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = singleStepAreaChart.addCategoryAxis("x", "Month");
            x.addOrderRule("Date");

        // Vertical
        var y = singleStepAreaChart.addMeasureAxis("y", "Unit Sales");

        // Construct layout
        // ------------------------------

        // Add line
        var s = singleStepAreaChart.addSeries(null, dimple.plot.area);
            s.interpolation = "step";
            s.lineWeight = 1;

        // Assign Color
        singleStepAreaChart.defaultColors = [
            new dimple.color("#673AB7"), // Set a green fill
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";


        // Draw
        singleStepAreaChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



		/************************************************
		*			Multiple Step Area Chart 			*
		************************************************/
		// Filter data
        data = dimple.filterData(data, "Owner", ["Aperture", "Black Mesa"]);


        // Create chart
        // ------------------------------

        // Define chart
        var multipleStepAreaChart = new dimple.chart(multiple_step_area_svg, data);

        // Set bounds
        multipleStepAreaChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        multipleStepAreaChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = multipleStepAreaChart.addCategoryAxis("x", "Month");
            x.addOrderRule("Date");

        // Vertical
        var y = multipleStepAreaChart.addMeasureAxis("y", "Unit Sales");

        // Construct layout
        // ------------------------------

        // Add area
        var s = multipleStepAreaChart.addSeries("Channel", dimple.plot.area);
            s.interpolation = "step";
            s.lineWeight = 1;

        // Assign Color
        multipleStepAreaChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#F50057"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        multipleStepAreaChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



		/************************************************
		*			Grouped Step Area Chart 			*
		************************************************/
		// Filter data
        data = dimple.filterData(data, "Owner", ["Aperture", "Black Mesa"]);


        // Create chart
        // ------------------------------

        // Define chart
        var groupedStepAreaChart = new dimple.chart(grouped_step_area_svg, data);

        // Set bounds
        groupedStepAreaChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        groupedStepAreaChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = groupedStepAreaChart.addCategoryAxis("x", ["Owner", "Month"]);
            x.addGroupOrderRule("Date");

        // Vertical
        var y = groupedStepAreaChart.addMeasureAxis("y", "Unit Sales");

        // Construct layout
        // ------------------------------

        // Add area
        var s = groupedStepAreaChart.addSeries("Owner", dimple.plot.area);
            s.interpolation = "step";
            s.lineWeight = 1;
            s.barGap = 0.05;

        // Assign Color
        groupedStepAreaChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#F50057"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        groupedStepAreaChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



		/************************************************
		*			Vertical Step Area Chart 			*
		************************************************/
		// Filter data
        data = dimple.filterData(data, "Owner", ["Aperture", "Black Mesa"]);


        // Create chart
        // ------------------------------

        // Define chart
        var verticalStepAreaChart = new dimple.chart(vertical_step_area_svg, data);

        // Set bounds
        verticalStepAreaChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        verticalStepAreaChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = verticalStepAreaChart.addMeasureAxis("x", "Unit Sales");

        // Vertical
        var y = verticalStepAreaChart.addCategoryAxis("y", "Month");
            y.addOrderRule("Date");

        // Construct layout
        // ------------------------------

        // Add area
        var s = verticalStepAreaChart.addSeries("Channel", dimple.plot.area);
            s.interpolation = "step";
            s.lineWeight = 1;

        // Assign Color
        verticalStepAreaChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#F50057"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        verticalStepAreaChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



		/********************************************************
		*			Grouped Vertical Step Area Chart 			*
		********************************************************/
		// Filter data
        data = dimple.filterData(data, "Owner", ["Aperture", "Black Mesa"]);


        // Create chart
        // ------------------------------

        // Define chart
        var groupedVerticalStepAreaChart = new dimple.chart(grouped_vertical_step_area_svg, data);

        // Set bounds
        groupedVerticalStepAreaChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        groupedVerticalStepAreaChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = groupedVerticalStepAreaChart.addMeasureAxis("x", "Unit Sales");

        // Vertical
        var y = groupedVerticalStepAreaChart.addCategoryAxis("y", ["Owner", "Month"]);
            y.addGroupOrderRule("Date");

        // Construct layout
        // ------------------------------

        // Add area
        var s = groupedVerticalStepAreaChart.addSeries("Owner", dimple.plot.area);
            s.interpolation = "step";
            s.lineWeight = 1;
            s.barGap = 0.05;

        // Assign Color
        groupedVerticalStepAreaChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#F50057"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        groupedVerticalStepAreaChart.draw();

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
                singleStepLineChart.draw(0, true);
				multipleStepLineChart.draw(0, true);
				groupedMultipleStepLineChart.draw(0, true);
				multipleVerticalStepLineChart.draw(0, true);
				groupedVerticalStepLineChart.draw(0, true);
				singleStepAreaChart.draw(0, true);
				multipleStepAreaChart.draw(0, true);
				groupedStepAreaChart.draw(0, true);
				verticalStepAreaChart.draw(0, true);
				groupedVerticalStepAreaChart.draw(0, true);

                // Remove axis titles
                x.titleShape.remove();
                y.titleShape.remove();
            }, 100);
        }
    });
});