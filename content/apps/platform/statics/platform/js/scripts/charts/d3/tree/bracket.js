 /*=========================================================================================
    File Name: baracket.js
    Description: D3 bracket tree chart with pan and zoom
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Basic Tree chart
// ------------------------------
$(window).on("load", function(){

    var ele = d3.select('#bracket-tree'),
        margin = {top: 0, right: 0, bottom: 0, left: 0},
        width = ele.node().getBoundingClientRect().width - margin.left - margin.right,
        halfWidth = width / 2,
        height = 600 - margin.top - margin.bottom - 5,
        i = 0,
        duration = 500,
        root;



    // Chart
    // ------------------------------

    var container = ele.append("svg");

    var svg = container
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    var getChildren = function(d) {
        var a = [];
        if(d.winners) for(var i = 0; i < d.winners.length; i++){
            d.winners[i].isRight = false;
            d.winners[i].parent = d;
            a.push(d.winners[i]);
        }
        if(d.challengers) for(var i = 0; i < d.challengers.length; i++){
            d.challengers[i].isRight = true;
            d.challengers[i].parent = d;
            a.push(d.challengers[i]);
        }
        return a.length?a:null;
    };

    // Zoom with scale
    var zoom = d3.behavior.zoom()
        .scaleExtent([1,2])
        .on('zoom', function(){
            svg.attr("transform", "translate(" + d3.event.translate + ") scale(" + d3.event.scale + ")");
        });

    // Initialize zoom
    container.call(zoom);

    var tree = d3.layout.tree()
        .size([height, width]);

    var diagonal = d3.svg.diagonal()
        .projection(function(d) { return [d.y, d.x]; });


    var elbow = function (d, i){
        var source = calcLeft(d.source),
            target = calcLeft(d.target),
            hy = (target.y-source.y) / 2;

            if(d.isRight) hy = -hy;
            return "M" + source.y + "," + source.x + "H" + (source.y + hy) + "V" + target.x + "H" + target.y;
    };
    var connector = elbow;

    var calcLeft = function(d) {
        var l = d.y;
        if(!d.isRight) {
            l = d.y-halfWidth;
            l = halfWidth - l;
        }
        return {x : d.x, y : l};
    };

    var toArray = function(item, arr){
        arr = arr || [];
        var i = 0,
        l = item.children?item.children.length : 0;

        arr.push(item);
        for(; i < l; i++) {
            toArray(item.children[i], arr);
        }
        return arr;
    };



    // Load data
    // ------------------------------

    d3.json("../../../app-assets/data/d3/tree/bracket-tree.json", function(json) {
        root = json;
        root.x0 = height / 2;
        root.y0 = width / 2;

        // Add tree layout
        var t1 = d3.layout.tree().size([height, halfWidth]).children(function(d){return d.winners;}),
            t2 = d3.layout.tree().size([height, halfWidth]).children(function(d){return d.challengers;});
            t1.nodes(root);
            t2.nodes(root);

        // Rebuild children nodes
        var rebuildChildren = function(node){
            node.children = getChildren(node);
            if(node.children) node.children.forEach(rebuildChildren);
        }
        rebuildChildren(root);
        root.isRight = false;
        update(root);
    });



    // Layout setup
    // ------------------------------

    function update(source) {

        var nodes = toArray(source);
        nodes.forEach(function(d) { d.y = d.depth * 180 + halfWidth; });

        var node = svg.selectAll("g.node")
            .data(nodes, function(d) { return d.id || (d.id = ++i); });

        nodes.forEach(function(d) {
            var p = calcLeft(d);
            d.x0 = p.x;
            d.y0 = p.y;
        });


        // Enter nodes
        // ------------------------------

        var nodeEnter = node.enter().append("g")
            .attr("class", "node")
            .attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; })
            .on("click", click);    

        nodeEnter.append("circle")
            .attr("r", 1e-6)
            .style("stroke", "#F6BB42")
            .style("stroke-width", 1.5)
            .style("cursor", "pointer")
            .style("fill", function(d) { return d._children ? "#F6BB42" : "#fff"; });

        nodeEnter.append("text")
        .attr("dy", function(d) { return d.isRight?18:-12;})
        .attr("text-anchor", "middle")
        .text(function(d) { return d.name; })
        .style("font-size", 12)
        .style("fill-opacity", 1e-6);


        var nodeUpdate = node.transition()
            .duration(duration)
            .attr("transform", function(d) { p = calcLeft(d); return "translate(" + p.y + "," + p.x + ")"; });

        nodeUpdate.select("circle")
            .attr("r", 4.5)
            .style("fill", function(d) { return d._children ? "#F6BB42" : "#fff"; });

        nodeUpdate.select("text")
            .style("fill-opacity", 1);

        var nodeExit = node.exit().transition()
            .duration(duration)
            .attr("transform", function(d) { p = calcLeft(d.parent||source); return "translate(" + p.y + "," + p.x + ")"; })
            .remove();

        nodeExit.select("circle")
            .attr("r", 1e-6);

        nodeExit.select("text")
            .style("fill-opacity", 1e-6);



        // Links
        // ------------------------------

        var link = svg.selectAll("path.link")
            .data(tree.links(nodes), function(d) { return d.target.id; });

        link.enter().insert("path", "g")
            .attr("class", "link")
            .style("stroke", "#F6BB42")
            .style("fill", "none")
            .style("stroke-width", 1.5)
            .attr("d", function(d) {
                var o = {x: source.x0, y: source.y0};
                return connector({source: o, target: o});
            });

        link.transition()
            .duration(duration)
            .attr("d", connector);

        link.exit().transition()
            .duration(duration)
            .attr("d", function(d) {
                var o = calcLeft(d.source||source);
                if(d.source.isRight) o.y -= halfWidth - (d.target.y - d.source.y);
                else o.y += halfWidth - (d.target.y - d.source.y);
                return connector({source: o, target: o});
            })
            .remove();

        function click(d) {
            if (d.children) {
                d._children = d.children;
                d.children = null;
            } else {
                d.children = d._children;
                d._children = null;
            }
            update(source);
        }


        // Resize chart
        // ------------------------------

        // Call function on window resize
        $(window).on('resize', resize);

        // Call function on sidebar width change
        $('.menu-toggle').on('click', resize);


        // Resize function
        function resize() {

            // Layout variables
            width = ele.node().getBoundingClientRect().width - margin.left - margin.right,

            // Main svg width
            container.attr("width", width + margin.left + margin.right);

            svg.attr("width", width + margin.left + margin.right);
        }
    }
});