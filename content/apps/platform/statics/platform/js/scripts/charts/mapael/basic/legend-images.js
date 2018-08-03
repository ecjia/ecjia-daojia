/*=========================================================================================
    File Name: legend-images.js
    Description: legend images mapael vector map example.
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Legend images mapael vector map
// --------------------------------

$(window).on("load", function(){

    $(".legend-images").mapael({
        map: {
            name: "usa_states",
            defaultArea: {
                attrs: {
                    fill: "#FECEA8",
                    stroke: "#FFFFFF"
                },
                attrsHover: {
                    fill: "#99B898"
                }
            }
        },
        legend: {
            plot: {
                title: "American cities",
                slices: [{
                    label: "Value 1",
                    sliceValue: "Value 1",
                    type: "image",
                    url: "http://www.neveldo.fr/mapael/assets/img/marker.png",
                    width: 18,
                    height: 60,
                    attrsHover: {
                        transform: "s1.5"
                    }
                }, {
                    label: "Value 2",
                    sliceValue: "Value 2",
                    type: "image",
                    url: "http://www.neveldo.fr/mapael/assets/img/marker1.png",
                    width: 18,
                    height: 60,
                    attrsHover: {
                        transform: "s1.5"
                    }
                }]
            }
        },
        plots: {
            'ny': {
                latitude: 40.717079,
                longitude: -74.00116,
                tooltip: {content: "New York"},
                value: "Value 1"
            },
            'an': {
                latitude: 61.2108398,
                longitude: -149.9019557,
                tooltip: {content: "Anchorage"},
                value: "Value 2"
            },
            'sf': {
                latitude: 37.792032,
                longitude: -122.394613,
                tooltip: {content: "San Francisco"},
                value: "Value 1"
            },
            'pa': {
                latitude: 19.493204,
                longitude: -154.8199569,
                tooltip: {content: "Pahoa"},
                value: "Value 2"
            },
            'la': {
                latitude: 34.025052,
                longitude: -118.192006,
                tooltip: {content: "Los Angeles"},
                value: "Value 1"
            },
            'dallas': {
                latitude: 32.784881,
                longitude: -96.808244,
                tooltip: {content: "Dallas"},
                value: "Value 2"
            },
            'miami': {
                latitude: 25.789125,
                longitude: -80.205674,
                tooltip: {content: "Miami"},
                value: "Value 2"
            },
            'washington': {
                latitude: 38.905761,
                longitude: -77.020746,
                tooltip: {content: "Washington"},
                value: "Value 2"
            },
            'seattle': {
                latitude: 47.599571,
                longitude: -122.319426,
                tooltip: {content: "Seattle"},
                value: "Value 1"
            }
        }
    });

});