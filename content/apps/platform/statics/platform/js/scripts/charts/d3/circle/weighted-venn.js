/*=========================================================================================
    File Name: weighted-venn.js
    Description: D3 weighted venn diagram
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Weighted venn diagram
// ------------------------------
$(window).on("load", function(){

    var ele = d3.select("#weighted-venn");

    var sets = [
        {sets: [0], size: 1958},
        {sets: [1], size: 1856},
        {sets: [2], size: 297},
        {sets: [3], size: 17281},
        {sets: [4], size: 4301},
        {sets: [2,0], size: 123},
        {sets: [2,1], size: 139},
        {sets: [2,3], size: 92},
        {sets: [2,4], size: 12},
        {sets: [0,0], size: 0, weight: 1e-10},
        {sets: [0,1], size: 0, weight: 1e-10},
        {sets: [0,3], size: 0, weight: 1e-10},
        {sets: [0,4], size: 0, weight: 1e-10},
        {sets: [1,0], size: 0, weight: 1e-10},
        {sets: [1,1], size: 0, weight: 1e-10},
        {sets: [1,3], size: 0, weight: 1e-10},
        {sets: [1,4], size: 0, weight: 1e-10},
        {sets: [3,0], size: 0, weight: 1e-10},
        {sets: [3,1], size: 0, weight: 1e-10},
        {sets: [3,3], size: 0, weight: 1e-10},
        {sets: [3,4], size: 0, weight: 1e-10},
        {sets: [4,0], size: 0, weight: 1e-10},
        {sets: [4,1], size: 0, weight: 1e-10},
        {sets: [4,3], size: 0, weight: 1e-10},
        {sets: [4,4], size: 0, weight: 1e-10}
    ];

    var chart = venn.VennDiagram()
                    .width(400)
                    .height(400)
                    .fontSize("18px");

    ele.datum(sets).call(chart);

    ele.selectAll(".venn-circle text")
        .style("font-weight", "100");
});