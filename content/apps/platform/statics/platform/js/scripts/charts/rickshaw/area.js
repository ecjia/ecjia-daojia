/*=========================================================================================
    File Name: area.js
    Description: Rickshaw area chart
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Area chart
// ------------------------------
$(window).on("load", function(){

    var seriesData = [
        [],
        [],
        [],
        []
    ];
    var random = new Rickshaw.Fixtures.RandomData(150);

    for (var i = 0; i < 150; i++) {
        random.addData(seriesData);
    }

    var $element = $('#area-chart');
    var graph = new Rickshaw.Graph({
        element: $element.get(0),
        width: $element.width(),
        height: 400,
        renderer: 'area',
        stroke: true,
        series: [{
            color: '#99B898',
            data: seriesData[0],
            name: 'New York'
        }, {
            color: '#FECEA8',
            data: seriesData[1],
            name: 'London'
        }, {
            color: '#FF847C',
            data: seriesData[2],
            name: 'Tokyo'
        }, {
            color: '#6C5B7B',
            data: seriesData[3],
            name: 'Paris'
        }]
    });

    graph.render();

    setInterval(function() {
        random.removeData(seriesData);
        random.addData(seriesData);
        graph.update();

    }, 2000);

    var hoverDetail = new Rickshaw.Graph.HoverDetail({
        graph: graph
    });

    var legend = new Rickshaw.Graph.Legend({
        graph: graph,
        element: document.getElementById('area-chart-legend')
    });

    var shelving = new Rickshaw.Graph.Behavior.Series.Toggle({
        graph: graph,
        legend: legend
    });

    $(window).on('resize', function() {
        graph.configure({
            width: $element.width()
        });
        graph.render();
    });
});