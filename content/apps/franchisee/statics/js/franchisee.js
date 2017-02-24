// JavaScript Document
;(function (app, $) {
    app.franchisee = {
        init: function () {
            //单选框切换事件
            $(document).on('click', 'input[name="validate_type"]', function (e) {
            	if ($("input[name='validate_type']:checked").val() == 1) {
            		$('.company_responsible_person').addClass('hide');
            		$('.responsible_person').removeClass('hide');
            	} else {
            		$('.company_responsible_person').removeClass('hide');
            		$('.responsible_person').addClass('hide');
            	}
            });
            $('input[name="validate_type"]:checked').trigger('click');
        	
        	var InterValObj; 	//timer变量，控制时间
    		var count = 120; 	//间隔函数，1秒执行
    		var curCount;		//当前剩余秒数
    		
            $("#get_code").on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('data-url')+'&mobile=' + $("input[name='mobile']").val();
                $.get(url, function (data) {
                	if (data.state == 'success') {
	        		  　    curCount = count;
	        		     $("#mobile").attr("readonly", "true");
	        		     $("#get_code").attr("disabled", "true");
	        		     $("#get_code").html("重新发送" + curCount + "(s)");
	        		     InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
					}
                    ecjia.merchant.showmessage(data);
                }, 'json');
            });
            
            //timer处理函数
            function SetRemainTime() {
	            if (curCount == 0) {     
	                window.clearInterval(InterValObj);		//停止计时器
	                $("#mobile").removeAttr("readonly");	//启用按钮
	                $("#get_code").removeAttr("disabled");	//启用按钮
	                $("#get_code").html("重新发送验证码");
	            } else {
	                curCount--;
	                $("#get_code").attr("disabled", "true");
	                $("#get_code").html("重新发送" + curCount + "(s)");
	            }
	        };
	        
            var $form = $("form[name='theForm']");
			var option = {
	            rules: {
	            	mobile: "required",
	            	merchants_name: "required",
	                email: {
	                	required: true,
	                    email: true
	              	},
	              	store_cat: {
	                    min: 1
	              	},
	              	district: {
	                    min: 1
	              	},
	              	address: "required",
	            	responsible_person: "required",
	            	company_responsible_person: "required",
	            	identity_number: "required"
	            },
	            messages: {
	            	mobile: "请输入手机号码",
	            	merchants_name: "请输入店铺名称",
	              	store_cat: {
	                    min: "请选择店铺分类"
	              	},
	            	email: {
	                	required: "请输入电子邮箱",
	                    email: "请输入一个正确的邮箱",
	              	},
	              	district: {
	                    min: "请选择地区"
	              	},
	              	address: "请输入详细地址",
	            	responsible_person: "请输入负责人姓名",
	            	company_responsible_person: "请输入法定代表人姓名",
	            	identity_number: "请输入证件号码"
	            },
				submitHandler : function() {
					$form.ajaxSubmit({
						dataType : "json",
						success : function(data) {
							if (data.message == '') {
								ecjia.pjax(data.url);
							} else {
								ecjia.merchant.showmessage(data);
							}
						}
					});
				}
			}
			var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
			$form.validate(options);
			
			app.franchisee.gethash();
			
			$('.remove_apply').on('click', function() {
				var $this = $(this),
					message = $this.attr('data-msg'),
					url = $this.attr('data-href');
				if (message != undefined) {
					smoke.confirm(message, function(e) {
						if (e) {
							$.post(url, function(data){
								ecjia.pjax(data.pjaxurl);
//								ecjia.merchant.showmessage(data);
							})
						}
					}, {ok:"确定", cancel:"取消"});
				} 
			});
			
			$(document).on('pjax:end', function() {
                window.clearInterval(InterValObj);
			});
        },
        
        gethash : function(){
            $('[data-toggle="get-gohash"]').on('click',function(e){
                e.preventDefault();
                var province = $('select[name="province"]').val(),
                city = $('select[name="city"]').val(),
                district = $('select[name="district"]').val(),
                address = $('input[name="address"]').val(),
                url = $(this).attr('data-url');

                var option = {
                    'province' :　province,
                    'city' :　city,
                    'district' :　district,
                    'address' : address,
                }
                $.post(url, option, app.franchisee.sethash, "JSON");
            })
        },

        sethash : function(location){
            if(location.state =='error'){
                if(location.element == 'address'){
                    $('input[name="address"]').focus();
                    $('input[name="address"]').parents('.form-group').addClass('f_error');
                }else{
                    $('.form-address').addClass('error');
                }
                ecjia.merchant.showmessage(location);
            }else{
                $('.localtion-address').removeClass('hide');
                var map = new BMap.Map("allmap");
                var point = new BMap.Point(location.lng, location.lat);  // 创建点坐标
                $('input[name="longitude"]').val(location.lng);
                $('input[name="latitude"]').val(location.lat);
                map.centerAndZoom(point,15);
                map.enableScrollWheelZoom();
                var marker = new BMap.Marker(point);  // 创建标注
            	map.addOverlay(marker);               // 将标注添加到地图中
                map.addEventListener("click",function(e){
                    map.removeOverlay(marker);
                    $('input[name="longitude"]').val(e.point.lng)
                    $('input[name="latitude"]').val(e.point.lat)
                    point = new BMap.Point(e.point.lng, e.point.lat);
                    marker = new BMap.Marker(point)
                    map.addOverlay(marker);
                });
            }
        }
    }
    
})(ecjia.merchant, jQuery);
 
// end