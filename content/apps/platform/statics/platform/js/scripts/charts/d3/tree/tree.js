 /*=========================================================================================
    File Name: tree.js
    Description: D3 basic tree chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Basic Tree chart
// ------------------------------
$(window).on("load", function(){

    var ele = d3.select("#tree-chart"),
        margin = {top: 20, right: 20, bottom: 30, left: 50},
        width = ele.node().getBoundingClientRect().width - margin.left - margin.right,
        height = 600 - margin.top - margin.bottom;

    // Chart
    // ------------------------------

    var container = ele.append("svg");

    var svg = container
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    var tree = d3.layout.tree()
        .size([height, width - 180]);

    var diagonal = d3.svg.diagonal()
        .projection(function(d) { return [d.y, d.x]; });



    // Load data
    // ------------------------------
    d3.json("../../../app-assets/data/d3/tree/tree.json", function(error, json) {

        var nodes = tree.nodes(json),
            links = tree.links(nodes);


        // Links
        // ------------------------------

        var linkGroup = svg.append("g")
            .attr("class", "d3-tree-link-group");

        var link = linkGroup.selectAll(".d3-tree-link")
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

        var nodeGroup = svg.append("g")
            .attr("class", "d3-tree-node-group");

        var node = nodeGroup.selectAll(".d3-tree-node")
            .data(nodes)
            .enter()
            .append("g")
                .attr("class", "d3-tree-node")
                .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; });

        node.append("circle")
            .attr("r", 4.5)
            .attr("class", "d3-tree-circle")
            .style("fill", "#fff")
            .style("stroke", "#E84A5F")
            .style("stroke-width", 1.5);

        node.append("text")
            .attr("dx", function(d) { return d.children ? -12 : 12; })
            .attr("dy", 4)
            .style("text-anchor", function(d) { return d.children ? "end" : "start"; })
            .style("font-size", 12)
            .text(function(d) { return d.name; });



        // Resize chart
        // ------------------------------

        // Call function on window resize
        $(window).on('resize', resize);

        // Call function on sidebar width change
        $('.menu-toggle').on('click', resize);

        function resize() {

            // Layout variables
            width = ele.node().getBoundingClientRect().width - margin.left - margin.right,
            nodes = tree.nodes(json),
            links = tree.links(nodes);

            container.attr("width", width + margin.left + margin.right);
            svg.attr("width", width + margin.left + margin.right);
            tree.size([height, width - 180]);

            svg.selectAll(".d3-tree-link").attr("d", diagonal);
            svg.selectAll(".d3-tree-node").attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; });
        }
    });
});