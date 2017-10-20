// JavaScript Document
;(function(app, $) {
	app.sale_list = {
		init : function() {
			app.sale_list.theForm();
		},
		
		theForm : function () {
			$('.screen-btn').on('click', function(e) {
				e.preventDefault();
				var year_beginYear	= $("select[name='year_beginYear']").val(); 		
				var month_beginMonth= $("select[name='month_beginMonth']").val(); 		
				var url				= $("form[name='searchForm']").attr('action'); 
				if (month_beginMonth == '') {
					month_beginMonth = 'all'
				} 
				ecjia.pjax(url + '&year_beginYear=' + year_beginYear + '&month_beginMonth=' + month_beginMonth);
			});
		},
	};
	
})(ecjia.admin, jQuery);

// end