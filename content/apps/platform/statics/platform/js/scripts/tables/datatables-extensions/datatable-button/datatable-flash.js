/*=========================================================================================
    File Name: datatables-flash.js
    Description: Flash data export Datatable
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function() {

/*****************************************
*       js of HTML5 export buttons        *
*****************************************/

$('.dataex-html5-flashex').DataTable( {
    dom: 'Bfrtip',
    buttons: [
        'copyFlash',
        'csvFlash',
        'excelFlash',
        'pdfFlash'
    ]
} );

/******************************************
*       js of Tab separated values        *
******************************************/

$('.dataex-html5-separated').DataTable( {
    dom: 'Bfrtip',
    buttons: [
        'copyFlash',
        {
            extend: 'csvFlash',
            fieldSeparator: '\t',
            extension: '.tsv'
        }
    ]
} );

/*************************************
*       js of Tab Name values        *
*************************************/

$('.dataex-html5-name').DataTable( {
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'excelFlash',
            filename: 'Data export'
        },
        {
            extend: 'pdfFlash',
            filename: 'Data export'
        }
    ]
} );

/******************************************
*       js of Tab separated values        *
******************************************/

$('.dataex-html5-hidden').wrap('<div id="hide" style="display:none"/>');

$('.dataex-html5-hidden').DataTable( {
    dom: 'Bfrtip',
    buttons: [
        'copyFlash',
        'csvFlash',
        'excelFlash',
        'pdfFlash'
    ]
} );

$('#vis').one( 'click', function () {
    $('#hide').css( 'display', 'block' );
} );

$('#resize').on( 'click', function () {
    $.fn.dataTable.tables( { visible: true, api: true } ).buttons.resize();
} );


} );