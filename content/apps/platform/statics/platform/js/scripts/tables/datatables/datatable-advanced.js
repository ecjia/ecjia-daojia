/*=========================================================================================
    File Name: datatable-advanced.js
    Description: Advanced Datatable 
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function() {

    /***************************************
     *       js of dom jQuery events        *
     ***************************************/

    var eventsTable = $('.dom-jQuery-events').DataTable();

    $('.dom-jQuery-events tbody').on('click', 'tr', function() {
        var data = table.row(this).data();
        alert('You clicked on ' + data[0] + '\'s row');
    });


    /***************************************
     *        js of column rendering        *
     ***************************************/

    $('.column-rendering').DataTable({
        "columnDefs": [{
            // The `data` parameter refers to the data for the cell (defined by the
            // `data` option, which defaults to the column being worked with, in
            // this case `data: 0`.
            "render": function(data, type, row) {
                return data + ' (' + row[3] + ')';
            },
            "targets": 0
        }, {
            "visible": false,
            "targets": [3]
        }]
    });

    /******************************************************
     *        js of multiple table control elements        *
     ******************************************************/


    $('.multiple-control-elements').DataTable({
        "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });



    /*************************************************************
     *        js of Complex headers with column visibility        *
     *************************************************************/

    $('.column-visibility').DataTable({
        "columnDefs": [{
            "visible": false,
            "targets": -1
        }]
    });

    /************************************
     *        js of Language file        *
     ************************************/

    $('.language-file').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/German.json"
        }
    });


    /***************************************
     *        js of Setting defaults        *
     ***************************************/
    var defaults = {
        "searching": false,
        "ordering": false
    };


    $('.setting-defaults').dataTable($.extend(true, {}, defaults, {}));



    /*******************************************
     *        js of Row created callback        *
     *******************************************/


    $('.created-callback').DataTable({
        "createdRow": function(row, data, index) {
            if (data[5].replace(/[\$,]/g, '') * 1 > 150000) {
                $('td', row).eq(5).addClass('highlight');
            }
        }
    });

    /********************************************
     *        js of Order by the grouping        *
     ********************************************/

    var groupingTable = $('.row-grouping').DataTable({
        "columnDefs": [{
            "visible": false,
            "targets": 2
        }],
        "order": [
            [2, 'asc']
        ],
        "displayLength": 25,
        "drawCallback": function(settings) {
            var api = this.api();
            var rows = api.rows({
                page: 'current'
            }).nodes();
            var last = null;

            api.column(2, {
                page: 'current'
            }).data().each(function(group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                        '<tr class="group"><td colspan="5">' + group + '</td></tr>'
                    );

                    last = group;
                }
            });
        }
    });

    $('.row-grouping tbody').on('click', 'tr.group', function() {
        var currentOrder = table.order()[0];
        if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
            table.order([2, 'desc']).draw();
        }
        else {
            table.order([2, 'asc']).draw();
        }
    });


    /***********************************************
     *        js of Order by footer callback        *
     ***********************************************/

    $('.footer-callback').DataTable({
        "footerCallback": function(row, data, start, end, display) {
            var api = this.api(),
                data;

            // Remove the formatting to get integer data for summation
            var intVal = function(i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                    i : 0;
            };

            // Total over all pages
            total = api
                .column(4)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Total over this page
            pageTotal = api
                .column(4, {
                    page: 'current'
                })
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer
            $(api.column(4).footer()).html(
                '$' + pageTotal + ' ( $' + total + ' total)'
            );
        }
    });


    /**********************************************
     *        js of custom toolbar elements        *
     **********************************************/


    $('.custom-toolbar-elements').DataTable({
        "dom": '<"toolbar">frtip'
    });

    $("div.toolbar").html('<b>Custom tool bar! Text/images etc.</b>');


    /**********************************
     *        js of File export        *
     **********************************/

    $('.file-export').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');

});


