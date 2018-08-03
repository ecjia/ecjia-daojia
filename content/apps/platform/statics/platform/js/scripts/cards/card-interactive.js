/*=========================================================================================
    File Name: card-interactive.js
    Description: Interactive cards
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: GeeksLabs
    Author URL: http://www.themeforest.net/user/geekslabs
==========================================================================================*/
(function(window, document, $) {
    'use strict';

    /****************************************************
    *               Interactive Charts                  *
    ****************************************************/

    // Live visits from specific countries
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

    var liveVisits = $('#live-visits');
    var liveVisitsGraph = new Rickshaw.Graph({
        element: liveVisits.get(0),
        width: liveVisits.width(),
        height: 400,
        renderer: 'area',
        stroke: true,
        series: [{
            color: '#99B898',
            data: seriesData[0],
            name: 'Asia'
        }, {
            color: '#FECEA8',
            data: seriesData[1],
            name: 'Africa'
        }, {
            color: '#FF847C',
            data: seriesData[2],
            name: 'America'
        }, {
            color: '#6C5B7B',
            data: seriesData[3],
            name: 'Europe'
        }]
    });

    liveVisitsGraph.render();

    setInterval(function() {
        random.removeData(seriesData);
        random.addData(seriesData);
        liveVisitsGraph.update();

    }, 2000);

    var hoverDetail = new Rickshaw.Graph.HoverDetail({
        graph: liveVisitsGraph
    });

    var shelving = new Rickshaw.Graph.Behavior.Series.Toggle({
        graph: liveVisitsGraph,
        // legend: legend
    });

    $(window).on('resize', function() {
        liveVisitsGraph.configure({
            width: liveVisits.width()
        });
        liveVisitsGraph.render();
    });

    //Get the context of the Chart canvas element we want to select
    var liveVisitsDoughnut = $("#live-visits-doughnut");

    // Chart Options
    var liveVisitsOptions = {
        responsive: true,
        maintainAspectRatio: false,
        responsiveAnimationDuration:500,
    };

    // Chart Data
    var liveVisitsData = {
        labels: ["Asia", "Africa", "America", "Europe"],
        datasets: [{
            label: "My First dataset",
            data: [15684, 54789, 89756, 23489],
            backgroundColor: ["#99B898","#FECEA8","#FF847C","#6C5B7B"],
        }]
    };

    var liveVisitsConfig = {
        type: 'doughnut',

        // Chart Options
        options : liveVisitsOptions,

        data : liveVisitsData
    };

    // Create the chart
    var visitsDoughnutChart = new Chart(liveVisitsDoughnut, liveVisitsConfig);


})(window, document, jQuery);