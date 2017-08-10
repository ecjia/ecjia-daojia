// JavaScript Document
;(function (app, $) {
    app.mobile_manage = {

        info: function () {	
        	var test_id = $("input[name='id']").val();
        	if (test_id) {
        	    var app_key = document.getElementById('app_key');
        		new Clipboard(app_key);
        		var app_secret = document.getElementById('app_secret');
        		new Clipboard(app_secret);
        	}
	    	$('.change_status').on('click', function() {
				var $this = $(this);
				var message = $this.attr('data-msg');
				var url = $this.attr('data-href');
				if (message != undefined) {
					smoke.confirm(message, function(e) {
						if (e) {
							$.get(url, function(data){
								ecjia.admin.showmessage(data);
							})
						}
					}, {ok:"确定", cancel:"取消"});
				} 
			});
	    	
            app.mobile_manage.submit();
 
            $('#info-toggle-button').toggleButtons({
                label: {
                    enabled: js_lang.enabled,
                    disabled: js_lang.disabled
                },
                style: {
                    enabled: "info",
                    disabled: "success"
                }
            });
        },
        
        submit: function () {
            var $this = $("form[name='theForm']");
            var option = {
                rules: {
                    name: {
                        required: true
                    },
                    client: {
                        required: true
                    },
                    code: {
                        required: true
                    },
                    bundleid: {
                        required: true
                    },
                    appkey: {
                        required: true
                    },
                    appsecret: {
                        required: true
                    },
                    platform: {
                        required: true
                    },
                },
                messages: {
                    name: {
                        required: js_lang.app_name_required
                    },
                    client: {
                        required: js_lang.app_client_required
                    },
                    code: {
                        required: js_lang.app_code_required
                    },
                    bundleid: {
                        required: js_lang.bundleid_required
                    },
                    appkey: {
                        required: js_lang.appkey_required
                    },
                    appsecret: {
                        required: js_lang.appsecret_required
                    },
                    platform: {
                        required: js_lang.platform_required
                    },
                },
                submitHandler: function () {
                    $this.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            ecjia.admin.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.admin.defaultOptions.validate, option);
            $this.validate(options);
        }
    };
    
    
    app.mobile_config = {
            info: function () {
                $('.switch').on('click', function (e) {
                    var url = $(this).attr('data-url');
                	$.get(url, function(data) {
                		ecjia.admin.showmessage(data);
                	});
                });
                
                app.mobile_config.submit();
            },
            
            submit: function () {
                var $this = $("form[name='theForm']");
                var option = {
                    rules: {
                    	app_key: {
                            required: true
                        },
                        app_secret: {
                            required: true
                        }
                    },
                    messages: {
                    	app_key: {
                            required: "请输入App Key"
                        },
                        app_secret: {
                            required: "请输入App Secret"
                        }
                    },
                    submitHandler: function () {
                        $this.ajaxSubmit({
                            dataType: "json",
                            success: function (data) {
                                ecjia.admin.showmessage(data);
                            }
                        });
                    }
                }
                var options = $.extend(ecjia.admin.defaultOptions.validate, option);
                $this.validate(options);
            },

        };
    
})(ecjia.admin, jQuery);
 
// end