// JavaScript Document
;
(function(app, $) {
    app.admin_ship_ecjia_express = {
        init: function() {
            app.admin_ship_ecjia_express.shippingForm();
            app.admin_ship_ecjia_express.datepicker();
            app.admin_ship_ecjia_express.tpicker();
        },
		datepicker : function(){
			$.fn.datetimepicker.dates['zh'] = {  
                days:       ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六","星期日"],  
                daysShort:  ["日", "一", "二", "三", "四", "五", "六","日"],  
                daysMin:    ["日", "一", "二", "三", "四", "五", "六","日"],  
                months:     ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月","十二月"],  
                monthsShort:  ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月","十二月"], 
                meridiem:    ["上午", "下午"],  
                today:       "今天"  
	        };
            $(".tp_1").datetimepicker({
                format: "hh:ii",
                language: 'zh',  
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 1,
                forceParse: 0,
                minuteStep: 5,
                container: '.main_content',
            });
        },
        
        shippingForm: function () {
            var $form = $("form[name='shippingForm']");
            var option = {
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
        
        tpicker: function () {
			$('.fontello-icon-plus').off('click').on('click', function(e) {
				setTimeout(function () { 
					app.admin_ship_ecjia_express.datepicker();
			    });
			});
		},
    };
})(ecjia.admin, jQuery);
// end