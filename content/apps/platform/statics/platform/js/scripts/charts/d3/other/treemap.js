/*=========================================================================================
    File Name: treemap.js
    Description: D3 treemap chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Treemap chart
// ------------------------------
$(window).on("load", function(){

    var ele = d3.select("#treemap"),
    margin = {top: 20, right: 20, bottom: 30, left: 50},
    width = ele.node().getBoundingClientRect().width - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

    // Initialize Colors
    // ------------------------------
    // var color = d3.scale.category20c();
    var color = d3.scale.ordinal()
        .range(["#99B898", "#FECEA8", "#FF847C", "#E84A5F", "#F8B195", "#F67280", "#C06C84"]);

    // Chart
    var treemap = d3.layout.treemap()
        .size([width, height])
        .sticky(true)
        .value(function(d) { return d.size; });

    var container = ele.append("div");

    var div = container
        .style("position", "relative")
        .style("width", (width + margin.left + margin.right) + "px")
        .style("height", (height + margin.top + margin.bottom) + "px")
        .style("left", margin.left + "px")
        .style("top", margin.top + "px");

    // Load data
    // ------------------------------

    d3.json("../../../app-assets/data/d3/other/treemap.json", function(error, root) {
        if (error) throw error;

        var node = div.datum(root).selectAll(".node")
            .data(treemap.nodes)
        .enter().append("div")
            .attr("class", "node")
            .call(position)
            .style("background", function(d) { return d.children ? color(d.name) : null; })
            .style("border", "solid 1px white")
            .style("font-size", "10px")
            .style("line-height", "12px")
            .style("overflow", "hidden")
            .style("position", "absolute")
            .style("text-indent", "2px")
            .style("color", "#000")
            .text(function(d) { return d.children ? null : d.name; });

        d3.selectAll("input").on("change", function change() {
            var value = this.value === "count" ? function() { return 1; } : function(d) { return d.size; };

            node
                .data(treemap.value(value).nodes)
            .transition()
                .duration(1500)
                .call(position);
        });
    });

    function position() {
        this.style("left", function(d) { return d.x + "px"; })
            .style("top", function(d) { return d.y + "px"; })
            .style("width", function(d) { return Math.max(0, d.dx - 1) + "px"; })
            .style("height", function(d) { return Math.max(0, d.dy - 1) + "px"; });
    }
});