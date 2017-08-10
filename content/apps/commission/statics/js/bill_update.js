// JavaScript Document
;
(function(app, $) {
	app.bill_update = {
		init : function() {
			app.bill_update.subForm();
		},
		subForm : function () {
			$(".start_date,.end_date").datepicker({
                format: "yyyy-mm-dd",
			});
			
			var $form = $("form[name='theForm']");
			var option = {
					submitHandler : function() {
						var start_date = $('.start_date').val(),
						end_date = $('.end_date').val();
						if (start_date.length < 3) {
							var mesObj = {
									message : "开始时间不能为空！",
									state : "error",
								};
						    ecjia.admin.showmessage(mesObj);
							return;
						}
						if (end_date.length < 3) {
							var mesObj = {
									message : "结束时间不能为空！",
									state : "error",
								};
						    ecjia.admin.showmessage(mesObj);
							return;
						}
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
		month : function () {
			$(".start_date,.end_date").datepicker({
	            format: "yyyy-mm",
	            minViewMode: 1,
			});
			
			var $form = $("form[name='theForm']");
			var option = {
					submitHandler : function() {
						var start_date = $('.start_date').val(),
						end_date = $('.end_date').val();
						if (start_date.length < 3) {
							var mesObj = {
									message : "时间不能为空！",
									state : "error",
								};
						    ecjia.admin.showmessage(mesObj);
							return;
						}
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
		
	};
})(ecjia.admin, jQuery);

// end