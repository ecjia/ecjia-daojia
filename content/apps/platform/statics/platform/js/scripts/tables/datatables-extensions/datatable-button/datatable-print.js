/*=========================================================================================
    File Name: datatables-print.js
    Description: Print Datatables.
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function() {

/**********************************
*       js of Print button        *
**********************************/

$('.dataex-visibility-print').DataTable( {
    dom: 'Bfrtip',
    buttons: [
        'print'
    ]
} );

/************************************
*       js of Custom message        *
************************************/

$('.dataex-visibility-message').DataTable( {
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'print',
            message: 'This print was produced using the Print button for DataTables'
        }
    ]
} );

/******************************************************
*       js of Export options - column selector        *
******************************************************/

$('.dataex-visibility-selector').DataTable( {
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'print',
            exportOptions: {
                columns: ':visible'
            }
        },
        'colvis'
    ],
    columnDefs: [ {
        targets: -1,
        visible: false
    } ]
} );

/******************************************************
*       js of Export options - Row selector        *
******************************************************/

$('.dataex-visibility-rowselector').DataTable( {
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'print',
            text: 'Print all'
        },
        {
            extend: 'print',
            text: 'Print selected',
            exportOptions: {
                modifier: {
                    selected: true
                }
            }
        }
    ],
    select: true
} );

/****************************************
*       js of Disable auto print        *
****************************************/

$('.dataex-visibility-disable').DataTable( {
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'print',
            autoPrint: false
        }
    ]
} );


/************************************************************
*       js of Customisation of the print view window        *
************************************************************/

$('.dataex-visibility-customisation').DataTable( {
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'print',
            customize: function ( win ) {
                $(win.document.body)
                    .css( 'font-size', '10pt' )
                    .prepend(
                        '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                    );

                $(win.document.body).find( 'table' )
                    .addClass( 'compact' )
                    .css( 'font-size', 'inherit' );
            }
        }
    ]
} );


} );