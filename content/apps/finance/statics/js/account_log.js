// JavaScript Document
;
(function (app, $) {
    /*会员账户明细列表js*/
    app.account_log = {
        init: function () {
            /* 加载日期控件 */
            $(".date").datepicker({
                format: "yyyy-mm-dd",
                container: '.main_content',
            });

            app.account_log.screen_account_log();
        },

        screen_account_log: function () {
            $(".select-button").on('click', function (e) {
                e.preventDefault();

                var url = $("form[name='searchForm']").attr('action');

                var start_date = $("input[name='start_date']").val();
                var end_date = $("input[name='end_date']").val();

                if (start_date == '' || end_date == '') {
                    var data = {
                        message: '开始或结束时间不能为空',
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                }

                if (start_date >= end_date) {
                    var data = {
                        message: '开始时间不能大于或等于结束时间',
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                }

                if (start_date != '') url += '&start_date=' + start_date;
                if (end_date != '') url += '&end_date=' + end_date;

                ecjia.pjax(url);
            })
        }
    };

    /*会员明细编辑js*/
    app.account_log_edit = {
        init: function () {
            app.account_log_edit.submit_account_log();
            app.account_log_edit.select_note();
        },

        submit_account_log: function () {
            var $this = $("form[name='theForm']");
            var option = {
                rules: {
                    change_desc: {
                        required: true
                    }
                },
                messages: {
                    change_desc: {
                        required: account_log_jslang.change_desc_required
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

        select_note: function () {
            $('.select_admin_note').off('change').on('change', function () {
                var $this = $('.select_admin_note option:selected');
                var text = $this.text();
                var val = $this.val();
                var html = '';
                if (val != 0) {
                    html = text;
                }
                $('textarea[name="change_desc"]').val(html);
            });
        }
    };

})(ecjia.admin, jQuery);

// end