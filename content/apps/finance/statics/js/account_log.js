// JavaScript Document
;(function (app, $) {
    /*会员账户明细列表js*/
    app.account_log = {
        init: function () {
            app.account_log.screen_account_log();
            //调用图表控件
            $.fn.peity.defaults.line = {
                strokeWidth: 1,
                delimeter: ",",
                height: 32,
                max: null,
                min: 0,
                width: 50
            };
            $.fn.peity.defaults.bar = {
                delimeter: ",",
                height: 32,
                max: null,
                min: 0,
                width: 50
            };
            $(".p_bar_up").peity("bar", {
                colour: "#6cc334"
            });
            $(".p_bar_down").peity("bar", {
                colour: "#e11b28"
            });
            $(".p_line_up").peity("line", {
                colour: "#b4dbeb",
                strokeColour: "#3ca0ca"
            });
            $(".p_line_down").peity("line", {
                colour: "#f7bfc3",
                strokeColour: "#e11b28"
            });
        },
        
        screen_account_log: function () {
            $(".select-button").on('click', function (e) {
                e.preventDefault();
                var account_type = $("#account_type option:selected").val();
                var url = $("form[name='searchForm']").attr('action');
                if (account_type != '') url += '&account_type=' + account_type;
                ecjia.pjax(url);
            })
        }
    };
 
    /*会员明细编辑js*/
    app.account_log_edit = {
        init: function () {
            app.account_log_edit.submit_account_log();
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
        }
    };
 
})(ecjia.admin, jQuery);

// end