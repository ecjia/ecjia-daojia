/*=========================================================================================
    File Name: datatables-visibility.js
    Description: Column visibility Datatables.
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function() {

/*********************************************
*       js of Basic column visibility        *
*********************************************/

$('.dataex-visibility-basic').DataTable( {
    dom: 'Bfrtip',
    buttons: [
        'colvis'
    ]
} );

/*****************************************
*       js of Multi-column layout        *
*****************************************/

$('.dataex-visibility-multi').DataTable( {
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'colvis',
            collectionLayout: 'fixed two-column'
        }
    ]
} );

/***********************************************
*       js of Restore column visibility        *
***********************************************/

$('.dataex-visibility-restore').DataTable( {
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'colvis',
            postfixButtons: [ 'colvisRestore' ]
        }
    ],
    columnDefs: [
        {
            targets: -1,
            visible: false
        }
    ]
} );

/***********************************
*       js of Column groups        *
***********************************/

$('.dataex-visibility-groups').DataTable( {
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'colvisGroup',
            text: 'Office info',
            show: [ 1, 2 ],
            hide: [ 3, 4, 5 ]
        },
        {
            extend: 'colvisGroup',
            text: 'HR info',
            show: [ 3, 4, 5 ],
            hide: [ 1, 2 ]
        },
        {
            extend: 'colvisGroup',
            text: 'Show all',
            show: ':hidden'
        }
    ]
} );

/***********************************************
*       js of Restore column visibility        *
***********************************************/

$('.dataex-visibility-state').DataTable( {
    dom: 'Bfrtip',
    stateSave: true,
    buttons: [
        'colvis'
    ]
} );


} );