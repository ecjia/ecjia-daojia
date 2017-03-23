// JavaScript Document
;(function (app, $) {
    app.appeal = {
        init: function () {
            app.appeal.list_search();
            app.appeal.appeal_info();
            $(".date").datepicker({
    			format: "yyyy-mm-dd"
    		});
        },
 
        list_search: function (e) {
            $(".search_appeal").on('click', function (e) {
            	e.preventDefault();
            	var start_date = $("input[name='start_date']").val();
    			var end_date = $("input[name='end_date']").val();
    			if (start_date > end_date && (start_date != '' && end_date !='')) {
    				var data = {
    						message : "开始时间不得大于结束时间！",
    						state : "error",
    				};
    				ecjia.admin.showmessage(data);
    				return false;
    			}
                var url = $("form[name='searchForm']").attr('action');
                var keywords = $("input[name='keyword']").val();
                if (keywords != '') {
                    url += '&keywords=' + keywords;
                }
                if (start_date != '')		url+= '&start_date=' + start_date;
    			if (end_date != '')			url+= '&end_date=' + end_date;
                ecjia.pjax(url);
            });
        },
        appeal_info: function () {			
            $(".ckeck-comment-appeal").on('click', function (e) {
                e.preventDefault();
                var url 	   = $(this).attr('data-url');
                var check_status = $(this).attr('data-status');
                var data = {
                	check_remark: $(".ckeck_remark").val(),
                	comment_id	 : $("input[name='comment_id']").val(),
                	appeal_id    :$("input[name='appeal_id']").val(),
                	check_status : check_status
                };
                $.get(url, data, function (data) {
                	ecjia.admin.showmessage(data);
                }, 'json');
            });
		},
    }  
})(ecjia.admin, jQuery);
 
// end