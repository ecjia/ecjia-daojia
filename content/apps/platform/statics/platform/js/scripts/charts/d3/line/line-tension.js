/*=========================================================================================
    File Name: line-tension.js
    Description: D3 line tension chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Line tension chart
// ------------------------------
$(window).on("load", function(){

    var ele = d3.select("#line-tension"),
    margin = {top: 20, right: 20, bottom: 30, left: 50},
    width = ele.node().getBoundingClientRect().width - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

    var formatDate = d3.time.format("%d-%b-%y");

    var tsvData;

    // Scales
    // ------------------------------

    var x = d3.scale.linear()
        .domain([0, 1])
        .range([0, width]);

    var y = d3.scale.linear()
        .domain([0, 1])
        .range([height, 0]);

    var z = d3.scale.linear()
        .domain([2 / 3, 1]) // D3 3.x tension is buggy!
        .range(["#00BCD4", "#E91E63"]);

    // Axis
    // ------------------------------
    var xAxis = d3.svg.axis()
        .scale(x)
        .orient("bottom");

    var yAxis = d3.svg.axis()
        .scale(y)
        .orient("left");

    // Chart
    var line = d3.svg.line()
        .interpolate("cardinal")
        .x(function(d) { return x(d.x); })
        .y(function(d) { return y(d.y); });

    var container = ele.append("svg");

    var svg = container
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
      .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");



    // Load data
    // ------------------------------

    d3.tsv("../../../app-assets/data/d3/line/line-tension.tsv", type, function(error, data) {
        if (error) throw error;

        tsvData = data;

        svg.append("g")
            .attr("class", "d3-axis d3-xaxis")
            .attr("transform", "translate(0," + height + ")")
            .call(xAxis);

        svg.append("g")
            .attr("class", "d3-axis d3-yaxis")
            .call(yAxis);

        svg.selectAll(".d3-line")
            .data(z.ticks(6))
        .enter().append("path")
            .attr("class", "d3-line")
            .attr("d", function(d) { return line.tension(d)(data); })
            .style("stroke", z);

        svg.selectAll(".d3-dot")
            .data(data)
        .enter().append("circle")
            .attr("class", "d3-dot")
            .attr("cx", function(d) { return x(d.x); })
            .attr("cy", function(d) { return y(d.y); })
            .attr("r", 3.5)
            .style("fill", '#FFF')
            .style("stroke", '#2A363B');
    });

    function type(d) {
        d.x = +d.x;
        d.y = +d.y;
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

        svg.selectAll('.d3-line').attr("d", function(d) { return line.tension(d)(tsvData); });

        svg.selectAll(".d3-dot")
            .attr("cx", function(d) { return x(d.x); })
            .attr("cy", function(d) { return y(d.y); })
            .attr("r", 3.5);
    }
});