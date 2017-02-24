// JavaScript Document
;(function (app, $) {
    app.device_list = {
        init: function () {
            //搜索功能
            $("form[name='searchForm'] .search_device").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action') + '&keywords=' + $("input[name='keywords']").val();
                ecjia.pjax(url);
            });
 
            app.device_list.toggle_view();
        },
 
        toggle_view: function (option) {
            $('.toggle_view').on('click', function (e) {
                e.preventDefault();
                var $this = $(this);
                var href = $this.attr('href');
                var val = $this.attr('data-val') || 'back';
                var option = {
                    href: href,
                    val: val
                };
                var url = option.href;
                var val = {
                    change: option.val
                };
                var msg = $this.attr("data-msg");
                if (msg) {
                    smoke.confirm(msg, function (e) {
                        if (e) {
                            $.get(url, val, function (data) {
                                var url = $this.attr("data-pjax-url");
                                ecjia.pjax(url, function () {
                                    ecjia.admin.showmessage(data);
                                });
                            }, 'json');
                        }
                    }, {
                        ok: js_lang.ok,
                        cancel: js_lang.cancel
                    });
                } else {
                    $.get(url, val, function (data) {
                        var url = $this.attr("data-pjax-url");
                        ecjia.pjax(url, function () {
                            ecjia.admin.showmessage(data);
                        });
                    }, 'json');
                }
            });
        },
    };
    
})(ecjia.admin, jQuery);
 
// end