// JavaScript Document
;(function (app, $) {
    app.merchant_validate_order = {
            init: function () {
                app.merchant_validate_order.submit_form();
                app.merchant_validate_order.validate_to_ship();
            },
            
    	    submit_form: function () {
    	        var $form = $("form[name='theForm']");
    	        var option = {
    	            rules: {
    	            	pickup_code: {
    	                    required: true
    	                },
    	            },
    	            messages: {
    	            	pickup_code: {
    	                	required: "请输入取货验证码！"
    	                },
    	            },
    	            submitHandler: function () {
    	                $form.ajaxSubmit({
    	                    dataType: "json",
    	                    success: function (data) {
    	                    	if (data.state == 'error') {
    	                    		ecjia.merchant.showmessage(data);
    	                    	}
    	                    	if (data.status == '1') {
    	                    		$("#operate").modal('show');
    	                    		$(".pickup_code").html(data.order.pickup_code);
    	                    		$(".user_name").html(data.order.user_name);
    	                    		$(".mobile").html(data.order.mobile);
    	                    		$(".total_fee").html(data.order.total_fee);
    	                    		$(".pay_name").html(data.order.pay_name);
    	                    		$(".order_sn").html(data.order.order_sn);
    	                    		$(".add_time").html(data.order.add_time);
    	                    		$(".btn-info-new").attr('href',data.order.url);
    	                    		"form[name='theForm']"
    	                    		$("input[name='order_id']").attr('value',data.order.order_id);
    	                    	}
    	                    }
    	                });
    	            }
    	        }
    	        var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
    	        $form.validate(options);
    	    },
    	    
    	    validate_to_ship: function () {
    	        var $form = $("form[name='validateForm']");
    	        var option = {
    	            submitHandler: function () {
    	                $form.ajaxSubmit({
    	                    dataType: "json",
    	                    success: function (data) {
    	                    	ecjia.merchant.showmessage(data);
    	                    	if (data.state == 'success') {
    	                    		$("#operate").modal('hide');
    	                    	}
    	                    }
    	                });
    	            }
    	        }
    	        var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
    	        $form.validate(options);
    	    },
      };
    
})(ecjia.merchant, jQuery);
 
// end