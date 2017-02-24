// JavaScript Document
;
(function (app, $) {
    app.order_stats = {
        init: function () {
            app.order_stats.searchForm();
            app.order_stats.selectForm();
        },
        
        searchForm: function () {
            $(".start_date,.end_date").datepicker({
                format: "yyyy-mm-dd",
                container : '.main_content',
            });
            
            $('.screen-btn').on('click', function (e) {
                e.preventDefault();
                var start_date = $("input[name='start_date']").val(); //开始时间
                var end_date = $("input[name='end_date']").val(); //结束时间
                var url = $("form[name='searchForm']").attr('action'); //请求链接
                if (start_date == 'undefind') start_date = '';
                if (end_date == 'undefind') end_date = '';
                if (url == 'undefind') url = '';
 
                if (start_date == '') {
                    var data = {
                        message: js_lang.start_time_required,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                } else if (end_date == '') {
                    var data = {
                        message: js_lang.end_time_required,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                };
 
                if (start_date >= end_date && (start_date != '' && end_date != '')) {
                    var data = {
                        message: js_lang.time_exceed,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                } else {
                    ecjia.pjax(url + '&start_date=' + start_date + '&end_date=' + end_date);
                }
            });
        },
        
        selectForm: function () {
            $(".year_month").datepicker({
				format: "yyyy-mm",
			    minViewMode: 1,
                container : '.main_content',
            });
            $('.screen-btn1').on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='selectForm']").attr('action'); //请求链接
                var is_multi = $("input[name='is_multi']").val();
                var year_month = "";
                $("input[name=year_month]").each(function () {
                    if ($(this).val()) {
                        year_month += $(this).val() + '.';
                    }
                });
                if (year_month == '') {
                    var data = {
                        message: js_lang.time_required,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                }
                if (year_month == 'undefind') year_month = '';
                if (url == 'undefind') url = '';
                if (is_multi == 'undefind') is_multi = '';
                ecjia.pjax(url + '&year_month=' + year_month + '&is_multi=' + is_multi);
            });
        }
    };
    
})(ecjia.admin, jQuery);
 
// end