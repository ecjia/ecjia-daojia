/*=========================================================================================
    File Name: datatables-select.js
    Description: Select Datatable
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function() {

/**********************************
*      Basic initialisation       *
**********************************/

$('.dataex-select-initialisation').DataTable( {
    select: true
} );

/**********************************
*      Multi item selection       *
**********************************/

$('.dataex-select-multi').DataTable( {
    select: {
        style: 'multi'
    }
} );

/****************************
*      Cell selection       *
****************************/

$('.dataex-select-cell').DataTable( {
    select: {
        style: 'os',
        items: 'cell'
    }
} );

/**********************************
*      DataTables Scrolling       *
**********************************/

$('.dataex-select-checkbox').DataTable( {
    columnDefs: [ {
        orderable: false,
        className: 'select-checkbox',
        targets:   0
    } ],
    select: {
        style:    'os',
        selector: 'td:first-child'
    },
    order: [[ 1, 'asc' ]]
} );

/*********************
*      Buttons       *
*********************/

var tableButtons = $('.dataex-select-buttons').DataTable( {
    dom: 'Bfrtip',
    buttons: [
        'selected',
        'selectedSingle',
        'selectAll',
        'selectNone',
        'selectRows',
        'selectColumns',
        'selectCells'
    ],
    select: true
} );

/**************************
*      Select items       *
**************************/

var tableSelectItems = $('.dataex-select-selectitems').DataTable( {
    dom: 'Bfrtip',
    select: true,
    buttons: [
        {
            text: 'Select all',
            action: function () {
                tableSelectItems.rows().select();
            }
        },
        {
            text: 'Select none',
            action: function () {
                tableSelectItems.rows().deselect();
            }
        }
    ]
} );

/********************
*      Events       *
********************/

var events = $('.dt-events-log');
var tableEvents = $('.dataex-select-events').DataTable( {
    select: true
} );

tableEvents
    .on( 'select', function ( e, dt, type, indexes ) {
        var rowData = tableEvents.rows( indexes ).data().toArray();
        events.prepend( '<div><b>'+type+' selection</b> - '+JSON.stringify( rowData )+'</div>' );
    } )
    .on( 'deselect', function ( e, dt, type, indexes ) {
        var rowData = tableEvents.rows( indexes ).data().toArray();
        events.prepend( '<div><b>'+type+' <i>de</i>selection</b> - '+JSON.stringify( rowData )+'</div>' );
    } );


} );