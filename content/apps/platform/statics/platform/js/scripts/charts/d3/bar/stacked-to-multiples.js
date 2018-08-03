/*=========================================================================================
    File Name: stacked-to-multiples.js
    Description: D3 stacked to multiples chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Stacked to multiples chart
// ------------------------------
$(window).on("load", function(){

    var ele = d3.select("#stacked-to-multiples"),
    margin = {top: 20, right: 20, bottom: 30, left: 60},
    width = ele.node().getBoundingClientRect().width - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

    // Format data
    var parseDate = d3.time.format("%Y-%m").parse,
        formatYear = d3.format("02d"),
        formatDate = function(d) { return "Q" + ((d.getMonth() / 3 | 0) + 1) + formatYear(d.getFullYear() % 100); };

    // Initialize Scales
    // ------------------------------

    var y0 = d3.scale.ordinal()
        .rangeRoundBands([height, 0], .2);

    var y1 = d3.scale.linear();

    var x = d3.scale.ordinal()
        .rangeRoundBands([0, width], .1, 0);

    // Initialize Axis
    // ------------------------------
    var xAxis = d3.svg.axis()
        .scale(x)
        .orient("bottom")
        .tickFormat(formatDate);

    // Chart
    var nest = d3.nest()
        .key(function(d) { return d.group; });

    var stack = d3.layout.stack()
        .values(function(d) { return d.values; })
        .x(function(d) { return d.date; })
        .y(function(d) { return d.value; })
        .out(function(d, y0) { d.valueOffset = y0; });

    var color = d3.scale.ordinal()
        .range(["#99B898", "#FECEA8", "#FF847C", "#E84A5F"]);

    var container = ele.append("svg");

    var svg = container
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
      .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");


    // Load data
    // ------------------------------

    d3.tsv("../../../app-assets/data/d3/bar/stacked-to-multiples.tsv", function(error, data) {
        if (error) throw error;

        data.forEach(function(d) {
            d.date = parseDate(d.date);
            d.value = +d.value;
        });

        var dataByGroup = nest.entries(data);

        stack(dataByGroup);
        x.domain(dataByGroup[0].values.map(function(d) { return d.date; }));
        y0.domain(dataByGroup.map(function(d) { return d.key; }));
        y1.domain([0, d3.max(data, function(d) { return d.value; })]).range([y0.rangeBand(), 0]);

        var group = svg.selectAll(".d3-bar-group")
            .data(dataByGroup)
        .enter().append("g")
            .attr("class", "d3-bar-group")
            .attr("transform", function(d) { return "translate(0," + y0(d.key) + ")"; });

        group.append("text")
            .attr("class", "d3-group-label")
            .attr("x", -60)
            .attr("y", function(d) { return y1(d.values[0].value / 2); })
            .attr("dy", ".35em")
            .text(function(d) { return "Group " + d.key; });

        group.selectAll(".d3-bar")
            .data(function(d) { return d.values; })
        .enter().append("rect")
            .attr("class", "d3-bar")
            .style("fill", function(d) { return color(d.group); })
            .attr("x", function(d) { return x(d.date); })
            .attr("y", function(d) { return y1(d.value); })
            .attr("width", x.rangeBand())
            .attr("height", function(d) { return y0.rangeBand() - y1(d.value); });

        group.filter(function(d, i) { return !i; }).append("g")
            .attr("class", "d3-axis d3-xaxis")
            .attr("transform", "translate(0," + y0.rangeBand() + ")")
            .call(xAxis);

        d3.selectAll(".smradio").on("change", change);

        var timeout = setTimeout(function() {
            d3.select("input[value=\"stacked\"]").property("checked", true).each(change);
        }, 2000);

        function change() {
            clearTimeout(timeout);
            if (this.value === "multiples") transitionMultiples();
            else transitionStacked();
        }

        function transitionMultiples() {
            var t = svg.transition().duration(750),
                g = t.selectAll(".d3-bar-group").attr("transform", function(d) { return "translate(0," + y0(d.key) + ")"; });
            g.selectAll(".d3-bar").attr("y", function(d) { return y1(d.value); });
            g.select(".d3-group-label").attr("y", function(d) { return y1(d.values[0].value / 2); });
        }

        function transitionStacked() {
            var t = svg.transition().duration(750),
                g = t.selectAll(".d3-bar-group").attr("transform", "translate(0," + y0(y0.domain()[0]) + ")");
            g.selectAll(".d3-bar").attr("y", function(d) { return y1(d.value + d.valueOffset); });
            g.select(".d3-group-label").attr("y", function(d) { return y1(d.values[0].value / 2 + d.values[0].valueOffset); });
        }
    });

    // Resize chart
    // ------------------------------

    // Call function on window resize
    $(window).on('resize', resize);

    // Call function on sidebar width change
    $('.menu-toggle').on('click', resize);

    // Resize function
    // ------------------------------
    function resize() {

        width = ele.node().getBoundingClientRect().width - margin.left - margin.right;

        // Main svg width
        container.attr("width", width + margin.left + margin.right);

        // Width of appended group
        svg.attr("width", width + margin.left + margin.right);


        // Axis
        // -------------------------
        x.rangeRoundBands([0, width], .1, 0);
        svg.selectAll('.d3-xaxis').call(xAxis);


        svg.selectAll('.d3-bar').attr("x", function(d) { return x(d.date); }).attr("width", x.rangeBand());
    }
});