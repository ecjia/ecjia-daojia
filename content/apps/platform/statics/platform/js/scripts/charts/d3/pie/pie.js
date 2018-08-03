/*=========================================================================================
    File Name: pie.js
    Description: D3 simple pie chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Pie chart
// ------------------------------
$(window).on("load", function(){

    var ele = d3.select("#basic-pie"),
    width = ele.node().getBoundingClientRect().width,
    height = 500,
    radius = Math.min(width, height) / 2;

    var color = d3.scale.ordinal()
    .range(["#99B898", "#FECEA8", "#FF847C", "#E84A5F", "#F8B195", "#F67280", "#C06C84"]);

    var arc = d3.svg.arc()
        .outerRadius(radius - 10)
        .innerRadius(0);

    var labelArc = d3.svg.arc()
        .outerRadius(radius - 60)
        .innerRadius(radius - 60);

    var pie = d3.layout.pie()
        .sort(null)
        .value(function(d) { return d.population; });

    var container = ele.append('svg');

    var svg = container
        .attr("width", width)
        .attr("height", height)
      .append("g")
        .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

    d3.csv("../../../app-assets/data/d3/pie/pie.csv", type, function(error, data) {
      if (error) throw error;

        var g = svg.selectAll(".arc")
          .data(pie(data))
        .enter().append("g")
          .attr("class", "arc");

        g.append("path")
          .attr("d", arc)
          .style("fill", function(d) { return color(d.data.age); })
          .style("stroke", "#FFF");

        g.append("text")
            .attr("transform", function(d) { return "translate(" + labelArc.centroid(d) + ")"; })
            .attr("dy", ".35em")
            .style("fill", "#FFF")
            .text(function(d) { return d.data.age; });
    });

    function type(d) {
        d.population = +d.population;
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

        width = ele.node().getBoundingClientRect().width;
        radius = Math.min(width, height) / 2;

        container.attr("width", width);
        svg.attr("width", width)
            .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

        arc = d3.svg.arc()
            .outerRadius(radius - 10)
            .innerRadius(0);

        labelArc = d3.svg.arc()
            .outerRadius(radius - 60)
            .innerRadius(radius - 60);

        svg.selectAll("path").attr("d", arc);
        svg.selectAll("text")
            .attr("transform", function(d) { return "translate(" + labelArc.centroid(d) + ")"; });
    }

});