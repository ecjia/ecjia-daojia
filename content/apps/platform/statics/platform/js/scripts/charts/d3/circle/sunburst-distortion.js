/*=========================================================================================
    File Name: line.js
    Description: D3 simple line chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Line chart
// ------------------------------
$(window).on("load", function(){

    var ele = d3.select("#sunburst-distortion"),
    width = ele.node().getBoundingClientRect().width,
    height = 400;
    radius = 190;

    // Color
    var color = d3.scale.ordinal()
        .range(["#99B898", "#FECEA8", "#FF847C", "#E84A5F", "#C06C84", "#6C5B7B", "#355C7D"]);

    var partition = d3.layout.partition()
        .size([2 * Math.PI, radius])
        .value(function(d) { return d.size; });

    var arc = d3.svg.arc()
        .startAngle(function(d) { return d.x; })
        .endAngle(function(d) { return d.x + d.dx; })
        .innerRadius(function(d) { return d.y; })
        .outerRadius(function(d) { return d.y + d.dy; });

    var svg = ele.append("svg")
        .attr("width", width)
        .attr("height", height)
      .append("g")
        .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

    d3.json("../../../app-assets/data/d3/circle/flare.json", function(error, root) {
      if (error) throw error;

      path = svg.data([root]).selectAll("path")
          .data(partition.nodes)
        .enter().append("path")
          .attr("d", arc)
          .style("fill", function(d) { return color((d.children ? d : d.parent).name); })
          .on("click", magnify)
          .each(stash);
    });

    // Distort the specified node to 80% of its parent.
    function magnify(node) {
      if (parent = node.parent) {
        var parent,
            x = parent.x,
            k = .8;
        parent.children.forEach(function(sibling) {
          x += reposition(sibling, x, sibling === node
              ? parent.dx * k / node.value
              : parent.dx * (1 - k) / (parent.value - node.value));
        });
      } else {
        reposition(node, 0, node.dx / node.value);
      }

      path.transition()
          .duration(750)
          .attrTween("d", arcTween);
    }

    // Recursively reposition the node at position x with scale k.
    function reposition(node, x, k) {
      node.x = x;
      if (node.children && (n = node.children.length)) {
        var i = -1, n;
        while (++i < n) x += reposition(node.children[i], x, k);
      }
      return node.dx = node.value * k;
    }

    // Stash the old values for transition.
    function stash(d) {
      d.x0 = d.x;
      d.dx0 = d.dx;
    }

    // Interpolate the arcs in data space.
    function arcTween(a) {
      var i = d3.interpolate({x: a.x0, dx: a.dx0}, a);
      return function(t) {
        var b = i(t);
        a.x0 = b.x;
        a.dx0 = b.dx;
        return arc(b);
      };
    }
});