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
                        "sFirst": '首页',
                        "sLast": '尾页',
                        "sPrevious": '上一页',
                        "sNext": '下一页',
                    },
                    "sInfo": "共_TOTAL_条记录 第_START_条到第_END_条",
                    "sZeroRecords": "没有找到任何记录",
                    "sEmptyTable": "没有找到任何记录",
                    "sInfoEmpty": "共0条记录",
                    "sInfoFiltered": "（从_MAX_条数据中检索）",
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