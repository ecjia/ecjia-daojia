/*=========================================================================================
    File Name: invoices-list.js
    Description: Invoices list datables configurations
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function() {
    /********************************************
    *        js of Order by the grouping        *
    ********************************************/

    var groupingTable = $('.row-grouping').DataTable({
        responsive: true,
        rowReorder: true,
        "columnDefs": [
            { "visible": false, "targets": 5 },
        ],
        // "order": [[ 2, 'desc' ]],
        "displayLength": 25,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;

            api.column(5, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="9">'+group+'</td></tr>'
                    );

                    last = group;
                }
            } );
        }
    } );

    $('.row-grouping tbody').on( 'click', 'tr.group', function () {
        if (typeof table !== 'undefined' && table.order()[0]) {
            var currentOrder = table.order()[0];
            if ( currentOrder[0] === 5 && currentOrder[1] === 'asc' ) {
                table.order( [ 5, 'desc' ] ).draw();
            }
            else {
                table.order( [ 5, 'asc' ] ).draw();
            }
        }
    });
    

    // Checkbox & Radio 1
    $('.icheck input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
    });

    $('#invoices-list').on( 'draw.dt', function () {
        // Checkbox & Radio 1
        $('.icheck input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
        });
    });
    
    //TODO:AJ: Improve check uncheck all func
    var checkAll = $('input.input-chk-all');
    var checkboxes = $('input.input-chk');

    checkAll.on('ifChecked ifUnchecked', function(event) {        
        if (event.type == 'ifChecked') {
            checkboxes.iCheck('check');
        } else {
            checkboxes.iCheck('uncheck');
        }
    });

    checkboxes.on('ifChanged', function(event){
        if(checkboxes.filter(':checked').length == checkboxes.length) {
            checkAll.prop('checked', 'checked');
        } else {
            checkAll.removeProp('checked');
        }
        checkAll.iCheck('update');
    });

});