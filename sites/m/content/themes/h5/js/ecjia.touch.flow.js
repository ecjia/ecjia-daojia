/**
 * 后台综合js文件
 */
;
(function (ecjia, $) {


	ecjia.touch.flow = {
		init: function () {
			ecjia.touch.flow.change_number_click();
			ecjia.touch.flow.selectShipping();
			ecjia.touch.flow.selectPayment();
			ecjia.touch.flow.change_need_inv();
			ecjia.touch.flow.change_bonus();
			ecjia.touch.flow.change_surplus();
			ecjia.touch.flow.change_integral();
			ecjia.touch.flow.select_inv();
			ecjia.touch.flow.select_attr();
			ecjia.touch.flow.fold_area();
			ecjia.touch.flow.check_goods();
			ecjia.touch.flow.form_submit();
			ecjia.touch.flow.select_inv_type();
			ecjia.touch.flow.inv_img();
			ecjia.touch.flow.selectPayShipping();
			ecjia.touch.flow.pay_order();
			ecjia.touch.flow.boardInit();

			$('[data-toggle="selectShipping"]:checked').trigger('click');
			$('[data-toggle="selectPayment"]:checked').trigger('click');
			$('[data-toggle="change_bonus"]:checked').trigger('click');
			$('[data-toggle="change_surplus"]').blur();
			$('[data-toggle="change_integral"]').blur();

			function back_goods_number(id) {
				var goods_number = document.getElementById('goods_number' + id).value;
				document.getElementById('back_number' + id).value = goods_number;
			}

			$(document).winderCheck();
		},

		inv_img: function () {
			$('.inv_img').on('click', function () {
				alert(js_lang.invoice_desc)
				$(".modal-overlay").css('transition-duration', "0ms");
				$(".modal-in").css("position", "fixed");
				$(".modal-in").css("top", "30%");
				$(".modal-in").css("height", "70%");
				$(".modal-inner").css("background-color", "#FFF");
				$(".modal-inner").css("width", "100%");
				$(".modal-inner").css("padding", "0");
				$(".modal-inner").css("height", "85%");
				$(".modal-button-bold").css("background-color", "#FFF");
				$(".modal-button-bold").css("border-top", "1px solid #eee");
				$(".modal-inner").append("<style>.modal-inner::after{ width:0 }</style>");
				$(".modal-text").css("height", "100%");
			});
		},

		select_inv_type: function () {
			$('.personal').on('click', function (e) {
				e.preventDefault();
				$(this).addClass('action');
				$('.enterprise').removeClass('action');
				$('.inv_input').addClass('inv_none');
				$('.inv_type_input').val("");
				$('input[name="inv_type_name"]').val("personal")
				$('.ecjia-bill-img').hide();
				$(this).children('.ecjia-bill-img').show();
			});
			$('.enterprise').on('click', function (e) {
				e.preventDefault();
				$(this).addClass('action');
				$('.personal').removeClass('action');
				$('.inv_input').removeClass('inv_none');
				$('input[name="inv_type_name"]').val("enterprise")
				$('.ecjia-bill-img').hide();
				$(this).children('.ecjia-bill-img').show();
			});
		},

		form_submit: function () {
			$("form[name='checkForm']").on('submit', function (e) {
				ecjia.touch.pjaxloadding();
				e.preventDefault();
				return false;
			}).Validform({
				tiptype: function (msg, o, cssctl) {
					if (o.type == 3) {
						alert(msg);
					}
				},
				ajaxPost: true,
				callback: function (data) {
					$('.la-ball-atom').remove();
					ecjia.touch.showmessage(data);
				}
			});

			$('.check_address').off('click').on('click', function (e) {
				e.preventDefault();
				var $this = $(this),
					href = $this.attr('href');
				$.post(href, function (data) {
					if (data.state == 'error') {
						alert(data.message);
						return false;
					}
					ecjia.pjax(href);
				})
			});
		},

		change_number_click: function () {
			$('[data-toggle="change_goods_number"]').on('click', function () {
				var $this = $(this),
					options = {
						rec_id: $this.attr('data-rec_id'),
						url: $this.attr('data-url'),
						status: $this.attr('data-status')
					};
				var goods_number = $('#goods_number' + options.rec_id).val();
				if (options.status == 'del') {
					if (goods_number == 1) {
						goods_number = 1;
					} else {
						goods_number = parseInt(goods_number) - 1;
						$('#goods_number' + options.rec_id).val(goods_number);
					}
				} else {
					goods_number = parseInt(goods_number) + 1;
					$('#goods_number' + options.rec_id).val(goods_number);
				}
				ecjia.touch.flow._change_goods(options, goods_number);
			});

			$('[data-toggle="change_goods_number_blur"]').on('blur', function () {
				var $this = $(this),
					options = {
						rec_id: $this.attr('data-rec_id'),
						url: $this.attr('data-url'),
						status: $this.attr('data-status')
					};
				var goods_number = $('#goods_number' + options.rec_id).val();
				if (goods_number <= 0) {
					goods_number = 1;
					$('#goods_number' + options.rec_id).val(1);
				}
				ecjia.touch.flow._change_goods(options, goods_number);
			});
		},

		_change_goods: function (options, goods_number) {
			$.post(
				options.url, {
					'rec_id': options.rec_id,
					'goods_number': goods_number
				},
				function (data) {
					if (data.state == "success") {
						$('#total_number').html(data.total_number);
						$('#goods_subtotal').html(data.total_desc);
					} else {
						if (data.error == "1") {
							alert(data.message);
							$('#goods_number' + options.rec_id).val(data.err_max_number);
						}
					}
				}, 'json');
		},

		selectShipping: function () {
			$(document).off('click', '[data-toggle="selectShipping"]');
			$(document).on('click', '[data-toggle="selectShipping"]', function () {
				var $this = $(this),
					rec_id = $('.hidden_rec_id').val(),
					options = {
						shipping: $this.val(),
						rec_id: rec_id
					},
					url = $this.attr('data-url');
				$.get(url, options, function (data) {
					if (data.state == "success") {
						$('#total_number').html(data.content);
					} else {
						if (data.error == "1") {
							alert(data.message);
						}
					}
				});
			});
		},

		selectPayment: function () {
			$(document).off('click', '[data-toggle="selectPayment"]');
			$(document).on('click', '[data-toggle="selectPayment"]', function () {
				var $this = $(this),
					rec_id = $('.hidden_rec_id').val(),
					options = {
						payment: $this.val(),
						rec_id: rec_id
					},
					url = $this.attr('data-url');
				$.get(url, options, function (data) {
					if (data.state == "success") {
						$('#total_number').html(data.content);
						//$('#goods_subtotal').html(data.total_desc);
					} else {
						if (data.error == "1") {
							alert(data.message);
							$('#goods_number' + options.rec_id).val(data.err_max_number);
						}
					}
				});
			});
		},

		select_attr: function () {
			$('.flow-checkout .checkout-select label').on('click', function () {
				var pay = $.trim($(this).text());
				$(this).parents('div').prev('a').find('.select_nav').text(pay);
			});
		},

		change_need_inv: function () {
			$('[data-toggle="click_need_inv"]').on('click', function () {
				var $this = $(this),
					rec_id = $('.hidden_rec_id').val(),
					options = {
						need_inv: $this.val(),
						rec_id: rec_id
					},
					url = $this.attr('data-url');
				$.get(url, options, function (data) {
					if (data.state == "success") {
						$('#total_number').html(data.total_number);
						$('#goods_subtotal').html(data.total_desc);
					} else {
						if (data.error == "1") {
							alert(data.message);
							$('#goods_number' + options.rec_id).val(data.err_max_number);
						}
					}
				});
			});
			$('[data-toggle="change_need_inv"]').on('change', function () {
				var $this = $(this),
					rec_id = $('.hidden_rec_id').val(),
					options = {
						inv_type: $this.val(),
						rec_id: rec_id
					},
					url = $this.attr('data-url');
				$.get(url, options, function (data) {
					if (data.state == "success") {
						$('#total_number').html(data.total_number);
						$('#goods_subtotal').html(data.total_desc);
					} else {
						if (data.error == "1") {
							alert(data.message);
							$('#goods_number' + options.rec_id).val(data.err_max_number);
						}
					}
				});
			});
			$('[data-toggle="blur_need_inv"]').on('blur', function () {
				var $this = $(this),
					options = {
						inv_payee: $this.val()
					},
					url = $this.attr('data-url');
				$.get(url, options, function (data) {
					if (data.state == "success") {
						$('#total_number').html(data.total_number);
						$('#goods_subtotal').html(data.total_desc);
					} else {
						if (data.error == "1") {
							alert(data.message);
							$('#goods_number' + options.rec_id).val(data.err_max_number);
						}
					}
				});
			});
		},

		change_bonus: function () {
			$('[data-toggle="change_bonus"]').on('click', function () {
				var $this = $(this),
					rec_id = $('.hidden_rec_id').val(),
					options = {
						bonus: $this.val(),
						rec_id: rec_id
					},
					url = $this.attr('data-url');
				$.get(url, options, function (data) {
					if (data.state == "success") {
						$('#total_number').html(data.content);
					} else {
						if (data.error == "1") {
							alert(data.message);
							$('#goods_number' + options.rec_id).val(data.err_max_number);
						}
					}
				});
			});
		},

		change_surplus: function () {
			$('[data-toggle="change_surplus"]').on('blur', function () {
				var $this = $(this),
					rec_id = $('.hidden_rec_id').val(),
					options = {
						surplus: $this.val(),
						rec_id: rec_id
					},
					url = $this.attr('data-url');
				$.get(url, options, function (data) {
					if (data.state == "success") {
						$('#total_number').html(data.content);
					} else {
						if (data.error == "1") {
							alert(data.message);
							$('#goods_number' + options.rec_id).val(data.err_max_number);
						}
					}
				});
			});
		},

		change_integral: function () {
			$('[data-toggle="change_integral"]').on('blur', function () {
				var $this = $(this),
					rec_id = $('.hidden_rec_id').val(),
					options = {
						integral: $this.val(),
						rec_id: rec_id
					},
					url = $this.attr('data-url');
				$.get(url, options, function (data) {
					if (data.message.message) {
						ecjia.touch.showmessage(data.message);
					} else {
						$('#total_number').html(data.message.content);
					}
				});
			});
		},

		select_inv: function () {
			$('[data-flag="need_inv_i"]').on('click', function () {
				if ($(this).hasClass("fl")) {
					$(this).removeClass("fl").addClass("fr");
					$(this).siblings("ins").text(js_lang.yes);
					$(this).parent().parent("li").siblings().hide();
				} else if ($(this).hasClass("fr")) {
					$(this).removeClass("fr").addClass("fl");
					$(this).siblings("ins").text(js_lang.no);
					$(this).parent().parent("li").siblings().show();
				}
			});
		},

		fold_area: function () {
			$(document).off('click', '.flow-checkout .checkout-select .select');
			$(document).on('click', '.flow-checkout .checkout-select .select', function (e) {
				e.preventDefault();
				$(this).next().toggle();
			});
		},

		init_pay: function () {
			if (!$('input[name="shipping"]:checked').val()) {
				$('input[name="shipping"]').eq(0).prop('checked', 'true');
			}
			if (!$('input[name="payment"]:checked').val()) {
				$('input[name="payment"]').eq(0).prop('checked', 'true');
			}
		},

		check_goods: function () {
			$('.checkbox').on('change', function () {
				var $id = $(".checkbox:checked");
				var id = [],
					url = $('.goods-checkout').attr('data-url') + '&rec_id=';
				$id.each(function () {
					id = $(this).val();
					url = url + id + ',';
				});
				url = url.substring(0, url.length - 1);
				$('.goods-checkout').attr('href', url);
			});
		},

		selectPayShipping: function () {
			//选择支付方式
			$('.select-pay-title').off('click').on('click', function () {
				var $this = $(this),
					parent = $this.parents('.ecjia-list'),
					pay_id = $this.attr('data-payment'),
					pay_code = $this.attr('data-code');
				parent.find('.select-pay-title').removeClass('active');
				$this.addClass('active');
				$('input[name="payment"]').val(pay_id);
				//货到付款 隐藏不支持的配送方式
				if (pay_code == 'pay_cod') {
					$('.select-shipping-title.unsupport_cod_shipping').hide();
					if ($('.select-shipping-title.active').hasClass('unsupport_cod_shipping')) {
						$('.select-item-li').find('.select-shipping-title').each(function () {
							if (!$(this).hasClass('unsupport_cod_shipping')) {
								$(this).trigger('click');
								return false;
							}
						})
					}
				} else {
					$('.select-shipping-title').show();
				}
			});
			//选择配送方式
			$('.select-shipping-title').off('click').on('click', function () {
				var $this = $(this),
					parent = $this.parents('.ecjia-list'),
					shipping_id = $this.attr('data-shipping'),
					shipping_code = $this.attr('data-code');

				parent.find('.select-shipping-title').removeClass('active');
				$this.addClass('active');
				$('input[name="shipping"]').val(shipping_id);
				if (shipping_code == 'ship_o2o_express' || shipping_code == 'ship_ecjia_express') {
					$('.select-shipping-date').addClass('show').attr('data-code', shipping_code);
					$(('ul.' + shipping_code + '_date')).find('li').eq(0).addClass('active').siblings('li').removeClass('active');
					var index = $(('ul.' + shipping_code + '_time')).find('li').eq(0);
					var date = index.attr('data-date');
					var time = index.attr('data-time');
					$(('ul.' + shipping_code + '_time li')).each(function () {
						if ($(this).attr('data-date') == date) {
							$(this).removeClass('hide');
							if ($(this).attr('data-time') == time) {
								$(this).addClass('active');
							}
						} else {
							$(this).addClass('hide').removeClass('active');
						}
					});
					$('input[name="shipping_date"]').val(date);
					$('input[name="shipping_time"]').val(time);
					$('.shipping-time').html(date + ' ' + time);
				} else {
					$('.select-shipping-date').removeClass('show');
				}
			});
			//显示送达时间选择框
			$('.select-shipping-date').off('click').on('click', function () {
				var code = $(this).attr('data-code');
				$('.mod_address_slide').find('ul.' + code + '_date').show().siblings('ul').hide();
				$('.mod_address_slide').find('ul.' + code + '_time').show().siblings('ul').hide();
				$('.mod_address_slide').addClass('show');
			});
			//关闭送达时间选择框
			$('.mod_address_slide_head .icon-close').off('click').on('click', function () {
				$('.mod_address_slide').removeClass('show');
				firstResultAry = [];

				$('.confirm-payment').val(js_lang.confirm_payment);
				$('.confirm-payment').attr("disabled", false);
				$('.confirm-payment').removeClass("payment-bottom");
			});

			//点击日期
			$('.mod_address_slide_tabs li').off('click').on('click', function () {
				var $this = $(this),
					date = $this.attr('data-date');
				$this.addClass('active').siblings('li').removeClass('active');

				$('.mod_address_slide_list li').each(function () {
					if ($(this).attr('data-date') == date) {
						$(this).removeClass('hide');
					} else {
						$(this).addClass('hide');
					}
				});
			});

			//点击时间
			$('.mod_address_slide_list li').off('click').on('click', function () {
				var $this = $(this);
				parent = $this.parent('.mod_address_slide_tabs'),
					date = $this.attr('data-date'),
					time = $this.attr('data-time');
				$('.mod_address_slide_list').find('li').removeClass('active');
				$this.addClass('active');

				$('input[name="shipping_date"]').val(date);
				$('input[name="shipping_time"]').val(time);

				$('input[name="pickup_date"]').val(date);
				$('input[name="pickup_time"]').val(time);

				$('.shipping-time').html(date + ' ' + time);

				$('.mod_address_slide').removeClass('show');
			});

		},

		pay_order: function () {
			$("body").greenCheck();
			$('.confirm-payment').off('click').on('click', function (e) {
				e.preventDefault();

				var pay_id = $("input[name='pay_id']:checked").val();
				var pay_balance_id = $("input[name='pay_balance_id']").val();
				
				if (!$(this).hasClass('payment-balance')) {
					if (pay_id == null || pay_id == undefined) {
						alert(js_lang.please_select_payment);
						return false;
					}
					if (pay_id == pay_balance_id) {
						ecjia.touch.flow.check_paypass();
						return false;
					}
				} else {
					ecjia.touch.flow.check_paypass();
					return false;
				}

				$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
				var alipay_btn_html = $(this).val();
				$(this).val(js_lang.requesting);
				$(this).attr("disabled", true);
				$(this).addClass("payment-bottom");

				var url = $("form[name='payForm']").attr('action');
				$("form[name='payForm']").ajaxSubmit({
					type: 'post',
					url: url,
					dataType: "json",
					success: function (data) {
						$('.la-ball-atom').remove();
						$('.confirm-payment').removeClass("payment-bottom")
						$('.confirm-payment').removeAttr("disabled");
						$('.confirm-payment').val(alipay_btn_html);
						if (data.state == 'error') {
							ecjia.touch.showmessage(data);
							return false;
						}
						if (data.redirect_url) {
							location.href = data.redirect_url;
						} else if (data.weixin_data) {
							$('.wei-xin-pay').html("");
							$('.wei-xin-pay').html(data.weixin_data);
							callpay();
						}
					}
				});
			});
		},

		check_paypass: function() {
			//支付时输入支付密码
			var has_set_paypass = $('input[name="has_set_paypass"]').val();

			if (has_set_paypass == 1) {
				$(this).val(js_lang.requesting);
				$(this).attr("disabled", true);
				$(this).addClass("payment-bottom");

				$('.mod_address_slide').addClass('show');
				$(".pass_container input").eq(0).focus();
			} else {
				var myApp = new Framework7();
				var url = $('.set_paypass_url').attr('data-url');
				myApp.modal({
					title: '',
					text: js_lang.payment_password,
					buttons: [{
						text: js_lang.cancel,
						onClick: function () {
							$('.modal').remove();
							$('.modal-overlay').remove();
							return false;
						}
					}, {
						text: js_lang.go_set,
						onClick: function () {
							window.location.href = url;
						}
					}, ]
				});
			}
			return false;
		},

		//模拟键盘初始化
		boardInit: function () {
			var firstResultAry = []; //记录输入结果
			var $targetInput = $("#payPassword_container").find("div.input"); //模拟输入的input
			var keyLength = $targetInput.length; //模拟输入的位数
			var $keyboard = $("#keyboard"); //设置密码中的键盘
			var $board = $keyboard.find("li"); //模拟键盘中的按键
			var autoRequest = 0;

			$board.on("touchend", function (e) {
				e.preventDefault();
				var keyType = $(this).attr("data-key");

				if (keyType == "del") {
					firstResultAry.pop();
				} else if (keyType && firstResultAry.length < keyLength) {
					firstResultAry.push(keyType);
				}
				$targetInput.html("");
				for (var i = 0; i < firstResultAry.length; i++) {
					$targetInput.eq(i).html('<div class="point"></div>')
				}

				if (autoRequest == 1) {
					return false;
				}

				if (firstResultAry.length == keyLength) {
					autoRequest = 1;
					var order_id = $('input[name="order_id"]').val();
					var pay_id = $('input[name="pay_balance_id"]').val();
					var url = $('input[name="url"]').val();
                    var extension_code = $('input[name="extension_code"]').val();
					var value = '';
					$.each(firstResultAry, function (i, v) {
						value += v;
					})

					var info = {
						'order_id': order_id,
						'pay_id': pay_id,
						'value': value,
						'type': 'check_paypassword',
						'extension_code': extension_code

					}
					$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
					$.post(url, info, function (data) {
						autoRequest = 0;
						$('.la-ball-atom').remove();
						$('.confirm-payment').removeClass("payment-bottom")
						$('.confirm-payment').removeAttr("disabled");
						$('.confirm-payment').val(js_lang.confirm_payment);
						if (data.state == 'error') {
							// $('.mod_address_slide').removeClass('show');
							$("#payPassword_container").find(".point").remove();
							firstResultAry = [];
							ecjia.touch.showmessage(data);
							return false;
						}
						if (data.redirect_url) {
							location.href = data.redirect_url;
						} else if (data.weixin_data) {
							$('.wei-xin-pay').html("");
							$('.wei-xin-pay').html(data.weixin_data);
							callpay();
						}
					})
					return false;
				}
			})
		},
	};

})(ecjia, jQuery);

//end