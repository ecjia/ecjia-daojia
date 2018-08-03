/*=========================================================================================
    File Name: utils.js
    Description: google utils
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


$(window).on("load", function(){

  // Context Menu
  // ------------------------------

  context_menu_map = new GMaps({
    div: '#context-menu',
    lat: -12.043333,
    lng: -77.028333,
    styles: [{"stylers":[{"hue":"#2c3e50"},{"saturation":250}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":50},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]}]
  });

  context_menu_map.setContextMenu({
    control: 'map',
    options: [{
      title: 'Add marker',
      name: 'add_marker',
      action: function(e) {
        this.addMarker({
          lat: e.latLng.lat(),
          lng: e.latLng.lng(),
          title: 'New marker'
        });
      }
    }, {
      title: 'Center here',
      name: 'center_here',
      action: function(e) {
        this.setCenter(e.latLng.lat(), e.latLng.lng());
      }
    }]
  });


  // Geofences
  // ------------------------------

  geofences_map = new GMaps({
    div: '#geofences',
    lat: -12.043333,
    lng: -77.028333
  });

  var geofences_path=[];
  var p = [[-12.040397656836609,-77.03373871559225],[-12.040248585302038,-77.03993927003302],[-12.050047116528843,-77.02448169303511],[-12.044804866577001,-77.02154422636042]];
  for(var i in p){
    latlng = new google.maps.LatLng(p[i][0], p[i][1]);
    geofences_path.push(latlng);
  }
  polygon = geofences_map.drawPolygon({
    paths: geofences_path,
    strokeColor: '#BBD8E9',
    strokeOpacity: 1,
    strokeWeight: 3,
    fillColor: '#BBD8E9',
    fillOpacity: 0.6
  });
  geofences_map.addMarker({
    lat: -12.043333,
    lng: -77.028333,
    draggable: true,
    fences: [polygon],
    outside: function(marker, fence) {
      alert('This marker has been moved outside of its fence');
    }
  });


  // Custom Controls
  // ------------------------------

  custom_control_map = new GMaps({
    div: '#custom-controls',
    zoom: 16,
    lat: -12.043333,
    lng: -77.028333,
    styles: [{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#165c64"},{"saturation":34},{"lightness":-69},{"visibility":"on"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"hue":"#b7caaa"},{"saturation":-14},{"lightness":-18},{"visibility":"on"}]},{"featureType":"landscape.man_made","elementType":"all","stylers":[{"hue":"#cbdac1"},{"saturation":-6},{"lightness":-9},{"visibility":"on"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#8d9b83"},{"saturation":-89},{"lightness":-12},{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"hue":"#d4dad0"},{"saturation":-88},{"lightness":54},{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"hue":"#bdc5b6"},{"saturation":-89},{"lightness":-3},{"visibility":"simplified"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"hue":"#bdc5b6"},{"saturation":-89},{"lightness":-26},{"visibility":"on"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"hue":"#c17118"},{"saturation":61},{"lightness":-45},{"visibility":"on"}]},{"featureType":"poi.park","elementType":"all","stylers":[{"hue":"#8ba975"},{"saturation":-46},{"lightness":-28},{"visibility":"on"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"hue":"#a43218"},{"saturation":74},{"lightness":-51},{"visibility":"simplified"}]},{"featureType":"administrative.province","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":0},{"lightness":100},{"visibility":"simplified"}]},{"featureType":"administrative.neighborhood","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":0},{"lightness":100},{"visibility":"off"}]},{"featureType":"administrative.locality","elementType":"labels","stylers":[{"hue":"#ffffff"},{"saturation":0},{"lightness":100},{"visibility":"off"}]},{"featureType":"administrative.land_parcel","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":0},{"lightness":100},{"visibility":"off"}]},{"featureType":"administrative","elementType":"all","stylers":[{"hue":"#3a3935"},{"saturation":5},{"lightness":-57},{"visibility":"off"}]},{"featureType":"poi.medical","elementType":"geometry","stylers":[{"hue":"#cba923"},{"saturation":50},{"lightness":-46},{"visibility":"on"}]}]
  });
  custom_control_map.addControl({
    position: 'top_right',
    content: 'Geolocate',
    style: {
      margin: '5px',
      padding: '1px 6px',
      border: 'solid 1px #717B87',
      background: '#fff'
    },
    events: {
      click: function(){
        GMaps.geolocate({
          success: function(position){
            custom_control_map.setCenter(position.coords.latitude, position.coords.longitude);
          },
          error: function(error){
            alert('Geolocation failed: ' + error.message);
          },
          not_supported: function(){
            alert("Your browser does not support geolocation");
          }
        });
      }
    }
  });

  // Fusion Table Layers
  // ------------------------------

  infoWindow = new google.maps.InfoWindow({});
  fusion_layers_map = new GMaps({
    div: '#fusion-table-layers',
    zoom: 11,
    lat: 41.850033,
    lng: -87.6500523
  });
  fusion_layers_map.loadFromFusionTables({
    query: {
      select: '\'Geocodable address\'',
      from: '1mZ53Z70NsChnBMm-qEYmSDOvLXgrreLTkQUvvg'
    },
    suppressInfoWindows: true,
    events: {
      click: function(point){
        infoWindow.setContent('You clicked here!');
        infoWindow.setPosition(point.latLng);
        infoWindow.open(fusion_layers_map.map);
      }
    }
  });

  // KML and GeoRSS Layers
  // ------------------------------

  infoWindow = new google.maps.InfoWindow({});
  kml_layers_map = new GMaps({
    div: '#kml-layers',
    zoom: 12,
    lat: 40.65,
    lng: -73.95
  });
  kml_layers_map.loadFromKML({
    url: 'http://api.flickr.com/services/feeds/geo/?g=322338@N20&lang=en-us&format=feed-georss',
    suppressInfoWindows: true,
    events: {
      click: function(point){
        infoWindow.setContent(point.featureData.infoWindowHtml);
        infoWindow.setPosition(point.latLng);
        infoWindow.open(kml_layers_map.map);
      }
    }
  });


  // Map Types
  // ------------------------------

  map = new GMaps({
    div: '#map-types',
    lat: -12.043333,
    lng: -77.028333,
    mapTypeControlOptions: {
      mapTypeIds : ["hybrid", "roadmap", "satellite", "terrain", "osm"]
    }
  });
  map.addMapType("osm", {
    getTileUrl: function(coord, zoom) {
      return "https://a.tile.openstreetmap.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
    },
    tileSize: new google.maps.Size(256, 256),
    name: "OpenStreetMap",
    maxZoom: 18
  });
  map.setMapTypeId("osm");


  // Overlay Map Types
  // ------------------------------

  var getTile = function(coord, zoom, ownerDocument) {
    var div = ownerDocument.createElement('div');
    div.innerHTML = coord;
    div.style.width = this.tileSize.width + 'px';
    div.style.height = this.tileSize.height + 'px';
    div.style.background = 'rgba(250, 250, 250, 0.55)';
    div.style.fontFamily = 'Monaco, Andale Mono, Courier New, monospace';
    div.style.fontSize = '10';
    div.style.fontWeight = 'bolder';
    div.style.border = 'dotted 1px #aaa';
    div.style.textAlign = 'center';
    div.style.lineHeight = this.tileSize.height + 'px';
    return div;
  };

  map = new GMaps({
    el: '#overlay-map-types',
    lat: -12.043333,
    lng: -77.028333
  });
  map.addOverlayMapType({
    index: 0,
    tileSize: new google.maps.Size(256, 256),
    getTile: getTile
  });


  // Street View Panoramas
  // ------------------------------

  panorama = GMaps.createPanorama({
    el: '#street-view-panoramas',
    lat : 42.3455,
    lng : -71.0983
  });


  // Interacting with UI
  // ------------------------------

  var map;

  // Update position
  $(document).on('submit', '.edit_marker', function(e) {
    e.preventDefault();

    var $index = $(this).data('marker-index');

    $lat = $('#marker_' + $index + '_lat').val();
    $lng = $('#marker_' + $index + '_lng').val();

    var template = $('#edit_marker_template').text();

    // Update form values
    var content = template.replace(/{{index}}/g, $index).replace(/{{lat}}/g, $lat).replace(/{{lng}}/g, $lng);

    map.markers[$index].setPosition(new google.maps.LatLng($lat, $lng));
    map.markers[$index].infoWindow.setContent(content);

    $marker = $('#markers-with-coordinates').find('li').eq(0).find('a');
    $marker.data('marker-lat', $lat);
    $marker.data('marker-lng', $lng);
  });

  // Update center
  $(document).on('click', '.pan-to-marker', function(e) {
    e.preventDefault();

    var lat, lng;

    var $index = $(this).data('marker-index');
    var $lat = $(this).data('marker-lat');
    var $lng = $(this).data('marker-lng');

    if ($index != undefined) {
      // using indices
      var position = map.markers[$index].getPosition();
      lat = position.lat();
      lng = position.lng();
    }
    else {
      // using coordinates
      lat = $lat;
      lng = $lng;
    }

    map.setCenter(lat, lng);
  });


    map = new GMaps({
      div: '#interact-ui',
      lat: -12.043333,
      lng: -77.028333,
      styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#193341"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#2c5a71"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#29768a"},{"lightness":-37}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#3e606f"},{"weight":2},{"gamma":0.84}]},{"elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"weight":0.6},{"color":"#1a3541"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#2c5a71"}]}]
    });

    GMaps.on('marker_added', map, function(marker) {
      $('#markers-with-index').append('<li><a href="#" class="pan-to-marker" data-marker-index="' + map.markers.indexOf(marker) + '">' + marker.title + '</a></li>');

      $('#markers-with-coordinates').append('<li><a href="#" class="pan-to-marker" data-marker-lat="' + marker.getPosition().lat() + '" data-marker-lng="' + marker.getPosition().lng() + '">' + marker.title + '</a></li>');
    });

    GMaps.on('click', map.map, function(event) {
      var index = map.markers.length;
      var lat = event.latLng.lat();
      var lng = event.latLng.lng();

      var template = $('#edit_marker_template').text();

      var content = template.replace(/{{index}}/g, index).replace(/{{lat}}/g, lat).replace(/{{lng}}/g, lng);

      map.addMarker({
        lat: lat,
        lng: lng,
        title: 'Marker #' + index,
        infoWindow: {
          content : content
        }
      });
    });

  // Working with JSON
  // ------------------------------

  var json_map;

  function loadResults (data) {
    var items, markers_data = [];
    if (data.venues.length > 0) {
      items = data.venues;

      for (var i = 0; i < items.length; i++) {
        var item = items[i];

        if (item.location.lat != undefined && item.location.lng != undefined) {
          var icon = 'https://foursquare.com/img/categories/food/default.png';

          markers_data.push({
            lat : item.location.lat,
            lng : item.location.lng,
            title : item.name,
            icon : {
              size : new google.maps.Size(32, 32),
              url : icon
            }
          });
        }
      }
    }

    json_map.addMarkers(markers_data);
  }

  function printResults(data) {
    $('#foursquare-results').text(JSON.stringify(data));
  }

  $(document).on('click', '.pan-to-marker', function(e) {
    e.preventDefault();

    var position, lat, lng, $index;

    $index = $(this).data('marker-index');

    position = json_map.markers[$index].getPosition();

    lat = position.lat();
    lng = position.lng();

    json_map.setCenter(lat, lng);
  });

  json_map = new GMaps({
    div: '#json',
    lat: -12.043333,
    lng: -77.028333,
    styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}]
  });

  json_map.on('marker_added', function (marker) {
    var index = json_map.markers.indexOf(marker);
    $('#results').append('<li><a href="#" class="pan-to-marker" data-marker-index="' + index + '">' + marker.title + '</a></li>');

    if (index == json_map.markers.length - 1) {
      json_map.fitZoom();
    }
  });

  var xhr = $.getJSON('../../../app-assets/data/gmaps/foursquare.json?q[near]=Lima,%20PE&q[query]=Ceviche');

  xhr.done(printResults);
  xhr.done(loadResults);
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