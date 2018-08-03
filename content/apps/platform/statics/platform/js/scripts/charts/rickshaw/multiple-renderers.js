/*=========================================================================================
    File Name: multiple-renderers.js
    Description: Rickshaw multiple renderers chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: GeeksLabs
    Author URL: http://www.themeforest.net/user/geekslabs
==========================================================================================*/

// Multiple renderers chart
// ------------------------------
$(window).on("load", function(){

    var seriesData = [ [], [], [], [], [] ];
    var random = new Rickshaw.Fixtures.RandomData(50);

    for (var i = 0; i < 75; i++) {
        random.addData(seriesData);
    }

    var graph = new Rickshaw.Graph( {
        element: document.getElementById("multiple-renderers"),
        renderer: 'multi',
        // width: 900,
        height: 500,
        dotSize: 5,
        series: [
            {
                name: 'temperature',
                data: seriesData.shift(),
                color: 'rgba(153,184,152, 0.6)',
                renderer: 'stack'
            }, {
                name: 'heat index',
                data: seriesData.shift(),
                color: 'rgba(254,206,168, 0.6)',
                renderer: 'stack'
            }, {
                name: 'dewpoint',
                data: seriesData.shift(),
                color: 'rgba(255,132,124, 0.5)',
                renderer: 'scatterplot'
            }, {
                name: 'pop',
                data: seriesData.shift().map(function(d) { return { x: d.x, y: d.y / 4 } }),
                color: 'rgba(232,74,95, 0.6)',
                renderer: 'bar'
            }, {
                name: 'humidity',
                data: seriesData.shift().map(function(d) { return { x: d.x, y: d.y * 1.5 } }),
                renderer: 'line',
                color: 'rgba(108,91,123, 0.35)'
            }
        ]
    } );

    var slider = new Rickshaw.Graph.RangeSlider.Preview({
        graph: graph,
        element: document.querySelector('#slider')
    });

    graph.render();

    var detail = new Rickshaw.Graph.HoverDetail({
        graph: graph
    });

    var legend = new Rickshaw.Graph.Legend({
        graph: graph,
        element: document.querySelector('#multiple-renderers-legend')
    });

    var highlighter = new Rickshaw.Graph.Behavior.Series.Highlight({
        graph: graph,
        legend: legend,
        disabledColor: function() { return 'rgba(0, 0, 0, 0.2)' }
    });

    var highlighter = new Rickshaw.Graph.Behavior.Series.Toggle({
        graph: graph,
        legend: legend
    });
});