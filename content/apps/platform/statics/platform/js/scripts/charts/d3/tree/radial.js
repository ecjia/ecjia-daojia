 /*=========================================================================================
    File Name: radial.js
    Description: D3 radial tree chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Basic Tree chart
// ------------------------------
$(window).on("load", function(){

    var ele = d3.select('#radial-tree');

    // Chart
    // ------------------------------
    var container = ele.append("svg");

    var svg = container
        .attr("width", 900)
        .attr("height", 900 - 140)
        .append("g")
            .attr("transform", "translate(" + (900 / 2) + "," + (900 / 2) + ")");

    var tree = d3.layout.tree()
        .size([360, (900 / 2) - 110])
        .separation(function(a, b) { return (a.parent == b.parent ? 1 : 2) / a.depth; });

    var diagonal = d3.svg.diagonal.radial()
        .projection(function(d) { return [d.y, d.x / 180 * Math.PI]; });


    // Load data
    // ------------------------------

    d3.json("../../../app-assets/data/d3/tree/radial-tree.json", function(error, root) {

        var nodes = tree.nodes(root),
            links = tree.links(nodes);


        // Links
        // ------------------------------

        var link = svg.selectAll(".d3-tree-link")
            .data(links)
            .enter()
            .append("path")
                .attr("class", "d3-tree-link")
                .attr("d", diagonal)
                .style("fill", "none")
                .style("stroke", "#e3e3e3")
                .style("stroke-width", 1.5);


        // Nodes
        // ------------------------------

        var node = svg.selectAll(".d3-tree-node")
            .data(nodes)
            .enter()
            .append("g")
                .attr("class", "d3-tree-node")
                .attr("transform", function(d) { return "rotate(" + (d.x - 90) + ")translate(" + d.y + ")"; });

        node.append("circle")
            .attr("r", 4.5)
            .style("fill", "#fff")
            .style("stroke", "#99B898")
            .style("stroke-width", 1.5);

        node.append("text")
            .attr("dy", ".31em")
            .attr("text-anchor", function(d) { return d.x < 180 ? "start" : "end"; })
            .attr("transform", function(d) { return d.x < 180 ? "translate(8)" : "rotate(180)translate(-8)"; })
            .style("font-size", 12)
            .text(function(d) { return d.name; });
    });
});