/*=========================================================================================
    File Name: datatables-fixedcolumn.js
    Description: fixed columns Datatable
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

    $('.dataex-basic-initialisation').DataTable({
        scrollY: 300,
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        fixedColumns: true
    });

    /********************************************
     *       Left and right fixed columns        *
     ********************************************/

    var tableLeftRight = $('.dataex-lr-fixedcolumns').DataTable({
        scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        fixedColumns: {
            leftColumns: 1,
            rightColumns: 1
        }
    });

    /**************************************
     *       Multiple fixed columns        *
     **************************************/

    var tableMultipleFixed = $('.dataex-multiple-fixed').DataTable({
        scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        fixedColumns: {
            leftColumns: 2
        }
    });

    /*********************************
     *       Right column only        *
     *********************************/

    var tableRightColumn = $('.dataex-right-column').DataTable({
        scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        fixedColumns: {
            leftColumns: 0,
            rightColumns: 1
        }
    });

    /*********************************************
     *       Column visibility integration        *
     *********************************************/

    var tableVisibility = $('.dataex-column-visibility').DataTable({
        dom: "Bfrtip",
        scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        buttons: ['colvis'],
        fixedColumns: {
            leftColumns: 2
        }
    });

    /******************************
     *       CSS row sizing        *
     ******************************/

    var tableCssRow = $('.dataex-css-row').DataTable({
        scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        fixedColumns: {
            heightMatch: 'none'
        }
    });

    /*************************************
     *       Assigned column width        *
     *************************************/

    var tableColumnWidth = $('.dataex-column-width').removeAttr('width').DataTable({
        scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        columnDefs: [
            { width: 200, targets: 0 }
        ],
        fixedColumns: true
    });

    /****************************
     *       Index column        *
     ****************************/

    var tableTndex = $('.dataex-index-column').DataTable({
        scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        columnDefs: [{
            sortable: false,
            "class": "index",
            targets: 0
        }],
        order: [
            [1, 'asc']
        ],
        fixedColumns: true
    });

    tableTndex.on('order.dt search.dt', function() {
        tableTndex.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    /**********************************
     *       Select - whole row        *
     **********************************/

    $('.dataex-Select-row').DataTable({
        scrollY: 300,
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        fixedColumns: true,
        select: true
    });

    /***********************************
     *       Select - checkboxes        *
     ***********************************/

    $('.dataex-checkboxes').DataTable({
        scrollY: 300,
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        fixedColumns: true,
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0
        }],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },
        order: [
            [1, 'asc']
        ]
    });

    /*******************************
     *       Complex headers        *
     *******************************/

    var tableComplexHeaders = $('.dataex-complex-headers').DataTable({
        scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        fixedColumns: true
    });

    /*******************************************
     *       Individual column filtering        *
     *******************************************/

    // Setup - add a text input to each footer cell
    $('.dataex-individual-filtering tfoot th').each(function(i) {
        var title = $('.dataex-individual-filtering thead th').eq($(this).index()).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" data-index="' + i + '" />');
    });

    // DataTable
    var tableIndividualFiltering = $('.dataex-individual-filtering').DataTable({
        scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        fixedColumns: true
    });

    // Filter event handler
    $(tableIndividualFiltering.table().container()).on('keyup', 'tfoot input', function() {
        tableIndividualFiltering
            .column($(this).data('index'))
            .search(this.value)
            .draw();
    });
    // Fixed right column overflow -y scroll issue
    $('.DTFC_RightBodyLiner').css('overflow-y', 'hidden');

});
