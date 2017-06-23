// JavaScript Document
;(function (app, $) {
    app.comment_list = {
        init: function () {
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
            app.comment_list.toggle_view();//评论状态审核
        },
        toggle_view: function (option) {
            $('.toggle_view').on('click', function (e) {
                e.preventDefault();
                var $this = $(this);
                var url = $this.attr('href');
                var val = $this.attr('data-val') || 'allow';
                var status = $this.attr('data-status') || '';
                var data = {
                    check: val,
                    status: status
                }
                var msg = $this.attr("data-msg");
                if (msg) {
                    smoke.confirm(msg, function (e) {
                        if (e) {
                            $.post(url, data, function (data) {
                            	console.log(data);
                            	ecjia.admin.showmessage(data);
                            }, 'json');
                        }
                    }, {
                        ok: js_lang.ok,
                        cancel: js_lang.cancel
                    });
                } else {
                    $.post(url, data, function (data) {
                    	console.log(data);
                    	ecjia.admin.showmessage(data);
                    }, 'json');
                }
            });
        },
    }
})(ecjia.admin, jQuery);
 
// end