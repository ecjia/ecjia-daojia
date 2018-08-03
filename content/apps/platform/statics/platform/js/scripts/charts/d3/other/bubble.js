/*=========================================================================================
    File Name: bubble.js
    Description: D3 bubble chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Bubble chart
// ------------------------------
$(window).on("load", function(){

    var ele = d3.select("#bubble-chart"),
    diameter = 960,
    format = d3.format(",d"),
    color = d3.scale.category20c();

    //  Chart
    var bubble = d3.layout.pack()
        .sort(null)
        .size([diameter, diameter])
        .padding(1.5);

    var svg = ele.append("svg")
        .attr("width", diameter)
        .attr("height", diameter)
        .attr("class", "bubble");

    // Load data
    // ------------------------------

    d3.json("../../../app-assets/data/d3/other/flare.json", function(error, root) {
        if (error) throw error;

        var node = svg.selectAll(".node")
          .data(bubble.nodes(classes(root))
          .filter(function(d) { return !d.children; }))
        .enter().append("g")
          .attr("class", "node")
          .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });

        node.append("title")
          .text(function(d) { return d.className + ": " + format(d.value); });

        node.append("circle")
          .attr("r", function(d) { return d.r; })
          .style("fill", function(d) { return color(d.packageName); });

        node.append("text")
          .attr("dy", ".3em")
          .style("text-anchor", "middle")
          .style("font-size", "10px")
          .text(function(d) { return d.className.substring(0, d.r / 3); });
    });


    // Returns a flattened hierarchy containing all leaf nodes under the root.
    function classes(root) {
        var classes = [];

        function recurse(name, node) {
            if (node.children) node.children.forEach(function(child) { recurse(node.name, child); });
            else classes.push({packageName: name, className: node.name, value: node.size});
        }

        recurse(null, root);
        return {children: classes};
    }

    d3.select(self.frameElement).style("height", diameter + "px");
});