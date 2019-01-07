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
        	 var option = {
                 rules: {
                	 machine_code: {
                         required: true
                     },
                     machine_key: {
                         required: true
                     }
                 },
                 messages: {
                	 machine_code: {
                         required: "请输入终端编号"
                     },
                     machine_key: {
                         required: "请输入终端密钥"
                     }
                 },
                 submitHandler: function () {
					 $('#uploadLogo').modal('hide');
					 $(".modal-backdrop").remove();
                     $("form[name='theForm']").ajaxSubmit({
                         dataType: "json",
                         success: function (data) {
                             ecjia.merchant.showmessage(data);
                         }
                     });
                 }
             }
             var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
             $("form[name='theForm']").validate(options);
        },
        
        toggleButton: function() {
        	//响铃类型
			$('#voice_type').on('click', function() {
				var type = $('#voice_type').val(),
					url = $('.info-toggle-button').attr('data-url');
				var info = {
	            	'type': type,
	            	'action': 'edit_type'
				}
	           	$.post(url, info, function(data) {
	           		ecjia.merchant.showmessage(data);
	           	});
			});
			
			//按键打印
			$('#print_type').on('click', function() {
				var type = $('#print_type').val(),
					url = $('.info-toggle-print-type').attr('data-url');
				var info = {
	            	'type': type,
				}
	           	$.post(url, info, function(data) {
	           		ecjia.merchant.showmessage(data);
	           	});
			});
			
			//订单确认
			$('#getorder').on('click', function() {
				var type = $('#getorder').val(),
					url = $('.info-toggle-getorder').attr('data-url');
				var info = {
	            	'type': type,
				}
	           	$.post(url, info, function(data) {
	           		ecjia.merchant.showmessage(data);
	           	});
			});
			
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
        },
        
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
                   		ecjia.merchant.showmessage(data);
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
				$(".modal-backdrop").remove();
        	});
        },
        
        testForm: function () {
        	var option = {
       			 submitHandler: function () {
					$('#testPrint').modal('hide');
					$(".modal-backdrop").remove();   
                    $("form[name='testForm']").ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            ecjia.merchant.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
            $("form[name='testForm']").validate(options);
            
            $('.print_test').off('click').on('click', function() {
        		var type = $(this).attr('data-type'); 
        		var number = $('input[name="print_count"]').val();
        		var tail_content = $('input[name="tail_content"]').val();
        		var url = $(this).attr('data-url');
        		var info = {
        			type: type,
        			number: number,
        			tail_content: tail_content
        		}
        		$.post(url, info, function(data){
        			ecjia.merchant.showmessage(data);
        		});
        	});
       },
       
       toggle_view: function() {
           $('.toggle_view').off('click').on('click', function (e) {
               e.preventDefault();
               var $this = $(this);
               var url = $this.attr('href');
               $.post(url, function (data) {
            	   ecjia.merchant.showmessage(data);
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
})(ecjia.merchant, jQuery);
 
// end