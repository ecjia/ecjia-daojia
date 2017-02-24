// JavaScript Document
;(function (app, $) {
    app.mail_settings = {
    	setmail : function(){
			$('input[type="submit"]').on('click', function(e){
				$(".control-group").removeClass("error f_error");
			});

			$('.formSep:first-child :radio:checked').each(function(i){
				if(this.value === "0"){
					var count = $('.formSep:not(:first-child)').not(':last-child').length;
					$('.formSep:not(:first-child)').not(':last-child').each(function(index){
						if(index < count-2 )
						$('.formSep:not(:first-child)').eq(index).hide();
					});
				}
			});
			$('.formSep:first-child :radio').click(function(){
				var count = $('.formSep:not(:first-child)').not(':last-child').length;
				if(this.value === "0") {
					$('.formSep:not(:first-child)').not(':last-child').each(function(index){
						if(index < count-2 )
						$('.formSep:not(:first-child)').eq(index).hide();
					});
				}else {
					$('.formSep:not(:first-child)').not(':last-child').each(function(index){
						if(index < count-2 )
						$('.formSep:not(:first-child)').eq(index).show();
					});
				}
			});

			app.mail_settings.send_mail();
			app.mail_settings.set_mail_conf();
		},
		send_mail : function() {
			$('.test_mail').on('click', function(e){
				var option = {};
				var options = $.extend(ecjia.admin.defaultOptions.validate, option);
				$("form[name='theForm']").validate(options);
				$("input[name='value[501]']").rules('add', {
					required: true,
					messages:{
						required : mail_settings.pls_select_smtp 
					},
				});
				$("input[name='value[502]']").rules('add', {
					required: true,
					messages:{
						required : mail_settings.required_port 
					},
				});
				$("input[name='value[503]']").rules('add', {
					required: true,
					email :  true,
					messages: {
						required: mail_settings.required_account,
						email: mail_settings.check_account
					},
				});
				$("input[name='value[504]']").rules('add', {
					required: true,
					messages:{
						required: mail_settings.required_password
					},
				});
				$("input[name='value[505]']").rules('add', {
					required: true,
					email :  true,
					messages:{
						required: mail_settings.required_reply_account,
						email: mail_settings.check_reply_account,
					},
				}); 
				$("input[name='test_mail_address']").rules('add', {
					required: true,
					email :  true,
					messages:{
						required: mail_settings.required_send_account,
						email: mail_settings.check_send_account,
					},
				}); 
				if($("form[name='theForm']").validate(options).form()){
					var smtp_host         = $("input[name='value[501]']").val();
					var smtp_port         = $("input[name='value[502]']").val();
					var smtp_user         = $("input[name='value[503]']").val();
					var smtp_pass         = $("input[name='value[504]']").val();
					var reply_email       = $("input[name='value[505]']").val();
					var test_mail_address = $("input[name='test_mail_address']").val();
					var mail_charset      = $("input[name='value[506]']:checked").val();
					var mail_service      = $("input[name='value[507]']:checked").val();
					var smtp_ssl          = $("input[name='value[508]']:checked").val();
					var datahref 		  = $(".test_mail").attr("data-href");
					$("form[name='theForm']").ajaxSubmit({
						dataType:"json",
						data : {
							'email' : test_mail_address,
							'mail_service' : mail_service,
							'smtp_ssl' : smtp_ssl,
							'smtp_host' : smtp_host,
							'smtp_port' : smtp_port,
							'smtp_user' : smtp_user,
							'smtp_pass' : encodeURIComponent(smtp_pass),
							'reply_email' :reply_email,
							'mail_charset' : mail_charset,
						},
						url: datahref,
						success:function(data){
							ecjia.admin.showmessage(data);
						}
					});
				}

				$("input[name='value[501]']").rules("remove"); 
				$("input[name='value[502]']").rules("remove"); 
				$("input[name='value[503]']").rules("remove"); 
				$("input[name='value[504]']").rules("remove"); 
				$("input[name='value[505]']").rules("remove"); 
				$("input[name='test_mail_address']").rules("remove"); 
				e.preventDefault();

			})
		},
		set_mail_conf : function() {
			var $this = $("form[name='theForm']");
			var option = {
				submitHandler:function(){
					$this.ajaxSubmit({
						dataType:"json",
						success:function(data){
							ecjia.admin.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
		}
    };
    
})(ecjia.admin, jQuery);
 
// end