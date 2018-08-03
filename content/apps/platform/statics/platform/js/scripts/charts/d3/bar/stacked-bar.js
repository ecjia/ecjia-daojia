/*=========================================================================================
    File Name: stacked-bar.js
    Description: D3 stacked bar chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Stacked bar chart
// ------------------------------
$(window).on("load", function(){

    var ele = d3.select("#stacked-bar"),
    margin = {top: 20, right: 20, bottom: 30, left: 50},
    width = ele.node().getBoundingClientRect().width - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

    // Initialize Scales
    // ------------------------------

    var x = d3.scale.ordinal()
        .rangeRoundBands([0, width], .1);

    var y = d3.scale.linear()
        .rangeRound([height, 0]);

    // Initialize Colors
    // ------------------------------
    var color = d3.scale.ordinal()
    .range(["#99B898", "#C7C29F", "#FECEA8", "#FEAC94", "#FF847C", "#F56A6F", "#E84A5F"]);

    // Initialize Axis
    // ------------------------------
    var xAxis = d3.svg.axis()
        .scale(x)
        .orient("bottom");

    var yAxis = d3.svg.axis()
        .scale(y)
        .orient("left")
        .tickFormat(d3.format(".2s"));

    // Chart
    var container = ele.append("svg");

    var svg = container
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
      .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    // Load data
    // ------------------------------

    d3.csv("../../../app-assets/data/d3/bar/stacked-bar.csv", function(error, data) {
        if (error) throw error;

        color.domain(d3.keys(data[0]).filter(function(key) { return key !== "State"; }));

        data.forEach(function(d) {
            var y0 = 0;
            d.ages = color.domain().map(function(name) { return {name: name, y0: y0, y1: y0 += +d[name]}; });
            d.total = d.ages[d.ages.length - 1].y1;
        });

        data.sort(function(a, b) { return b.total - a.total; });

        x.domain(data.map(function(d) { return d.State; }));
        y.domain([0, d3.max(data, function(d) { return d.total; })]);

        svg.append("g")
            .attr("class", "d3-axis d3-xaxis")
            .attr("transform", "translate(0," + height + ")")
            .call(xAxis);

        svg.append("g")
            .attr("class", "d3-axis d3-yaxis")
            .call(yAxis)
        .append("text")
            .attr("transform", "rotate(-90)")
            .attr("y", 6)
            .attr("dy", ".71em")
            .style("text-anchor", "end")
            .style("fill", "#666")
            .style("font-size", 12)
            .text("Population");

        var state = svg.selectAll(".state")
            .data(data)
        .enter().append("g")
            .attr("class", "state")
            .attr("transform", function(d) { return "translate(" + x(d.State) + ",0)"; });

        state.selectAll(".d3-bar")
            .data(function(d) { return d.ages; })
        .enter().append("rect")
            .attr("class", "d3-bar")
            .attr("width", x.rangeBand())
            .attr("y", function(d) { return y(d.y1); })
            .attr("height", function(d) { return y(d.y0) - y(d.y1); })
            .style("fill", function(d) { return color(d.name); });

        var legend = svg.selectAll(".legend")
            .data(color.domain().slice().reverse())
        .enter().append("g")
            .attr("class", "d3-legend")
            .attr("transform", function(d, i) { return "translate(0," + i * 20 + ")"; });

        legend.append("rect")
            .attr("x", width - 18)
            .attr("width", 18)
            .attr("height", 18)
            .style("fill", color);

        legend.append("text")
            .attr("x", width - 24)
            .attr("y", 9)
            .attr("dy", ".35em")
            .style("text-anchor", "end")
            .text(function(d) { return d; });
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
        x.rangeRoundBands([0, width], .1, .5);
        svg.selectAll('.d3-xaxis').call(xAxis);

        // Bar group
        svg.selectAll('.state').attr("transform", function(d) { return "translate(" + x(d.State) + ",0)"; });

        // Bars
        svg.selectAll('.d3-bar').attr("width", x.rangeBand()).attr("x", function(d) { return x(d.name); });

        // Legend
        svg.selectAll(".d3-legend text").attr("x", width - 24);
        svg.selectAll(".d3-legend rect").attr("x", width - 18);
    }
});