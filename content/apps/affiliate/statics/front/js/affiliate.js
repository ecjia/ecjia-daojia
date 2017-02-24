// JavaScript Document
;(function(app, $) {
	app.affiliate = {
		init : function () {
			$("form[name='invite']").on('submit', function(e) {
        		e.preventDefault();
        		var url = $("form[name='invite']").attr('action');
        		var mobile_phone = $("input[name='mobile_phone']").val();
        		var invite_code	= $("input[name='invite_code']").val();
        		
        		
        		var phoneReg = /^1[34578]\d{9}$/; 
        		if (phoneReg.test(mobile_phone) == false) {
        			alert('填写的手机号码格式不正确');
        			return false;
        		} 
        		
        		$.ajax({
					type: "POST",
					url: url,
					data: {
						mobile_phone : mobile_phone,
						invite_code : invite_code,
					},
					dataType: "json",
					success: function (data) {
						if (data.state == 'error') {
							alert(data.message);
						} else {
							location.href = data.url;
						}
					}
        		});
        	});
		},
	};
})(ecjia.front, jQuery);

//end
