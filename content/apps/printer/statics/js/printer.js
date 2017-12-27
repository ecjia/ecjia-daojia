// JavaScript Document
;(function (app, $) {
    app.printer = {
        init: function () {
        	 app.printer.form();
        	 app.printer.toggleButton();
        	 app.printer.slider();
        	 app.printer.remove_logo();
        	 app.printer.testForm();
        	 app.printer.toggle_view();
        	 app.printer.view_print_content();
        },
        
        form: function () {
        	$('.view_key').off('click').on('click', function() {
        		var $this = $(this),
        			key = $this.attr('data-key'),
        			value = $this.attr('data-value'),
        			i = $this.children('i').attr('class');

        		if (i == 'fontello-icon-eye') {
        			$this.parent().find('.machine_key').html(value);
        			$this.children('i').attr('class', 'fontello-icon-eye-off')
        		} else {
        			$this.parent().find('.machine_key').html(key);
        			$this.children('i').attr('class', 'fontello-icon-eye')
        		}
        	});
        	
        	$('.toggle-printer-button').toggleButtons({
				label: {  
                     enabled: "开启",  
                     disabled: "关闭"  
                },  
                style: {
                    enabled: "info",
                    disabled: "success"
                }
            });
        	var option = {
				 rules: {
					 machine_name: {
						 required: true
					 },
					 machine_code: {
				         required: true
				     },
				     machine_key: {
				         required: true
				     },
				     app_key: {
				         required: true
				     },
				     app_secret: {
				         required: true
				     },
				 },
                 messages: {
                	 machine_name: {
                         required: "请输入打印机名称"
                     },
                	 machine_code: {
                         required: "请输入终端编号"
                     },
                     machine_key: {
                         required: "请输入终端密钥"
                     },
                     app_key: {
                         required: "请输入App Key"
                     },
                     app_secret: {
                         required: "请输入App Secret"
                     }
                 },
                 submitHandler: function () {
                	 $('#uploadLogo').modal('hide');
                     $("form[name='theForm']").ajaxSubmit({
                         dataType: "json",
                         success: function (data) {
                             ecjia.admin.showmessage(data);
                         }
                     });
                 }
             }
             var options = $.extend(ecjia.admin.defaultOptions.validate, option);
             $("form[name='theForm']").validate(options);
        },
        
        toggleButton: function() {
        	//响铃类型
			$('.info-toggle-button').toggleButtons({
				label: {  
                     enabled: "蜂鸣器",  
                     disabled: "喇叭"  
                },  
                style: {
                    enabled: "info",
                    disabled: "success"
                },
                onChange: function($el, status, e) {  
                    var type = $('input[name="voice_type"]').val();
                    if (status && type == 'buzzer') {
                    	return false
                    } else if (!status && type == 'horn') {
                    	return false;
                    }
                    var url = $('.info-toggle-button').attr('data-url');
                    var info = {
                    	'type': type,
                    	'action': 'edit_type'
                    }
                   	$.post(url, info, function(data) {
                   		ecjia.admin.showmessage(data);
                   	});
                },  
            });
			
			//按键打印
			$('.info-toggle-print-type').toggleButtons({
				label: {  
                     enabled: "开启",  
                     disabled: "关闭"  
                },  
                style: {
                    enabled: "info",
                    disabled: "success"
                },
                onChange: function($el, status, e) {
                    var type = $('input[name="print_type"]').val();
                    if (status && type == 'btnopen') {
                    	return false
                    } else if (!status && type == 'btnclose') {
                    	return false;
                    }
                    var url = $('.info-toggle-print-type').attr('data-url');
                    var info = {
                    	'type': type,
                    }
                   	$.post(url, info, function(data) {
                   		ecjia.admin.showmessage(data);
                   	});
                },  
            });
			
			//订单确认
			$('.info-toggle-getorder').toggleButtons({
				label: {  
                     enabled: "开启",  
                     disabled: "关闭"  
                },  
                style: {
                    enabled: "info",
                    disabled: "success"
                },
                onChange: function($el, status, e) {  
                    var type = $('input[name="getorder"]').val();
                    if (status && type == 'open') {
                    	return false
                    } else if (!status && type == 'close') {
                    	return false;
                    }
                    var url = $('.info-toggle-getorder').attr('data-url');
                    var info = {
                    	'type': type,
                    }
                   	$.post(url, info, function(data) {
                   		ecjia.admin.showmessage(data);
                   	});
                },  
            });
        },
        
        //音量调节
        slider: function() {
        	var voiceSlider = document.getElementById('voice-slider');
        	if (voiceSlider != null) {
	        	var v = parseInt($('.voice_value').html());
	            noUiSlider.create(voiceSlider, {
	                start: v,
	                step: 1,
	                range: {
	                    'min': 0,
	                    'max': 3
	                }
	            });
	            voiceSlider.noUiSlider.on('change', function ( values, handle ) {
	            	var v = parseInt($('.voice_value').html());
	            	$('.voice-slider-handle').attr("disabled", true);
	            	var url = $('.info-toggle-button').attr('data-url');
                	var voice = parseInt(values[handle]);
                	if (v == voice) {
                		$('.voice-slider-handle').attr("disabled", false);
                		return false;
                	}
                    var info = {
                      'voice': voice,
                      'action': 'edit_voice'
                    }
                	$.post(url, info, function(data) {
                   		$('.voice-slider-handle').attr("disabled", false);
                   		ecjia.admin.showmessage(data);
                   		if (data.state == 'success') {
                   			$('.voice_value').html(voice);
                   		}
                   	});
                   	
	            });
        	}
        },
        
        remove_logo: function() {
        	$('.remove_logo').off('click').on('click', function() {
        		$('#uploadLogo').modal('hide');
        	});
        },
        
        testForm: function () {
        	var option = {
       			 submitHandler: function () {
       				$('#testPrint').modal('hide');
                    $("form[name='testForm']").ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            ecjia.admin.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.admin.defaultOptions.validate, option);
            $("form[name='testForm']").validate(options);
       },
       
       toggle_view: function() {
           $('.toggle_view').off('click').on('click', function (e) {
               e.preventDefault();
               var $this = $(this);
               var url = $this.attr('href');
               $.post(url, function (data) {
               	ecjia.admin.showmessage(data);
               }, 'json');
           });
       },
       view_print_content: function() {
    	   $('.view_print_content').off('click').on('click', function() {
    		   var $this = $(this),
					val = $this.parent('.edit-list').find('input').val();
    		   $('.modal-body').find('pre').html(val);
    		   $('#print_content').modal('show');
    	   });
      }
    };  
})(ecjia.admin, jQuery);
 
// end