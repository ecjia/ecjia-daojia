// JavaScript Document
;(function(app, $) {
	app.order_stats = {
		init : function() {
			app.order_stats.searchForm();
			app.order_stats.selectForm();
		},
		searchForm : function () {
			$(".start_date,.end_date").datepicker({
				format: "yyyy-mm-dd",
			});
			$('.screen-btn').on('click', function(e) {
				e.preventDefault();
				var start_date		= $("input[name='start_date']").val(); 		//开始时间
				var end_date		= $("input[name='end_date']").val(); 		//结束时间
				var url				= $("form[name='searchForm']").attr('action'); //请求链接
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
				} else if(end_date == '') {
					var data = {
						message : "查询的结束时间不能为空！",
						state : "error",
					};
					ecjia.merchant.showmessage(data);
					return false;
				};
				var myDate = new Date();
					year = myDate.getFullYear(),
					month = myDate.getMonth()+1,
					date = myDate.getDate();
					if(String(date).length < 2) date = '0'+date;
					time = year + '-' + month + '-' + date;
				if (start_date > time){
					var data = {
						message : "查询的开始时间不能超于当前时间！",
						state : "error",
					};
					ecjia.merchant.showmessage(data);
				}
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
		selectForm : function () {
			$(".year_month").datepicker({
				format: "yyyy-mm",
			    minViewMode: 1,
			});
			$('.screen-btn1').on('click', function(e) {
				e.preventDefault();
				var url				= $("form[name='selectForm']").attr('action'); //请求链接
				var is_multi        = $("input[name='is_multi']").val();
				var year_month = "";
		        $("input[name=year_month]").each(function() {
		        	if ($(this).val()) {
		        		year_month += $(this).val()+'.';
		        	}
		        });
		        if (year_month == '') {
		        	var data = {
						message : "查询的时间不能为空！",
						state : "error",
					};
					ecjia.merchant.showmessage(data);
					return false;
		        }
				if(year_month	== 'undefind')year_month='';
				if(url      	== 'undefind')url='';
				if(is_multi  	== 'undefind')is_multi='';
				ecjia.pjax(url + '&year_month=' + year_month + '&is_multi=' + is_multi);
			});
		}
	};
	
})(ecjia.merchant, jQuery);

// end