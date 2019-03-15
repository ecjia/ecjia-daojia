// JavaScript Document
;(function (app, $) {
    app.history_list = {
        init: function () {
        	 $(".date").datepicker({
                 format: "yyyy-mm-dd",
                 container : '.main_content',
             });
        	 
            //筛选功能
            $("form[name='searchForm'] .search_history").off('click').on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var start_date = $("input[name='start_date']").val();
                var end_date   = $("input[name='end_date']").val();
                var work_type  = $("#select-work option:selected").val();
                var keyword    = $("input[name='keyword']").val();
                if (start_date > end_date && (start_date != '' && end_date != '')) {
                    var data = {
                        message: js_lang.time_range_screening,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                }
                if (start_date != '') url += '&start_date=' + start_date;
                if (end_date != '') url += '&end_date=' + end_date;
                if (work_type != '') url += '&work_type=' + work_type;
                if (keyword != '') url += '&keyword=' + keyword;
                ecjia.pjax(url);
            });
            app.history_list.detail();
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
    };
    
})(ecjia.admin, jQuery);
 
// end