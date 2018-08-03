/*=========================================================================================
    File Name: datatables-keytable.js
    Description: Keytable Datatable
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function() {

/************************************
*       Basic initialisation        *
************************************/

$('.dataex-key-basic').DataTable( {
    keys: true
} );

/*********************
*       Events       *
**********************/

var events = $('.dt-events-log');
var tableEvents = $('.dataex-key-events').DataTable( {
    keys: true
} );

tableEvents
    .on( 'key', function ( e, datatable, key, cell, originalEvent ) {
        events.prepend( '<div>Key press: '+key+' for cell <i>'+cell.data()+'</i></div>' );
    } )
    .on( 'key-focus', function ( e, datatable, cell ) {
        events.prepend( '<div>Cell focus: <i>'+cell.data()+'</i></div>' );
    } )
    .on( 'key-blur', function ( e, datatable, cell ) {
        events.prepend( '<div>Cell blur: <i>'+cell.data()+'</i></div>' );
    } )

/******************************
*       Scrolling table       *
******************************/

var tableScrolling = $('.dataex-key-scrolling').DataTable( {
    scrollY: 300,
    paging:  false,
    keys:    true
} );

/***********************************
*       Scroller integration       *
***********************************/

$('.dataex-key-State').DataTable( {
    keys: true,
    stateSave: true
} );

/****************************************
*       Focus cell custom styling       *
****************************************/

$('.dataex-key-customstyling').DataTable( {
    keys: true
} );


} );