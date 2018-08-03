/*=========================================================================================
    File Name: focus-context.js
    Description: d3 focust + context via brushing chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Focus context chart
// ------------------------------
$(window).on("load", function(){

    var ele = d3.select("#focus-context"),
    margin = {top: 10, right: 10, bottom: 100, left: 40},
    margin2 = {top: 430, right: 10, bottom: 20, left: 40},
    width = ele.node().getBoundingClientRect().width - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;
    height2 = 500 - margin2.top - margin2.bottom;

    var parseDate = d3.time.format("%b %Y").parse;


    // Scales
    // ------------------------------

    var x = d3.time.scale().range([0, width]),
        x2 = d3.time.scale().range([0, width]),
        y = d3.scale.linear().range([height, 0]),
        y2 = d3.scale.linear().range([height2, 0]);

    // Axis
    // ------------------------------
    var xAxis = d3.svg.axis().scale(x).orient("bottom"),
        xAxis2 = d3.svg.axis().scale(x2).orient("bottom"),
        yAxis = d3.svg.axis().scale(y).orient("left");

    // Brush
    // ------------------------------
    var brush = d3.svg.brush()
        .x(x2)
        .on("brush", brushed);

    // Chart
    var area = d3.svg.area()
        .interpolate("monotone")
        .x(function(d) { return x(d.date); })
        .y0(height)
        .y1(function(d) { return y(d.price); });

    var area2 = d3.svg.area()
        .interpolate("monotone")
        .x(function(d) { return x2(d.date); })
        .y0(height2)
        .y1(function(d) { return y2(d.price); });

    var container = ele.append("svg");

    var svg = container
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom);

    svg.append("defs").append("clipPath")
        .attr("id", "clip")
    .append("rect")
        .attr("width", width)
        .attr("height", height);

    var focus = svg.append("g")
        .attr("class", "focus")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    var context = svg.append("g")
        .attr("class", "context")
        .attr("transform", "translate(" + margin2.left + "," + margin2.top + ")");

    // Load data
    // ------------------------------

    d3.csv("../../../app-assets/data/d3/line/focus-context.csv", type, function(error, data) {
        if (error) throw error;

        x.domain(d3.extent(data.map(function(d) { return d.date; })));
        y.domain([0, d3.max(data.map(function(d) { return d.price; }))]);
        x2.domain(x.domain());
        y2.domain(y.domain());


        focus.append("path")
            .datum(data)
            .attr("class", "d3-area d3-focus-area")
            .attr("d", area)
            .style("fill", "#5C6BC0");

        focus.append("g")
            .attr("class", "d3-axis d3-xaxis")
            .attr("transform", "translate(0," + height + ")")
            .call(xAxis);

        focus.append("g")
            .attr("class", "d3-axis d3-yaxis")
            .call(yAxis);

        context.append("path")
            .datum(data)
            .attr("class", "d3-area d3-context-area")
            .attr("d", area2)
            .style("fill", "#5C6BC0");

        context.append("g")
            .attr("class", "d3-axis d3-xaxis")
            .attr("transform", "translate(0," + height2 + ")")
            .call(xAxis2);

        context.append("g")
            .attr("class", "d3-xbrush")
            .call(brush)
        .selectAll("rect")
            .attr("y", -6)
            .attr("height", height2 + 7)
            .style("fill-opacity", ".225");
    });

    function brushed() {
        x.domain(brush.empty() ? x2.domain() : brush.extent());
        focus.select(".d3-area").attr("d", area);
        focus.select("d3-xaxis").call(xAxis);
    }

    function type(d) {
        d.date = parseDate(d.date);
        d.price = +d.price;
        return d;
    }

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
        x2.range([0, width]);
        svg.selectAll('.d3-xaxis').call(xAxis);


        svg.selectAll('.d3-focus-area').attr("d", area);
        svg.selectAll('.d3-context-area').attr("d", area2);
    }
});