/*=========================================================================================
    File Name: venn-venn.js
    Description: D3 venn diagram
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Venn diagram
// ------------------------------
$(window).on("load", function(){

    var sets = [
        {sets:["Information"], size: 12},
        {sets:["Things That Overlap"], size: 12},
        {sets:["Circles"], size: 12},
        {sets: ["Information", "Things That Overlap"], size: 4, label: "Redundancy"},
        {sets: ["Information", "Circles"], size: 4, label: "Pie Charts", },
        {sets: ["Things That Overlap", "Circles"], size: 4, label: "Eclipses"},
        {sets: ["Information", "Things That Overlap", "Circles"], size: 2, label: "Venn Diagrams"}
    ];

    var ele = d3.select("#venn-diagram");

    var chart = venn.VennDiagram();

    chart.wrap(false)
    .width(400)
    .height(400)
    .fontSize("16px");

    var div = ele.datum(sets).call(chart);
        div.selectAll("text").style("fill", "white").style('font-weight','100');
        div.selectAll(".venn-circle path").style("fill-opacity", .6);
    });