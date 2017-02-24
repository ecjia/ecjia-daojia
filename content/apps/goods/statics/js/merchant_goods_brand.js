// JavaScript Document
;
(function(app, $) {
	app.goods_brand = {
		init: function() {
			app.goods_brand.search();
		},

		search: function() {
			$('form[name="searchForm"]').on('submit', function(e) {
				e.preventDefault();
				var $this = $(this);
				var url = $this.attr('action');
				var keywords = $this.find('[name="keywords"]').val();
				if (keywords) {
					url += '&keywords=' + keywords;
				}
				ecjia.pjax(url);
			});
		}
	};

	app.goods_brand_info = {
		init: function() {
			// $("input[type='radio']").not(".nouniform").uniform();
			/* 获取编辑时的type */
			var type = $('#type').val();
			if (type == 1) {
				$('#show_src').css("display", "none");
				$("#show_local").css("display", "block");
			}

			$("input[name='brand_logo_type']").click(function() {
				var brand_type = $(this).val();
				if (brand_type == 0) {
					$('#show_src').css("display", "block");
					$('#show_local').css("display", "none");
					// $('input[name="url_logo"]').attr('value','');
				} else {
					$('#show_src').css("display", "none");
					$("#show_local").css("display", "block");
					// $('.fileupload').attr('class' , 'fileupload-new');
				}
			});
			app.goods_brand_info.submit();
		},
		/* 自定义submit事件 */
		submit: function() {
			var $this = $('form[name="theForm"]');
			var option = {
				rules: {
					brand_name: {
						required: true
					},
					url: {
						required: true
					}
				},
				messages: {
					brand_name: {
						required: "请输入品牌名称"
					},
					url: {
						required: "请输正确的网址"
					},
				},
				submitHandler: function() {
					$this.ajaxSubmit({
						dataType: "json",
						success: function(data) {
							if (data.state == "success") {
								$("input[name='old_brandname']").val($("input[name='brand_name']").val());
							}
							ecjia.merchant.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
			$this.validate(options);
		},
	};
})(ecjia.merchant, jQuery);

// end