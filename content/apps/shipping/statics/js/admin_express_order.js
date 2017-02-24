// JavaScript Document
;(function(app, $) {
	app.admin_express_order = {
		init : function() {
			app.admin_express_order.searchform();
		},
		searchform : function() {
			//搜索功能
			$("form[name='searchForm']").on('submit', function(e){
				e.preventDefault();
				var url = $(this).attr('action');
				var keywords = $("input[name='keywords']").val();
				var merchant_keywords = $("input[name='merchant_keywords']").val();
				
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
