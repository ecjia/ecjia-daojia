/*=========================================================================================
    File Name: datatable-api.js
    Description: API Datatable 
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: Pixinvent
    Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function() {

/*****************************
*       js of Add Row        *
******************************/

var t = $('.add-rows').DataTable();
var counter = 1;

$('#addRow').on( 'click', function () {
    t.row.add( [
        counter +'.1',
        counter +'.2',
        counter +'.3',
        counter +'.4',
        counter +'.5'
    ] ).draw( false );

    counter++;
} );

/*****************************************************
*       Automatically add a first row of data        *
*****************************************************/

$('#addRow').trigger('click');


/***************************************************************
*       js of Individual column searching (text inputs)        *
***************************************************************/

// Setup - add a text input to each footer cell
$('.text-inputs-searching tfoot th').each( function () {
    var title = $(this).text();
    $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
} );

// DataTable
var tableSearching = $('.text-inputs-searching').DataTable();

// Apply the search
tableSearching.columns().every( function () {
    var that = this;

    $( 'input', this.footer() ).on( 'keyup change', function () {
        if ( that.search() !== this.value ) {
            that
                .search( this.value )
                .draw();
        }
    } );
} );


/*****************************************************************
*       js of Individual column searching (select inputs)        *
*****************************************************************/

$('.datatable-select-inputs').DataTable( {
    initComplete: function () {
        this.api().columns().every( function () {
            var column = this;
            var select = $('<select><option value="">Select option</option></select>')
                .appendTo( $(column.footer()).empty() )
                .on( 'change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search( val ? '^'+val+'$' : '', true, false )
                        .draw();
                } );

            column.data().unique().sort().each( function ( d, j ) {
                select.append( '<option value="'+d+'">'+d+'</option>' );
            } );
        } );
    }
} );


/********************************************************************
*       js of Child rows (show extra / detailed information)        *
********************************************************************/


/* Formatting function for row details - modify as you need */
function format ( d ) {
// `d` is the original data object for the row
return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
    '<tr>'+
        '<td>Full name:</td>'+
        '<td>'+d.name+'</td>'+
    '</tr>'+
    '<tr>'+
        '<td>Extension number:</td>'+
        '<td>'+d.extn+'</td>'+
    '</tr>'+
    '<tr>'+
        '<td>Extra info:</td>'+
        '<td>And any further details here (images etc)...</td>'+
    '</tr>'+
'</table>';
}

// -- Child rows (show extra / detailed information) --


var tableChildRows = $('.show-child-rows').DataTable( {
    "ajax": "../../../app-assets/data/datatables/ajax-child-rows.json",
    "columns": [
        {
            "className":      'details-control',
            "orderable":      false,
            "data":           null,
            "defaultContent": ''
        },
        { "data": "name" },
        { "data": "position" },
        { "data": "office" },
        { "data": "salary" }
    ],
    "order": [[1, 'asc']]
} );

// Add event listener for opening and closing details
$('.show-child-rows tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = tableChildRows.row( tr );

    if ( row.child.isShown() ) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
        // Open this row
        row.child( format(row.data()) ).show();
        tr.addClass('shown');
    }
} );


/***************************************************
*       js of Row selection (multiple rows)        *
***************************************************/


    var multipleRowsTable = $('.selection-multiple-rows').DataTable();

    $('.selection-multiple-rows tbody').on('click', 'tr', function() {
        $(this).toggleClass('selected');
    });

    $('#row-count').on('click', function() {
        alert(multipleRowsTable.rows('.selected').data().length + ' row(s) selected');
    });


/*************************************************************
*       js of Row selection and deletion (single row)        *
*************************************************************/


    var tableselectionDelete = $('.selection-deletion-row').DataTable();

    $('.selection-deletion-row tbody').on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            tableselectionDelete.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $('#delete-row').on('click', function() {
        tableselectionDelete.row('.selected').remove().draw(false);
    });


/*********************************
*       js of Form inputs        *
*********************************/


    var tableFormInputs = $('.submit-form-inputs').DataTable();

    $('.inputs-submin').on('click', function() {
        var data = tableFormInputs.$('input, select').serialize();
        alert(
            "The following data would have been submitted to the server: \n\n" +
            data.substr(0, 120) + '...'
        );
        return false;
    });


/*****************************************************
*       js of Show / hide columns dynamically        *
*****************************************************/


    var tableDynamically = $('.hide-columns-dynamically').DataTable({
        "scrollY": "200px",
        "paging": false
    });

    $('a.toggle-vis').on('click', function(e) {
        e.preventDefault();

        // Get the column API object
        var column = tableDynamically.column($(this).attr('data-column'));

        // Toggle the visibility
        column.visible(!column.visible());
    });

/************************************************
*       Search API (regular expressions)        *
************************************************/


    $('.search-api').DataTable();

    $('input.global_filter_search').on('keyup click', function() {
        filterGlobal();
    });

    $('input.column_filter_search').on('keyup click', function() {
        filterColumn($(this).parents('tr').attr('data-column'));
    });


    function filterGlobal() {
        $('.search-api').DataTable().search(
            $('#global_filter').val(),
            $('#global_regex').prop('checked'),
            $('#global_smart').prop('checked')
        ).draw();
    }

    function filterColumn(i) {
        $('.search-api').DataTable().column(i).search(
            $('#col' + i + '_filter').val(),
            $('#col' + i + '_regex').prop('checked'),
            $('#col' + i + '_smart').prop('checked')
        ).draw();
    }

} );
