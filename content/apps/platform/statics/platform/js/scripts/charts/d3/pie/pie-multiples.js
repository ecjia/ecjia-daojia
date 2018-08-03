/*=========================================================================================
    File Name: pie-multiples.js
    Description: D3 pie multiples chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Pie multiples chart
// ------------------------------
$(window).on("load", function(){

    var ele = d3.select("#pie-muliples"),
    margin = 10,
    width = 300,
    height = 300;
    radius = (Math.min(width, height) - (margin * 2) ) / 2;

    // Data
    var data = [
        [ 25,  11, 22, 28, 14],
        [ 51, 87, 65, 42, 78],
        [ 65, 35, 80, 90, 75],
        [ 36, 78, 64,  32, 69]
    ];

    // Colors
    var colors = d3.scale.ordinal()
    .range(["#99B898", "#FECEA8", "#FF847C", "#E84A5F", "#F8B195", "#F67280", "#C06C84"]);


    // Chart
    // ------------------------------

    var svg = ele
        .selectAll("svg")
        .data(data)
        .enter()
        .append("svg")
            .attr("width", width)
            .attr("height", height)
            .append("g")
                .attr("class", "d3-arc")
                .attr("transform", "translate(" + (radius + margin) + "," + (radius + margin) + ")");

    // Arc
    var arc = d3.svg.arc()
        .innerRadius(0)
        .outerRadius(radius);


    svg.selectAll("path")
        .data(d3.layout.pie())
        .enter()
        .append("path")
            .attr("d", arc)
            .style("stroke", "#fff")
            .style("fill", function(d, i) { return colors(i); });

});