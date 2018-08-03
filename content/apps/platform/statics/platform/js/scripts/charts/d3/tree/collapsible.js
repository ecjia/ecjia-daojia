 /*=========================================================================================
    File Name: collapsible.js
    Description: D3 collapsible tree chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Basic Tree chart
// ------------------------------
$(window).on("load", function(){


    var ele = d3.select("#collapsible-tree"),
        margin = {top: 20, right: 20, bottom: 30, left: 50},
        width = ele.node().getBoundingClientRect().width - margin.left - margin.right,
        height = 600 - margin.top - margin.bottom,
        i = 0,
        root;

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

    d3.json("../../../app-assets/data/d3/tree/collapsible-tree.json", function(error, json) {

        root = json;
        root.x0 = height/2;
        root.y0 = 0;

        // Toggle nodes function
        function toggleAll(d) {
            if (d.children) {
                d.children.forEach(toggleAll);
                toggle(d);
            }
        }

        // Initialize the display to show a few nodes
        root.children.forEach(toggleAll);
        toggle(root.children[1]);
        toggle(root.children[1].children[2]);
        toggle(root.children[9]);
        toggle(root.children[9].children[0]);

        update(root);
    });

    // Update nodes
    function update(source) {

        var duration = d3.event && d3.event.altKey ? 5000 : 500;

        var nodes = tree.nodes(root).reverse();

        var node = svg.selectAll(".d3-tree-node")
            .data(nodes, function(d) { return d.id || (d.id = ++i); });

        var nodeEnter = node.enter().append("g")
            .attr("class", "d3-tree-node")
            .attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; })
            .on("click", function(d) { toggle(d); update(d); });

        nodeEnter.append("circle")
            .attr("r", 1e-6)
            .style("fill", "#fff")
            .style("stroke", "#E84A5F")
            .style("stroke-width", 1.5)
            .style("cursor", "pointer")
            .style("fill", function(d) { return d._children ? "#E84A5F" : "#fff"; });

        nodeEnter.append("text")
            .attr("x", function(d) { return d.children || d._children ? -10 : 10; })
            .attr("dy", ".35em")
            .style("text-anchor", function(d) { return d.children || d._children ? "end" : "start"; })
            .style("font-size", 12)
            .style("fill-opacity", 1e-6)
            .text(function(d) { return d.name; });

        var nodeUpdate = node.transition()
            .duration(duration)
            .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; });

        nodeUpdate.select("circle")
            .attr("r", 4.5)
            .style("fill", function(d) { return d._children ? "#E84A5F" : "#fff"; });

        nodeUpdate.select("text")
            .style("fill-opacity", 1);

        var nodeExit = node.exit()
            .transition()
                .duration(duration)
                .attr("transform", function(d) { return "translate(" + source.y + "," + source.x + ")"; })
                .remove();

        nodeExit.select("circle")
            .attr("r", 1e-6);

        nodeExit.select("text")
            .style("fill-opacity", 1e-6);


        // Links
        // ------------------------------

        // Update the links…
        var link = svg.selectAll(".d3-tree-link")
            .data(tree.links(nodes), function(d) { return d.target.id; });

        // Enter any new links at the parent's previous position.
        link.enter().insert("path", "g")
            .attr("class", "d3-tree-link")
            .style("fill", "none")
            .style("stroke", "#e3e3e3")
            .style("stroke-width", 1.5)
            .attr("d", function(d) {
                var o = {x: source.x0, y: source.y0};
                return diagonal({source: o, target: o});
            })
            .transition()
                .duration(duration)
                .attr("d", diagonal);

        // Transition links to their new position.
        link.transition()
            .duration(duration)
            .attr("d", diagonal);

        // Transition exiting nodes to the parent's new position.
        link.exit().transition()
            .duration(duration)
            .attr("d", function(d) {
            var o = {x: source.x, y: source.y};
                return diagonal({source: o, target: o});
            })
            .remove();

        // Stash the old positions for transition.
        nodes.forEach(function(d) {
            d.x0 = d.x;
            d.y0 = d.y;
        });


        // Resize chart
        // ------------------------------

        // Call function on window resize
        $(window).on('resize', resize);

        // Call function on sidebar width change
        $('.menu-toggle, .d3-tree-node circle').on('click', resize);


        // Resize function
        // 
        // Since D3 doesn't support SVG resize by default,
        // we need to manually specify parts of the graph that need to 
        // be updated on window resize
        function resize() {

            // Layout variables
            width = ele.node().getBoundingClientRect().width - margin.left - margin.right,
            nodes = tree.nodes(root),
            links = tree.links(nodes);

            // Layout
            // -------------------------

            // Main svg width
            container.attr("width", width + margin.left + margin.right);

            // Width of appended group
            svg.attr("width", width + margin.left + margin.right);


            // Tree size
            tree.size([height, width - 180]);

            diagonal.projection(function(d) { return [d.y, d.x]; });

            svg.selectAll(".d3-tree-link").attr("d", diagonal);
            svg.selectAll(".d3-tree-node").attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; });
        }
    }

    // Toggle childrens
    function toggle(d) {
        if (d.children) {
            d._children = d.children;
            d.children = null;
        }
        else {
            d.children = d._children;
            d._children = null;
        }
    }
});