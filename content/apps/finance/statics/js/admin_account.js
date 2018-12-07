// JavaScript Document
;
(function (app, $) {
    app.account_list = {
        init: function () {
            /* 加载日期控件 */
            $(".date").datepicker({
                format: "yyyy-mm-dd",
                container: '.main_content',
            });
            app.account_list.search();
            app.account_list.screen();
        },

        screen: function () {
            $(".select-button").click(function () {
                var payment = $("select[name='payment'] option:selected").val();
                var start_date = $("input[name='start_date']").val();
                var end_date = $("input[name='end_date']").val();

                if (start_date != '' && end_date != '' && start_date >= end_date) {
                    var data = {
                        message: '开始时间不能大于或等于结束时间',
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                }

                var url = $("form[name='searchForm']").attr('action');

                if (payment != '' && payment != undefined) url += '&payment=' + payment;
                if (start_date != '') url += '&start_date=' + start_date;
                if (end_date != '') url += '&end_date=' + end_date;

                var keywords = $("input[name='keywords']").val();

                if (keywords != '') {
                    url += '&keywords=' + keywords;
                }

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
            app.account_edit.validate();
            app.account_edit.submit();
            app.account_edit.select_note();
        },

        validate: function () {
            $(".user-mobile").koala({
                delay: 500,
                keyup: function (event) {
                    var $this = $(this);
                    var url = $this.attr('action');
                    var mobile = $this.val();
                    if (mobile.length < 11) {
                        return false;
                    }
                    var data = {
                        user_mobile: mobile,
                    }
                    $.post(url, data, function (data) {
                        if (data.state == 'error') {
                            ecjia.admin.showmessage(data);
                        }
    
                        if (data.status == 1) {
                            $(".user").removeClass("username");
                            $(".userinfo").find('span').html(data.username);
                        }
                    }, 'json');
                }
            });
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
        },

        select_note: function () {
            $('input[name="pay_type"]').off('click').on('click', function () {
                var $this = $(this);
                val = $this.val();
                if (val == 0) {
                    $('.fixed_amount').show();
                    $('.random_amount').hide();
                } else {
                    $('.fixed_amount').hide();
                    $('.random_amount').show();
                }
            });

            $('.select_admin_note').off('change').on('change', function () {
                var $this = $('.select_admin_note option:selected');
                var text = $this.text();
                var val = $this.val();
                var html = '';
                if (val != 0) {
                    html = text;
                }
                $('textarea[name="admin_note"]').val(html);
            });
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