/*=========================================================================================
    File Name: donut-multiples-nesting.js
    Description: D3 donut multiples nesting chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Donut multiples nesting chart
// ------------------------------
$(window).on("load", function(){

    var ele = d3.select("#nested-donut"),
    margin = {top: 20, right: 10, bottom: 20, left: 10},
    width = 300,
    height = 300;
    radius = (Math.min(width, height) - (margin.top * 2) ) / 2;

    // Colors
    var colors = d3.scale.ordinal()
    .range(["#99B898", "#FECEA8", "#FF847C", "#E84A5F", "#F8B195", "#F67280", "#C06C84"]);


    // Load data
    // ------------------------------

    d3.csv("../../../app-assets/data/d3/pie/flights.csv", function(flights) {

        // Nest the flight data by originating airport
        var airports = d3.nest()
            .key(function(d) { return d.origin; })
            .entries(flights);


        // Create chart
        // ------------------------------

        // Insert an svg element (with margin) for each row in our dataset
        var svg = ele
            .selectAll("svg")
            .data(airports)
            .enter()
                .append("svg")
                    .attr("width", (radius + margin.left + margin.right) * 2)
                    .attr("height", (radius + margin.left + margin.right) * 2)
                    .append("g")
                        .attr("transform", "translate(" + (radius + margin.left + margin.right) + "," + (radius + margin.left + margin.right) + ")");


        // Construct chart layout
        // ------------------------------

        // Arc
        var arc = d3.svg.arc()
            .innerRadius(radius / 2)
            .outerRadius(radius);

        // Pie
        var pie = d3.layout.pie()
            .value(function(d) { return +d.count; })
            .sort(function(a, b) { return b.count - a.count; });



        //
        // Append chart elements
        //

        // Add a label for the airport
        svg.append("text")
            .attr("dy", ".35em")
            .style("text-anchor", "middle")
            .style("font-weight", 500)
            .text(function(d) { return d.key; });


        // Pass the nested values to the pie layout
        var g = svg.selectAll("g")
            .data(function(d) { return pie(d.values); })
            .enter()
            .append("g")
                .attr("class", "d3-arc");


        // Add a colored arc path, with a mouseover title showing the count
        g.append("path")
            .attr("d", arc)
            .style("stroke", "#fff")
            .style("fill", function(d) { return colors(d.data.carrier); })
            .append("title")
                .text(function(d) { return d.data.carrier + ": " + d.data.count; });


        // Add a label to the larger arcs, translated to the arc centroid and rotated.
        g.filter(function(d) { return d.endAngle - d.startAngle > .2; }).append("text")
            .attr("dy", ".35em")
            .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")rotate(" + angle(d) + ")"; })
            .style("fill", "#fff")
            .style("font-size", 12)
            .style("text-anchor", "middle")
            .text(function(d) { return d.data.carrier; });


        // Computes the label angle of an arc, converting from radians to degrees.
        function angle(d) {
            var a = (d.startAngle + d.endAngle) * 90 / Math.PI - 90;
            return a > 90 ? a - 180 : a;
        }
    });

    // Resize chart
    // ------------------------------

    // Call function on window resize
    $(window).on('resize', resize);

    // Call function on sidebar width change
    $('.menu-toggle').on('click', resize);

    // Resize function
    // ------------------------------
    function resize() {

        width = ele.node().getBoundingClientRect().width - margin.left - margin.right;

        // Main svg width
        container.attr("width", width + margin.left + margin.right);

        // Width of appended group
        svg.attr("width", width + margin.left + margin.right);


        // Axis
        // -------------------------
        x.range([0, width]);
        svg.selectAll('.d3-xaxis').call(xAxis);


        svg.selectAll('.d3-line').attr("d", line);
    }
});