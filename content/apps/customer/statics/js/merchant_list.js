// JavaScript Document
;(function (app, $) {
    app.customer_list = {
        init: function () {
            $(".date").datepicker({
                format: "yyyy-mm-dd",
            });
            //筛选功能
            $('.screen-btn').on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action') + '&rank_id=' + $("#select-cat option:selected").val();
                ecjia.pjax(url);
            });

            //搜索功能
            $("form[name='searchForm'] .search_articles").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var keywords = $("input[name='keywords']").val();
                var start_time = $("input[name='start_time']").val();
                var end_time = $("input[name='end_time']").val();
                if (keywords != '') {
                    url += '&keywords=' + keywords;
                }
                if (start_time != '') {
                    url += '&start_time=' + start_time;
                }
                if (end_time != '') {
                    url += '&end_time=' + end_time;
                }
                ecjia.pjax(url);
            });
        }
    }
})(ecjia.merchant, jQuery);

// end