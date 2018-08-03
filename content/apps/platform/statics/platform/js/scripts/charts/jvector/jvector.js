/*=========================================================================================
    File Name: jvector.js
    Description: jVector maps examples.
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// jVector maps
// -----------------------------------

$(window).on("load", function(){

    // GDP by country visualization
    // -----------------------------------
    $('#world-map-gdp').vectorMap({
      map: 'world_mill',
      backgroundColor: '#1DE9B6',
      regionStyle: {
        initial: {
            fill: '#A7FFEB',
        },
        hover: {
            fill: '#64FFDA'
        },
        selected: {
            fill: '#1DE9B6'
        },
        selectedHover: {
            fill: '#00BFA5'
        }
      },
      scaleColors: ['#C8EEFF', '#0071A4'],
      series: {
        regions: [{
          values: gdpData,
          // scale: [5, 15],
          scale: ['#A7FFEB', '#64FFDA'],
          normalizeFunction: 'polynomial'
        }],
      },
      onRegionTipShow: function(e, el, code){
        el.html(el.html()+' (GDP - '+gdpData[code]+')');
      }
    });


    // Markers on the world map
    // -----------------------------------
    $('#world-map-markers').vectorMap({
        backgroundColor: '#1DE9B6',
        zoomOnScroll: false,
        map: 'world_mill',
        scaleColors: ['#C8EEFF', '#0071A4'],
        normalizeFunction: 'polynomial',
        hoverOpacity: 0.7,
        hoverColor: false,
        markerStyle: {
          initial: {
              fill: '#FF9E80',
              stroke: '#FF6E40',
              'stroke-width': 2
          },
          hover: {
              fill: '#FF6E40',
              stroke: '#FF6E40',
          },
          selected: {
              fill: '#FF3D00',
              stroke: '#FF6E40',
          },
          selectedHover: {
              fill: '#DD2C00',
              stroke: '#FF6E40',
          }
        },
        regionStyle: {
          initial: {
              fill: '#A7FFEB',
          },
          hover: {
              fill: '#64FFDA'
          },
          selected: {
              fill: '#1DE9B6'
          },
          selectedHover: {
              fill: '#00BFA5'
          }
        },
        markers: [
            {latLng: [51.52, -0.14], name: 'London'},
            {latLng: [48.87, 2.34], name: 'Paris'},
            {latLng: [47.36, 8.53], name: 'Switzerland'},
            {latLng: [40.54, -3.77], name: 'Spain'},
            {latLng: [39.59, -105.19], name: 'USA'},
            {latLng: [19.67, -99.12], name: 'Mexico'},
            {latLng: [-8.37, -56.06], name: 'Brazil'},
            {latLng: [-31.17, -64.14], name: 'Argentina'},
            {latLng: [-26.20, 28.02], name: 'Johanesburg'},
            {latLng: [19.05, 72.87], name: 'Mumbai'},
            {latLng: [40.03, 116.46], name: 'Beijing'},
            {latLng: [31.27, 121.47], name: 'Shanghai'},
            {latLng: [35.739, 139.75], name: 'Japan'},
            {latLng: [-34.83, 138.60], name: 'Adelaide'},
            {latLng: [-37.77, 144.97], name: 'Melbourne'},
            {latLng: [1.3, 103.8], name: 'Singapore'},
            {latLng: [26.02, 50.55], name: 'Bahrain'},
        ]
    });

    // Regions selection
    // -----------------------------------
    var map,
      markers = [
        {latLng: [52.50, 13.39], name: 'Berlin'},
        {latLng: [53.56, 10.00], name: 'Hamburg'},
        {latLng: [48.13, 11.56], name: 'Munich'},
        {latLng: [50.95, 6.96], name: 'Cologne'},
        {latLng: [50.11, 8.68], name: 'Frankfurt am Main'},
        {latLng: [48.77, 9.17], name: 'Stuttgart'},
        {latLng: [51.23, 6.78], name: 'Düsseldorf'},
        {latLng: [51.51, 7.46], name: 'Dortmund'},
        {latLng: [51.45, 7.01], name: 'Essen'},
        {latLng: [53.07, 8.80], name: 'Bremen'}
      ],
      cityAreaData = [
        887.70,
        755.16,
        310.69,
        405.17,
        248.31,
        207.35,
        217.22,
        280.71,
        210.32,
        325.42
      ];

    map = new jvm.Map({
      container: $('#region-selection'),
      map: 'de_merc',
      backgroundColor: '#1DE9B6',
      regionsSelectable: true,
      markersSelectable: true,
      markers: markers,
      markerStyle: {
        initial: {
          fill: '#FF9E80',
          stroke: '#FF6E40',
        },
        selected: {
          fill: '#FF3D00',
          stroke: '#FF6E40',
        },
      },
      regionStyle: {
        initial: {
          fill: '#A7FFEB'
        },
        selected: {
          fill: '#1DE9B6'
        }
      },
      series: {
        markers: [{
          attribute: 'r',
          scale: [5, 15],
          values: cityAreaData
        }]
      },
      onRegionSelected: function(){
        if (window.localStorage) {
          window.localStorage.setItem(
            'jvectormap-selected-regions',
            JSON.stringify(map.getSelectedRegions())
          );
        }
      },
      onMarkerSelected: function(){
        if (window.localStorage) {
          window.localStorage.setItem(
            'jvectormap-selected-markers',
            JSON.stringify(map.getSelectedMarkers())
          );
        }
      }
    });
    map.setSelectedRegions( JSON.parse( window.localStorage.getItem('jvectormap-selected-regions') || '[]' ) );
    map.setSelectedMarkers( JSON.parse( window.localStorage.getItem('jvectormap-selected-markers') || '[]' ) );

    // Reverse projection
    // -----------------------------------
    var map,
      markerIndex = 0,
      markersCoords = {};

    map = new jvm.Map({
        map: 'us_lcc',
        backgroundColor: '#1DE9B6',
        regionStyle: {
          initial: {
            fill: '#A7FFEB'
          },
          selected: {
            fill: '#1DE9B6'
          }
        },
        container: $('#reverse-projection'),
        onMarkerTipShow: function(e, label, code){
          map.tip.text(markersCoords[code].lat.toFixed(2)+', '+markersCoords[code].lng.toFixed(2));
        },
        onMarkerClick: function(e, code){
          map.removeMarkers([code]);
          map.tip.hide();
        }
    });

    map.container.on('click', function(e){
        var latLng = map.pointToLatLng(
                e.pageX - map.container.offset().left,
                e.pageY - map.container.offset().top
            ),
            targetCls = $(e.target).attr('class');

        if (latLng && (!targetCls || (targetCls && $(e.target).attr('class').indexOf('jvectormap-marker') === -1))) {
          markersCoords[markerIndex] = latLng;
          map.addMarker(markerIndex, {latLng: [latLng.lat, latLng.lng]});
          markerIndex += 1;
        }
    });

    // Region labels
    // -----------------------------------
    new jvm.Map({
      map: 'us_aea',
      container: $('#region-labels'),
      backgroundColor: '#1DE9B6',
      regionStyle: {
        initial: {
          fill: '#A7FFEB'
        },
        selected: {
          fill: '#1DE9B6'
        }
      },
      labels: {
        regions: {
          render: function(code){
            var doNotShow = ['US-RI', 'US-DC', 'US-DE', 'US-MD'];

            if (doNotShow.indexOf(code) === -1) {
              return code.split('-')[1];
            }
          },
          offsets: function(code){
            return {
              'CA': [-10, 10],
              'ID': [0, 40],
              'OK': [25, 0],
              'LA': [-20, 0],
              'FL': [45, 0],
              'KY': [10, 5],
              'VA': [15, 5],
              'MI': [30, 30],
              'AK': [50, -25],
              'HI': [25, 50]
            }[code.split('-')[1]];
          }
        }
      },
      regionLabelStyle: {
        initial: {
          fill: '#FF6E40'
        },
      }
    });

    // Drill down US map
    // -----------------------------------
    new jvm.MultiMap({
      container: $('#drill-down-us-map'),
      maxLevel: 1,
      main: {
        map: 'us_lcc',
        backgroundColor: '#1DE9B6',
        regionStyle: {
          initial: {
            fill: '#A7FFEB'
          },
          selected: {
            fill: '#1DE9B6'
          }
        },
      },
      mapUrlByCode: function(code, multiMap){
        return '/js/us-counties/jquery-jvectormap-data-'+
               code.toLowerCase()+'-'+
               multiMap.defaultProjection+'-en.js';
      }
    });
});