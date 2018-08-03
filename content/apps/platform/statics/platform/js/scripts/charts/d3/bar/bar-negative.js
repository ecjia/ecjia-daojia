/*=========================================================================================
    File Name: bar-negative.js
    Description: D3 negative bar value chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Negative bar value chart
// ------------------------------
$(window).on("load", function(){

    var ele = d3.select("#bar-negative"),
    margin = {top: 20, right: 20, bottom: 30, left: 50},
    width = ele.node().getBoundingClientRect().width - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

    // Initialize Scales
    // ------------------------------

    var x = d3.scale.linear()
        .range([0, width]);

    var y = d3.scale.ordinal()
        .rangeRoundBands([0, height], 0.1);

    // Initialize Axis
    // ------------------------------
    var xAxis = d3.svg.axis()
        .scale(x)
        .orient("bottom");

    var yAxis = d3.svg.axis()
        .scale(y)
        .orient("left")
        .tickSize(0)
        .tickPadding(6);

    // Chart
    var container = ele.append("svg");

    var svg = container
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
      .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");



    // Load data
    // ------------------------------

    d3.tsv("../../../app-assets/data/d3/bar/bar-negative.tsv", type, function(error, data) {
        if (error) throw error;

        x.domain(d3.extent(data, function(d) { return d.value; })).nice();
        y.domain(data.map(function(d) { return d.name; }));

        svg.selectAll(".d3-bar")
            .data(data)
        .enter().append("rect")
            .attr("class", function(d) { return "d3-bar d3-bar--" + (d.value < 0 ? "negative" : "positive"); })
            .attr("x", function(d) { return x(Math.min(0, d.value)); })
            .attr("y", function(d) { return y(d.name); })
            .attr("width", function(d) { return Math.abs(x(d.value) - x(0)); })
            .attr("height", y.rangeBand());

        svg.append("g")
            .attr("class", "d3-axis d3-xaxis")
            .attr("transform", "translate(0," + height + ")")
            .call(xAxis);

        svg.append("g")
            .attr("class", "d3-axis d3-yaxis")
            .attr("transform", "translate(" + x(0) + ",0)")
            .call(yAxis);
    });

    function type(d) {
        d.value = +d.value;
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
        svg.selectAll('.d3-xaxis').call(xAxis);

        svg.selectAll('.d3-yaxis').attr("transform", "translate(" + x(0) + ",0)");

        svg.selectAll('.d3-bar')
            .attr("x", function(d) { return x(Math.min(0, d.value)); })
            .attr("y", function(d) { return y(d.name); })
            .attr("width", function(d) { return Math.abs(x(d.value) - x(0)); });
    }
});