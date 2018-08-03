/*=========================================================================================
    File Name: difference.js
    Description: d3 difference chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Difference chart
// ------------------------------
$(window).on("load", function(){

    var ele = d3.select("#difference-chart"),
    margin = {top: 20, right: 20, bottom: 30, left: 50},
    width = ele.node().getBoundingClientRect().width - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

    var parseDate = d3.time.format("%Y%m%d").parse;


    // Scales
    // ------------------------------

    var x = d3.time.scale()
        .range([0, width]);

    var y = d3.scale.linear()
        .range([height, 0]);

    // Axis
    // ------------------------------
    var xAxis = d3.svg.axis()
        .scale(x)
        .orient("bottom");

    var yAxis = d3.svg.axis()
        .scale(y)
        .orient("left");

    // Chart
    var line = d3.svg.area()
        .interpolate("basis")
        .x(function(d) { return x(d.date); })
        .y(function(d) { return y(d["New York"]); });

    var area = d3.svg.area()
        .interpolate("basis")
        .x(function(d) { return x(d.date); })
        .y1(function(d) { return y(d["New York"]); });

    var container = ele.append("svg");

    var svg = container
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
      .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");



    // Load data
    // ------------------------------

    d3.tsv("../../../app-assets/data/d3/line/difference.tsv", function(error, data) {
        if (error) throw error;

        data.forEach(function(d) {
            d.date = parseDate(d.date);
            d["New York"]= +d["New York"];
            d["San Francisco"] = +d["San Francisco"];
        });

        x.domain(d3.extent(data, function(d) { return d.date; }));

        y.domain([
            d3.min(data, function(d) { return Math.min(d["New York"], d["San Francisco"]); }),
            d3.max(data, function(d) { return Math.max(d["New York"], d["San Francisco"]); })
        ]);

        svg.datum(data);

        svg.append("clipPath")
            .attr("id", "clip-below")
        .append("path")
            .attr("d", area.y0(height));

        svg.append("clipPath")
            .attr("id", "clip-above")
        .append("path")
            .attr("d", area.y0(0));

        svg.append("path")
            .attr("class", "d3-area above")
            .attr("clip-path", "url(#clip-above)")
            .attr("d", area.y0(function(d) { return y(d["San Francisco"]); }))
            .style("fill", "#00BCD4");

        svg.append("path")
            .attr("class", "d3-area below")
            .attr("clip-path", "url(#clip-below)")
            .attr("d", area)
            .style("fill", "#E91E63");

        svg.append("path")
            .attr("class", "d3-line")
            .attr("d", line);

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
            .text("Temperature (ºF)");
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


        svg.selectAll('.d3-area').attr("d", area);
    }
});