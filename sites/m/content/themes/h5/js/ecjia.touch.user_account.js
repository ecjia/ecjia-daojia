/**
 * 后台综合js文件
 */
;
(function (ecjia, $) {
	ecjia.touch.user_account = {
		init: function () {
			ecjia.touch.user_account.wxpay_user_account();
			ecjia.touch.user_account.btnflash();
			ecjia.touch.user_account.btnpay();
			ecjia.touch.user_account.add_bonus();
			ecjia.touch.user_account.withdraw_all();
			ecjia.touch.user_account.widthDrawFormSubmit();
		},

		wxpay_user_account: function () {
			$('.wxpay-btn').off('click').on('click', function (e) {
				e.preventDefault();
				$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');

				var record = $('input[name="record"]').val();
				var amount = $('input[name="amount"]').val();

				if (amount == '') {
					$('.la-ball-atom').remove();
					alert("金额不能为空");
					return false;
				}
				var alipay_btn_html = $(this).val();
				if (record != 1) {
					$(this).val("请求中...");
				}
				$(this).attr("disabled", true);
				$(this).addClass("payment-bottom");

				var url = $("form[name='useraccountForm']").attr('action');
				$("form[name='useraccountForm']").ajaxSubmit({
					type: 'post',
					url: url,
					dataType: "json",
					success: function (data) {
						$('.wxpay-btn').removeClass("payment-bottom")
						$('.la-ball-atom').remove();
						$('.wxpay-btn').removeAttr("disabled");
						if (record != 1) {
							$('.wxpay-btn').val(alipay_btn_html);
						}
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

		btnflash: function () {
			$('.alipay-btn').off('click').on('click', function (e) {
				e.preventDefault();
				$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');

				var record = $('input[name="record"]').val();
				var amount = $('input[name="amount"]').val();
				if (amount == '') {
					$('.la-ball-atom').remove();
					alert("金额不能为空");
					return false;
				}
				var alipay_btn_html = $(this).val();

				$(this).val("请求中...");
				$(this).attr("disabled", true);
				$(this).addClass("payment-bottom");

				var url = $("form[name='useraccountForm']").attr('action');
				$("form[name='useraccountForm']").ajaxSubmit({
					type: 'post',
					url: url,
					dataType: "json",
					success: function (data) {
						$('.alipay-btn').removeClass("payment-bottom")
						$('.la-ball-atom').remove();
						$('.alipay-btn').removeAttr("disabled");
						$('.alipay-btn').val(alipay_btn_html);

						if (data.state == 'error') {
							ecjia.touch.showmessage(data);
							return false;
						}
						location.href = data.redirect_url;
					}
				});
			});
		},

		//继续充值
		btnpay: function () {
			$('.pay-btn').off('click').on('click', function (e) {
				e.preventDefault();

				if ($("input[name='pay_id']:checked").val() == null) {
					alert("请选择支付方式");
					return false;
				}

				$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
				var alipay_btn_html = $(this).val();
				$(this).val("请求中...");
				$(this).attr("disabled", true);
				$(this).addClass("payment-bottom");

				var url = $("form[name='useraccountForm']").attr('action');
				$("form[name='useraccountForm']").ajaxSubmit({
					type: 'post',
					url: url,
					dataType: "json",
					success: function (data) {
						$('.pay-btn').removeClass("payment-bottom")
						$('.pay-btn').removeAttr("disabled");
						$('.pay-btn').val(alipay_btn_html);
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

		//添加红包
		add_bonus: function () {
			$('input[name="add_bonus"]').off('click').on('click', function (e) {
				e.preventDefault();
				var $this = $(this);
				var bonus_number = $(".bonus_number_input").val();

				if (bonus_number == '' || bonus_number == undefined || bonus_number == null) {
					alert("请输入号码");
					return false;
				}
				$('.bonus_number_input').blur();
				$("input[name='bonus_number']").val(bonus_number);

				$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
				var html = $this.val();
				$this.val("请求中...");
				$this.attr("disabled", true);

				var url = $("form[name='addBonusForm']").attr('action');
				$("form[name='addBonusForm']").ajaxSubmit({
					type: 'post',
					url: url,
					dataType: "json",
					success: function (data) {
						$this.removeAttr("disabled");
						$this.val(html);
						$('body').find('.la-ball-atom').remove();
						$('.ecjia-add-bonus').append(data.data);
						$('.ecjia-normal-modal').show();
						$('.ecjia-normal-modal-overlay').show();
						ecjia.touch.user_account.close_nomal_modal();
						ecjia.touch.user_account.confirm_add_bonus();
					}
				});
			});

			$(document).keydown(function (event) {
				if (event.keyCode == 13) {
					$('input[name="add_bonus"]').trigger('click');
				}
			});
		},

		close_nomal_modal: function () {
			$('.close-normal-btn').off('click').on('click', function (e) {
				if ($(this).hasClass('success')) {
					window.location.reload();
					return false;
				}
				$('.ecjia-normal-modal').remove();
				$('.ecjia-normal-modal-overlay').remove();
			});
		},

		confirm_add_bonus: function () {
			$('.confirm-add-btn').off('click').on('click', function (e) {
				var $this = $(this),
					url = $this.attr('data-href');
				var bonus_number = $('input[name="bonus_number"]').val();
				if (bonus_number == '' || bonus_number == undefined) {
					alert('该红包不存在');
					return false;
				}
				$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
				var html = $this.html();
				$this.val("请求中...");
				$this.attr("disabled", true);

				$.post(url, {
					bonus_number: bonus_number,
					action: 'bind'
				}, function (data) {
					$this.removeAttr("disabled");
					$this.html(html);
					$('body').find('.la-ball-atom').remove();
					$('.ecjia-normal-modal').remove();
					$('.ecjia-normal-modal-overlay').remove();
					$('.ecjia-add-bonus').append(data.data);
					$('.ecjia-normal-modal').show();
					$('.ecjia-normal-modal-overlay').show();
					ecjia.touch.user_account.close_nomal_modal();
				});
			});
		},

		withdraw_all: function () {
			$('.widhdraw_all_span').off('click').on('click', function () {
				$('input[name="amount"]').val($(this).attr('data-price'));
			});

			$('.ecjia-withdraw-notice-btn').off('click').on('click', function () {
				var url = $(this).attr('data-url');
				ecjia.pjax(url, function () {}, {
					replace: true
				});
			});
		},

		widthDrawFormSubmit: function () {
			$("form[name='widthDrawForm']").on('submit', function (e) {
				$('input[name="submit"]').val('请求中...').prop('disabled', true);
				e.preventDefault();
				return false;
			}).Validform({
				tiptype: function (msg, o, cssctl) {},
				ajaxPost: true,
				callback: function (data) {
					if (data.state == 'error') {
						$('input[name="submit"]').val('立即提现').prop('disabled', false);
						alert(data.message);
						return false;
					}
					var url = data.url;
					ecjia.pjax(url, function () {}, {
						replace: true
					});
				}
			});
		},
	};
})(ecjia, jQuery);

//end