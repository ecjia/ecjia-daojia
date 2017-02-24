// JavaScript Document
;(function(admin, $) {
	admin.admin_shop_config = {
		init : function() {			
			$("input[type=radio]").bind('click', function(event){
				if (event.target.id == 'value_enable_gzip_1') {
					//event.preventDefault();  //关键是这句
					ecjia.ui.confirm(shop_config_lang.enable_gzip_confirm, function(e) {
						if (!e) {
							$('#uniform-value_enable_gzip_0 span').addClass("uni-checked");
							$('#uniform-value_enable_gzip_1 span').removeClass("uni-checked");
							$('#value_enable_gzip_0').prop("checked", true);
						}
					});
				}
				else if (event.target.id == 'value_retain_original_img_1') {
					ecjia.ui.confirm(shop_config_lang.retain_original_img_confirm, function(e) {
						if (!e) {
							$('#uniform-value_retain_original_img_0 span').addClass("uni-checked");
							$('#uniform-value_retain_original_img_1 span').removeClass("uni-checked");
							$('#value_retain_original_img_0').prop("checked", true);
						}
					});
				}
				else if (event.target.id == 'value_smtp_ssl_1') {
					ecjia.ui.confirm(shop_config_lang.smtp_ssl_confirm, function(e) {
						if (!e) {
							$('#uniform-value_smtp_ssl_0 span').addClass("uni-checked");
							$('#uniform-value_smtp_ssl_1 span').removeClass("uni-checked");
							$('#value_smtp_ssl_0').prop("checked", true);
						}
					});
				}
				else if (event.target.id == 'value_rewrite_0' || event.target.id == 'value_rewrite_1' || event.target.id == 'value_rewrite_2') {
					admin.admin_shop_config.rewriterConfirm(event.target);
				}
			});

			admin.admin_shop_config.set_conf();
			admin.admin_shop_config.set_goarea();
			admin.admin_shop_config.goarea();
		},
		
		rewriterConfirm : function(sender) {
			if (sender == ReWriteSelected) {
				console.log(ReWriteSelected);
				return true;
			}
			
			if (sender != ReWriteRadiobox[0]) {
				ecjia.ui.confirm(shop_config_lang.rewrite_confirm, function(e) {
					if (e == false) {
						ReWriteSelected.checked = true;
						
						$('#'+ReWriteSelected.id).parent().addClass("uni-checked");
						$('#'+sender.id).parent().removeClass("uni-checked");
					} else {
						ReWriteSelected = sender;
					}
				});
			} else {
				ReWriteSelected = sender;
			}
		},
		
		
		setmail : function(){
			$('.warning-toggle-button').toggleButtons({style: {disabled: "danger"}});

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

			admin.admin_shop_config.send_mail();
			admin.admin_shop_config.set_mail_conf();
		},

		/* shop_config init START */
		set_conf : function() {
			var $this = $("form[name='theForm']");
			var option = {
				submitHandler:function(){
					$this.ajaxSubmit({
						dataType:"json",
						success:function(data){
							$('fieldset .fileupload').each(function(i){
								if($(this).find("img").attr("src") || $(this).children().find("a").attr("href")){
									$(this).children("a:last-child").attr("data-removefile","true");
								} 
							});
							ecjia.admin.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
		},
		set_goarea : function(){
			$('.float_block').css({top : 116, position : 'fixed'});
			var setright = function(){
				var rightnum = $(document).width() - 1680;
				// console.log(rightnum);
				if(rightnum > 0) {
					rightnum = rightnum / 2 + 30;
					$('.float_block').css({right : rightnum});
				} else {
					$('.float_block').css({right : 30});
				}
			}
			setright();
			$(window).resize(setright);
		},
		goarea : function() {
			var tmp = 0;
			$('li[data-toggle="goarea"]').on('click', function(){
				var $this = $(this);
				var area = $this.attr('data-area') || '#top';
				tmp = $(area).offset().top-60>=0?$(area).offset().top-60:0;
				$("html,body").animate({ scrollTop:tmp}, 300);
			});

			var areastr = '', areas = [],
				$goarea = $('li[data-toggle="goarea"]');
			if ($goarea.length) {
				$(document).scroll(function(){
					tmp = $goarea.offset().top-60;
					/* 如果区域组还不存在，则获取区域组 */
					if(areastr == ''){
						$('li[data-toggle="goarea"]').each(function(i){
							areastr += ',' + $goarea.eq(i).attr('data-area');
						});
						areas = areastr.split(",");
					}
					/* 循环区域组，查看当前所属组。找到则跳出循环 */
					for (var i = areas.length - 1; i >= 1; i--) {
						$(document).scrollTop() < 56 && $('li[data-toggle="goarea"]').removeClass('active');
						if($(document).scrollTop()+61 >= $(areas[i]).offset().top){
							$('li[data-toggle="goarea"]').removeClass('active');
							if (tmp<9750) {
								$('li[data-area="' + areas[i] + '"]').addClass('active');
							}
							break;
						}
					};
					if (tmp>9750) {
						$('li[data-area="#wap"]').addClass('active');
					}
				})
			}
		},
		/* shop_config init END */

		/* mail_config init START */
		send_mail : function() {
			$('.test_mail').on('click', function(e){
				var option = {};
				var options = $.extend(ecjia.admin.defaultOptions.validate, option);
				$("form[name='theForm']").validate(options);
				$("input[name='value[501]']").rules('add', {
					required: true,
					messages:{
						required : admin_shop_config.pls_select_smtp 
					},
				});
				$("input[name='value[502]']").rules('add', {
					required: true,
					messages:{
						required : admin_shop_config.required_port 
					},
				});
				$("input[name='value[503]']").rules('add', {
					required: true,
					email :  true,
					messages: {
						required: admin_shop_config.required_account,
						email: admin_shop_config.check_account
					},
				});
				$("input[name='value[504]']").rules('add', {
					required: true,
					messages:{
						required: admin_shop_config.required_password
					},
				});
				$("input[name='value[505]']").rules('add', {
					required: true,
					email :  true,
					messages:{
						required: admin_shop_config.required_reply_account,
						email: admin_shop_config.check_reply_account,
					},
				}); 
				$("input[name='test_mail_address']").rules('add', {
					required: true,
					email :  true,
					messages:{
						required: admin_shop_config.required_send_account,
						email: admin_shop_config.check_send_account,
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

			});
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
			};
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
		}
		/* mail_config init END */
	};

})(ecjia.admin, jQuery);

var ReWriteSelected = null;
var ReWriteRadiobox = $("input[name='value[209]']");

for (var i=0; i< ReWriteRadiobox.length; i++) {
	if (ReWriteRadiobox[i].checked) {
		ReWriteSelected = ReWriteRadiobox[i];
	}
}

//end