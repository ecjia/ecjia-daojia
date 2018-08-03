// JavaScript Document
;
(function (app, $) {
	app.wechat_qrcode_list = {
		init: function () {
			$("form[name='searchForm'] .search_qrcode").off('click').on('click', function (e) {
				e.preventDefault();
				var url = $("form[name='searchForm']").attr('action') + '&keywords=' + $("input[name='keywords']").val();
				ecjia.pjax(url);
			});

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
	app.wechat_qrcode_edit = {
		init: function () {
			app.wechat_qrcode_edit.submit_form();
			app.wechat_qrcode_edit.checked();
		},
		submit_form: function (formobj) {
			var $form = $("form[name='theForm']");
			var option = {
				rules: {
					functions: {
						required: true
					},
					scene_id: {
						required: true
					}
				},
				messages: {
					functions: {
						required: js_lang.qrcode_funcions_empty
					},
					scene_id: {
						required: js_lang.application_adsense_required
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
		},

		checked: function () {
			$('input[name="keywords"]').off('click').on('click', function () {
				var $this = $(this),
					val = $this.val();
				if (val == 1) {
					$('#input_function').removeClass('d-none').find('input').attr('name', 'functions');
					$('#choose_function').addClass('d-none').find('select').attr('name', '');
				} else {
					$('#input_function').addClass('d-none').find('input').attr('name', '');
					$('#choose_function').removeClass('d-none').find('select').attr('name', 'functions');
				}
			});
		}
	};

})(ecjia.platform, jQuery);

// end