// JavaScript Document
;
(function(app, $) {
    app.logviewer = {
        init: function() {
            app.logviewer.data_table();
        },
        data_table: function() {
            $('#plugin-table').dataTable({
                "sDom": "<'row page'<'span4'<'dt_actions'>l><'span8'f>r>t<'row page pagination'<'span4'i><'span8'p>>",
                "sPaginationType": "bootstrap",
                "iDisplayLength": 25,
                "aLengthMenu": [25, 50, 100],
                "aaSorting": [
                    [0, "desc"]
                ],
                "oLanguage": {
                    "oPaginate": {
                        "sFirst": js_lang.home_page,
                        "sLast": js_lang.last_page,
                        "sPrevious": js_lang.previous_page,
                        "sNext": js_lang.next_page,
                    },
                    "sInfo": js_lang.all_pages,
                    "sZeroRecords": js_lang.no_records_were_found,
                    "sEmptyTable": js_lang.no_records_were_found,
                    "sInfoEmpty": js_lang.total_zero_records,
                    "sInfoFiltered": js_lang.retrieved_max_data,
                },
                "aoColumns": [{
                    "bSortable": true,
                    "asSorting": ["desc", "asc"]
                }, {
                    "bSortable": true,
                    "asSorting": ["desc", "asc"]
                }, {
                    "bSortable": false
                }],
            });
        },
    }
})(ecjia.admin, jQuery);

// end