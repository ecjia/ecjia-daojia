// JavaScript Document
;(function (app, $) {
    app.cashdesk_scales = {
        init: function () {
        	$('.info-toggle-button').toggleButtons({
				label: {  
                     enabled: js_lang.open,  
                     disabled: js_lang.close  
                },  
                style: {
                    enabled: "info",
                    disabled: "success"
                }
            });
            app.cashdesk_scales.toggle_wipezero();
            app.cashdesk_scales.toggle_reserve_quantile();
            app.cashdesk_scales.cashdesk_info();
        },
        toggle_wipezero: function() {
			$('[data-trigger="toggle_wipezero"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this);
				var url = $this.attr('data-url');
				var id = $this.attr('data-id');
				var val = $this.hasClass('fa-times') ? 1 : 0;
				var type = $this.attr('data-type') ? $this.attr('data-type') : "POST";
				var pjaxurl = $this.attr('refresh-url');

				var option = {
					obj: $this,
					url: url,
					id: id,
					val: val,
					type: type
				};

				$.ajax({
					url: option.url,
					data: {
						id: option.id,
						val: option.val
					},
					type: option.type,
					dataType: "json",
					success: function(data) {
						data.content ? option.obj.removeClass('fa-times').addClass('fa-check') : option.obj.removeClass('fa-check').addClass('fa-times');
						ecjia.pjax(pjaxurl, function() {
							ecjia.merchant.showmessage(data);
						});
					}
				});
			})
		},
		
		toggle_reserve_quantile: function() {
			$('[data-trigger="toggle_reserve_quantile"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this);
				var url = $this.attr('data-url');
				var id = $this.attr('data-id');
				var val = $this.hasClass('fa-times') ? 1 : 0;
				var type = $this.attr('data-type') ? $this.attr('data-type') : "POST";
				var pjaxurl = $this.attr('refresh-url');

				var option = {
					obj: $this,
					url: url,
					id: id,
					val: val,
					type: type
				};

				$.ajax({
					url: option.url,
					data: {
						id: option.id,
						val: option.val
					},
					type: option.type,
					dataType: "json",
					success: function(data) {
						data.content ? option.obj.removeClass('fa-times').addClass('fa-check') : option.obj.removeClass('fa-check').addClass('fa-times');
						ecjia.pjax(pjaxurl, function() {
							ecjia.merchant.showmessage(data);
						});
					}
				});
			})
		},
        
		cashdesk_info: function () {
            var $form = $("form[name='theForm']");
            var option = {
    	            rules: {
    	            	scale_sn: {
    	                    required: true
    	                }
    	            },
    	            messages: {
    	            	scale_sn: {
    	            		required: js_lang.scale_sn_required
    	                }
    	            },
    	            submitHandler: function () {
    	                $form.ajaxSubmit({
    	                    dataType: "json",
    	                    success: function (data) {
    	                        ecjia.merchant.showmessage(data);
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