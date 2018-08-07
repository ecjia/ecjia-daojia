// JavaScript Document
;
(function (app, $) {
	app.prize_list = {
		init: function () {
			app.prize_list.toggle_view();
		},
		
		 toggle_view: function (option) {
	            $('.toggle_view').on('click', function (e) {
	                e.preventDefault();
	                var $this = $(this);
	                var url = $this.attr('href');
	                var val = $this.attr('data-val') || 'allow';

	                var data = {
	                    check: val,
	                }
	                var msg = $this.attr("data-msg");
	                if (msg) {
	                    smoke.confirm(msg, function (e) {
	                        if (e) {
	                            $.post(url, data, function (data) {
	                                ecjia.platform.showmessage(data);
	                            }, 'json');
	                        }
	                    }, {
	                        ok: js_lang.ok,
	                        cancel: js_lang.cancel
	                    });
	                } else {
	                    $.post(url, data, function (data) {
	                        ecjia.platform.showmessage(data);
	                    }, 'json');
	                }
	            });
	        },
	};
})(ecjia.platform, jQuery);

// end