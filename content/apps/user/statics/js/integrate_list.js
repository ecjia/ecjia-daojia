// JavaScript Document
;(function (app, $) {
    app.integrate_list = {
        init: function () {
            $('#smpl_tbl').dataTable({
                sDom: "<'row page'<'span6'<'dt_actions'>l><'span6'f>r>t<'row page pagination'<'span6'i><'span6'p>>",
                aaSorting: [[1, "asc"]],
                bPaginate: true,
                sPaginationType: "bootstrap",
                oLanguage: {
                    oPaginate: {
                        "sFirst": js_lang.sFirst,
                        "sLast": js_lang.sLast,
                        "sPrevious": js_lang.sPrevious,
                        "sNext": js_lang.sNext
                    },
                    "sInfo": js_lang.sInfo,
                    "sZeroRecords": js_lang.sZeroRecords,
                    "sEmptyTable": js_lang.sEmptyTable,
                    "sInfoEmpty": js_lang.sInfoEmpty,
                    "sInfoFiltered": js_lang.sInfoFiltered,
                },
                aoColumns: [
                    {
                        sType: "string"
                    },
                    {
                        bSortable: false
                    }
                ]
            });
            app.integrate_list.install_user();
        },
 
        install_user: function () {
            $('.install').on('click', function (e) {
                e.preventDefault();
                var $this = $(this),
                    href = $this.attr('href');
                $.get(href, '', function (data) {
                    ecjia.admin.showmessage(data);
                });
            });
        },
    };
 
    app.integrate_setup = {
        init: function () {
            app.integrate_setup.check_config();
        },
 
        check_config: function () {
            var $this = $("form[name='setupForm'] , form[name='Form1']");
            var option = {
                rules: {
                    'cfg[db_host]': {
                        required: true
                    },
                    'cfg[db_user]': {
                        required: true
                    },
                    'cfg[db_name]': {
                        required: true
                    },
                    'cfg[integrate_url]': {
                        url: true
                    },
                    'cfg[cookie_prefix]': {
                        required: true
                    }
                },
                messages: {
                    'cfg[db_host]': {
                        required: js_lang.server_name
                    },
                    'cfg[db_user]': {
                        required: js_lang.data_name
                    },
                    'cfg[db_name]': {
                        required: js_lang.data_password
                    },
                    'cfg[integrate_url]': {
                        url: js_lang.check_url
                    },
                    'cfg[cookie_prefix]': {
                        required: js_lang.check_cookie
                    }
                },
                submitHandler: function () {
                    $this.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            ecjia.admin.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.admin.defaultOptions.validate, option);
            $this.validate(options);
        },
    };
 
    app.integrate_install = {
        init: function () {
            app.integrate_install.submit();
        },
        
        submit: function () {
            var $this = $('form[name="Form2"]');
            var option = {
                submitHandler: function () {
                    $this.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            ecjia.admin.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.admin.defaultOptions.validate, option);
            $this.validate(options);
        }
    };
 
})(ecjia.admin, jQuery);
 
// end