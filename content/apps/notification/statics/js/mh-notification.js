// JavaScript Document
;
(function (app, $) {
	app.notice_list = {
		init: function () {
			app.notice_list.toggle_view();
		},

		toggle_view: function (option) {
			$('.toggle_view').on('click', function (e) {
				e.preventDefault();

				var $this = $(this);
				var url = $this.attr('href');
				var val = $this.attr('data-id');
				var type = $this.attr('data-type');
				var msg = $this.attr("data-msg");

				if (val == undefined && type == undefined) {
					return false;
				}
				var option = {
					'type': type,
					'val': val
				};

				if (msg) {
					smoke.confirm(msg, function (e) {
						if (e) {
							$.post(url, option, function (data) {
								ecjia.merchant.showmessage(data);
							}, 'json');
						}
					}, {
						ok: js_lang.ok,
						cancel: js_lang.cancel
					});
				} else {
					$.post(url, option, function (data) {
						ecjia.merchant.showmessage(data);
					}, 'json');
				}
			});
		},
	};
})(ecjia.merchant, jQuery);

// end