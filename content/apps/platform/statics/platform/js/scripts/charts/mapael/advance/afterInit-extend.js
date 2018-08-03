/*=========================================================================================
    File Name: afterInit-extend.js
    Description: afterInit extend mapael vetor map example
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// AfterInit extend mapael vetor map
// ----------------------------------

$(window).on("load", function(){

    $(".afterInit-extend").mapael({

        map : {
            name : "france_departments",
            defaultArea : {
                attrs : {
                    fill : "#FECEA8",
                    stroke : "#FFFFFF"
                }
            },
            afterInit : function($self, paper, areas, plots, options) {
                // You are free to call all Raphael.js functions on paper object
                paper.ellipse(100, 200, 100, 60).attr({stroke:"#FF847C", fill:"#FF847C",opacity:0.4});
                paper.ellipse(300, 150, 80, 100).attr({stroke:"#99B898", fill:"#99B898",opacity:0.4});
                paper.path("m 198.57144,240 c 0,0 23.57142,163.57143 143.57142,136.42857").attr({stroke:"#99B898", "stroke-width":4});
            }
        },
        plots : {
            'p1' : {
                size:30,
                x:198,
                y:240,
                attrs: {
                    fill:"#99B898"
                }
            },
            'p2' : {
                size:30,
                x:340,
                y:380,
                attrs: {
                    fill:"#99B898"
                }
            }
        }
    });

});