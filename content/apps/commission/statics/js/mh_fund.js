// JavaScript Document
;
(function(app, $) {
	app.fund = {
		init : function() {
			app.fund.set_value();
			app.fund.subForm();
			app.fund.time();
			app.fund.search();
		},
		set_value: function() {
			$('.set_value').off('click').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					val = $this.attr('data-money');
				$("input[name='money']").val(val);
			})
		},
		
		subForm : function () {
			var $form = $("form[name='fundForm']");
			var option = {
				rules: {
					money: {
                        required: true
                    },
                    desc: {
                        required: true
                    }
                },
                messages: {
                	money: {
                        required: '提现金额不能为空'
                    },
                    desc: {
                        required: '备注内容不能为空'
                    }
                },
				submitHandler : function() {
					$form.ajaxSubmit({
						dataType : "json",
						success : function(data) {
							ecjia.merchant.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
			$form.validate(options);
		},
		
		time: function() {
			$(".fund_time").datepicker({
                format: "yyyy-mm-dd",
			});
		},
		
		search : function() {
			$("form[name='searchForm']").on('submit', function(e) {
				e.preventDefault();
				var start_time = $("input[name='start_time']").val();
				var end_time = $("input[name='end_time']").val();
				var keywords = $("input[name='keywords']").val();
				var url = $("form[name='searchForm']").attr('action'); 
				if (start_time != '') {
					url += '&start_time=' + start_time;
				}
				if (end_time != '') {
					url += '&end_time=' + end_time;
				}
				if (start_time != '' && end_time != '') {
					if (start_time >= end_time) {
						var mesObj = {
							message : "开始时间不能超于或等于结束时间",
							state : "error",
						};
						ecjia.merchant.showmessage(mesObj);
						return false;
					}
				}
				if (keywords != '') {
					url += '&keywords=' + keywords;
				}
				ecjia.pjax(url);
			});
		},
	};
})(ecjia.merchant, jQuery);

// end