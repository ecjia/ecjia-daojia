// JavaScript Document
;(function(app, $) {
	app.sale_order = {
		init : function() {
			app.sale_order.sale_order();
		},

		sale_order : function(){
			$(".start_date,.end_date").datepicker({
				format: "yyyy-mm-dd",
				container : '.main_content',
			});

			$('.screen-btn').on('click', function(e) {
				e.preventDefault();
				var start_date			= $("input[name='start_date']").val(), 		//开始时间
					end_date			= $("input[name='end_date']").val(), 		//结束时间
					merchant_keywords 	= $("input[name='merchant_keywords']").val(),
					url					= $("form[name='theForm']").attr('action'); //请求链接
				if (!start_date) start_date='';
				if (!end_date) end_date='';
				if (!merchant_keywords) merchant_keywords=''
				if (!url) url='';

                if (start_date == '') {
                    var data = {
                        message: js_lang.start_time_required,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                } else if (end_date == '') {
                    var data = {
                        message: js_lang.end_time_required,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                };

				if (start_date >= end_date && (start_date != '' && end_date !='')) {
					var data = {
                        message: js_lang.time_exceed,
                        state: "error",
                    };
					ecjia.admin.showmessage(data);
					return false;
				} else {
					ecjia.pjax(url + '&start_date=' + start_date + '&end_date=' +end_date+ '&merchant_keywords='+merchant_keywords);
				}
			});
		},
	};

})(ecjia.admin, jQuery);

// end