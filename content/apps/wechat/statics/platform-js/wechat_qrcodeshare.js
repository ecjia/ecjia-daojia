// JavaScript Document
;
(function (app, $) {
	app.wechat_qrcodeshare_list = {
		init: function () {
			$(".ajaxswitch").off('click').on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('href');
				$.get(url, function (data) {
					ecjia.platform.showmessage(data);
				}, 'json');
			});

			$(".ajaxwechat").off('click').on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('href');
				$.get(url, function (data) {
					if (data.state == 'error') {
						ecjia.platform.showmessage(data);
					}
					var img = '<img style="-webkit-user-select: none;" src=' + data.url + '>';
					$('#show_qrcode').find('.modal-body').html(img);
					$('#show_qrcode').modal('show');
				}, 'json');
			});
		}
	};
	/* **编辑** */
	app.wechat_qrcodeshare_edit = {
		init: function () {
			app.wechat_qrcodeshare_edit.submit_form();
		},
		submit_form: function (formobj) {
			var $form = $("form[name='theForm']");
			var option = {
				rules: {
					username: {
						required: true
					},
					scene_id: {
						required: true
					},
					functions: {
						required: true
					}
				},
				messages: {
					username: {
						required: js_lang.qrcode_username_required
					},
					scene_id: {
						required: js_lang.qrcode_scene_id_required
					},
					functions: {
						required: js_lang.qrcode_funcions_required
					}
				},
				submitHandler: function () {
					$form.ajaxSubmit({
						dataType: "json",
						success: function (data) {
							ecjia.platform.showmessage(data);
						}
					});

				}
			}
			var options = $.extend(ecjia.platform.defaultOptions.validate, option);
			$form.validate(options);
		}
	};

})(ecjia.platform, jQuery);

// end