// JavaScript Document
;(function (app, $) {
    app.area_stats = {
        init: function () {
            app.area_stats.searchForm();
        },
        
        searchForm: function () {
            $(".start_date,.end_date").datepicker({
                format: "yyyy-mm-dd",
                container : '.main_content',
            });
            $('.screen-btn').on('click', function (e) {
                e.preventDefault();
                $("#area_loading").css('display', 'block');
                var start_date = $("input[name=start_date]").val();
                var end_date = $("input[name=end_date]").val();
                var url = $("form[name='searchForm']").attr('action');
                var start_time = (new Date(start_date.replace(/-/g, '/')).getTime()) / 1000;
                var end_time = (new Date(end_date.replace(/-/g, '/')).getTime()) / 1000;
 
                if (start_date == '') {
                    var data = {
                        message: js_lang.start_date_required,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                } else if (end_date == '') {
                    var data = {
                        message: js_lang.end_date_required,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                } else if (start_date > end_date) {
                    var data = {
                        message: js_lang.start_lt_end_date,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                } else if (end_time - start_time > 86400 * 90) {
                    var data = {
                        message: js_lang.range_error,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                }
 
                if (start_date == 'undefind') start_date = '';
                if (end_date == 'undefind') end_date = '';
                if (url == 'undefind') url = '';
                ecjia.pjax(url + '&start_date=' + start_date + '&end_date=' + end_date);
            });
        }
    };
    
})(ecjia.admin, jQuery);
 
// end