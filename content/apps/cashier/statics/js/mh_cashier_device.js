// JavaScript Document
;(function (app, $) {
    app.cashier_device = {
        init: function () {
        	$("form[name='searchForm']").on('submit', function(e) {
				e.preventDefault();
				var keywords = $("input[name='keywords']").val(); //关键字
				var url = $("form[name='searchForm']").attr('action');

				if (keywords == 'undefind') keywords = '';
				if (keywords != '') {
					url += '&keywords=' + keywords;
				}
				ecjia.pjax(url);
			});
            app.cashier_device.toggle_status();
            app.cashier_device.cashier_device_info();
            app.cashier_device.change_cashier_type();
        },
        toggle_status: function() {
			$('[data-trigger="toggle_status"]').on('click', function(e) {
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
		
		cashier_device_info: function () {
            var $form = $("form[name='theForm']");
            var option = {
    	            rules: {
    	            	device_name: {
    	                    required: true
    	                },
    	                device_mac: {
    	                    required: true
    	                },
    	                product_sn: {
    	                    required: true
    	                },
    	                device_type: {
    	                    required: true
    	                },
    	                device_sn: {
    	                    required: true
    	                },
    	            },
    	            messages: {
    	            	device_name: {
    	            		required: js_lang.device_name
    	                },
    	                device_mac: {
    	            		required: js_lang.device_mac
    	                },
    	                product_sn: {
    	            		required: js_lang.product_sn
    	                },
    	                cashier_type: {
    	            		required: js_lang.cashier_type
    	                },
    	                device_type: {
    	            		required: js_lang.device_type
    	                },
    	                device_sn: {
    	            		required: js_lang.device_sn
    	                },
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
		change_cashier_type: function() {
			$('.cashier-img').on('click', function() {				
				var $this = $(this),
				cashier_type = $this.attr('cashier-type');				
				if (cashier_type == 'cashier-desk') {
					$('#cashier-desk').attr("checked",true); 
					$('#cashier-pos').removeAttr("checked"); 
					$('.kooldesk-type').removeClass('ecjia-dn');
                    $('.koolpos-type').addClass('ecjia-dn');
				} else {
					$('#cashier-pos').attr("checked",true); 
					$('#cashier-desk').removeAttr("checked"); 
					$('.kooldesk-type').addClass('ecjia-dn');
                    $('.koolpos-type').removeClass('ecjia-dn');
				}
			});
            $('.cashier-select').on('click', function() {              
                var $this = $(this),
                cashier_type = $this.attr('cashier-type');              
                if (cashier_type == 'cashier-desk') {
                    $('#cashier-desk').attr("checked",true); 
                    $('#cashier-pos').removeAttr("checked"); 
                    $('.kooldesk-type').removeClass('ecjia-dn');
                    $('.koolpos-type').addClass('ecjia-dn');
                } else {
                    $('#cashier-pos').attr("checked",true); 
                    $('#cashier-desk').removeAttr("checked"); 
                    $('.kooldesk-type').addClass('ecjia-dn');
                    $('.koolpos-type').removeClass('ecjia-dn');
                }
            });
		},
    };
    
})(ecjia.merchant, jQuery);
 
// end