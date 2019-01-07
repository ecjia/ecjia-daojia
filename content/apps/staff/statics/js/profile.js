// JavaScript Document
;(function (app, $) {
    app.profile_info = {
        init: function () {
        	$form = $('form[name="profileForm"]');
 			var option = {
	            rules: {
	            	name: "required",
	            },
	            messages: {
	            	name: "请输入用户名称",
	            },
 				submitHandler : function() {
 					$form.ajaxSubmit({
 						dataType : "json",
 						success : function(data) {
 							top.location.reload();
 							ecjia.merchant.showmessage(data);
 						}
 					});
 				}
 			}
 			var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
 			$form.validate(options);
        }
    };
    
    app.profile_setting = {
        init: function () {
        	
	        app.profile_setting.mobileForm(); 
	        app.profile_setting.emailForm(); 
	        app.profile_setting.form_submit(); 
        },
        
        mobileForm : function(){
        	var InterValObj; //timer变量，控制时间
    		var count = 120; //间隔函数，1秒执行
    		var curCount;//当前剩余秒数
    		
            $("#get_mobile_code").on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('data-url')+'&newmobile=' + $("input[name='newmobile']").val();
                $.get(url, function (data) {
                	if (data.state == 'success'){
	        		  　    curCount = count;
	        		     $("#get_mobile_code").attr("disabled", "true");
	        		     $("#get_mobile_code").val("重新发送" + curCount + "(s)");
	        		     InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
	        		     var $info = $('<div class="staticalert alert alert-success ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
						 $info.appendTo('.success-msg').delay(5000).hide(0);
					} else {
						 var $info = $('<div class="staticalert alert alert-danger ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
						 $info.appendTo('.error-msg').delay(5000).hide(0);
					}
                }, 'json');
            });
            
            //timer处理函数
            function SetRemainTime() {
	            if (curCount == 0) {                
	                window.clearInterval(InterValObj);//停止计时器
	                $("#get_code_value").removeAttr("disabled");//启用按钮
	                $("#get_code_value").val("重新发送验证码");
	            }
	            else {
	                curCount--;
	                $("#get_mobile_code").val("重新发送" + curCount + "(s)");
	            }
	        };
        	
            var $form = $("form[name='mobileForm']");
			var option = {
		            rules: {
		            	newmobile: "required",
		            },
		            messages: {
		            	newmobile: "请输入手机账号",
		            },
					submitHandler : function() {
						$form.ajaxSubmit({
							dataType : "json",
							success : function(data) {
								if (data.state == 'success') {
									$('#mobilemodal').modal('hide');
									$(".modal-backdrop").remove();
									ecjia.merchant.showmessage(data);
								} else {
									var $info = $('<div class="staticalert alert alert-danger ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
									$info.appendTo('.error-msg').delay(5000).hide(0);
								}
							}
						});
					}
				}
			 var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
			 $form.validate(options);
        },
        
        emailForm : function(){
           	var InterValObj; //timer变量，控制时间
    		var count = 120; //间隔函数，1秒执行
    		var curCount;//当前剩余秒数
    		
            $("#get_email_code").on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('data-url')+'&newemail=' + $("input[name='newemail']").val();
                $.get(url, function (data) {
                	if (data.state == 'success') {
	        		  　    curCount = count;
	        		     $("#get_email_code").attr("disabled", "true");
	        		     $("#get_email_code").val("重新发送" + curCount + "(s)");
	        		     InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
	        		     var $info = $('<div class="staticalert alert alert-success ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
						 $info.appendTo('.success-msg').delay(5000).hide(0);
					} else {
						var $info = $('<div class="staticalert alert alert-danger ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
						$info.appendTo('.error-msg').delay(5000).hide(0);
					}
                }, 'json');
            });
            
            //timer处理函数
            function SetRemainTime() {
	            if (curCount == 0) {                
	                window.clearInterval(InterValObj);//停止计时器
//	                $("#newemail").removeAttr("disabled");//启用按钮
	                $("#get_email_code").removeAttr("disabled");//启用按钮
	                $("#get_email_code").val("重新发送验证码");
	            }
	            else {
	                curCount--;
	                $("#get_email_code").val("重新发送" + curCount + "(s)");
	            }
	        };

            var $form = $("form[name='emailForm']");
			var option = {
		            rules: {
		            	newemail: {
		                    required: true,
		                    email: true
			            },
		            },
		            messages: {
		            	newemail: "请输入正确格式的邮件地址",
		            },
					submitHandler : function() {
						$form.ajaxSubmit({
							dataType : "json",
							success : function(data) {
								if (data.state == 'success') {
									$('#emailmodal').modal('hide');
									$(".modal-backdrop").remove();
									ecjia.merchant.showmessage(data);
								} else {
									var $info = $('<div class="staticalert alert alert-danger ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
									$info.appendTo('.error-msg').delay(5000).hide(0);
								}
							}
						});
					}
				}
			 var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
			 $form.validate(options);
        },

        form_submit : function(){
            var $form = $("form[name='profileForm']");
			var option = {
		            rules: {
		                new_password: {
		                    minlength: 6
		                },
		                pwd_confirm: {
		                    equalTo: "#new_password"
		                },
		            },
		            messages: {
		                new_password: {
		                    minlength: "您的密码必须至少为6个字符"
		                },
		                pwd_confirm: {
		                    equalTo: "请输入与上述相同的密码"
		                },
		            },
					submitHandler : function() {
						$form.ajaxSubmit({
							dataType : "json",
							success : function(data) {
								ecjia.merchant.showmessage(data);
							}
						});
					}
				}
			 var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
			 $form.validate(options);
        }
    };
    
    app.profile_avatar = {
        init: function () {
		        var options =
			{
			    thumbBox: '.thumbBox',
			    spinner: '.spinner',
		 	    imgSrc: './content/apps/staff/statics/images/crop_avatar.jpg'
			}
		    var cropper = $('.imageBox').cropbox(options);
		    $('#upload-file').on('change', function () {
		        var reader = new FileReader();
		        reader.onload = function (e) {
		            options.imgSrc = e.target.result;
		            cropper = $('.imageBox').cropbox(options);
		        }
		        reader.readAsDataURL(this.files[0]);
		        // this.files = [];
		    })
	    
		    $('#btnCrop').on('click', function () {
		        var img = cropper.getDataURL();
		        $('.cropped').html('');
		        $('.cropped').append('<img src="' + img + '" align="absmiddle" style="width:64px;margin-top:4px;border-radius:64px;box-shadow:0px 0px 12px #7E7E7E;" ><p>64px*64px</p>');
		        $('.cropped').append('<img src="' + img + '" align="absmiddle" style="width:128px;margin-top:4px;border-radius:128px;box-shadow:0px 0px 12px #7E7E7E;"><p>128px*128px</p>');
		        $('.cropped').append('<img src="' + img + '" align="absmiddle" style="width:180px;margin-top:4px;border-radius:180px;box-shadow:0px 0px 12px #7E7E7E;"><p>180px*180px</p>');
		    })
		    $('#btnZoomIn').on('click', function () {
		        cropper.zoomIn();
		    })
		    
		    $('#btnZoomOut').on('click', function () {
		        cropper.zoomOut();
		    })
 
		    $('#btnSubmit').on('click', function() {
		        var url = $(this).attr('data-url');
				var img = cropper.getBlob();
		        var formdata = new FormData();
		        formdata.append("avatar", img, "image.png");

		        $.ajax({
		        	url: url,
		        	data: formdata,
		            type: 'post',
		          	contentType: false,    
            		processData: false,  
		            success: function (data) {
		            	ecjia.merchant.showmessage(data);
		            }
		        });
		    })
        }
    }
    
    
})(ecjia.merchant, jQuery);
 
// end