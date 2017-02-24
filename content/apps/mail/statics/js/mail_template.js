// JavaScript Document
;(function (app, $) {
    app.mail_template = {
        init: function () {
            app.mail_template.data_table();
        },
 
        data_table: function () {
            $('#plugin-table').dataTable({
                "sDom": "<'row page'<'span6'<'dt_actions'>l><'span6'f>r>t<'row page pagination'<'span6'i><'span6'p>>",
                "sPaginationType": "bootstrap",
                "iDisplayLength": 15,
                "aLengthMenu": [15, 25, 50, 100],
                "aaSorting": [[2, "asc"]],
                "oLanguage": {
                    "oPaginate": {
                        "sFirst": js_lang.sFirst,
                        "sLast": js_lang.sLast,
                        "sPrevious": js_lang.sPrevious,
                        "sNext": js_lang.sNext
                    },
                    "sInfo": js_lang.sInfo,
                    "sZeroRecords": js_lang.sZeroRecords,
                    "sEmptyTable": js_lang.sEmptyTable,
                    "sInfoEmpty": js_lang.sInfoEmpty,
                    "sInfoFiltered": js_lang.sInfoFiltered
                },
                "aoColumns": [
                    {
                        "sType": "string"
                    },
                    {
                        "bSortable": false
                    },
                    {
                        "bSortable": false
                    }
                ],
                "fnInitComplete": function () {
                    $("select").not(".noselect").chosen({
                        add_class: "down-menu-language",
                        allow_single_deselect: true,
                        disable_search_threshold: 8
                    })
                },
            });
        },
    };
    
    app.mail_template_info = {
        init: function () {
            app.mail_template_info.change_editor();
            app.mail_template_info.validate_mail();
        },
 
        change_editor: function () {
            $('[data-toggle="change_editor"]').on('click', function () {
                url = $(this).attr('data-url');
                ecjia.pjax(url);
            });
        },
 
        validate_mail: function () {
            var option = {
                rules: {
                    subject: {
                        required: true
                    },
                    content: {
                        required: true
                    }
                },
                messages: {
                    subject: {
                        required: js_lang.subject_required
                    },
                    content: {
                        required: js_lang.content_required
                    }
                },
                submitHandler: function () {
                    $("form[name='theForm']").bind('form-pre-serialize', function (event, form, options, veto) {
                        (typeof (tinyMCE) != "undefined") && tinyMCE.triggerSave();
                    }).ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            ecjia.admin.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.admin.defaultOptions.validate, option);
            $("form[name='theForm']").validate(options);
        },
    };
 
})(ecjia.admin, jQuery);
 
// end