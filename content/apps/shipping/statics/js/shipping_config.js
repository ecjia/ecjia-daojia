// JavaScript Document
;(function (app, $) {
    app.shipping_config = {
        init: function () {
        	app.shipping_config.submit_form();
        },
	    submit_form: function (formobj) {
	        var $form = $("form[name='theForm']");
	        var option = {
	            rules: {
	            	express_key: {
	                    required: true
	                },
	                express_secret: {
	                    required: true
	                }
	            },
	            messages: {
	            	express_key: {
	                    required: '请填写'
	                },
	                express_secret: {
	                	required: '请填写'
	                }
	            },
	            submitHandler: function () {
	                $form.ajaxSubmit({
	                    dataType: "json",
	                    success: function (data) {
	                        ecjia.admin.showmessage(data);
	                    }
	                });
	
	            }
	        }
	        var options = $.extend(ecjia.admin.defaultOptions.validate, option);
	        $form.validate(options);
	    },
    };
 
})(ecjia.admin, jQuery);
 
// end