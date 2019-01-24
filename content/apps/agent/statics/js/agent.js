// JavaScript Document
;(function (app, $) {
    app.agent = {
        init: function () {
            app.agent.search();
            app.agent.submit_form();
            app.agent.stop_propagation();//阻止冒泡事件
            app.agent.check_agent_rank();
        },

        search: function () {
            $('.search-btn').off('click').on('click', function (e) {
                e.preventDefault();

                var $this = $(this),
                    url = $this.attr('data-url'),
                    keywords = $('input[name="keywords"]').val();

                if (keywords != '' && keywords != undefined) {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });

            $('.filter-btn').off('click').on('click', function (e) {
                e.preventDefault();

                var $this = $(this),
                    url = $this.attr('data-url'),
                    agent_rank = $('select[name="agent_rank"]').val();

                if (agent_rank != 0 && agent_rank != undefined) {
                    url += '&agent_rank=' + agent_rank;
                }
                ecjia.pjax(url);
            });
        },
        submit_form: function () {
            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                    agent_name: {required: true},
                    mobile_phone: {required: true},
                    login_password: {required: true},
                    email: {required: true},
                    affiliate_percent: {required: true}
                },
                messages: {
                    agent_name: {required: "请输入代理商名称！"},
                    mobile_phone: {required: "请输入手机号码！"},
                    login_password: {required: "请输入登录密码！"},
                    email: {required: "请输入邮箱账号！"},
                    affiliate_percent: {required: "请输入分红比例！"}
                },
                submitHandler: function () {
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            ecjia.admin.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.admin.defaultOptions.validate, option);
            $form.validate(options);
        },

        stop_propagation: function () {
            $('.stop_propagation').off('click').on('click', function (e) {
                e.stopPropagation();
            })
        },

        check_agent_rank: function () {
            $('input[name="agent_rank"]').off('click').on('click', function () {
                var $this = $(this),
                    val = $this.val();

                $('.choose_list').find('div').removeClass('hide');
                if (val == 'province_agent') {
                    $('#selCities').parent('div').addClass('hide');
                    $('#seldistrict').parent('div').addClass('hide');
                } else if (val == 'city_agent') {
                    $('#seldistrict').parent('div').addClass('hide');
                }
            });
        },
    };
})(ecjia.admin, jQuery);

// end