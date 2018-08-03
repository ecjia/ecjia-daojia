/*=========================================================================================
    File Name: pie-multiples-nesting.js
    Description: D3 pie multiples nesting chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Pie multiple nesting chart
// ------------------------------
$(window).on("load", function(){

    var ele = d3.select("#nested-pie"),
    margin = {top: 20, right: 10, bottom: 20, left: 10},
    width = 300,
    height = 300;
    radius = (Math.min(width, height) - (margin * 2) ) / 2;

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
                    .attr("height", (radius + margin.left + margin.right + margin.top) * 2)
                    .append("g")
                        .attr("transform", "translate(" + (radius + margin.left + margin.right) + "," + (radius + margin.left + margin.right + margin.top) + ")");

        // Chart
        // --------------

        // Arc
        var arc = d3.svg.arc()
            .innerRadius(0)
            .outerRadius(radius);

        // Pie
        var pie = d3.layout.pie()
            .value(function(d) { return +d.count; })
            .sort(function(a, b) { return b.count - a.count; });

        svg.append("text")
            .attr("dy", ".35em")
            .attr("y", -150)
            .style("text-anchor", "middle")
            .style("font-weight", 500)
            .text(function(d) { return d.key; });

        var g = svg.selectAll("g")
            .data(function(d) { return pie(d.values); })
            .enter()
            .append("g")
                .attr("class", "d3-arc");

        g.append("path")
            .attr("d", arc)
            .style("stroke", "#fff")
            .style("fill", function(d) { return colors(d.data.carrier); })
            .append("title")
                .text(function(d) { return d.data.carrier + ": " + d.data.count; });

        g.filter(function(d) { return d.endAngle - d.startAngle > .2; }).append("text")
            .attr("dy", ".35em")
            .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")rotate(" + angle(d) + ")"; })
            .style("fill", "#fff")
            .style("font-size", 12)
            .style("text-anchor", "middle")
            .text(function(d) { return d.data.carrier; });

        function angle(d) {
            var a = (d.startAngle + d.endAngle) * 90 / Math.PI - 90;
            return a > 90 ? a - 180 : a;
        }
    });
});