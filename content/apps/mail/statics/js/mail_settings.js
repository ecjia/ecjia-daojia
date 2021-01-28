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
				$('[data-code="smtp_host"]').rules('add', {
					required: true,
					messages:{
						required : mail_settings.pls_select_smtp 
					},
				});
				$('[data-code="smtp_port"]').rules('add', {
					required: true,
					messages:{
						required : mail_settings.required_port 
					},
				});
				$('[data-code="smtp_user"]').rules('add', {
					required: true,
					email :  true,
					messages: {
						required: mail_settings.required_account,
						email: mail_settings.check_account
					},
				});
				$('[data-code="smtp_pass"]').rules('add', {
					required: true,
					messages:{
						required: mail_settings.required_password
					},
				});
				$('[data-code="smtp_mail"]').rules('add', {
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
					var smtp_host         = $('[data-code="smtp_host"]').val();
					var smtp_port         = $('[data-code="smtp_port"]').val();
					var smtp_user         = $('[data-code="smtp_user"]').val();
					var smtp_pass         = $('[data-code="smtp_pass"]').val();
					var reply_email       = $('[data-code="smtp_mail"]').val();
					var test_mail_address = $("input[name='test_mail_address']").val();
					var mail_charset      = $("input[data-code='mail_charset']:checked").val();
					var mail_service      = $("input[data-code='mail_service']:checked").val();
					var smtp_ssl          = $("input[data-code='smtp_ssl']:checked").val();
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

				$('[data-code="smtp_host"]').rules("remove");
				$('[data-code="smtp_port"]').rules("remove");
				$('[data-code="smtp_user"]').rules("remove");
				$('[data-code="smtp_pass"]').rules("remove");
				$('[data-code="smtp_mail"]').rules("remove");
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