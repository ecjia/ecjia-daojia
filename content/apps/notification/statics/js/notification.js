// JavaScript Document
;(function(app, $) {
	app.notice_list = {
		init : function() {
			app.notice_list.toggle_view();
			app.notice_list.switch_state();
		},
		
		toggle_view : function (option) {
			$('.toggle_view').on('click', function (e) {
				e.preventDefault();
				var $this = $(this);
				var url = $this.attr('href');
				var val = $this.attr('data-id');
				var type = $this.attr('data-type');
				var msg = $this.attr("data-msg");

				if (val == undefined && type == undefined) {
					return false;
				}
				
				var option = {'type' : type, 'val' : val};
				if (msg) {
					smoke.confirm( msg , function(e){
						if (e) {
							$.post(url, option, function(data){
								ecjia.admin.showmessage(data);
							},'json');
						}
					}, {ok:'确定', cancel:'取消'});
				} else {
					$.post(url, option, function(data){
						ecjia.admin.showmessage(data);
					},'json');
				}
			});
		},
		
        switch_state: function () {
            $('.switch').on('click', function (e) {
            	e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: $(this).attr('data-url'),
                    data: '',
                    dataType: "json",
                    success: function (data) {
                    	ecjia.admin.showmessage(data);
                    }
                });
            });
        },
	};
	
	app.notice_edit = {
		init : function() {
			app.notice_edit.submit();
		},
		
		/* 编辑form提交 */
	    submit: function() {
	        var $form = $('form[name="editForm"]');
	        /* 给表单加入submit事件 */
	        var option = {
	            rules: {
	            	channel_name: {
	                    required: true,
	                },
	                channel_desc: {
	                    required: true,
	                    minlength: 6
	                },
	            },
	            messages: {
	            	channel_name: {
	                    required: js_lang.channel_name_required,
	                },
	                channel_desc: {
	                    required: js_lang.channel_desc_required,
	                    minlength: js_lang.channel_desc_minlength,
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