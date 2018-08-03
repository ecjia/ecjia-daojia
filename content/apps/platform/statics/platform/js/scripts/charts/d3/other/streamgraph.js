/*=========================================================================================
    File Name: streamgraph.js
    Description: D3 streamgraph chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: GeeksLabs
    Author URL: http://www.themeforest.net/user/geekslabs
==========================================================================================*/

// Streamgraph chart
// ------------------------------
$(window).on("load", function(){

    var ele = d3.select("#streamgraph"),
    margin = {top: 20, right: 20, bottom: 30, left: 50},
    width = ele.node().getBoundingClientRect().width - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

    var n = 20, // number of layers
    m = 200, // number of samples per layer
    stack = d3.layout.stack().offset("wiggle"),
    layers0 = stack(d3.range(n).map(function() { return bumpLayer(m); })),
    layers1 = stack(d3.range(n).map(function() { return bumpLayer(m); }));

    // Initialize Scales
    // ------------------------------

    var x = d3.scale.linear()
        .domain([0, m - 1])
        .range([0, width]);

    var y = d3.scale.linear()
        .domain([0, d3.max(layers0.concat(layers1), function(layer) { return d3.max(layer, function(d) { return d.y0 + d.y; }); })])
        .range([height, 0]);

    // Initialize Colors
    // ------------------------------
    var color = d3.scale.linear()
    // .range(["#729C70", "#51834E"]);
    .range(["#99B898", "#FECEA8"]);

    // Chart
    var area = d3.svg.area()
        .x(function(d) { return x(d.x); })
        .y0(function(d) { return y(d.y0); })
        .y1(function(d) { return y(d.y0 + d.y); });


    var container = ele.append("svg");

    var svg = container
        .attr("width", width)
        .attr("height", height);


    svg.selectAll("path")
        .data(layers0)
    .enter().append("path")
        .attr("d", area)
        .style("fill", function() { return color(Math.random()); });

    function transition() {
        d3.selectAll("path")
            .data(function() {
                var d = layers1;
                layers1 = layers0;
                return layers0 = d;
            })
        .transition()
            .duration(2500)
            .attr("d", area);
    }

    // Inspired by Lee Byron's test data generator.
    function bumpLayer(n) {

        function bump(a) {
            var x = 1 / (.1 + Math.random()),
                y = 2 * Math.random() - .5,
                z = 10 / (.1 + Math.random());
            for (var i = 0; i < n; i++) {
                var w = (i / n - y) * z;
                a[i] += x * Math.exp(-w * w);
            }
        }

        var a = [], i;
        for (i = 0; i < n; ++i) a[i] = 0;
        for (i = 0; i < 5; ++i) bump(a);
        return a.map(function(d, i) { return {x: i, y: Math.max(0, d)}; });
    }
});