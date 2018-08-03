/**
 * 后台综合js文件
 */
;
(function (ecjia, $) {
	ecjia.touch.quickpay = {
		init: function () {
			$("body").greenCheck();
			ecjia.touch.quickpay.checkbtn();
			ecjia.touch.quickpay.order_money();
			ecjia.touch.quickpay.drop_out_money();
			ecjia.touch.quickpay.close_pay_content();
			ecjia.touch.quickpay.change_activity();
			ecjia.touch.quickpay.show_exclude_amount();
			ecjia.touch.quickpay.quickpay_done();
			ecjia.touch.quickpay.quickpay_order_handle();
			ecjia.touch.quickpay.confirm_pay();
			ecjia.touch.quickpay.quick_pay();
		},

		checkbtn: function () {
			var order_money = $("input[name='order_money']").val();
			if (order_money == '' || order_money == undefined) {
				$('.check_quickpay_btn').prop('disabled', true);
			}
		},

		order_money: function () {
			$('input[name="order_money"]').koala({
				delay: 500,
				keyup: function (event) {
					ecjia.touch.quickpay.checkout('change_amount');
				}
			});
		},

		drop_out_money: function () {
			$('input[name="drop_out_money"]').koala({
				delay: 500,
				keyup: function (event) {
					console.log(22);
					ecjia.touch.quickpay.checkout('change_amount');
				}
			});
		},

		close_pay_content: function () {
			//关闭确认付款框
			$('.ecjia-pay-content .pay-content-close').off('click').on('click', function () {
				$('.ecjia-pay-content').removeClass('show');
			});
		},

		change_activity: function () {
			$('input[name="activity_id"]').off('click').on('click', function () {
				var order_money = $("input[name='order_money']").val();
				if (order_money == '' || order_money == undefined) {
					alert('请输入消费金额');
					return false;
				}
				ecjia.touch.quickpay.checkout('change_amount', 'change_activity');
			});
		},

		show_exclude_amount: function () {
			$('input[name="show_exclude_amount"]').off('change').on('change', function () {
				var val = $('input[name="show_exclude_amount"]:checked').val();
				if (val == 1) {
					$('.amount_li.li').show();
					$(this).parent('label').addClass('ecjia-checkbox-checked');
				} else {
					$('.amount_li.li').hide();
					$(this).parent('label').removeClass('ecjia-checkbox-checked');
				}
				var drop_out_money = $("input[name='drop_out_money']").val();
				if (drop_out_money != '' && drop_out_money != 0) {
					ecjia.touch.quickpay.checkout('change_amount');
				}
			});
		},

		quickpay_done: function () {
			$('.quickpay_done').off('click').on('click', function (e) {
				e.preventDefault();
				var $this = $(this);
				if ($this.hasClass('disabled')) {
					return false;
				}
				$this.addClass('disabled');
				var order_id = $("input[name='order_id']").val();
				var show_exclude_amount = $("input[name='show_exclude_amount']:checked").val();
				var direct_pay = $("input[name='direct_pay']").val();

				if (order_id == undefined) {
					var order_money = $("input[name='order_money']").val();
					if (order_money == '' || order_money == undefined) {
						$this.removeClass('disabled');
						alert('消费金额不能为空');
						return false;
					}
					if (order_money == 0) {
						$this.removeClass('disabled');
						alert('消费金额不能为0');
						return false;
					}
					var drop_out_money = $("input[name='drop_out_money']").val();
					if (show_exclude_amount == 1 && drop_out_money > order_money) {
						$this.removeClass('disabled');
						alert('不参与优惠金额不能大于消费总金额');
						return false;
					}
				}
				$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
				var url = $("form[name='quickpayForm']").attr('action');

				$("form[name='quickpayForm']").ajaxSubmit({
					type: 'post',
					url: url,
					dataType: "json",
					success: function (data) {
						$this.removeClass('disabled');
						$('.la-ball-atom').remove();
						var myApp = new Framework7();
						if (data.referer_url || data.message == 'Invalid session') {
							myApp.modal({
								title: '温馨提示',
								text: '您还没有登录',
								buttons: [{
									text: '取消',
								}, {
									text: '去登录',
									onClick: function () {
										location.href = data.referer_url;
										return false;
									}
								}, ]
							});
							return false;
						}
						if (data.status == 'error') {
							alert(data.message);
							return false;
						}
						if (direct_pay == 1) {
							$('.ecjia-pay-content').find('.goods-amount').html(data.content.format_goods_amount);
							$('.ecjia-pay-content').find('.discount').html('-' + data.content.format_discount);
							$('.ecjia-pay-content').find('.total-fee').html(data.content.format_total_fee);
							$('.confirm-pay-btn').attr('data-money', data.content.goods_amount);
							$('.confirm-pay-btn').attr('data-activity', data.activity_id);
							$('.ecjia-pay-content').addClass('show');
							$('.ecjia-pay-content-lay').show();
							return false;
						}
						if (data.redirect_url) {
							location.href = data.redirect_url;
						}
					}
				});
			});
		},

		quickpay_order_handle: function () {
			$('.quickpay_order_handle').off('click').on('click', function (e) {
				e.preventDefault();
				var myApp = new Framework7();
				var url = $(this).attr('href');
				var message = $(this).attr('data-message');
				myApp.modal({
					title: message,
					buttons: [{
						text: '取消',
					}, {
						text: '确定',
						onClick: function () {
							$.post(url, function (data) {
								ecjia.touch.showmessage(data);
							});
						},
					}]
				});
			});
		},

		confirm_pay: function () {
			$('.confirm-pay-btn').off('click').on('click', function (e) {
				e.preventDefault();
				var $this = $(this),
					order_money = $this.attr('data-money'),
					store_id = $("input[name='store_id']").val(),
					activity_id = $this.attr('data-activity'),
					pay_code = $this.attr('data-paycode'),
					pay_url = $("input[name='pay_url']").val();
				var info = {
					'store_id': store_id,
					'order_money': order_money,
					'activity_id': activity_id,
				};
				var url = $('input[name="quickpay_done_url"]').val();

				$this.addClass('disabled').html('请求中...');
				$.post(url, info, function (data) {
					if (data.status == 'error') {
						alert(data.message);
						$this.removeClass('disabled').html('确认买单');
						return false;
					}
					var order_id = data.order_id;
					$.post(pay_url, {
						order_id: order_id,
						pay_code: pay_code
					}, function (data) {
						$this.removeClass('disabled').html('确认买单');
						if (data.state == 'error') {
							alert(data.message);
							return false;
						}
						if (data.redirect_url) {
							location.href = data.redirect_url;
						} else if (data.weixin_data) {
							$('.wei-xin-pay').html("");
							$('.wei-xin-pay').html(data.weixin_data);
							callpay();
						}
					});
				});
			});
		},

		checkout: function (c, a) {
			var change_amount = 0;
			var order_money = $("input[name='order_money']").val();
			var drop_out_money = $("input[name='drop_out_money']").val();
			var store_id = $("input[name='store_id']").val();
			var show_exclude_amount = $("input[name='show_exclude_amount']:checked").val();
			if (order_money == '' || order_money == undefined) {
				$('.check_quickpay_btn').prop('disabled', true);
				return false;
			}
			$('.check_quickpay_btn').prop('disabled', false);

			var direct_pay = $("input[name='direct_pay']").val();
			if (direct_pay == 1) {
				return false;
			}

			var url = $('form[name="quickpayForm"]').attr('data-url');
			var activity_id = $("input[name='activity_id']:checked").val();
			if (c == 'change_amount') {
				change_amount = 1;
			}
			var change_activity = 0;
			if (a != 'change_activity') {
				activity_id = 0;
			} else {
				change_activity = 1;
			}
			var info = {
				'store_id': store_id,
				'order_money': order_money,
				'drop_out_money': drop_out_money,
				'activity_id': activity_id,
				'show_exclude_amount': show_exclude_amount,
				'change_amount': change_amount,
				'change_activity': change_activity
			}
			$.post(url, info, function (data) {
				$('.auto_activity_id').val(data.activity_id);
				$('.quickpay_done').removeAttr('disabled');
				$('.quickpay-content').html(data.list);
				ecjia.touch.quickpay.init();
			});
		},

		quick_pay: function () {
			$('.quick_pay_btn').on('click', function (e) {
				var $this = $(this);
				e.preventDefault();
				$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
				var bool = $this.hasClass('external');
				if (bool) {
					$this.val("请求中");
				} else {
					$this.val("支付请求中，请稍后");
				}

				$this.attr("disabled", true);
				$this.addClass("payment-bottom");

				var url = $("form[name='quickpay_form']").attr('action');
				$("form[name='quickpay_form']").ajaxSubmit({
					type: 'post',
					url: url,
					dataType: "json",
					success: function (data) {
						$('.quick_pay_btn').removeClass("payment-bottom")
						$('.la-ball-atom').remove();
						$('.quick_pay_btn').removeAttr("disabled");
						if (bool) {
							$this.val("去支付");
						} else {
							$('.quick_pay_btn').val("确认支付");
						}

						if (data.state == 'error') {
							$this.val("去支付");
							alert(data.message);
							return false;
						}
						if (data.redirect_url) {
							location.href = data.redirect_url;
						} else if (data.weixin_data) {
							$this.val("去支付");
							$('.wei-xin-pay').html("");
							$('.wei-xin-pay').html(data.weixin_data);
							callpay();
						}
					}
				});
			});
		},

	};
})(ecjia, jQuery);

//end