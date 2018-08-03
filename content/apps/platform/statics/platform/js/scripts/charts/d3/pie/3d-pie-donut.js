/*=========================================================================================
    File Name: 3d-pie-donut.js
    Description: D3 pie and donut chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// 3D pie and donut chart
// ------------------------------
$(window).on("load", function(){

    var quotesData=[
        {label:"Basic", value:25, color:"#99B898"},
        {label:"Plus", value:11, color:"#FECEA8"},
        {label:"Lite", value:22, color:"#FF847C"},
        {label:"Elite", value:28, color:"#E84A5F"},
        {label:"Delux", value:14, color:"#F8B195"}
    ];

    var salesData=[
        {label:"Basic", value:32, color:"#99B898"},
        {label:"Plus", value:14, color:"#FECEA8"},
        {label:"Lite", value:19, color:"#FF847C"},
        {label:"Elite", value:12, color:"#E84A5F"},
        {label:"Delux", value:23, color:"#F8B195"}
    ];

    var ele_pie = d3.select("#pie-3d"),
    ele_donut = d3.select("#donut-3d"),
    pie_width = ele_pie.node().getBoundingClientRect().width,
    pie_height = 500,
    donut_width = ele_donut.node().getBoundingClientRect().width,
    donut_height = 500;

    var pie_svg   = ele_pie.append("svg").attr("width",pie_width).attr("height",pie_height);
    var donut_svg = ele_donut.append("svg").attr("width",donut_width).attr("height",donut_height);

    pie_svg.append("g").attr("id","quotesDonut");
    donut_svg.append("g").attr("id","salesDonut");

    Donut3D.draw("quotesDonut", quotesData, pie_width / 2, pie_height / 2, 250, 210, 40, 0);

    Donut3D.draw("salesDonut", salesData, donut_width / 2, donut_height / 2, 250, 210, 40, 0.4);

    // Resize chart
    // ------------------------------

    // Call function on window resize
    $(window).on('resize', resize);

    // Call function on sidebar width change
    $('.menu-toggle').on('click', resize);

    // Resize function
    // ------------------------------
    function resize() {

        pie_width = ele_pie.node().getBoundingClientRect().width;
        donut_width = ele_donut.node().getBoundingClientRect().width;

        pie_x  = pie_width / 2;
        pie_y  = pie_height / 2;

        donut_x  = donut_width / 2;
        donut_y  = donut_height / 2;

        pie_svg.attr("width", pie_width);
        d3.select("#quotesDonut g").attr("transform", "translate(" + pie_x + "," + pie_y + ")");

        donut_svg.attr("width", donut_width);
        d3.select("#salesDonut g").attr("transform", "translate(" + donut_x + "," + donut_y + ")");
    }
});