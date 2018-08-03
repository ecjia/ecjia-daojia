/*=========================================================================================
    File Name: href-plotted-cities.js
    Description: href plotted cities mapael vector map example.
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Href plotted cities mapael vector map
// -------------------------------------

$(window).on("load", function(){

    $(".href-plotted-cities").mapael({
        map: {
            name: "france_departments",
            // Enable zoom on the map
            zoom: {
                enabled: true
            },
            // Set default plots and areas style
            defaultPlot: {
                attrs: {
                    fill: "#E84A5F",
                    opacity: 0.8
                },
                attrsHover: {
                    opacity: 1
                },
                text: {
                    attrs: {
                        fill: "#2A363B"
                    },
                    attrsHover: {
                        fill: "#000"
                    }
                }
            },
            defaultArea: {
                attrs: {
                    fill: "#FECEA8",
                    stroke: "#FFFFFF"
                },
                attrsHover: {
                    fill: "#99B898"
                },
                text: {
                    attrs: {
                        fill: "#2A363B"
                    },
                    attrsHover: {
                        fill: "#000"
                    }
                }
            }
        },

        // Customize some areas of the map
        areas: {
            "department-56": {
                text: {content: "Morbihan", attrs: {"font-size": 10}},
                tooltip: {content: "Morbihan (56)"},
                href: "http://fr.wikipedia.org/wiki/Morbihan"
            },
            "department-21": {
                attrs: {
                    fill: "#FF847C"
                },
                attrsHover: {
                    fill: "#99B898"
                },
                href: "http://fr.wikipedia.org/wiki/C%C3%B4te-d%27Or",
                target: "_blank"
            }
        },

        // Add some plots on the map
        plots: {
            // Image plot
            'paris': {
                type: "image",
                url: "http://www.neveldo.fr/mapael/assets/img/marker.png",
                width: 12,
                height: 40,
                latitude: 48.86,
                longitude: 2.3444,
                attrs: {
                    opacity: 1
                },
                attrsHover: {
                    transform: "s1.5"
                },
                href: "http://fr.wikipedia.org/wiki/Paris",
                target: "_blank"
            },
            // Circle plot
            'lyon': {
                type: "circle",
                size: 50,
                latitude: 45.758888888889,
                longitude: 4.8413888888889,
                value: 700000,
                tooltip: {content: "<span style=\"font-weight:bold;\">City :</span> Lyon"},
                text: {content: "Lyon"},
                href: "http://fr.wikipedia.org/wiki/Lyon"
            },
            // Square plot
            'rennes': {
                type: "square",
                size: 20,
                latitude: 48.114166666667,
                longitude: -1.6808333333333,
                tooltip: {content: "<span style=\"font-weight:bold;\">City :</span> Rennes"},
                text: {content: "Rennes"},
                href: "http://fr.wikipedia.org/wiki/Rennes"
            },
            // Plot positioned by x and y instead of latitude, longitude
            'myplot': {
                x: 300,
                y: 200,
                text: {
                    content: "My plot",
                    position: "bottom",
                    attrs: {"font-size": 10, fill: "#E84A5F", opacity: 0.8},
                    attrsHover: {fill: "#E84A5F", opacity: 1}
                },
            }
        }
    });

});