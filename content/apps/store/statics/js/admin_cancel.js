// JavaScript Document
;(function (app, $) {
    app.admin_cancel = {
        init: function () {
            //搜索功能
            $('.search_store').off('click').on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action'),
                    keywords = $("input[name='keywords']").val();

                if (keywords != '' && keywords != undefined) {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
        }
    };
})(ecjia.admin, jQuery);

// end