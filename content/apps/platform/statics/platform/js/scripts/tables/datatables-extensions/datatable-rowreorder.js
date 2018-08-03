/*=========================================================================================
    File Name: datatables-rowreorder.js
    Description: RowReorder Datatable
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

var tableRowreBasic = $('.dataex-rowre-basic').DataTable( {
    rowReorder: true
} );

/****************************************
*      Restricted column ordering       *
****************************************/

var tableRestricted = $('.dataex-rowre-restricted').DataTable( {
    rowReorder: true,
    columnDefs: [
        { orderable: true, className: 'reorder', targets: 0 },
        { orderable: false, targets: '_all' }
    ]
} );

/*****************************************************
*      Mobile support (Responsive integration)       *
*****************************************************/

var tableMobileSupport = $('.dataex-rowre-mobilesupport').DataTable( {
    rowReorder: {
        selector: 'td:nth-child(2)'
    },
    responsive: true
} );

/********************************
*      Full row selection       *
********************************/

var tableFullRow = $('.dataex-rowre-fullrow').DataTable( {
    rowReorder: {
        selector: 'tr'
    },
    columnDefs: [
        { targets: 0, visible: false }
    ]
} );

/***************************
*      Reorder event       *
***************************/

var tableEvent = $('.dataex-rowre-event').DataTable( {
    rowReorder: true
} );

tableEvent.on( 'row-reorder', function ( e, diff, edit ) {
    var result = 'Reorder started on row: '+edit.triggerRow.data()[1]+'<br>';

    for ( var i=0, ien=diff.length ; i<ien ; i++ ) {
        var rowData = tableEvent.row( diff[i].node ).data();

        result += rowData[1]+' updated to be in position '+
            diff[i].newData+' (was '+diff[i].oldData+')<br>';
    }

    $('.dt-events-log').html( 'Event result:<br>'+result );
} );

/**********************************
*      DataTables Scrolling       *
**********************************/

var tableScrolling = $('.dataex-rowre-scrolling').DataTable( {
    rowReorder: true,
    scrollY: 300,
    paging: false
} );

/*********************************************
*      DataTables horizontal Scrolling       *
*********************************************/

var tableHorizontal = $('.dataex-rowre-horizontal').DataTable( {
    rowReorder: {
        snapX: 10
    }
} );

/**********************************
*      DataTables Scrolling       *
**********************************/

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



} );