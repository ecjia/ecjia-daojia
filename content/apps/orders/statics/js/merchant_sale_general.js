// JavaScript Document
;(function(app, $) {
	app.sale_general = {
		init : function() {
			app.sale_general.searchForm();
			$(".no_search").chosen({
				allow_single_deselect : false,
				disable_search : true
			});
		},
		searchForm : function () {
			$('.screen-btn').on('click', function(e){
				e.preventDefault();
				var year_beginYear	= $("select[name='year_beginYear']").val(); 		
				var year_endYear	= $("select[name='year_endYear']").val(); 		
				var url				= $("form[name='searchForm']").attr('action'); //请求链接
				var query_by_year   = 1;
				if(year_beginYear   == 'undefind')year_beginYear='';
				if(year_endYear     == 'undefind')year_endYear='';
				if(url        		== 'undefind')url='';
				
				if (year_beginYear == '') {
					var data = {
						message : "查询的开始年份不能为空！",
						state : "error",
					};
					ecjia.merchant.showmessage(data);
					return false;
				} else if (year_endYear == '') {
					var data = {
						message : "查询的结束年份不能为空！",
						state : "error",
					};
					ecjia.merchant.showmessage(data);
					return false;
				};
				
				if (year_beginYear > year_endYear && (year_beginYear != '' && year_endYear !='')) {
					var data = {
						message : "查询的开始时间不能超于结束时间！",
						state : "error",
					};
					ecjia.merchant.showmessage(data);
					return false;
				} else {
					ecjia.pjax(url + '&query_by_year=' + query_by_year +'&year_beginYear=' + year_beginYear + '&year_endYear=' + year_endYear);
				}
			});
			$('.screen-btn1').on('click', function(e){
				e.preventDefault();
				var month_beginYear	= $("select[name='month_beginYear']").val();	
				var month_beginMonth= $("select[name='month_beginMonth']").val();
				var month_endYear   = $("select[name='month_endYear']").val();
				var month_endMonth  = $("select[name='month_endMonth']").val();
				var query_by_month  = 1;
				var url				= $("form[name='searchForm']").attr('action'); //请求链接
				if(month_beginYear  == 'undefind')month_beginYear='';
				if(month_beginMonth == 'undefind')month_beginMonth='';
				if(month_endYear    == 'undefind')month_endYear='';
				if(month_endMonth   == 'undefind')month_endMonth='';
				if(url        		== 'undefind')url='';
				if (month_beginYear+month_beginMonth >= month_endYear+month_endMonth) {
					var data = {
						message : "查询的开始时间不能超于结束时间！",
						state : "error",
					};
					ecjia.merchant.showmessage(data);
					return false;
				} else {
					ecjia.pjax(url+'&query_by_month='+query_by_month+'&month_beginYear='+month_beginYear+'&month_beginMonth='+month_beginMonth+'&month_endYear='+month_endYear+'&month_endMonth='+month_endMonth);
				}
			});
		}
	};
})(ecjia.merchant, jQuery);

// end