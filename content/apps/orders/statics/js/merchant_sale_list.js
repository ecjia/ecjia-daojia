// JavaScript Document
;(function(app, $) {
	app.sale_list = {
		init : function() {
			app.sale_list.theForm();
		},
		theForm : function () {
			$(".start_date,.end_date").datepicker({
				format: "yyyy-mm-dd"
			});
			$('.screen-btn').on('click', function(e) {
				e.preventDefault();
				var start_date		= $("input[name='start_date']").val(); 		//开始时间
				var end_date		= $("input[name='end_date']").val(); 		//结束时间
				var url				= $("form[name='theForm']").attr('action'); //请求链接
				if(start_date       == 'undefind')start_date='';
				if(end_date       	== 'undefind')end_date='';
				if(url        		== 'undefind')url='';

				if (start_date == '') {
					var data = {
						message : "查询的开始时间不能为空！",
						state : "error",
					};
					ecjia.merchant.showmessage(data);
					return false;
				} else if (end_date == '') {
					var data = {
						message : "查询的结束时间不能为空！",
						state : "error",
					};
					ecjia.merchant.showmessage(data);
					return false;
				};
				
				if (start_date >= end_date && (start_date != '' && end_date !='')) {
					var data = {
						message : "查询的开始时间不能超于结束时间！",
						state : "error",
					};
					ecjia.merchant.showmessage(data);
					return false;
				} else {
					ecjia.pjax(url + '&start_date=' + start_date + '&end_date=' +end_date);
				}
			});
		},
	};
	
})(ecjia.merchant, jQuery);

// end