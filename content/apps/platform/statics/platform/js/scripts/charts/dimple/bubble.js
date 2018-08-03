/*=========================================================================================
    File Name: bubble.js
    Description: Dimple bubble charts
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Theme
    Version: 1.2
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Bubble charts
// ------------------------------
$(window).on("load", function(){

    // Construct chart
    var bubble_chart_svg = dimple.newSvg("#bubble-chart", "100%", 500);
    var vertical_bubble_lollipop_svg = dimple.newSvg("#vertical-bubble-lollipop", "100%", 500);
    var horizontal_bubble_lollipop_svg = dimple.newSvg("#horizontal-bubble-lollipop", "100%", 500);
    var bubble_matrix_svg = dimple.newSvg("#bubble-matrix", "100%", 500);

    // Chart setup
    // ------------------------------

    d3.tsv("../../../app-assets/data/dimple/example-data.tsv", function (data) {

        /************************************
        *           Bubble Chart            *
        ************************************/
        // Filter data
        bubble_chart_data = dimple.filterData(data, "Date", "01/12/2012");


        // Create chart
        // ------------------------------

        // Define chart
        var bubbleChart = new dimple.chart(bubble_chart_svg, bubble_chart_data);

        // Set bounds
        bubbleChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        bubbleChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = bubbleChart.addMeasureAxis("x", "Unit Sales Monthly Change");

        // Vertical
        var y = bubbleChart.addMeasureAxis("y", "Price Monthly Change");

        var z = bubbleChart.addMeasureAxis("z", "Operating Profit");

        // Construct layout
        // ------------------------------

        // Add bubble
        bubbleChart.addSeries(["SKU", "Channel"], dimple.plot.bubble);

        // Assign Color
        bubbleChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#E91E63"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        bubbleChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



        /******************************************************
        *           Vertical Bubble Lollipop Chart            *
        ******************************************************/
        // Override data
        vertical_bubble_lollipop_data = dimple.filterData(data, "Date", [
          "01/07/2012", "01/08/2012", "01/09/2012",
          "01/10/2012", "01/11/2012", "01/12/2012"]);

        // Create chart
        // ------------------------------

        // Define chart
        var verticalBubbleLollipopChart = new dimple.chart(vertical_bubble_lollipop_svg, vertical_bubble_lollipop_data);

        // Set bounds
        verticalBubbleLollipopChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        verticalBubbleLollipopChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = verticalBubbleLollipopChart.addCategoryAxis("x", "Month");
            x.addOrderRule("Date");

        // Vertical
        var y = verticalBubbleLollipopChart.addMeasureAxis("y", "Unit Sales");

        var z = verticalBubbleLollipopChart.addMeasureAxis("z", "Operating Profit");

        // Construct layout
        // ------------------------------

        // Add bubble
        verticalBubbleLollipopChart.addSeries("Channel", dimple.plot.bubble);

        // Assign Color
        verticalBubbleLollipopChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#E91E63"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        verticalBubbleLollipopChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();



        /********************************************************
        *           Horizontal Bubble Lollipop Chart            *
        ********************************************************/
        // Override data
        horizontal_bubble_lollipop_data = dimple.filterData(data, "Date", [
          "01/07/2012", "01/08/2012", "01/09/2012",
          "01/10/2012", "01/11/2012", "01/12/2012"]);

        // Create chart
        // ------------------------------

        // Define chart
        var horizontalBubbleLollipopChart = new dimple.chart(horizontal_bubble_lollipop_svg, horizontal_bubble_lollipop_data);

        // Set bounds
        horizontalBubbleLollipopChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        horizontalBubbleLollipopChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = horizontalBubbleLollipopChart.addMeasureAxis("x", "Unit Sales");

        // Vertical
        var y = horizontalBubbleLollipopChart.addCategoryAxis("y", "Month");
            y.addOrderRule("Date");

        var z = horizontalBubbleLollipopChart.addMeasureAxis("z", "Operating Profit");

        // Construct layout
        // ------------------------------

        // Add bubble
        horizontalBubbleLollipopChart.addSeries("Channel", dimple.plot.bubble);

        // Assign Color
        horizontalBubbleLollipopChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#E91E63"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        horizontalBubbleLollipopChart.draw();

        // Remove axis titles
        x.titleShape.remove();
        y.titleShape.remove();




        /*******************************************
        *           Bubble Matrix Chart            *
        *******************************************/
        // Define chart
        var bubbleMatrixChart = new dimple.chart(bubble_matrix_svg, data);

        // Set bounds
        bubbleMatrixChart.setBounds(0, 0, "100%", "100%");

        // Set margins
        bubbleMatrixChart.setMargins(40, 10, 0, 50);


        // Create axes
        // ------------------------------

        // Horizontal
        var x = bubbleMatrixChart.addCategoryAxis("x", ["Channel", "Price Tier"]);

        // Vertical
        var y = bubbleMatrixChart.addCategoryAxis("y", "Owner");

        var z = bubbleMatrixChart.addMeasureAxis("z", "Distribution");

        // Construct layout
        // ------------------------------

        // Add bubble
        var s = bubbleMatrixChart.addSeries("Price Tier", dimple.plot.bubble);
            s.aggregate = dimple.aggregateMethod.max;
            z.overrideMax = 200;

        // Assign Color
        bubbleMatrixChart.defaultColors = [
            new dimple.color("#673AB7"),
            new dimple.color("#E91E63"),
        ];

        // Add styles
        // ------------------------------

        // Font size
        x.fontSize = "12";
        y.fontSize = "12";

        // Draw
        bubbleMatrixChart.draw();

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
                bubbleChart.draw(0, true);
                verticalBubbleLollipopChart.draw(0, true);
                horizontalBubbleLollipopChart.draw(0, true);
                bubbleMatrixChart.draw(0, true);

                // Remove axis titles
                x.titleShape.remove();
                y.titleShape.remove();
            }, 100);
        }
    });
});