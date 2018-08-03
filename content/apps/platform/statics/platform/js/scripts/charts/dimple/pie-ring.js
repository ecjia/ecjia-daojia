/*=========================================================================================
    File Name: pie-ring.js
    Description: Dimple pie & ring charts
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Theme
    Version: 1.2
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Pie & Ring charts
// ------------------------------
$(window).on("load", function(){

	// Construct chart
	var pie_svg             = dimple.newSvg("#pie-chart", "100%", 500);
	var pie_matrix_svg      = dimple.newSvg("#pie-matrix", "100%", 500);
	var pie_lollipop_svg    = dimple.newSvg("#pie-lollipop", "100%", 500);
	var pie_glollipop_svg   = dimple.newSvg("#pie-grouped-lollipop", "100%", 500);
	var pie_bubble_svg      = dimple.newSvg("#pie-bubble", "100%", 500);
	var pie_scatter_svg     = dimple.newSvg("#pie-scatter", "100%", 500);
	var ring_svg            = dimple.newSvg("#ring-chart", "100%", 500);
	var ring_matrix_svg     = dimple.newSvg("#ring-matrix", "100%", 500);
	var ring_lollipop_svg   = dimple.newSvg("#ring-lollipop", "100%", 500);
	var ring_glollipop_svg  = dimple.newSvg("#ring-grouped-lollipop", "100%", 500);
	var ring_concentric_svg = dimple.newSvg("#ring-concentric", "100%", 500);
	var ring_scatter_svg    = dimple.newSvg("#ring-scatter", "100%", 500);

    // Chart setup
    // ------------------------------

    d3.tsv("../../../app-assets/data/dimple/example-data.tsv", function (data) {


		/********************************
		*			Pie Chart 			*
		********************************/
		// Define chart
        var pieChart = new dimple.chart(pie_svg, data);

        // Set bounds
        pieChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        pieChart.setMargins(40, 10, 0, 50);


        // Create Pie
        // ------------------------------
        pieChart.addMeasureAxis("p", "Unit Sales");

        // Construct layout
        // ------------------------------

        // Add pie
        pieChart.addSeries("Owner", dimple.plot.pie);
        pieChart.addLegend("85%", 20, 90, 300, "right");

        // Assign Color
        pieChart.defaultColors = [
            new dimple.color("#99B898"),
            new dimple.color("#FECEA8"),
            new dimple.color("#FF847C"),
            new dimple.color("#E84A5F"),
            new dimple.color("#2A363B"),
            new dimple.color("#37BC9B"),
            new dimple.color("#F6BB42"),
            new dimple.color("#3BAFDA"),
        ];

        // Draw
        pieChart.draw();




        /****************************************
		*			Pie Matrix Chart 			*
		****************************************/
		// Define chart
        var pieMatrixChart = new dimple.chart(pie_matrix_svg, data);

        // Set bounds
        pieMatrixChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        pieMatrixChart.setMargins(40, 10, 0, 50);


        // Create Pie
        // ------------------------------
        var x = pieMatrixChart.addCategoryAxis("x", "Price Tier");

        var y = pieMatrixChart.addCategoryAxis("y", "Pack Size");

        pieMatrixChart.addMeasureAxis("p", "Unit Sales");

        // Construct layout
        // ------------------------------

        // Add pie
        var pies = pieMatrixChart.addSeries("Channel", dimple.plot.pie);
            pies.radius = 25;

        pieMatrixChart.addLegend(0, 10, "100%", "5%", "right");

        // Assign Color
        pieMatrixChart.defaultColors = [
            new dimple.color("#99B898"),
            new dimple.color("#FECEA8"),
            new dimple.color("#FF847C"),
            new dimple.color("#E84A5F"),
            new dimple.color("#2A363B"),
            new dimple.color("#37BC9B"),
            new dimple.color("#F6BB42"),
            new dimple.color("#3BAFDA"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";


        // Draw
        pieMatrixChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



		/****************************************
		*			Pie Lollipop Chart 			*
		****************************************/
		// overriding data
        pie_lollipop_data = dimple.filterData(data, "Date", [
          "01/07/2012", "01/08/2012", "01/09/2012",
          "01/10/2012", "01/11/2012", "01/12/2012"]);

        // Create chart
        // ------------------------------

        // Define chart
        var pieLollipopChart = new dimple.chart(pie_lollipop_svg, pie_lollipop_data);

        // Set bounds
        pieLollipopChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        pieLollipopChart.setMargins(40, 40, 0, 50);


        // Create Pie
        // ------------------------------
        var x = pieLollipopChart.addCategoryAxis("x", "Month");
        x.addOrderRule("Date");

        var y = pieLollipopChart.addMeasureAxis("y", "Unit Sales");

        pieLollipopChart.addMeasureAxis("p", "Unit Sales");

        // Construct layout
        // ------------------------------

        // Add pie
        var pies = pieLollipopChart.addSeries("Channel", dimple.plot.pie);
            pies.radius = 20;

        pieLollipopChart.addLegend(0, 10, "100%", "5%", "right");

        // Assign Color
        pieLollipopChart.defaultColors = [
            new dimple.color("#99B898"),
            new dimple.color("#FECEA8"),
            new dimple.color("#FF847C"),
            new dimple.color("#E84A5F"),
            new dimple.color("#2A363B"),
            new dimple.color("#37BC9B"),
            new dimple.color("#F6BB42"),
            new dimple.color("#3BAFDA"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        pieLollipopChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



		/************************************************
		*			Pie Grouped Lollipop Chart 			*
		************************************************/
		// Define chart
        var pieGlollipopChart = new dimple.chart(pie_glollipop_svg, data);

        // Set bounds
        pieGlollipopChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        pieGlollipopChart.setMargins(40, 40, 0, 50);


        // Create Pie
        // ------------------------------
        var x = pieGlollipopChart.addCategoryAxis("x", ["Price Tier", "Channel"]);

        var y = pieGlollipopChart.addMeasureAxis("y", "Unit Sales");

        pieGlollipopChart.addMeasureAxis("p", "Unit Sales");

        // Construct layout
        // ------------------------------

        // Add pie
        var pies = pieGlollipopChart.addSeries("Owner", dimple.plot.pie);
            pies.radius = 20;

        pieGlollipopChart.addLegend(0, 10, "100%", "5%", "right");

        // Assign Color
        pieGlollipopChart.defaultColors = [
            new dimple.color("#99B898"),
            new dimple.color("#FECEA8"),
            new dimple.color("#FF847C"),
            new dimple.color("#E84A5F"),
            new dimple.color("#2A363B"),
            new dimple.color("#37BC9B"),
            new dimple.color("#F6BB42"),
            new dimple.color("#3BAFDA"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        pieGlollipopChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



		/****************************************
		*			Pie Bubble Chart 			*
		****************************************/
		// Filter Data
        pie_bubble_data = dimple.filterData(data, "Date", "01/12/2012");

        // Create chart
        // ------------------------------

        // Define chart
        var pieBubbleChart = new dimple.chart(pie_bubble_svg, pie_bubble_data);

        // Set bounds
        pieBubbleChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        pieBubbleChart.setMargins(40, 40, 0, 50);


        // Create Pie
        // ------------------------------
        var x = pieBubbleChart.addMeasureAxis("x", "Price Monthly Change");

        var y = pieBubbleChart.addMeasureAxis("y", "Unit Sales Monthly Change");

        var z = pieBubbleChart.addMeasureAxis("z", "Operating Profit");

        pieBubbleChart.addMeasureAxis("p", "Operating Profit");

        // Construct layout
        // ------------------------------

        // Add pie
        var rings = pieBubbleChart.addSeries(["Owner", "Channel"], dimple.plot.pie);

        pieBubbleChart.addLegend(0, 10, "100%", "5%", "right");

        // Assign Color
        pieBubbleChart.defaultColors = [
            new dimple.color("#99B898"),
            new dimple.color("#FECEA8"),
            new dimple.color("#FF847C"),
            new dimple.color("#E84A5F"),
            new dimple.color("#2A363B"),
            new dimple.color("#37BC9B"),
            new dimple.color("#F6BB42"),
            new dimple.color("#3BAFDA"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";


        // Draw
        pieBubbleChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



		/****************************************
		*			Pie Scatter Chart 			*
		****************************************/
		// Filter data
        pie_scatter_data = dimple.filterData(data, "Date", "01/12/2012");

        // Create chart
        // ------------------------------

        // Define chart
        var pieScatterChart = new dimple.chart(pie_scatter_svg, pie_scatter_data);

        // Set bounds
        pieScatterChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        pieScatterChart.setMargins(40, 40, 0, 50);


        // Create Pie
        // ------------------------------
        var x = pieScatterChart.addMeasureAxis("x", "Price Monthly Change");

        var y = pieScatterChart.addMeasureAxis("y", "Unit Sales Monthly Change");

        pieScatterChart.addMeasureAxis("p", "Operating Profit");

        // Construct layout
        // ------------------------------

        // Add pie
        var pies = pieScatterChart.addSeries(["Owner", "Channel"], dimple.plot.pie);
            pies.radius = 20;

        pieScatterChart.addLegend(0, 10, "100%", "5%", "right");

        // Assign Color
        pieScatterChart.defaultColors = [
            new dimple.color("#99B898"),
            new dimple.color("#FECEA8"),
            new dimple.color("#FF847C"),
            new dimple.color("#E84A5F"),
            new dimple.color("#2A363B"),
            new dimple.color("#37BC9B"),
            new dimple.color("#F6BB42"),
            new dimple.color("#3BAFDA"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";


        // Draw
        pieScatterChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



		/********************************
		*			Ring Chart 			*
		********************************/
		// Define chart
        var ringChart = new dimple.chart(ring_svg, data);

        // Set bounds
        ringChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        ringChart.setMargins(40, 10, 0, 50);


        // Create Pie
        // ------------------------------
        ringChart.addMeasureAxis("p", "Unit Sales");

        // Construct layout
        // ------------------------------

        // Add pie
        var ring = ringChart.addSeries("Owner", dimple.plot.pie);
            ring.innerRadius = "50%";

        ringChart.addLegend("85%", 20, 90, 300, "right");

        // Assign Color
        ringChart.defaultColors = [
            new dimple.color("#99B898"),
            new dimple.color("#FECEA8"),
            new dimple.color("#FF847C"),
            new dimple.color("#E84A5F"),
            new dimple.color("#2A363B"),
            new dimple.color("#37BC9B"),
            new dimple.color("#F6BB42"),
            new dimple.color("#3BAFDA"),
        ];

        // Draw
        ringChart.draw();



		/****************************************
		*			Ring Matrix Chart 			*
		****************************************/
		// Define chart
        var ringMatrixChart = new dimple.chart(ring_matrix_svg, data);

        // Set bounds
        ringMatrixChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        ringMatrixChart.setMargins(40, 10, 0, 50);


        // Create Pie
        // ------------------------------
        var x = ringMatrixChart.addCategoryAxis("x", "Price Tier");

        var y = ringMatrixChart.addCategoryAxis("y", "Pack Size");

        ringMatrixChart.addMeasureAxis("p", "Unit Sales");

        // Construct layout
        // ------------------------------

        // Add pie
        var rings = ringMatrixChart.addSeries("Channel", dimple.plot.pie);
            rings.innerRadius = 15;
            rings.outerRadius = 25;

        ringMatrixChart.addLegend(0, 10, "100%", "5%", "right");

        // Assign Color
        ringMatrixChart.defaultColors = [
            new dimple.color("#99B898"),
            new dimple.color("#FECEA8"),
            new dimple.color("#FF847C"),
            new dimple.color("#E84A5F"),
            new dimple.color("#2A363B"),
            new dimple.color("#37BC9B"),
            new dimple.color("#F6BB42"),
            new dimple.color("#3BAFDA"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        ringMatrixChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



		/********************************************
		*			Ring Lollipop Chart 			*
		********************************************/
		// Overriding data
        ring_lollipop_data = dimple.filterData(data, "Date", [
          "01/07/2012", "01/08/2012", "01/09/2012",
          "01/10/2012", "01/11/2012", "01/12/2012"]);

        // Create chart
        // ------------------------------

        // Define chart
        var ringLollipopChart = new dimple.chart(ring_lollipop_svg, ring_lollipop_data);

        // Set bounds
        ringLollipopChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        ringLollipopChart.setMargins(40, 40, 0, 50);


        // Create Pie
        // ------------------------------
        var x = ringLollipopChart.addCategoryAxis("x", "Month");
            x.addOrderRule("Date");

        var y = ringLollipopChart.addMeasureAxis("y", "Unit Sales");

        ringLollipopChart.addMeasureAxis("p", "Unit Sales");

        // Construct layout
        // ------------------------------

        // Add pie
        var rings = ringLollipopChart.addSeries("Channel", dimple.plot.pie);
            rings.innerRadius = 15;
            rings.outerRadius = 20;

        ringLollipopChart.addLegend(0, 10, "100%", "5%", "right");

        // Assign Color
        ringLollipopChart.defaultColors = [
            new dimple.color("#99B898"),
            new dimple.color("#FECEA8"),
            new dimple.color("#FF847C"),
            new dimple.color("#E84A5F"),
            new dimple.color("#2A363B"),
            new dimple.color("#37BC9B"),
            new dimple.color("#F6BB42"),
            new dimple.color("#3BAFDA"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        ringLollipopChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();




		/****************************************************
		*			Ring Grouped Lollipop Chart 			*
		****************************************************/
		// Define chart
        var ringGlollipopChart = new dimple.chart(ring_glollipop_svg, data);

        // Set bounds
        ringGlollipopChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        ringGlollipopChart.setMargins(40, 40, 0, 50);


        // Create Pie
        // ------------------------------
        var x = ringGlollipopChart.addCategoryAxis("x", ["Price Tier", "Channel"]);

        var y = ringGlollipopChart.addMeasureAxis("y", "Unit Sales");

        ringGlollipopChart.addMeasureAxis("p", "Unit Sales");

        // Construct layout
        // ------------------------------

        // Add pie
        var rings = ringGlollipopChart.addSeries("Pack Size", dimple.plot.pie);
            rings.innerRadius = 20;
            rings.outerRadius = 30;

        ringGlollipopChart.addLegend(0, 10, "100%", "5%", "right");

        // Assign Color
        ringGlollipopChart.defaultColors = [
            new dimple.color("#99B898"),
            new dimple.color("#FECEA8"),
            new dimple.color("#FF847C"),
            new dimple.color("#E84A5F"),
            new dimple.color("#2A363B"),
            new dimple.color("#37BC9B"),
            new dimple.color("#F6BB42"),
            new dimple.color("#3BAFDA"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        ringGlollipopChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();




		/********************************************
		*			Ring Concentric Chart 			*
		********************************************/
		// Define chart
        var ringConcentricChart = new dimple.chart(ring_concentric_svg, data);

        // Set bounds
        ringConcentricChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        ringConcentricChart.setMargins(40, 40, 0, 50);


        // Create Pie
        // ------------------------------
        ringConcentricChart.addMeasureAxis("p", "Unit Sales");

        // Construct layout
        // ------------------------------

        // Add pie
        var outerRing = ringConcentricChart.addSeries("Channel", dimple.plot.pie);
        var innerRing = ringConcentricChart.addSeries("Price Tier", dimple.plot.pie);

        // Negatives are calculated from outside edge, positives from center
        outerRing.innerRadius = "-30px";
        innerRing.outerRadius = "-40px";
        innerRing.innerRadius = "-70px";

        ringConcentricChart.addLegend(0, 10, "100%", "5%", "right");

        // Assign Color
        ringConcentricChart.defaultColors = [
            new dimple.color("#99B898"),
            new dimple.color("#FECEA8"),
            new dimple.color("#FF847C"),
            new dimple.color("#E84A5F"),
            new dimple.color("#2A363B"),
            new dimple.color("#37BC9B"),
            new dimple.color("#F6BB42"),
            new dimple.color("#3BAFDA"),
        ];

        // Draw
        ringConcentricChart.draw();



		/****************************************
		*			Ring Scatter Chart 			*
		****************************************/
		// Filter data
        ring_scatter_data = dimple.filterData(data, "Date", "01/12/2012");

        // Create chart
        // ------------------------------

        // Define chart
        var ringScatterChart = new dimple.chart(ring_scatter_svg, ring_scatter_data);

        // Set bounds
        ringScatterChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        ringScatterChart.setMargins(40, 40, 0, 50);


        // Create Pie
        // ------------------------------
        var x = ringScatterChart.addMeasureAxis("x", "Unit Sales Monthly Change");

        var y = ringScatterChart.addMeasureAxis("y", "Price Monthly Change");

        ringScatterChart.addMeasureAxis("p", "Operating Profit");

        // Construct layout
        // ------------------------------

        // Add pie
        var rings = ringScatterChart.addSeries(["Owner", "Channel"], dimple.plot.pie);
            rings.innerRadius = 20;
            rings.outerRadius = 25;

        ringScatterChart.addLegend(0, 10, "100%", "5%", "right");

        // Assign Color
        ringScatterChart.defaultColors = [
            new dimple.color("#99B898"),
            new dimple.color("#FECEA8"),
            new dimple.color("#FF847C"),
            new dimple.color("#E84A5F"),
            new dimple.color("#2A363B"),
            new dimple.color("#37BC9B"),
            new dimple.color("#F6BB42"),
            new dimple.color("#3BAFDA"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";


        // Draw
        ringScatterChart.draw();

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
                pieChart.draw(0, true);
				pieMatrixChart.draw(0, true);
				pieLollipopChart.draw(0, true);
				pieGlollipopChart.draw(0, true);
				pieBubbleChart.draw(0, true);
				pieScatterChart.draw(0, true);
				ringChart.draw(0, true);
				ringMatrixChart.draw(0, true);
				ringLollipopChart.draw(0, true);
				ringGlollipopChart.draw(0, true);
				ringConcentricChart.draw(0, true);
				ringScatterChart.draw(0, true);

                // Remove axis titles
                x.titleShape.remove();
                y.titleShape.remove();

            }, 100);
        }
    });
});