/*=========================================================================================
    File Name: normalized-stacked-bar.js
    Description: D3 normalized stacked bar chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Normalized stacked bar chart
// ------------------------------
$(window).on("load", function(){

    var ele = d3.select("#normalized-stacked"),
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
        .tickFormat(d3.format(".0%"));

    // Chart
    var container = ele.append("svg");

    var svg = container
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
      .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");



    // Load data
    // ------------------------------

    d3.csv("../../../app-assets/data/d3/bar/normalized-stacked-bar.csv", function(error, data) {
        if (error) throw error;

        color.domain(d3.keys(data[0]).filter(function(key) { return key !== "State"; }));

        data.forEach(function(d) {
            var y0 = 0;
            d.ages = color.domain().map(function(name) { return {name: name, y0: y0, y1: y0 += +d[name]}; });
            d.ages.forEach(function(d) { d.y0 /= y0; d.y1 /= y0; });
        });

        data.sort(function(a, b) { return b.ages[0].y1 - a.ages[0].y1; });

        x.domain(data.map(function(d) { return d.State; }));

        svg.append("g")
            .attr("class", "d3-axis d3-xaxis")
            .attr("transform", "translate(0," + height + ")")
            .call(xAxis);

        svg.append("g")
            .attr("class", "d3-axis d3-yaxis")
            .call(yAxis);

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

        var legend = svg.select(".state:last-child").selectAll(".d3-legend")
            .data(function(d) { return d.ages; })
        .enter().append("g")
            .attr("class", "d3-legend")
            .attr("transform", function(d) { return "translate(" + x.rangeBand() / 2 + "," + y((d.y0 + d.y1) / 2) + ")"; });

        legend.append("line")
            .attr("x2", 10);

        legend.append("text")
            .attr("x", 13)
            .attr("dy", ".35em")
            .text(function(d) { return d.name; });
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
        x.rangeRoundBands([0, width], .1);
        svg.selectAll('.d3-xaxis').call(xAxis);

        svg.selectAll('.state').attr("transform", function(d) { return "translate(" + x(d.State) + ",0)"; });

        svg.selectAll('.d3-bar').attr("width", x.rangeBand()).attr("x", function(d) { return x(d.name); });

        svg.selectAll(".d3-legend text").attr("x", width - 24);
        svg.selectAll(".d3-legend rect").attr("x", width - 18);
    }
});