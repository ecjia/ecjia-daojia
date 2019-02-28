// JavaScript Document
;(function (app, $) {
    app.sms_list = {
        init: function () {
            /* 加载日期控件 */
            $(".date").datepicker({
                format: "yyyy-mm-dd",
                container : '.main_content',
            });
            //时间筛选
            $(".select-button").click(function (e) {
                e.preventDefault();
 
                var start_date = $("input[name='start_date']").val();
                var end_date = $("input[name='end_date']").val();
                if (start_date > end_date && (start_date != '' && end_date != '')) {
                    var data = {
                        message: js_lang.start_lt_end_time,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                }
                var url = $("form[name='searchForm']").attr('action');
                if (start_date != '') url += '&start_date=' + start_date;
                if (end_date != '') url += '&end_date=' + end_date;
                ecjia.pjax(url);
            });
 
            //关键字搜索功能
            $(".search_sms").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action') + '&keywords=' + $("input[name='keywords']").val();
                ecjia.pjax(url);
            });
 
            $(".ajaxsms").on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                $.get(url, function (data) {
                    ecjia.admin.showmessage(data);
                }, 'json');
            });
        }
    };
})(ecjia.admin, jQuery);
 
// end