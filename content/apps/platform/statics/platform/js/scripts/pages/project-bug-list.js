/*=========================================================================================
    File Name: project-bug-list.js
    Description: Project bugs datables configurations
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function() {

    var groupingTable = $('.row-grouping').DataTable({
        responsive: false,
        autoWidth: false,
        rowReorder: true,
        "columnDefs": [
            { "orderable": true, "className": 'reorder', "targets": 0 },
            { "orderable": false, "targets": '_all' }
        ]
    } );

    $('select').select2();

    // Checkbox & Radio 1
    $('.icheck input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
    });

    $('#project-task-list').on( 'draw.dt', function () {
        // Checkbox & Radio 1
        $('.icheck input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
        });
    } );

});