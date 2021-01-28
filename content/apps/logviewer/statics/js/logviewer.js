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
                        "sFirst": js_lang_logviewer.home_page,
                        "sLast": js_lang_logviewer.last_page,
                        "sPrevious": js_lang_logviewer.previous_page,
                        "sNext": js_lang_logviewer.next_page,
                    },
                    "sInfo": js_lang_logviewer.all_pages,
                    "sZeroRecords": js_lang_logviewer.no_records_were_found,
                    "sEmptyTable": js_lang_logviewer.no_records_were_found,
                    "sInfoEmpty": js_lang_logviewer.total_zero_records,
                    "sInfoFiltered": js_lang_logviewer.retrieved_max_data,
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