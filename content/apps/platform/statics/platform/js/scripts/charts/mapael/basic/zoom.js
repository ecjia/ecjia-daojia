/*=========================================================================================
    File Name: zoom.js
    Description: zoom mapael vector map example
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Zoom mapael vector map
// ------------------------------

$(window).on("load", function(){

    $(".zoom").mapael({
        map: {
            name: "france_departments",
            // Enable zoom on the map
            zoom: {
                enabled: true,
                maxLevel: 10
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
                tooltip: {content: "Morbihan (56)"}
            },
            "department-21": {
                attrs: {
                    fill: "#FF847C"
                },
                attrsHover: {
                    fill: "#99B898"
                }
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
                }
            },
            // SVG plot
            'Limoge': {
                type: "svg",
                path: "M 24.267286,27.102843 15.08644,22.838269 6.3686216,27.983579 7.5874348,17.934248 0,11.2331 9.9341158,9.2868473 13.962641,0 l 4.920808,8.8464793 10.077199,0.961561 -6.892889,7.4136777 z",
                width: 30,
                height: 30,
                latitude: 45.8188276,
                longitude: 1.1060351,
                attrs: {
                    opacity: 1
                }
            },
            // Circle plot
            'lyon': {
                type: "circle",
                size: 50,
                latitude: 45.758888888889,
                longitude: 4.8413888888889,
                value: 700000,
                tooltip: {content: "<span style=\"font-weight:bold;\">City :</span> Lyon"},
                text: {content: "Lyon"}
            },
            // Square plot
            'rennes': {
                type: "square",
                size: 20,
                latitude: 48.114166666667,
                longitude: -1.6808333333333,
                tooltip: {content: "<span style=\"font-weight:bold;\">City :</span> Rennes"},
                text: {content: "Rennes"}
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
            },
            'Bordeaux': {
                type: "circle",
                size: 30,
                latitude: 44.834763,
                longitude: -0.580991,
                attrs: {
                    opacity: 1
                },
                text: {
                    content: "33",
                    position: "inner",
                    attrs: {
                        "font-size": 16,
                        "font-weight": "bold",
                        fill: "#fff"
                    },
                    attrsHover: {
                        "font-size": 16,
                        "font-weight": "bold",
                        fill: "#fff"
                    }
                }
            }
        }
    });

});