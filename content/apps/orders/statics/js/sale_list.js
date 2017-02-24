// JavaScript Document
;(function(app, $) {
	app.sale_list = {
		init : function() {
			app.sale_list.theForm();
		},
		
		theForm : function () {
			$(".start_date,.end_date").datepicker({
				format: "yyyy-mm-dd",
				container : '.main_content',
			});
			
			$('.screen-btn').on('click', function(e) {
				e.preventDefault();
				var start_date		= $("input[name='start_date']").val(); 		//开始时间
				var end_date		= $("input[name='end_date']").val(); 		//结束时间
				var merchant_keywords = $("input[name='merchant_keywords']").val();
				var url				= $("form[name='theForm']").attr('action'); //请求链接
				if(start_date       == 'undefind')start_date='';
				if(end_date       	== 'undefind')end_date='';
				if(merchant_keywords == 'undefind')merchant_keywords='';
				if(url        		== 'undefind')url='';

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
				}else{
					
					var parmars = '';
					if (start_date) {
						parmars += '&start_date=' + start_date;
					}
					if (end_date) {
						parmars += '&end_date=' +end_date;
					}
					if (merchant_keywords) {
						parmars += '&merchant_keywords=' + merchant_keywords;
					}
					
					ecjia.pjax(url + parmars);
				}
			});
		},
	};
	
})(ecjia.admin, jQuery);

// end