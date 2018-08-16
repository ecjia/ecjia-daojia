// JavaScript Document
;
(function(app, $) {
	app.goods_type = {
		init: function() {
			app.goods_type.edit_type();
			app.goods_type.search();
		},

		search: function() {
			$("form[name='searchForm']").on('submit', function(e) {
				e.preventDefault();
				var merchant_keywords = $("input[name='merchant_keywords']").val();
				var keywords = $("input[name='keywords']").val();
				var url = $("form[name='searchForm']").attr('action');

				if (merchant_keywords) {
					url += '&merchant_keywords=' + merchant_keywords;
				}

				if (keywords) {
					url += '&keywords=' + keywords;
				}
				ecjia.pjax(url);
			})
		},

		edit_type: function() {
			var $this = $('form[name="theForm"]');
			var option = {
				rules: {
					cat_name: {
						required: true
					},
				},
				messages: {
					cat_name: {
						required: js_lang.spec_name_required
					},
				},
				submitHandler: function() {
					$this.ajaxSubmit({
						dataType: "json",
						success: function(data) {
							ecjia.admin.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
		}
	};

	app.goods_arrt = {
		init: function() {
			app.goods_arrt.change_attr();
		},

		change_attr: function() {
			$('select[name="goods_type"]').on('change', function() {
				var $this = $(this),
					url = $this.attr('data-url') + $this.val();
				ecjia.pjax(url);
			});
		},
	};

	app.edit_arrt = {
		init: function() {
			//单选框切换事件
			$(document).on('click', 'input[name="attr_input_type"]', function(e) {
				$("input[name='attr_input_type']:checked").val() == 1 ? $('.attr_values').show() : $('.attr_values').hide();
			});
			$('input[name="attr_input_type"]:checked').trigger('click');

			$('select[name="cat_id"]').on('change', function() {
				var $this = $(this),
					url = $this.attr('data-url'),
					info = {
						'cat_id': $this.val()
					};
				$.post(url, info, function(data) {
					$('.attr_list').html('');
					if (data.content.length > 0) {
						for (var i = 0; i < data.content.length; i++) {
							var opt = '<option value="' + i + '">' + data.content[i] + '</option>';
							$('.attr_list').append(opt);
						}
						$('.attr_list').trigger("liszt:updated");
						$('#attrGroups').show();
					} else {
						$('#attrGroups').hide();
					}
				})
			});

			app.edit_arrt.edit_type_attr();
		},

		edit_type_attr: function() {
			var $this = $('form[name="theForm"]');
			var option = {
				rules: {
					attr_name: {
						required: true
					},
					cat_id: {
						min: 1
					},
				},
				messages: {
					attr_name: {
						required: js_lang.attr_name_required
					},
					cat_id: {
						min: js_lang.cat_id_select
					}
				},
				submitHandler: function() {
					$this.ajaxSubmit({
						dataType: "json",
						success: function(data) {
							ecjia.admin.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
		},
	};

})(ecjia.admin, jQuery);

// end