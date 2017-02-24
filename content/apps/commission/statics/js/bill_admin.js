// JavaScript Document
;(function (app, $) {
    app.bill_list = {
        init: function () {
            app.bill_list.searchForm();
        },
 
        searchForm : function () {
			$('.screen-btn').on('click', function(e) {
				e.preventDefault();
				var keywords = $("input[name='keywords']").val();
				var merchant_keywords = $("input[name='merchant_keywords']").val();
				var url = $("form[name='searchForm']").attr('action'); //请求链接
				
				if (keywords == 'undefind') keywords = '';
				if (merchant_keywords == 'undefind') merchant_keywords = '';
				if (url == 'undefind') url = '';

				var parmars = '';
				if (keywords) {
					parmars += '&keywords=' + keywords;
				}
				if (merchant_keywords) {
					parmars += '&merchant_keywords=' + merchant_keywords;
				}
				ecjia.pjax(url + parmars);
			});
		}
    }
})(ecjia.admin, jQuery);
 
// end