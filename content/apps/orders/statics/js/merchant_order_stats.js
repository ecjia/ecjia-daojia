// JavaScript Document
;
(function (app, $) {
    app.order_stats = {
        init: function () {
            app.order_stats.searchForm();
            app.order_stats.selectForm();
        },
        
        searchForm: function () {
            $('.screen-btn').off('click').on('click', function (e) {
                e.preventDefault();
                var year = $("select[name='year']").val(); //开始时间
                var month = $("select[name='month']").val(); //结束时间
                var url = $("form[name='searchForm']").attr('action'); //请求链接
                
                if (year == 0 || year == undefined) {
                	ecjia.merchant.showmessage({'state': 'error', 'message': '请选择年份'});
                	return false;
                }
                url += '&year=' + year;

                if (month != undefined && month != 0) {
                	url += '&month=' + month;
                }
                ecjia.pjax(url);
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
                    ecjia.merchant.showmessage(data);
                    return false;
                }
                if (year_month == 'undefind') year_month = '';
                if (url == 'undefind') url = '';
                if (is_multi == 'undefind') is_multi = '';
                ecjia.pjax(url + '&year_month=' + year_month + '&is_multi=' + is_multi);
            });
        }
    };
    
})(ecjia.merchant, jQuery);
 
// end