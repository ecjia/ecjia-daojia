/*=========================================================================================
    File Name: vertical-sankey.js
    Description: D3 vertical sankey chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Vertical sankey chart
// ------------------------------
$(window).on("load", function(){

    var ele = d3.select("#vertical-sankey"),
    margin = {top: 20, right: 20, bottom: 30, left: 50},
    width = ele.node().getBoundingClientRect().width - margin.left - margin.right,
    height = 650 - margin.top - margin.bottom;

    var formatNumber = d3.format(",.0f"),
        format = function(d) { return formatNumber(d) + "m CHF"; };

    // var color = d3.scale.category20();
    var color = d3.scale.ordinal()
        .range(["#99B898", "#FECEA8", "#FF847C", "#E84A5F", "#F8B195", "#F67280", "#C06C84"]);

    var container = ele.append("svg");

    var svg = container
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
    .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    // Chart
    var sankey = d3.sankey()
        .nodeWidth(25) // was 15
        .nodePadding(20) // was 10
        .size([width, height]);

    var path = sankey.link();

    // Load data
    // ------------------------------

    d3.json("../../../app-assets/data/d3/other/sankey.json", function(error, energy) {
        if (error) throw error;

        sankey
            .nodes(energy.nodes)
            .links(energy.links)
            .layout(32); // what is this? iterations

        var link = svg.append("g").selectAll(".link")
            .data(energy.links)
        .enter().append("path")
            .attr("class", "link")
            .attr("d", path)
            .style("stroke-width", function(d) { return Math.max(1, d.dy); })
            .style("stroke", function(d) { return d.source.color = color(d.source.name.replace(/ .*/, "")); })
            .style("fill", "none")
            .style("stroke-opacity","0.5")
            .sort(function(a, b) { return b.dy - a.dy; });

        link.append("title")
              .text(function(d) { return d.source.name + " → " + d.target.name + "\n" + format(d.value); });
              // title is an SVG standard way of providing tooltips, up to the browser how to render this, so changing the style is tricky

        var node = svg.append("g").selectAll(".node")
            .data(energy.nodes)
        .enter().append("g")
            .attr("class", "node")
            .attr("transform", function(d) {
                return "translate(" + d.x + "," + d.y + ")";
            })
            .call(d3.behavior.drag()
            .origin(function(d) { return d; })
            .on("dragstart", function() { this.parentNode.appendChild(this); })
            .on("drag", dragmove));

        node.append("rect")
            .attr("height", sankey.nodeWidth())
            .attr("width", function(d) { return d.dy; })
            .style("fill", function(d) { return d.color = color(d.name.replace(/ .*/, "")); })
            .style("stroke", function(d) { return d3.rgb(d.color).darker(2); })
            .style("fill-opacity", "0.9")
        .append("title")
            .text(function(d) { return d.name + "\n" + format(d.value); });

        node.append("text")
            .attr("text-anchor", "middle")
            .attr("x", function (d) { return d.dy / 2 })
            .attr("y", sankey.nodeWidth() / 2)
            .attr("dy", ".35em")
            .text(function(d) { return d.name; })
            .filter(function(d) { return d.x < width / 2; });

        function dragmove(d) {
            d3.select(this).attr("transform", "translate(" + (d.x = Math.max(0, Math.min(width - d.dy, d3.event.x))) + "," + d.y + ")");
            sankey.relayout();
            link.attr("d", path);
        }
    });
});