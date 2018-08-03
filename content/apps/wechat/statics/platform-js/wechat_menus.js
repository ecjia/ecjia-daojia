// JavaScript Document
;
(function (app, $) {
	app.wechat_menus_edit = {
		init: function () {
			$(".ajaxswitch").off('click').on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('href');
				$.get(url, function (data) {
					ecjia.platform.showmessage(data);
				}, 'json');
			});

			$('input[name="type"]').off('click').on('click', function (e) {
				if ($("input[name='type']:checked").val() == 'click') {
					$('#keydiv').show();
					$('#urldiv').hide();
					$('#weappdiv').hide();
				} else if ($("input[name='type']:checked").val() == 'view') {
					$('#keydiv').hide();
					$('#urldiv').show();
					$('#weappdiv').hide();
				} else {
					$('#keydiv').hide();
					$('#urldiv').hide();
					$('#weappdiv').show();
				}
			});
			$('input[name="type"]:checked').trigger('click');
		}
	};

	app.wechat_menus_list = {
		init: function () {
			$(".ajaxswitch").off('click').on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('href');
				$.get(url, function (data) {
					ecjia.platform.showmessage(data);
				}, 'json');
			});


			$(".ajaxmenu").off('click').on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('data-url');
				var message = $(this).attr('data-msg');
				if (message) {
					ecjia.platform_ui.confirm(message, function (e) {
						e && $.get(url, function (data) {
							ecjia.platform.showmessage(data);
						}, 'json');
					}, {
						ok: js_lang.ok,
						cancel: js_lang.cancel
					});
				} else {
					$.get(url, function (data) {
						ecjia.platform.showmessage(data);
					}, 'json');
				}
			});

			app.wechat_menus_list.add();
			app.wechat_menus_list.edit();
			app.wechat_menus_list.remove();
			app.wechat_menus_list.save();
			app.wechat_menus_list.btn_save();
		},

		add: function () {
			$('[data-toggle="add-menu"]').off('click').on('click', function () {
				var $this = $(this),
					pid = $this.attr('data-pid'),
					url = $('input[name="add_url"]').val(),
					count = $this.attr('data-count');
				var info = {
					pid: pid
				}
				if (count == 0) {
					ecjia.platform_ui.confirm('添加子菜单后，一级菜单的内容将被清除。确定添加子菜单？', function (e) {
						if (e) {
							$.post(url, info, function (data) {
								$('#weixin-menu').html(data.data);
								$('.weixin-menu-right-content').html(data.result);
								app.wechat_menus_edit.init();
								app.wechat_menus_list.init();
							});
						}
					}, {
						ok: "确定",
						cancel: "取消"
					});
				} else {
					$.post(url, info, function (data) {
						$('#weixin-menu').html(data.data);
						$('.weixin-menu-right-content').html(data.result);
						app.wechat_menus_edit.init();
						app.wechat_menus_list.init();
					});
				}
			});
		},

		edit: function () {
			$('[data-toggle="edit-menu"]').off('click').on('click', function () {
				var $this = $(this),
					id = $this.attr('data-id'),
					pid = $this.attr('data-pid'),
					url = $('input[name="edit_url"]').val();
				var info = {
					id: id,
					pid: pid
				}
				$.post(url, info, function (data) {
					$('.menu-sub-item').removeClass('current');
					$('.menu-item').removeClass('size1of1');
					if ($this.parent().hasClass('menu-item')) {
						$this.parent('.menu-item').addClass('size1of1');
						$('.weixin-sub-menu').addClass('hide');
						$this.parent('.menu-item').find('.weixin-sub-menu').removeClass('hide');
					} else {
						$this.parent('.menu-sub-item').addClass('current');
					}
					$('.weixin-menu-right-content').html(data.data);
					$("select").not(".noselect").select2();
					app.wechat_menus_edit.init();
					app.wechat_menus_list.init();
				});
			});
		},

		remove: function () {
			$('[data-toggle="del-menu"]').off('click').on('click', function () {
				var $this = $(this),
					id = $this.attr('data-id'),
					url = $('input[name="del_url"]').val();
				var info = {
					id: id
				}
				ecjia.platform_ui.confirm('您确定要删除该菜单吗？', function (e) {
					if (e) {
						$.post(url, info, function (data) {
							ecjia.platform.showmessage(data);
						});
					}
				}, {
					ok: "确定",
					cancel: "取消"
				});
			});
		},

		save: function () {
			$('[data-toggle="btn-create"]').off('click').on('click', function () {
				var $this = $(this),
					url = $('input[name="check_url"]').val();
				$.post(url, function (data) {
					if (data.id != 0) {
						$('#weixin-menu').html(data.data);
						$('.weixin-menu-right-content').html(data.result);
						app.wechat_menus_edit.init();
						app.wechat_menus_list.init();
						$('.div-input').find('.menu-tips').removeClass('hide');
					} else {
						var $this = $('[data-toggle="btn-create"]');
						var url = $this.attr('data-url');
						var message = $this.attr('data-msg');
						if (message) {
							ecjia.platform_ui.confirm(message, function (e) {
								e && $.get(url, function (data) {
									ecjia.platform.showmessage(data);
								}, 'json');
							}, {
								ok: js_lang.ok,
								cancel: js_lang.cancel
							});
						} else {
							$.get(url, function (data) {
								ecjia.platform.showmessage(data);
							}, 'json');
						}
					}
				});
			});
		},

		btn_save: function () {
			$('.btn-save').off('click').on('click', function () {
				var $form = $("form[name='the_form']");
				var option = {
					rules: {
						message_content: {
							required: true
						}
					},
					messages: {
						message_content: {
							required: js_lang.content_require
						}
					},
					submitHandler: function () {
						$form.ajaxSubmit({
							dataType: "json",
							success: function (data) {
								ecjia.platform.showmessage(data);
								$('#weixin-menu').html(data.data);
								$('.weixin-menu-right-content').html(data.result);
								$("select").not(".noselect").select2();
								app.wechat_menus_edit.init();
								app.wechat_menus_list.init();
							}
						});
					}
				}
				var options = $.extend(ecjia.platform.defaultOptions.validate, option);
				$form.validate(options);
			});
		}
	};

})(ecjia.platform, jQuery);

// end