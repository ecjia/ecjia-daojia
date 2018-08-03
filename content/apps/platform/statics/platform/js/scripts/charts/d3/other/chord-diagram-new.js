/*=========================================================================================
    File Name: chord-diagram.js
    Description: D3 chord diagram chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Chord Diagram
// ------------------------------
$(window).on("load", function(){

    // Matrix
    var matrix = [
        [6,32,47,81,31,89,24,68,50,39],
        [37,83,57,80,87,7,85,7,68,17],
        [50,15,31,3,1,85,36,95,83,99],
        [37,25,37,81,72,98,32,13,70,25],
        [19,99,97,79,74,43,78,18,4,57],
        [77,2,87,41,93,52,6,42,11,76],
        [44,54,60,69,36,44,76,58,50,16]
    ];

    var ele = d3.select("#chord-diagram");

    // Main variables
    var width = 800,
        height = 800,
        r0 = Math.min(width, height) * .37,
        r1 = r0 * 1.1;

    // Colors
    // var fill = d3.scale.category20c();
    var fill = d3.scale.ordinal()
        .range(["#99B898", "#FECEA8", "#FF847C", "#E84A5F", "#F8B195", "#F67280", "#C06C84"]);

    // Add chord layout
    var chord = d3.layout.chord()
        .padding(.05)
        .sortSubgroups(d3.descending)
        .matrix(matrix);

    // Create chart
    // var container = ele.append("svg");

    var svg = ele
        .append("svg")
            .attr("width", width)
            .attr("height", height)
            .append("g")
                .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

    // Bind data and add chord path
    svg.append("g")
        .selectAll(".chord-path")
        .data(chord.groups)
        .enter()
        .append("path")
            .attr("class", "chord-path")
            .style("fill", function(d) { return fill(d.index); })
            .style("stroke", function(d) { return fill(d.index); })
            .attr("d", d3.svg.arc().innerRadius(r0).outerRadius(r1))
            .on("mouseover", fade(.1, svg))
            .on("mouseout", fade(1, svg));


    // Add ticks
    // ------------------------------

    // Group
    var ticks = svg.append("g")
        .selectAll("g")
        .data(chord.groups)
        .enter()
        .append("g")
            .selectAll("g")
            .data(groupTicks)
            .enter()
            .append("g")
                .attr("transform", function(d) {
                    return "rotate(" + (d.angle * 180 / Math.PI - 90) + ")"
                    + "translate(" + r1 + ",0)";
                });

    // Add tick lines
    ticks.append("line")
        .attr("x1", 1)
        .attr("y1", 0)
        .attr("x2", 5)
        .attr("y2", 0)
        .style("stroke", "#2A363B");

    // Add tick text
    ticks.append("text")
        .attr("x", 8)
        .attr("dy", ".35em")
        .attr("text-anchor", function(d) {
            return d.angle > Math.PI ? "end" : null;
        })
        .attr("transform", function(d) {
            return d.angle > Math.PI ? "rotate(180)translate(-16)" : null;
        })
        .style("font-size", 12)
        .text(function(d) { return d.label; });


    // Add chord
    // ------------------------------

    svg.append("g")
        .attr("class", "d3-chord")
        .selectAll("path")
        .data(chord.chords)
        .enter()
        .append("path")
            .style("fill", function(d) { return fill(d.target.index); })
            .style("stroke", "#000")
            .style("stroke-width", 0.5)
            .style("fill-opacity", 0.7)
            .attr("d", d3.svg.chord().radius(r0))
            .style("opacity", 1);

    // Group Ticks
    function groupTicks(d) {
        var k = (d.endAngle - d.startAngle) / d.value;
        return d3.range(0, d.value, 50).map(function(v, i) {
            return {
                angle: v * k + d.startAngle,
                label: i % 2 ? null : v
            };
        });
    }

    // Fade Chord Group
    function fade(opacity, svg) {
        return function(g, i) {
            svg.selectAll(".d3-chord path").filter(function(d) {
                return d.source.index != i && d.target.index != i;
            })
            .transition()
            .style("opacity", opacity);
        };
    }
});