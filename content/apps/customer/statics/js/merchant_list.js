// JavaScript Document
;(function (app, $) {
    app.customer_list = {
        init: function () {
 
            //筛选功能
            $('.screen-btn').on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action') + '&rank_id=' + $("#select-cat option:selected").val();
                ecjia.pjax(url);
            })
 
            //搜索功能
            $("form[name='searchForm'] .search_articles").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var keywords = $("input[name='keywords']").val();
                if (keywords != '') {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
            
        },
    }
 
})(ecjia.merchant, jQuery);
 
// end