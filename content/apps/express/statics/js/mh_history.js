// JavaScript Document
;(function (app, $) {
    app.history_list = {
        init: function () {
        	 $(".date").datepicker({
                 format: "yyyy-mm-dd",
             });
        	 
            //筛选功能
            $("form[name='searchForm'] .search_history").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var start_date = $("input[name='start_date']").val();
                var end_date   = $("input[name='end_date']").val();
                var keyword    = $("input[name='keyword']").val();
                if (start_date > end_date && (start_date != '' && end_date != '')) {
                    var data = {
                        message: "请选择正确的时间范围进行筛选",
                        state: "error",
                    };
                    ecjia.merchant.showmessage(data);
                    return false;
                }
                if (start_date != '') url += '&start_date=' + start_date;
                if (end_date != '') url += '&end_date=' + end_date;
                if (keyword != '') url += '&keyword=' + keyword;
                ecjia.pjax(url);
            });
            app.history_list.detail();
        },
        
        detail :function(){
            $("a[data-toggle='modal']").on('click', function (e) {
            	e.preventDefault();
                var $this = $(this);
                var express_id = $this.attr('express-id');
                var url = $this.attr('express-url');
                $.post(url, {'express_id': express_id}, function (data) {
                	$('.modal').html(data.data);
                }, 'json');
			})
        }  
    };
    
})(ecjia.merchant, jQuery);
 
// end