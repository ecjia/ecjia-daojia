/*=========================================================================================
    File Name: jqvmap.js
    Description: jQuery vector maps examples.
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// jQuery vector maps
// -----------------------------------

$(window).on("load", function(){

    // Continents Vector Maps
    // -----------------------------------
    $('.continent-tab').each(function () {
        $(this).on('click', function () {
            $('.tab-selected').removeClass('tab-selected');
            $(this).addClass('tab-selected');
            $('.continent-map').css('z-index', '0');
            $('#continent-' + this.id).parent().css('z-index', '1');
        });
    });
    $('.continent-tab:first').addClass('tab-selected');
    $('.continent-map:first').css('z-index', '1');

    // Asia
    jQuery('#continent-asia').vectorMap({
      map: 'asia_en',
      backgroundColor: '#FFFFFF',
      borderColor: '#FFF',
      color: '#2A363B',
      hoverOpacity: 0.7,
      selectedColor: '#99B898',
      enableZoom: true,
      showTooltip: true,
      values: sample_data,
      scaleColors: ['#FECEA8', '#E84A5F'],
      normalizeFunction: 'polynomial'
    });

    // Europe
    jQuery('#continent-europe').vectorMap({
      map: 'europe_en',
      backgroundColor: '#FFFFFF',
      borderColor: '#FFF',
      color: '#2A363B',
      hoverOpacity: 0.7,
      selectedColor: '#99B898',
      enableZoom: true,
      showTooltip: true,
      values: sample_data,
      scaleColors: ['#FECEA8', '#E84A5F'],
      normalizeFunction: 'polynomial'
    });

    // Australia
    jQuery('#continent-australia').vectorMap({
      map: 'australia_en',
      backgroundColor: '#FFFFFF',
      borderColor: '#FFF',
      color: '#2A363B',
      hoverOpacity: 0.7,
      selectedColor: '#99B898',
      enableZoom: true,
      showTooltip: true,
      values: sample_data,
      scaleColors: ['#FECEA8', '#E84A5F'],
      normalizeFunction: 'polynomial'
    });

    // Africa
    jQuery('#continent-africa').vectorMap({
      map: 'africa_en',
      backgroundColor: '#FFFFFF',
      borderColor: '#FFF',
      color: '#2A363B',
      hoverOpacity: 0.7,
      selectedColor: '#99B898',
      enableZoom: true,
      showTooltip: true,
      values: sample_data,
      scaleColors: ['#FECEA8', '#E84A5F'],
      normalizeFunction: 'polynomial'
    });

    // North America
    jQuery('#continent-northamerica').vectorMap({
      map: 'north-america_en',
      backgroundColor: '#FFFFFF',
      borderColor: '#FFF',
      color: '#2A363B',
      hoverOpacity: 0.7,
      selectedColor: '#99B898',
      enableZoom: true,
      showTooltip: true,
      values: sample_data,
      scaleColors: ['#FECEA8', '#E84A5F'],
      normalizeFunction: 'polynomial'
    });

    // South America
    jQuery('#continent-southamerica').vectorMap({
      map: 'south-america_en',
      backgroundColor: '#FFFFFF',
      borderColor: '#FFF',
      color: '#2A363B',
      hoverOpacity: 0.7,
      selectedColor: '#99B898',
      enableZoom: true,
      showTooltip: true,
      values: sample_data,
      scaleColors: ['#FECEA8', '#E84A5F'],
      normalizeFunction: 'polynomial'
    });

    // Multi Select Region
    // -----------------------------------
    jQuery('#multi-select-region').vectorMap({
        map: 'usa_en',
        backgroundColor: '#FFFFFF',
        borderColor: '#FFF',
        color: '#E84A5F',
        selectedColor: '#FECEA8',
        enableZoom: true,
        showTooltip: true,
        multiSelectRegion: true,
        selectedRegions: ['TX']
    });

    // Custom Pins
    // -----------------------------------
    function escapeXml(string) {
        return string.replace(/[<>]/g, function (c) {
            switch (c) {
                case '<': return '\u003c';
                case '>': return '\u003e';
            }
        });
    }
    var pins = {
        mo: escapeXml('<div class="map-pin red"><span>MO</span></div>'),
        fl: escapeXml('<div class="map-pin blue"><span>FL</span></div>'),
        or: escapeXml('<div class="map-pin purple"><span>OR</span></div>')
    };

    jQuery('#custom-pins').vectorMap({
        backgroundColor: '#FFF',
        borderColor: '#FFF',
        map: 'usa_en',
        pins: pins,
        color: '#99B898',
        pinMode: 'content',
        hoverColor: null,
        selectedColor: '#FECEA8',
        showTooltip: false,
        selectedRegions: ['MO', 'FL', 'OR'],
        onRegionClick: function(event){
            event.preventDefault();
        }
    });

    // Inactive Regions
    // -----------------------------------
    var inactive_region_map;

    jQuery(document).ready(function () {

        // Store currentRegion
        var currentRegion = 'fl';

        // List of Regions we'll let clicks through for
        var enabledRegions = ['mo', 'fl', 'or'];

        inactive_region_map = jQuery('#inactive-regions').vectorMap({
            map: 'usa_en',
            backgroundColor: '#FFF',
            borderColor: '#FFF',
            enableZoom: true,
            showTooltip: true,
            color: '#99B898',
            selectedColor: '#FECEA8',
            selectedRegions: ['fl'],
            hoverColor: null,
            colors: {
                mo: '#2A363B',
                fl: '#2A363B',
                or: '#2A363B'
            },
            onRegionClick: function(event, code, region){
                // Check if this is an Enabled Region, and not the current selected on
                if(enabledRegions.indexOf(code) === -1 || currentRegion === code){
                    // Not an Enabled Region
                    event.preventDefault();
                } else {
                    // Enabled Region. Update Newly Selected Region.
                    currentRegion = code;
                }
            },
            onRegionSelect: function(event, code, region){
                console.log(inactive_region_map.selectedRegions);
            },
            onLabelShow: function(event, label, code){
                if(enabledRegions.indexOf(code) === -1){
                    event.preventDefault();
                }
            }
        });
    });

    // World Map
    // -----------------------------------
    jQuery('#world-map').vectorMap({
        map: 'world_en',
        backgroundColor: '#FFFFFF',
        borderColor: '#FFF',
        color: '#2A363B',
        hoverOpacity: 0.7,
        selectedColor: '#99B898',
        enableZoom: true,
        showTooltip: true,
        scaleColors: ['#FECEA8', '#E84A5F'],
        values: sample_data,
        normalizeFunction: 'polynomial'
    });
});