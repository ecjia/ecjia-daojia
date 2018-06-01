// JavaScript Document
;(function (app, $) {
    app.merchant_list = {
        init: function () {
            $("form[name='searchForm'] .search_merchant").off('click').on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var keyword = $("input[name='keyword']").val();
                if (keyword != '') {
                	url += '&keyword=' + keyword;
                }
                ecjia.pjax(url);
            });
            
            app.merchant_list.detail();
        },
        
        detail :function(){
            $("a[data-toggle='modal']").off('click').on('click', function (e) {
            	e.preventDefault();
                var $this = $(this);
                var express_id = $this.attr('express-id');
                var url = $this.attr('express-url');
                $.post(url, {'express_id': express_id}, function (data) {
                	$('.modal').html(data.data);
                }, 'json');
			})
        }
    }
})(ecjia.admin, jQuery);
 
// end