// JavaScript Document
;(function (app, $) {
    app.mobile_manage = {
        info: function () {
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
    
})(ecjia.admin, jQuery);
 
// end