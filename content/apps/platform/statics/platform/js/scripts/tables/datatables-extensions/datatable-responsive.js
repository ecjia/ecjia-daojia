/*=========================================================================================
    File Name: datatables-responsive.js
    Description: Responsive Datatable
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function() {

    /***********************************
     *       Configuration option       *
     ***********************************/

    $('.dataex-res-configuration').DataTable({
        responsive: true
    });

    /********************************
     *       `new` constructor       *
     ********************************/

    var tableConstructor = $('.dataex-res-constructor').DataTable();

    new $.fn.dataTable.Responsive(tableConstructor);

    /**********************************************
     *       Immediately show hidden details       *
     **********************************************/

    $('.dataex-res-immediately').DataTable({
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.childRowImmediate,
                type: ''
            }
        }
    });

    /************************************
     *       Modal details display       *
     ************************************/

    $('.dataex-res-modal').DataTable({
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function(row) {
                        var data = row.data();
                        return 'Details for ' + data[0] + ' ' + data[1];
                    }
                }),
                renderer: function(api, rowIdx, columns) {
                    var data = $.map(columns, function(col, i) {
                        return '<tr>' +
                            '<td>' + col.title + ':' + '</td> ' +
                            '<td>' + col.data + '</td>' +
                            '</tr>';
                    }).join('');

                    return $('<table/>').append(data);
                }
            }
        }
    });

    /***********************************************
     *       With Buttons - Column visibility       *
     ***********************************************/

    $('.dataex-res-visibility').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'colvis'
        ]
    });

    /*******************************
     *       With FixedHeader       *
     *******************************/

    var tableFixedHeader = $('.dataex-res-fixedheader').DataTable({
        responsive: true
    });

    new $.fn.dataTable.FixedHeader(tableFixedHeader, {
        header: true,
        headerOffset: $('.header-navbar').outerHeight()
    });

    /******************************
     *       With ColReorder       *
     ******************************/

    $('.dataex-res-colreorder').DataTable({
        responsive: true,
        colReorder: true
    });

    /*******************************************
     *       Column controlled child rows       *
     *******************************************/

    $('.dataex-res-controlled').DataTable({
        responsive: {
            details: {
                type: 'column'
            }
        },
        columnDefs: [{
            className: 'control',
            orderable: false,
            targets: 0
        }],
        order: [1, 'asc']
    });

    /*************************************
     *       Column control - right       *
     *************************************/

    $('.dataex-res-controlright').DataTable({
        responsive: {
            details: {
                type: 'column',
                target: -1
            }
        },
        columnDefs: [{
            className: 'control',
            orderable: false,
            targets: -1
        }]
    });

    /******************************************
     *       Whole row child row control       *
     ******************************************/

    $('.dataex-res-rowcontrol').DataTable({
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        columnDefs: [{
            className: 'control',
            orderable: false,
            targets: 0
        }],
        order: [1, 'asc']
    });

    /********************************
     *      Vertical scrolling       *
     ********************************/

    var table = $('.dataex-res-scrolling').DataTable({
        scrollY: 300,
        paging: false
    });

    // Resize datatable on menu width change and window resize
    $(function () {

        $(".menu-toggle").on('click', resize);

        // Resize function
        function resize() {
            setTimeout(function() {

                // ReDraw DataTable
                tableFixedHeader.draw();
            }, 400);
        }
    });

});