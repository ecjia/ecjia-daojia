// JavaScript Document
;
(function (app, $) {
	app.material = {
		init: function () {
			var action = $(".fileupload").attr('data-action');
			var type = $(".fileupload").attr('data-type');
			if (type == 'image') {
				var label = js_lang.upload_images_area;
			} else if (type == 'voice') {
				var label = js_lang.upload_mp3_area;
			}
			$(".fileupload").dropper({
				action: action,
				label: label,
				maxQueue: 2,
				maxSize: 5242880, // 5 mb
				height: 150,
				postKey: "img_url",
				successaa_upload: function (data) {
					ecjia.platform.showmessage(data);
				}
			});
			app.material.sort_ok();
			app.material.edit_title();
			app.material.get_material();

			$(".ajaxswitch").on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('href');
				$.get(url, function (data) {
					ecjia.platform.showmessage(data);
				}, 'json');
			});
		},
		sort_ok: function () {
			$('[data-toggle="sort-ok"]').on('click', function (e) {
				e.preventDefault();
				var $this = $(this),
					url = $this.attr('data-saveurl'),
					id = $this.attr('data-imgid'),
					val = $this.parent().find('.edit-inline').val(),
					info = {
						id: id,
						val: val
					};

				$.get(url, info, function (data) {
					$this.parent().find('.edit_title').html(val);
					$this.parent('p').find('.ajaxremove , .move-mod-head , [data-toggle="edit"]').css('display', 'inline-block');
					$this.parent('p').find('[data-toggle="sort-cancel"] , [data-toggle="sort-ok"]').css('display', 'none');
					ecjia.platform.showmessage(data);
				});
			});
		},
		edit_title: function () {
			$('[data-toggle="edit"]').on('click', function (e) {
				e.preventDefault();
				var $this = $(this),
					value = $(this).parent().find('.edit_title').text();
				$this.parent('p').find('.edit_title').html('<input class="edit-inline" type="text" value="' + value + '" />').find('.edit-inline').focus().select();

				$this.css('display', 'none').parent('p').find('.ajaxremove , .move-mod-head').css('display', 'none');
				$this.parent('p').find('[data-toggle="sort-cancel"] , [data-toggle="sort-ok"]').css('display', 'inline-block');

				$('[data-toggle="sort-cancel"]').off('click').on('click', function () {
					$this.parent().find('.edit_title').html(value);
					$this.css('display', 'inline-block').parent('p').find('.ajaxremove , .move-mod-head').css('display', 'inline-block');
					$this.parent('p').find('[data-toggle="sort-cancel"] , [data-toggle="sort-ok"]').css('display', 'none');

				});
			});
		},

		get_material: function () {
			$(".get_material").off('click').on('click', function (e) {
				e.preventDefault();
				var $this = $(this);
				$this.html('正在获取中').addClass('disabled');

				var url = $(this).attr('data-url');
				app.material.get_material_info(url);
			});
		},

		get_material_info: function (url) {
			$.ajax({
				type: "get",
				url: url,
				dataType: "json",
				success: function (data) {
					ecjia.platform.showmessage(data);
					if (data.page != undefined) {
						var url = data.url;
						app.material.get_material_info(url + '&page=' + data.page);
					}
				}
			});
		},
	};

	app.material_edit = {
		init: function () {
			app.material_edit.clone();
			app.material_edit.edit_area();
			app.material_edit.remove_area();
			app.material_edit.form_submit();
			app.material_edit.title_show();
			app.material_edit.image_show();
			app.material_edit.issue_submit();
			app.material_edit.upload_multi_articles();
			app.material_edit.remove_child_article();

			var index = $('.mobile_news_view').find('.select_mobile_area').length;
			if (index >= 8) {
				$('.create_news').hide();
			} else {
				$('.create_news').show();
			}
			app.material_edit.choose_material();
		},

		clone: function () {
			$('a[data-toggle="clone-object"]').off('click').on('click', function (e) {
				$('div.hide').find('input').prop('disabled', true);
				$('div.hide').find('textarea').prop('disabled', true);
				$('div.hide').find('checkbox').prop('disabled', true);

				$('.create_news').hide();
				var index = $('.select_mobile_area').length;
				$('.material_info').children().children('h4').html(js_lang.graphic + index);

				$('input[name="title"]').val('');
				$('input[name="sort"]').val('');
				$('input[name="author"]').val('');
				$('textarea[name="digest"]').val('');
				$('input[name="thumb_media_id"]').val('');

				$('.fileupload-preview.thumbnail').remove();
				$('input[name="is_show"]').prop("checked", false);

				$('input[name="id"]').val('');
				$('input[name="link"]').val('http://');
				$('input[name="index"]').val(index - 1);

				$('.sort_form').show();
				var $this = $(this),
					$parentobj = $($this.attr('data-parent')),
					$parentobj_clonearea = $($this.attr('data-clone-area'))
				before = $this.attr('data-before') || 'before',
					$childobj = $($this.attr('data-child')),
					$childobj_clonearea = $($this.attr('data-child-clone-area')),
					form_action = $('input[name="add_url"]').val();
				option = {
					parentobj: $parentobj,
					parentobj_clonearea: $parentobj_clonearea,
					before: before,
					childobj: $childobj,
					childobj_clonearea: $childobj_clonearea
				};
				!$parentobj ? console.log(js_lang.clone_no_parent) : app.material_edit.clone_obj(option);
				$('form[name="theForm"]').attr('action', form_action);

				$(document).unbind('keyup').on("keyup", "input[name^='title']", function () {
					$this = $(this);
					if ($this.val() == '') {
						$('.material_info_select').find('.title_show').html(js_lang.title);
					} else {
						$('.material_info_select').find('.title_show').html($this.val());
					}
				});

				$(document).unbind('change').on("change", 'input[name^="image_url"]', function () {
					$this = $(this);
					var index = $this.parents('.select_mobile_area').index() + 1;
					if ($this.val() == '') {
						$('.material_info_select').find('.show_image').html(js_lang.thumbnail);
					} else {
						setTimeout(function () {
							var src = $this.parents('.controls').find("img").attr('src');
							var html = '<img src="' + src + '"/>';
							$('.material_info_select').find('.show_image').html(html);
						}, 500);
					}
				});

				$('.mobile_news_view').find('.select_mobile_area').removeClass('active');
				$('.material_info_select').addClass('active');


				$("#content").children().find('iframe').contents().find('body.view').html('<p><br></p>');
				var editor = UE.getEditor('content');
				editor.setContent('');
			});
		},
		clone_obj(options) {
			if (!options.parentobj) return console.log(js_lang.batch_less_parameter);
			var tmpObj = options.parentobj.clone();
			tmpObj.removeClass('hide');
			tmpObj.removeClass('mobile_news_auxiliary_clone');

			(options.before == 'before') ? options.parentobj_clonearea.before(tmpObj): options.parentobj_clonearea.after(tmpObj);
			if (options.childobj && options.childobj_clonearea) {
				var size = options.childobj_clonearea.children('div').length + 2;
				if (size >= 9) {
					var error = {
						'message': js_lang.images_most8,
						'state': 'error'
					};
					ecjia.platform.showmessage(error);
					return false;
				}
				$('.material_add_info').children().children('h4').html(js_lang.graphic + size);
				num = size - 1;
			}

			//清空默认数据
			options.parentobj.find('input').not(":hidden").val('');
			//编辑区域展示效果js
			app.material_edit.edit_area_show(num);
			app.material_edit.remove_area();
		},
		edit_area_show: function (num) {
			var tmp = $('.mobile_news_edit').children().eq(num);
			tmp.removeClass('hide');
		},
		edit_area: function () {
			$('.ft-edit-2').off('click').on('click', function (e) {
				e.preventDefault();
				$('.material_info_select').not('.hide').remove();
				$('.create_news').show();
				var index = $(this).parents('.select_mobile_area').index() + 1;

				$('.mobile_news_view').find('.select_mobile_area').removeClass('active');
				$(this).parents('.select_mobile_area').addClass('active');

				$('.material_info').children().children('h4').html(js_lang.graphic + index);
				var edit_area = $('.mobile_news_view').children('.select_mobile_area').eq(index - 1);

				$(document).unbind('keyup').on("keyup", "input[name^='title']", function () {
					if ($(this).val() == '') {
						edit_area.find('.title_show').html(js_lang.title);
					} else {
						edit_area.find('.title_show').html($(this).val());
					}
				});

				$(document).unbind('change').on("change", 'input[name^="image_url"]', function () {
					$this = $(this);
					if ($(this).val() == '') {
						edit_area.find('.show_image').html(js_lang.thumbnail);
					} else {
						setTimeout(function () {
							var src = $this.parents('.controls').find("img").attr('src');
							var html = '<img src="' + src + '"/>';
							edit_area.find('.show_image').html(html);
						}, 500);
					}
				});

				var url = $(this).parent().attr('data-href');
				var id = $(this).parent().attr('data-id')

				if (url == undefined || id == undefined) {
					return false;
				}

				var form_action = $('input[name="update_url"]').val();
				$('form[name="theForm"]').attr('action', form_action + '&id=' + id);

				$.get(url, id, function (data) {
					$('input[name="title"]').val(data.content.title);
					$('input[name="author"]').val(data.content.author);
					$('input[name="sort"]').val(data.content.sort);
					$('textarea[name="digest"]').val(data.content.digest);
					$('input[name="id"]').val(data.content.id);
					$('input[name="link"]').val(data.content.link);
					$('input[name="index"]').val(index - 1);

					$('.fileupload-preview.thumbnail').remove();
					var html = '<div class="fileupload-preview fileupload-exists thumbnail m_r10 show_cover" style="width: 50px; height: 50px; line-height: 50px;"><img src="' + data.content.file + '"></div>';
					$('.choose_material').before(html);
					$('input[name="thumb_media_id"]').val(data.content.thumb);

					if (data.content.is_show == 1) {
						$('input[name="is_show"]').prop("checked", true);
					} else {
						$('input[name="is_show"]').prop("checked", false);
					}
					if (data.content.parent_id == 0) {
						$('.sort_form').hide();
					} else {
						$('.sort_form').show();
					}
					$("#content").children().find('iframe').contents().find('body.view').html(data.content.content);
					var editor = UE.getEditor('content');
					content = editor.setContent(data.content.content);
				}, "JSON");

				app.material_edit.edit_area_show(index);
			});
		},
		remove_area: function () {
			$('[data-toggle="remove_material"]').on('click', function () {
				var $this = $(this);
				var msg = $this.attr('data-msg'),
					id = $this.attr('data-id'),
					url = $this.attr('data-href');

				ecjia.platform_ui.confirm(msg, function (e) {
					if (e) {
						$.get(id, url, function (data) {
							ecjia.pjax(window.location.href, function () {
								ecjia.platform.showmessage(data);
							});
						}, 'json');
					}
				}, {
					ok: js_lang.ok,
					cancel: js_lang.cancel
				});
			});

			$('[data-toggle="remove_edit_mask"]').off('click').on('click', function () {
				var index = $(this).parents('.select_mobile_area').index();
				$('.mobile_news_view').children().eq(index).remove();
				$('.material_info').children().children('h4').html(js_lang.graphic + index);
				app.material_edit.edit_area_show(index);
				$('.create_news').show();

				$('.material_info_select').find('.title_show').html(js_lang.title);
				$('.material_info_select').find('.show_image').html('');

				var a = $('.create_news').prev('.select_mobile_area').children('.edit_mask').children('a');
				var id = a.attr('data-id');
				var url = a.attr('data-href');

				$.get(url, id, function (data) {
					$('input[name="title"]').val(data.content.title);
					$('input[name="author"]').val(data.content.author);

					$('.fileupload-preview.thumbnail').remove();
					var html = '<div class="fileupload-preview fileupload-exists thumbnail m_r10 show_cover" style="width: 50px; height: 50px; line-height: 50px;"><img src="' + data.content.file + '"></div>';
					$('.choose_material').before(html);
					$('input[name="thumb_media_id"]').val(data.content.thumb);

					if (data.content.is_show == 1) {
						$('input[name="is_show"]').attr("checked", true).parent().addClass('uni-checked');
					} else {
						$('input[name="is_show"]').attr("checked", false).parent().removeClass('uni-checked');
					}
					$('textarea[name="digest"]').val(data.content.digest);

					$("#content").children().find('iframe').contents().find('body.view').html(data.content.content);
					$('textarea[name="content"]').html(data.content.content);

					$('input[name="id"]').val(data.content.id);
					$('input[name="link"]').val(data.content.link);
					if (data.content.parent_id != 0) {
						$('.sort_form').hide();
					} else {
						$('.sort_form').show();
					}
				}, "JSON");
			});
		},
		issue_submit: function () {
			$('.issue').on('click', function (e) {
				var url = $(this).attr('data-url');
				$.get(url, function (data) {
					ecjia.platform.showmessage(data);
				}, 'json');
			});
		},
		form_submit: function () {
			$('div.hide').find('input').prop('disabled', true);
			$('div.hide').find('textarea').prop('disabled', true);
			$('div.hide').find('checkbox').prop('disabled', true);

			var $form = $("form[name='theForm']");
			var option = {
				rules: {
					title: {
						required: true
					},
				},
				messages: {
					title: {
						required: js_lang.title_placeholder_graphic
					},
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
		title_show: function () {
			var edit_area = $('.mobile_news_view').children('.select_mobile_area').eq(0);

			$(document).unbind('keyup').on("keyup", "input[name^='title']", function () {
				$this = $(this);
				if ($this.val() == '') {
					edit_area.find('.title_show').html(js_lang.title);
				} else {
					edit_area.find('.title_show').html($this.val());
				}
			});
		},
		image_show: function () {
			var edit_area = $('.mobile_news_view').children('.select_mobile_area').eq(0);

			$(document).unbind('change').on("change", 'input[name^="image_url"]', function () {
				$this = $(this);
				var index = $this.parents('.select_mobile_area').index() + 1;
				if ($this.val() == '') {
					edit_area.eq(0).find('.show_image').html(js_lang.thumbnail);
				} else {
					setTimeout(function () {
						var src = $this.parents('.controls').find("img").attr('src');
						var html = '<img src="' + src + '"/>';
						edit_area.eq(0).find('.show_image').html(html);
					}, 500);
				}
			});
		},

		choose_material: function () {
			$('.choose_material').off('click').on('click', function () {
				var $this = $(this);
				url = $this.attr('data-url'),
					type = $this.attr('data-type');
				var info = {
					type: type
				}
				$.post(url, info, function (data) {
					$('.inner_main').html(data.data);
					$('#choose_material').modal('show');
					app.material_edit.img_item_click();
				})
			});

			$('.js-btn').off('click').on('click', function () {
				var $this = $('.img_item_bd.selected'),
					media_id = $this.find('.pic').attr('data-media'),
					src = $this.find('.pic').attr('src');
				if ($this.length != 0) {
					$('input[name="thumb_media_id"]').val(media_id);
					$('.show_cover').remove();
					var html = '<div class="fileupload-preview fileupload-exists thumbnail m_r10 show_cover" style="width: 50px; height: 50px; line-height: 50px;"><img src="' + src + '"></div>';
					$('.choose_material').before(html);
				}
				$('#choose_material').modal('hide');
				$(".modal-backdrop").remove();
			});
		},

		img_item_click: function () {
			$('.img_item').off('click').on('click', function () {
				var $this = $(this),
					child = $this.children('.img_item_bd');

				if (child.hasClass('selected')) {
					child.removeClass('selected');
					return false;
				}
				child.addClass('selected');
				$this.siblings('li').children('.img_item_bd').removeClass('selected');
			});
		},

		upload_multi_articles: function () {
			$('.article_handle').off('click').on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('data-url');
				$.post(url, function (data) {
					ecjia.platform.showmessage(data);
				})
			});
		},

		remove_child_article: function () {
			$("[data-toggle='remove_child_material']").off('click').on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('data-url');
				$.post(url, function (data) {
					ecjia.platform.showmessage(data);
				})
			});
		}
	};
})(ecjia.platform, jQuery);

// end