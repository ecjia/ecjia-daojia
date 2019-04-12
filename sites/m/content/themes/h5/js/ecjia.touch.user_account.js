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
			ecjia.touch.user_account.widthBtn();
            ecjia.touch.user_account.choose_bank();
		},

		wxpay_user_account: function () {
			$('.wxpay-btn').off('click').on('click', function (e) {
				e.preventDefault();
				$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');

				var record = $('input[name="record"]').val();
				var amount = $('input[name="amount"]').val();

				if (amount == '') {
					$('.la-ball-atom').remove();
					alert(js_lang.money_not_empty);
					return false;
				}
				var alipay_btn_html = $(this).val();
				if (record != 1) {
					$(this).val(js_lang.requesting);
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
					alert(js_lang.money_not_empty);
					return false;
				}
				var alipay_btn_html = $(this).val();

				$(this).val(js_lang.requesting);
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
					alert(js_lang.please_select_payment);
					return false;
				}

				$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
				var alipay_btn_html = $(this).val();
				$(this).val(js_lang.requesting);
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
					alert(js_lang.please_enter_number);
					return false;
				}
				$('.bonus_number_input').blur();
				$("input[name='bonus_number']").val(bonus_number);

				$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
				var html = $this.val();
				$this.val(js_lang.requesting);
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
					alert(js_lang.bonus_not_exist);
					return false;
				}
				$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
				var html = $this.html();
				$this.val(js_lang.requesting);
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
			$('input[name="amount"]').koala({
				delay: 500,
				keyup: function () {
					var $this = $(this),
						amount = $this.val(),
						withdraw_fee_percent = $('input[name="withdraw_fee_percent"]').val();
					if (amount != 0 && amount > 0) {
						var withdraw_fee = amount * (withdraw_fee_percent / 100);
						withdraw_fee = withdraw_fee.toFixed(2);
						$('.withdraw_fee_money').html(withdraw_fee);
					}
				}
			});

			$('.withdraw_all_span').off('click').on('click', function () {
				$('input[name="amount"]').val($(this).attr('data-price'));
				var amount = $(this).attr('data-price'),
					withdraw_fee_percent = $('input[name="withdraw_fee_percent"]').val();
				var withdraw_fee = amount * (withdraw_fee_percent / 100);
				withdraw_fee = withdraw_fee.toFixed(2);
				$('.withdraw_fee_money').html(withdraw_fee);
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
				$('input[name="submit"]').val(js_lang.requesting).prop('disabled', true);
				e.preventDefault();
				return false;
			}).Validform({
				tiptype: function (msg, o, cssctl) {},
				ajaxPost: true,
				callback: function (data) {
					if (data.state == 'error') {
						$('input[name="submit"]').val(js_lang.withdraw_immediately).prop('disabled', false);

						if (data.url) {
                            var myApp = new Framework7();
                            myApp.modal({
                                title: '',
                                text: data.message,
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
                                        window.location.href = data.url;
                                    }
                                }, ]
                            });
                            return false;
						}

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

		widthBtn: function () {
			$('.withdraw-btn').off('click').on('click', function (e) {
				var myApp = new Framework7();

				var $this = $(this),
					url = $this.attr('data-url'),
                	redirect_url = url != '' ? url : '',
					message = redirect_url == '' ? js_lang.no_supportable_withdrawal_method : js_lang.please_set_withdraw,
					ok_btn_text = redirect_url == '' ? js_lang.ok : js_lang.go_set;
				myApp.modal({
					title: '',
					text: message,
					buttons: [{
						text: js_lang.cancel,
						onClick: function () {
							$('.modal').remove();
							$('.modal-overlay').remove();
							return false;
						}
					}, {
						text: ok_btn_text,
						onClick: function () {
							if (redirect_url != '') {
                                window.location.href = redirect_url;
							}
							return false;
						}
					}, ]
				});
				return false;
			});
		},

        //选择银行
        choose_bank: function () {
            var App = new Framework7();
            var list = eval($('input[name="bank_list"]').val());
            var id_list = [];
            var value_list = [];
            if (list == undefined) {
                return false;
            }

            for (i = 0; i < list.length; i++) {
                var id = list[i]['bank_type'];
                var value = "<img style='margin-right:5px;' src="+ list[i]['bank_icon'] +" width='25' height='25' >" + list[i]['bank_name'];
                id_list.push(id);
                value_list.push(value);
            };
            var pickerStreetToolbar = App.picker({
                input: '.choose_bank',
                cssClass: 'choose_bank_modal',
                toolbarTemplate: '<div class="toolbar">' +
                    '<div class="toolbar-inner">' +
                    '<div class="left">' +
                    '<a href="javascript:;" class="link close-picker external">'+ js_lang.cancel +'</a>' +
                    '</div>' +
                    '<div class="right">' +
                    '<a href="javascript:;" class="link save-picker external">'+ js_lang.ok +'</a>' +
                    '</div>' +
                    '</div>' +
                    '</div>',
                cols: [{
                    values: id_list,
                    displayValues: value_list
                }, ],
                onOpen: function (picker) {
                    var $pick_overlay = '<div class="picker-modal-overlay"></div>';
                    if ($('.picker-modal').hasClass('modal-in')) {
                        $('.picker-modal').after($pick_overlay);
                    }
                    var current_id = $('input[name="bank_type"]').val();
                    if (current_id != undefined && current_id != '') {
                        picker.setValue([current_id]); //设置选中值
                    }

                    picker.container.find('.save-picker').on('click', function () {
                        var value = picker.cols[0].container.find('.picker-selected').html();
                        var id = picker.cols[0].container.find('.picker-selected').attr('data-picker-value');
                        $('.choose_bank').html(value);
                        $('input[name="bank_type"]').val(id);
                        picker.close();
                        remove_overlay();
                    });
                    picker.container.find('.close-picker').on('click', function () {
                        picker.close();
                        remove_overlay();
                    });
                },
                onClose: function (picker) {
                    picker.close();
                    remove_overlay();
                }
            });
        },

	};

    function remove_overlay() {
        $('.modal-overlay').remove();
        $('.picker-modal-overlay').remove();
    }
})(ecjia, jQuery);

//end