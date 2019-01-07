// JavaScript Document
;
(function (app, $) {
    app.ucenter_list = {
        init: function () {
        	app.ucenter_list.ping();
        },
        ping: function() {
        	$('.app_linkstatus').each(function() {
        		var $this = $(this),
        			href = $this.attr('data-href'),
        			url = $this.attr('data-url'),
        			ip = $this.attr('data-ip'),
        			appid = $this.attr('data-appid');
        		var info = {
        			'url': url,
        			'ip': ip,
        			'appid': appid
        		};
        		$('#app_' + appid).html('正在连接...');
        		$.get(href, info, function(data) {
                    var appid = data.appid;
        			if (data.state == 'success') {
        				var message = '<span class="ecjiafc-blue"><i class="fontello-icon-ok"></i>' + data.message + '</span>';
        			} else {
        				var message = '<span class="ecjiafc-red"><i class="fontello-icon-cancel"></i>' + data.message + '</span>';
        			}
        			$('#app_' + appid).html(message);
        		})
        	})
        }
    
    };

    /* **编辑** */
    app.ucenter_edit = {
        init: function (get_value) {
            app.ucenter_edit.submit_form();
        },

        submit_form: function (formobj) {
            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                    url: {
                        required: true
                    },
                },
                messages: {
                    url: {
                        required: '应用的主URL不能为空'
                    },
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
        }
    };

})(ecjia.admin, jQuery);

// end