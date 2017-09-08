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
                
                if (keywords != '') {
                	url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
        },
        
        submit: function () {
            /* 加载日期控件 */
			$.fn.datetimepicker.dates['zh'] = {  
                days:       ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六","星期日"],  
                daysShort:  ["日", "一", "二", "三", "四", "五", "六","日"],  
                daysMin:    ["日", "一", "二", "三", "四", "五", "六","日"],  
                months:     ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月","十二月"],  
                monthsShort:  ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月","十二月"], 
                meridiem:    ["上午", "下午"],  
                today:       "今天"  
	        };
            $(".time").datetimepicker({
                format: "yyyy-mm-dd hh:ii",
                language: 'zh',  
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0,
                minuteStep: 1,
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
                        start_time: {
                            required: true
                        },
                        end_time: {
                            required: true
                        },
                    },
                    messages: {
                        /*活动信息必填*/
                        activity_name: {
                            required: "请输入活动名称"
                        },
                        start_time: {
                            required: "请输入活动开始时间"
                        },
                        end_time: {
                            required: "请输入活动结束时间"
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