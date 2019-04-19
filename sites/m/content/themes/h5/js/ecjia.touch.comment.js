/**
 * H5评论晒单
 */
;
(function (ecjia, $) {
	ecjia.touch.comment = {
		init: function () {
			ecjia.touch.comment.goods_info();
			ecjia.touch.comment.anonymity();
			ecjia.touch.comment.photo();
			ecjia.touch.comment.remove_goods_img();
			ecjia.touch.comment.submitForm();
		},
		goods_info: function () {
			var comment_goods = $("input[name='comment_goods']").val();
			if (comment_goods != '') {
				$('.star').raty({
					cancelOff: 'cancel-off-big.png',
					cancelOn: 'cancel-on-big.png',
					starOff: 'star-off-big.png',
					starOn: 'star-on-big.png',
					score: comment_goods,
					readOnly: true
				});
			} else {
				$('.star').raty({
					click: function (score, evt) {
						$(this).attr("data-number", score);
					},
					cancelOff: 'cancel-off-big.png',
					cancelOn: 'cancel-on-big.png',
					size: 24,
					starOff: 'star-off-big.png',
					starOn: 'star-on-big.png',
					score: 0
				});
			}
		},

		anonymity: function () {
			var is_commented = $("input[name='is_commented']").val();
			if (is_commented == 0) {
				$(".ecjia-anonymity-check").on('click', function (e) {
					e.preventDefault();
					if ($(this).hasClass('anonymity-check-checked')) {
						$(this).removeClass("anonymity-check-checked");
						$("input[name='anonymity_status']").val("0");
					} else {
						$(this).addClass("anonymity-check-checked");
						$("input[name='anonymity_status']").val("1");
					}
				});
			}
		},

		//评价晒单上传图片，并且不能超过5张。
		photo: function () {

			$('.push_photo').hide();
			$('#result0').show();
			$(".push_img_btn").on('change', function () {
				var f = $(this)[0].files[0];
				if (f) {
					var fr = new FileReader();
					fr.onload = function () {
						var _img = new Image();
						_img.src = this.result;

						var num = [];
						$(".push_photo").each(function () {
							if (!$(this).is(':hidden')) {
								var id = $(this).attr('id');
								var number = id.substr(id.length - 1, 1);
								num.push(number);
							}
						});

						var num = parseInt(num[0]);

						var check_push_rm = "check_push_rm" + num;
						var img_span = "<i class='a4y'>X</i>";
						var url = "<div class='" + check_push_rm + "'></div>";

						$(url).appendTo(".push_photo_img");
						$(_img).appendTo("." + check_push_rm);
						$(img_span).appendTo("." + check_push_rm);
						ecjia.touch.comment.remove_goods_img();

						var result = [];
						$(".push_photo").each(function () {
							if ($(this).is(':hidden')) {
								var id = $(this).attr('id');
								var number = id.substr(id.length - 1, 1);
								var check_push_rm = ".check_push_rm" + number;

								if ($(check_push_rm).length == 0) {
									result.push(id);
								}
							}
						});

						var result = "#" + result[0];
						$('.push_photo').hide();
						$(result).show();

						if ($(".push_photo_img img").length > 0) {
							$(".push_img_fonz").hide();
						}
						if ($(".push_photo_img img").length > 4) {
							$(".push_photo").hide();
						}
						if ($(".push_photo_img img").length >= 1) {
							$(".push_result_img").css("margin-left", "0");
						}
					}
					fr.readAsDataURL(f);
				}
			})
		},

		remove_goods_img: function () {
			$(".a4y").on('click', function (e) {
				e.preventDefault();

				var path = $(this).parent();
				var myApp = new Framework7({
					modalButtonCancel: js_lang.cancel,
					modalButtonOk: js_lang.ok,
					modalTitle: ''
				});
				myApp.confirm(js_lang.confirm_delete, function () {
					if ($(".push_photo_img img").length <= 5) {
						$(".push_photo").show();
					}
					if ($(".push_photo_img img").length <= 1) {
						$(".push_img_fonz").show();
					}
					path.remove();
					var c_name = path[0].className;
					var num = c_name.substr(c_name.length - 1, 1);
					var result = "#result" + num;
					var filechooser = "filechooser" + num;
					$('.push_photo').hide();
					document.getElementById(filechooser).value = "";
					$(result).show();
					if ($(".push_photo_img img").length < 1) {
						$(".push_result_img").css("margin-left", "0.3em");
					}
				});
			})
		},
		
		submitForm: function () {
			$('input[name="push-comment-btn"]').on('click', function (e) {
				e.preventDefault();

				var comment_goods = $("input[name='comment_goods']").val();
				if (comment_goods == '') {
					if (!$(".star").attr("data-number")) {
						alert(js_lang.please_choose_star);
						return false;
					}
				}

				var url = $("form[name='theForm']").attr('action');
				$("form[name='theForm']").ajaxSubmit({
					type: 'post',
					url: url,
					dataType: "json",
					success: function (data) {
						var myApp = new Framework7();
						myApp.modal({
							title: data.message,
							buttons: [{
								text: js_lang.ok,
								onClick: function () {
									if (data.pjaxurl != '') {
										ecjia.pjax(data.pjaxurl, function () { }, {
											replace: true
										});
									}
								}
							},]
						});
					}
				});
			});
		},
	};

})(ecjia, jQuery);

//end