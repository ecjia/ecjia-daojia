// JavaScript Document
;(function (app, $) {
    app.order = {
        init: function () {
            app.order.searchForm();
        },
 
        searchForm : function () {
			$('.screen-btn').on('click', function(e) {
				e.preventDefault();
				var order_sn			= $("input[name='order_sn']").val();
				var merchant_keywords 	= $("input[name='merchant_keywords']").val();
				var url					= $("form[name='searchForm']").attr('action'); //请求链接
				if(order_sn        		== 'undefind')order_sn='';
				if(merchant_keywords 	== 'undefind')merchant_keywords='';
				if(url        			== 'undefind')url='';

				var parmars = '';
				if (order_sn) {
					parmars += '&order_sn=' + order_sn;
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