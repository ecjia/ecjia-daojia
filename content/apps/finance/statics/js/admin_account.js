// JavaScript Document
;(function (app, $) {
    app.account_list = {
        init: function () {
            /* 加载日期控件 */
            $(".date").datepicker({
                format: "yyyy-mm-dd",
                container : '.main_content',
            });
            app.account_list.search();
            app.account_list.screen();
        },
        
        screen: function () {
            $(".select-button").click(function () {
                var process_type = $("select[name='process_type'] option:selected").val();
                var payment = $("select[name='payment'] option:selected").val();
                var is_paid = $("select[name='is_paid'] option:selected").val();
                var start_date = $("input[name='start_date']").val();
                var end_date = $("input[name='end_date']").val();
 
                if (start_date > end_date && (start_date != '' && end_date != '')) {
                    var data = {
                        message: account_jslang.check_time,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                }
                var url = $("form[name='searchForm']").attr('action');
 
                if (process_type != '-1') url += '&process_type=' + process_type;
                if (payment != '') url += '&payment=' + payment;
                if (is_paid != '-1') url += '&is_paid=' + is_paid;
                if (start_date != '') url += '&start_date=' + start_date;
                if (end_date != '') url += '&end_date=' + end_date;
                ecjia.pjax(url);
            });
        },
        
        search: function () {
            $("form[name='searchForm']").on('submit', function (e) {
                e.preventDefault();
                var keywords = $("input[name='keywords']").val();
                var url = $("form[name='searchForm']").attr('action');
                
                if (keywords != '') {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
        }
    };
 
    app.account_edit = {
        init: function () {
            app.account_edit.submit();
        },
        
        submit: function () {
            var $this = $("form[name='theForm']");
            var option = {
                rules: {
                    username: {
                        required: true
                    },
                    amount: {
                        required: true
                    }
                },
                messages: {
                    username: {
                        required: account_jslang.username_required
                    },
                    amount: {
                        required: account_jslang.amount_required
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
 
    app.account_check = {
        init: function () {
            app.account_check.submit();
        },
        
        submit: function () {
            var $this = $("form[name='theForm']");
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