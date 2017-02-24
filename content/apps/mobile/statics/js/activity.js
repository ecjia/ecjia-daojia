// JavaScript Document
;(function (app, $) {
    app.activity = {
        init: function () {
            app.activity.searchForm();
            app.activity.submit();
        },
        
        searchForm: function () {
            $('.screen-btn').on('click', function (e) {
                e.preventDefault();
                var keywords = $("input[name='keywords']").val();
                var url = $("form[name='searchForm']").attr('action');
                
                if (keywords == 'undefind') keywords = '';
                if (url == 'undefind') url = '';
                ecjia.pjax(url + '&keywords=' + keywords);
            });
        },
        
        submit: function () {
            $(".time").datetimepicker({
                format: "yyyy-mm-dd hh:ii",
                container: '.main_content',
            });
 
            $('#info-toggle-button').toggleButtons({
                style: {
                    enabled: "info",
                    disabled: "success"
                }
            });
            $("input[type='submit']").on('click', function () {
                var $form = $("form[name='theForm']");
                var option = {
                    rules: {
                        /*活动信息必填*/
                        activity_name: {
                            required: true
                        },
                    },
                    messages: {
                        /*活动信息必填*/
                        activity_name: {
                            required: "请输入活动名称"
                        },
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
            });
        },
        
        prize_init: function () {
            $("select[name^='prize_type']").live('change', function () {
                if ($(this).val() == '1') {
                    $(this).parent().siblings('.prize_value').children().eq(1).hide();
                    $(this).parent().siblings('.prize_value').children().eq(0).show();
                } else {
                    $(this).parent().siblings('.prize_value').children().eq(0).hide();
                    $(this).parent().siblings('.prize_value').children().eq(1).show();
                }
            });
            
            $("input[type='submit']").on('click', function () {
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
            });
        },
    };
    
})(ecjia.admin, jQuery);
 
//end