// JavaScript Document
;(function(app, $) {
	app.general_stats = {
		init : function() {
			app.general_stats.searchForm();
			app.general_stats.selectForm();
		},
		searchForm : function () {
			$(".start_year").datepicker({
				format: "yyyy"
			});
			$('.screen-btn').on('click', function(e) {
				e.preventDefault();
				$("#general_loading").css('display','block');
				var url				= $("form[name='searchForm']").attr('action'); //请求链接
				var start_year = "";  
		        $("input[name=start_year]").each(function() {
		        	if ($(this).val()) {  
		        		start_year += $(this).val()+'.';
		        	}
		        });
		        if (start_year == '') {
		        	var data = {
						message : "查询的时间不能为空！",
						state : "error",
					};
					ecjia.admin.showmessage(data);
					return false;
		        }
				if(start_year       == 'undefind')start_year='';
				if(url        		== 'undefind')url='';
				ecjia.pjax(url + '&start_year=' + start_year);
			});
		},
		selectForm : function () {
			$(".year_month").datepicker({
				format: "yyyy-mm"
			});
			$('.screen-btn1').on('click', function(e) {
				e.preventDefault();
				$("#general_loading").css('display','block');
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
					ecjia.admin.showmessage(data);
					return false;
		        }
				if(year_month       == 'undefind')year_month='';
				if(url        		== 'undefind')url='';
				if(is_multi        	== 'undefind')is_multi='';
				ecjia.pjax(url + '&year_month=' + year_month + '&is_multi=' + is_multi);
			});
		}
	};
})(ecjia.admin, jQuery);

// end
