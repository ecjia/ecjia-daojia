/**
 * 后台综合js文件
 */
;(function(ecjia, $) {
	ecjia.touch.user_account = {
		init : function(){
			ecjia.touch.user_account.wxpay_user_account();
		},
		wxpay_user_account: function () {
            $('.wxpay-btn').on('click', function (e) {
            	e.preventDefault();
				var url = $("form[name='useraccountForm']").attr('action');
            	$("form[name='useraccountForm']").ajaxSubmit({
            		type: 'post',
            		url: url,
	 				dataType:"json",
	 				success:function(data) {
	 					if (data.weixin_data) {
	 						$('.wei-xin-pay').html("");
	 						$('.wei-xin-pay').html(data.weixin_data);
	 						callpay();
	 					}
	 				}
	 			});
            });
        }
	};    
})(ecjia, jQuery);

//end