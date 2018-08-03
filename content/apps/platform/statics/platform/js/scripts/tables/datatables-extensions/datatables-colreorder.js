/*=========================================================================================
    File Name: datatables-colreorder.js
    Description: Colreorder Datatable
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function() {

    /******************************************
     *       js of basic initialisation        *
     ******************************************/

    $('.datacol-basic-initialisation').DataTable({
        colReorder: true
    });

    /**************************************
     *       js of scrolling table         *
     **************************************/

    $('.datacol-scrolling-table').dataTable({
        scrollY: '200px',
        paging: false,
        colReorder: true
    });

    /***************************************
     *       js of column ordering          *
     ***************************************/

    $('.datacol-column-ordering').dataTable({
        colReorder: {
            order: [4, 3, 2, 1, 0, 5]
        }
    });

    /************************************************
     *       js of Individual column filtering       *
     ************************************************/

    // Setup - add a text input to each footer cell
    $('.datacol-column-filtering tfoot th').each(function() {
        var title = $('.datacol-column-filtering thead th').eq($(this).index()).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" />');
    });

    // DataTable
    var tableFiltering = $('.datacol-column-filtering').DataTable({
        colReorder: true
    });

    // Apply the filter
    $(".datacol-column-filtering tfoot input").on('keyup change', function() {
        tableFiltering
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();
    });

    /****************************************
     *       js of Reset ordering API        *
     ****************************************/

    var tableResetOrdering = $('.datacol-reset-ordering').DataTable({
        colReorder: true
    });

    $('.reset').on('click', function(e) {
        e.preventDefault();

        tableResetOrdering.colReorder.reset();
    });

    /********************************************
     *       js of visibility integration        *
     ********************************************/

    var table = $('.datacol-visibility-integration').DataTable({
        dom: 'Bfrtip',
        colReorder: true,
        buttons: [
            'colvis'
        ]
    });

    /**********************************************
     *       js of cixedcolumns integration        *
     **********************************************/

    var table = $('.datacol-cixedcolumns-integration').DataTable({
        scrollX: true,
        scrollCollapse: true,
        columnDefs: [
            { orderable: false, targets: 0 },
            { orderable: false, targets: -1 }
        ],
        ordering: [
            [1, 'asc']
        ],
        colReorder: {
            fixedColumnsLeft: 1,
            fixedColumnsRight: 1
        }
    });

    new $.fn.dataTable.FixedColumns(table, {
        leftColumns: 1,
        rightColumns: 1
    });

    /********************************************
     *       js of Responsive integration        *
     ********************************************/

    var table = $('.datacol-responsive-integration').dataTable({
        colReorder: true,
        responsive: true,
        columnDefs: [{
            targets: 2,
            responsivePriority: 10001
        }]
    });




});
