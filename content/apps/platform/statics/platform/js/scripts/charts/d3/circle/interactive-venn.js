/*=========================================================================================
    File Name: interavtive-venn.js
    Description: D3 interavtive venn diagram
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Interactive venn diagram
// ------------------------------
$(window).on("load", function(){

    var sets = [
        {sets : [0], label : 'SE', size : 28,},
        {sets : [1], label : 'Treat', size: 35},
        {sets : [2], label : 'Anti-CCP', size : 108},
        {sets : [3], label : 'DAS28', size:106},
        {sets : [0,1], size:1},
        {sets : [0,2], size:1},
        {sets : [0,3], size:14},
        {sets : [1,2], size:6},
        {sets : [1,3], size:0},
        {sets : [2,3], size:1},
        {sets : [0,2,3], size:1},
        {sets : [0,1,2], size:0},
        {sets : [0,1,3], size:0},
        {sets : [1,2,3], size:0},
        {sets : [0,1,2,3], size:0}
    ];

    var ele = d3.select("#interactive-venn");
    var diagram = venn.VennDiagram()
                    .width(400)
                    .height(400)
                    .fontSize("24px");

    sets.sort(function(a,b) { return a.size - b.size; });

    ele.datum(sets).call(diagram);

    var colors = d3.scale.ordinal()
        .range(["#99B898", "#FECEA8", "#FF847C", "#6C5B7B"]);

    ele.selectAll(".venn-circle path")
        .style("fill-opacity", 0)
        .style("stroke-width", 10)
        .style("stroke-opacity", .5)
        .style("fill", function(d,i) { return colors(i); })
        .style("stroke", function(d,i) { return colors(i); });

    ele.selectAll(".venn-circle text")
        .style("fill", function(d,i) { return colors(i)})
        .style("font-weight", "100");

    ele.selectAll(".venn-circle")
        .on("mouseover", function(d, i) {
            var node = d3.select(this).transition();
            node.select("path").style("fill-opacity", .2);
            node.select("text").style("font-weight", "100")
                               .style("font-size", "30px");
        })
        .on("mouseout", function(d, i) {
            var node = d3.select(this).transition();
            node.select("path").style("fill-opacity", 0);
            node.select("text").style("font-weight", "100")
                               .style("font-size", "24px");
        });

});