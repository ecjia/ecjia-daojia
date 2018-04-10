// JavaScript Document
;
(function(app, $) {
	app.withdraw = {
		init : function() {
			app.withdraw.subForm();
			app.withdraw.time();
			app.withdraw.search();
		},

		subForm : function () {
			var $form = $("form[name='fundForm']");
			var option = {
				rules: {
					admin_note: {
                        required: true
                    }
                },
                messages: {
                	admin_note: {
                        required: '备注信息不能为空'
                    }
                },
				submitHandler : function() {
					$form.ajaxSubmit({
						dataType : "json",
						success : function(data) {
							ecjia.admin.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$form.validate(options);
		},
		
		time: function() {
			$(".date").datepicker({
                format: "yyyy-mm-dd",
			});
		},
		
		search : function() {
			$("form[name='searchForm']").on('submit', function(e) {
				e.preventDefault();
				var start_time = $("input[name='start_time']").val();
				var end_time = $("input[name='end_time']").val();
				var keywords = $("input[name='keywords']").val();
				var merchant_keywords = $("input[name='merchant_keywords']").val();
				
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
						ecjia.admin.showmessage(mesObj);
						return false;
					}
				}
				if (keywords != '') {
					url += '&keywords=' + keywords;
				}
				if (merchant_keywords != '') {
					url += '&merchant_keywords=' + merchant_keywords;
				}
				ecjia.pjax(url);
			});
		},
	};
})(ecjia.admin, jQuery);

// end