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
		            	name: "请输入员工名称",
		                new_password: {
		                    minlength: "您的密码必须至少为6个字符"
		                },
		                edit_confirm_password: {
		                    equalTo: "请输入与上述相同的密码"
		                },
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
    
    
    app.staff_info = {
        init: function () {
        	var InterValObj; //timer变量，控制时间
    		var count = 120; //间隔函数，1秒执行
    		var curCount;//当前剩余秒数
    		
            $("#get_code").on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('data-url')+'&mobile=' + $("input[name='mobile']").val();
                $.get(url, function (data) {
                	if(data.state == 'success'){
	        		  　    curCount = count;
	        		     $("#mobile").attr("disabled", "true");
	        		     $("#get_code").attr("disabled", "true");
	        		     $("#get_code").val("重新发送" + curCount + "(s)");
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
	                $("#get_code").val("重新发送验证码");
	            }
	            else {
	                curCount--;
	                $("#get_code").val("重新发送" + curCount + "(s)");
	            }
	        };
         
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
		            	name: "请输入员工名称",
		            	mobile: "请输入手机账号",
		                email: "请输入正确邮件账号",
		                password: {
		                    required: "请输入密码",
		                    minlength: "您的密码必须至少为6个字符"
		                },
		                confirm_password: {
		                    required: "确认密码不能为空",
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
    }
    
})(ecjia.merchant, jQuery);
 
// end