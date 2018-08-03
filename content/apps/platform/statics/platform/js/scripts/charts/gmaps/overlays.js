/*=========================================================================================
    File Name: overlays.js
    Description: google overlays
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(window).on("load", function(){

    // Polylines
    // ------------------------------

    polylines_map = new GMaps({
        div: '#polylines',
        lat: -12.043333,
        lng: -77.028333,
        styles: [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"color":"#000000"},{"lightness":13}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#144b53"},{"lightness":14},{"weight":1.4}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#08304b"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#0c4152"},{"lightness":5}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#0b434f"},{"lightness":25}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#000000"}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"color":"#0b3d51"},{"lightness":16}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"}]},{"featureType":"transit","elementType":"all","stylers":[{"color":"#146474"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#021019"}]}],
        click: function(e){
          console.log(e);
        }
    });

    polylines_path = [[-12.044012922866312, -77.02470665341184], [-12.05449279282314, -77.03024273281858], [-12.055122327623378, -77.03039293652341], [-12.075917129727586, -77.02764635449216], [-12.07635776902266, -77.02792530422971], [-12.076819390363665, -77.02893381481931], [-12.088527520066453, -77.0241058385925], [-12.090814532191756, -77.02271108990476]];

    polylines_map.drawPolyline({
        path: polylines_path,
        strokeColor: '#3BAFDA',
        strokeOpacity: 0.6,
        strokeWeight: 6
    });

    // Overlays
    // ------------------------------

    overlays_map = new GMaps({
        div: '#overlays',
        lat: -12.043333,
        lng: -77.028333,
        styles: [{"stylers":[{"visibility":"on"},{"saturation":-100},{"gamma":0.54}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"color":"#4d4946"}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels.text","stylers":[{"visibility":"simplified"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"visibility":"simplified"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"gamma":0.48}]},{"featureType":"transit.station","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"gamma":7.18}]}]
    });
    overlays_map.drawOverlay({
        lat: overlays_map.getCenter().lat(),
        lng: overlays_map.getCenter().lng(),
        content: '<div class="overlay">Lima<div class="overlay_arrow above"></div></div>',
        verticalAlign: 'top',
        horizontalAlign: 'center'
    });


    // Polygons
    // ------------------------------

    polygon_map = new GMaps({
        div: '#polygons',
        lat: -12.043333,
        lng: -77.028333,
    });
    var polygon_path = [[-12.040397656836609,-77.03373871559225], [-12.040248585302038,-77.03993927003302], [-12.050047116528843,-77.02448169303511],   [-12.044804866577001,-77.02154422636042]];

    polygon = polygon_map.drawPolygon({
        paths: polygon_path, // pre-defined polygon shape
        strokeColor: '#BBD8E9',
        strokeOpacity: 1,
        strokeWeight: 3,
        fillColor: '#BBD8E9',
        fillOpacity: 0.6
    });

    // GeoJSON Polygons
    // ------------------------------

    geo_polygons_map = new GMaps({
        div: '#geojson-polygons',
        lat: 39.743296277167325,
        lng: -105.00517845153809
    });
    var paths =
    [
        [
            [
                [-105.00432014465332, 39.74732195489861],
                [-105.00715255737305, 39.74620006835170],
                [-105.00921249389647, 39.74468219277038],
                [-105.01067161560059, 39.74362625960105],
                [-105.01195907592773, 39.74290029616054],
                [-105.00989913940431, 39.74078835902781],
                [-105.00758171081543, 39.74059036160317],
                [-105.00346183776855, 39.74059036160317],
                [-105.00097274780272, 39.74059036160317],
                [-105.00062942504881, 39.74072235994946],
                [-105.00020027160645, 39.74191033368865],
                [-105.00071525573731, 39.74276830198601],
                [-105.00097274780272, 39.74369225589818],
                [-105.00097274780272, 39.74461619742136],
                [-105.00123023986816, 39.74534214278395],
                [-105.00183105468751, 39.74613407445653],
                [-105.00432014465332, 39.74732195489861]
            ],
            [
                [-105.00361204147337, 39.74354376414072],
                [-105.00301122665405, 39.74278480127163],
                [-105.00221729278564, 39.74316428375108],
                [-105.00283956527711, 39.74390674342741],
                [-105.00361204147337, 39.74354376414072]
            ]
        ],
        [
            [
                [-105.00942707061768, 39.73989736613708],
                [-105.00942707061768, 39.73910536278566],
                [-105.00685214996338, 39.73923736397631],
                [-105.00384807586671, 39.73910536278566],
                [-105.00174522399902, 39.73903936209552],
                [-105.00041484832764, 39.73910536278566],
                [-105.00041484832764, 39.73979836621592],
                [-105.00535011291504, 39.73986436617916],
                [-105.00942707061768, 39.73989736613708]
            ]
        ]
    ];

    polygon = geo_polygons_map.drawPolygon({
        paths: paths,
        useGeoJSON: true,
        strokeColor: '#BBD8E9',
        strokeOpacity: 1,
        strokeWeight: 3,
        fillColor: '#BBD8E9',
        fillOpacity: 0.6
      });

});

// Resize Map
// ------------------------------

/*$(function () {

    // Resize map on menu width change and window resize
    $(window).on('resize', resize);
    $(".menu-toggle").on('click', resize);

    // Resize function
    function resize() {
        drawLine();
    }
});*/