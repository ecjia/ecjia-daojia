;
(function(ecjia, $) {
	ecjia.user_info = {
		init: function() {
			ecjia.user_info.submit();
		},
		
		//提交用户收货信息
		submit:function() {
			$('.submit_user_info').on('click', function(e) {
				e.preventDefault();
				var $this = $(this);
				if ($this.hasClass('disabled')) {
					return false;
				}
				$this.addClass('disabled');
				var url = $(this).attr('href');
				var user_name = $('input[name="user_name"]').val();
				var mobile = $('input[name="mobile"]').val();
				var address = $('input[name="address"]').val();
				var info = {'user_name': user_name,'mobile':mobile,'address':address};
				$.post(url, info, function(data) {
					$this.removeClass('disabled');
					if (data.state == 'error') {
						ecjia.user_info.alert(data.message);
					} else if (data.state == 'success'){
						ecjia.user_info.alert(data.message);
						location.href = data.url;
					}
				});
	
			});
		},
		
		alert: function(text, callback) {
			var app = new Framework7({
                modalButtonOk: "确定",
                modalTitle: ''
            });
            app.alert(text, '', callback);
		}
	};
})(ecjia, jQuery);

//end