/**
 * 后台综合js文件
 */
;
(function(ecjia, $) {
	ecjia.touch.user_account = {
		init: function() {
			 ecjia.touch.user_account.wxpay_user_account();
			 ecjia.touch.user_account.btnflash();
			 ecjia.touch.user_account.btnpay();
		},

		wxpay_user_account: function() {
			$('.wxpay-btn').off('click').on('click', function(e) {
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
					success: function(data) {
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
						} else if(data.weixin_data) {
							$('.wei-xin-pay').html("");
							$('.wei-xin-pay').html(data.weixin_data);
							callpay();
						}
					}
				});
			});
		},
		
		btnflash : function() {
			$('.alipay-btn').off('click').on('click', function(e) {
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
					success: function(data) {
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
		btnpay : function() {
			$('.pay-btn').off('click').on('click', function(e) {
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
					success: function(data) {
						$('.pay-btn').removeClass("payment-bottom")
						$('.pay-btn').removeAttr("disabled"); 
						$('.pay-btn').val(alipay_btn_html);
						if (data.state == 'error') {
							ecjia.touch.showmessage(data);
							return false;
						}
						if (data.redirect_url) {
							location.href = data.redirect_url;
						} else if(data.weixin_data) {
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