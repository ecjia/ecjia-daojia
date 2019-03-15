// JavaScript Document
;(function (app, $) {
    app.staff_list = {
        init: function () {
            //搜索功能
            $("form[name='searchForm'] .btn-primary").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var keywords = $("input[name='keywords']").val();
                if (keywords != '') {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
        }
    };
 
    app.staff_edit = {
        init: function () {        	
    		var $form = $("form[name='staffForm']");
			var option = {
		            rules: {
		            	name: "required",
		                new_password: {
		                    minlength: 6
		                },
		                edit_confirm_password: {
		                    equalTo: "#new_password"
		                },
		            },
		            messages: {
		            	name: js_lang.employee_name,
		                new_password: {
		                    minlength: js_lang.password_is_at_least_6_characters
		                },
		                edit_confirm_password: {
		                    equalTo: js_lang.same_password
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
    
    
    app.staff_info = {
        init: function () {
        	app.staff_info.setTime();
        	app.staff_info.theForm();
        },
        
        setTime: function () {
        	var InterValObj; //timer变量，控制时间
    		var count = 120; //间隔函数，1秒执行
    		var curCount;//当前剩余秒数
    		
            $("#get_code").on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('data-url')+'&mobile=' + $("input[name='mobile']").val();
                $.get(url, function (data) {
                	if (data.state == 'success') {
	        		  　    curCount = count;
	        		     $("#mobile").attr("disabled", "true");
	        		     $("#get_code").attr("disabled", "true");
	        		     $("#get_code").val(js_lang.resend + curCount + "(s)");
	        		     InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
					}
                    ecjia.merchant.showmessage(data);
                }, 'json');
            });
            
            //timer处理函数
            function SetRemainTime() {
	            if (curCount == 0) {                
	                window.clearInterval(InterValObj);//停止计时器
	                $("#mobile").removeAttr("disabled");//启用按钮
	                $("#get_code").removeAttr("disabled");//启用按钮
	                $("#get_code").val(js_lang.resend_code);
	            }
	            else {
	                curCount--;
	                $("#get_code").val(js_lang.resend + curCount + "(s)");
	            }
	        };
        },
        
        theForm: function() {
            var $form = $("form[name='theForm']");
			var option = {
		            rules: {
		            	name: "required",
		            	mobile: "required",
		                email: {
		                    required: true,
		                    email: true
		                },
		                password: {
		                    required: true,
		                    minlength: 6
		                },
		                confirm_password: {
		                    required: true,
		                    equalTo: "#password"
		                },
		            },
		            messages: {
		            	name: js_lang.employee_name,
		            	mobile: js_lang.phone_account,
		                email: js_lang.correct_mail_account,
		                password: {
		                    required: js_lang.enter_password,
		                    minlength: js_lang.password_is_at_least_6_characters
		                },
		                confirm_password: {
		                    required: js_lang.password_can_not_be_blank,
		                    equalTo: js_lang.same_password
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
    }
    
})(ecjia.merchant, jQuery);
 
// end