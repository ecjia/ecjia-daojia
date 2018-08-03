/*=========================================================================================
    File Name: waterfall.js
    Description: D3 waterfall chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Waterfall chart
// ------------------------------
$(window).on("load", function(){

    var ele = d3.select("#waterfall"),
    margin = {top: 20, right: 20, bottom: 30, left: 50},
    width = ele.node().getBoundingClientRect().width - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;
    padding = 0.3;

    // Initialize Scales
    // ------------------------------

    var x = d3.scale.ordinal()
        .rangeRoundBands([0, width], padding);

    var y = d3.scale.linear()
        .range([height, 0]);

    // Initialize Axis
    // ------------------------------
    var xAxis = d3.svg.axis()
        .scale(x)
        .orient("bottom");

    var yAxis = d3.svg.axis()
        .scale(y)
        .orient("left")
        .tickFormat(function(d) { return dollarFormatter(d); });

    // Chart
    var container = ele.append("svg");

    var svg = container
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
      .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");



    // Load data
    // ------------------------------

    d3.csv("../../../app-assets/data/d3/bar/waterfall.csv", type, function(error, data) {
        if (error) throw error;

        // Transform data (i.e., finding cumulative values and total) for easier charting
        var cumulative = 0;
        for (var i = 0; i < data.length; i++) {
            data[i].start = cumulative;
            cumulative += data[i].value;
            data[i].end = cumulative;

            data[i].class = ( data[i].value >= 0 ) ? 'positive' : 'negative';
        }
        data.push({
            name: 'Total',
            end: cumulative,
            start: 0,
            class: 'total'
        });

        x.domain(data.map(function(d) { return d.name; }));
        y.domain([0, d3.max(data, function(d) { return d.end; })]);

        svg.append("g")
            .attr("class", "d3-axis d3-xaxis")
            .attr("transform", "translate(0," + height + ")")
            .call(xAxis);

        svg.append("g")
            .attr("class", "d3-axis d3-yaxis")
            .call(yAxis);

        var bar = svg.selectAll(".d3-bar")
            .data(data)
        .enter().append("g")
            .attr("class", function(d) { return "d3-bar " + d.class; })
            .attr("transform", function(d) { return "translate(" + x(d.name) + ",0)"; });

        bar.append("rect")
            .attr("y", function(d) { return y( Math.max(d.start, d.end) ); })
            .attr("height", function(d) { return Math.abs( y(d.start) - y(d.end) ); })
            .attr("width", x.rangeBand());

        bar.append("text")
            .attr("x", x.rangeBand() / 2)
            .attr("y", function(d) { return y(d.end) + 5; })
            .attr("dy", function(d) { return ((d.class=='negative') ? '-' : '') + ".75em"; })
            .text(function(d) { return dollarFormatter(d.end - d.start);});

        bar.filter(function(d) { return d.class != "total"; }).append("line")
            .attr("class", "d3-connector")
            .attr("x1", x.rangeBand() + 5 )
            .attr("y1", function(d) { return y(d.end); } )
            .attr("x2", x.rangeBand() / ( 1 - padding) - 5 )
            .attr("y2", function(d) { return y(d.end); } );
    });

    function type(d) {
        d.value = +d.value;
        return d;
    }

    function dollarFormatter(n) {
        n = Math.round(n);
        var result = n;
        if (Math.abs(n) > 1000) {
            result = Math.round(n/1000) + 'K';
        }
        return '$' + result;
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
        x.rangeRoundBands([0, width], padding);
        svg.selectAll('.d3-xaxis').call(xAxis);


        svg.selectAll(".d3-bar").attr("transform", function(d) { return "translate(" + x(d.name) + ",0)"; });
        svg.selectAll(".d3-bar rect").attr("width", x.rangeBand());
        svg.selectAll(".d3-bar text").attr("x", x.rangeBand() / 2);
        svg.selectAll(".d3-connector").attr("x1", x.rangeBand() + 5 ).attr("x2", x.rangeBand() / ( 1 - padding) - 5 );
    }
});