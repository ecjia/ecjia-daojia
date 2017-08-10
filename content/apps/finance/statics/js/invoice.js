// JavaScript Document
;(function (app, $) {
    app.invoice_list = {
        init: function () {
            //搜索功能
            $("form[name='searchForm'] .btn").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var keywords = $("input[name='keywords']").val();
                if (keywords != '') {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
        }
    };
})(ecjia.admin, jQuery);
 
// end