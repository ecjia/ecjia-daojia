// JavaScript Document
;(function (app, $) {
    app.cron = {
        init: function () {
        	$("#cron_tab").cronGen();     
            app.cron.theForm();
            app.cron.toggle_view();
            app.cron.trigger();
            app.cron.ajax_select();
            app.cron.ajax_five();
        },
        
        //添加必填项js
        theForm: function () {
            var $form = $("form[name='theForm']");
            var option = {
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
 
        toggle_view: function (option) {
            $('.toggle_view').on('click', function (e) {
                e.preventDefault();
                var $this = $(this);
                var href = $this.attr('href');
                var val = $this.attr('data-val');
                var option = {
                    href: href,
                    val: val
                };
                var url = option.href;
                var code = {
                    code: option.val
                };
                var msg = $this.attr("data-msg");
                if (msg) {
                    smoke.confirm(msg, function (e) {
                        if (e) {
                            $.get(url, code, function (data) {
                                ecjia.admin.showmessage(data);
                            }, 'json');
                        }
                    }, {
                        ok: '确定',
                        cancel: '取消'
                    });
                } else {
                    $.get(url, code, function (data) {
                        ecjia.admin.showmessage(data);
                    }, 'json');
                }
            });
        },
 
        trigger: function () {
            $('.advance').css('display', 'none');
            if ($("input[name='show_advance']").attr("checked")) {
	        	 $('.advance').css('display', 'block');
	        }

            $(document).on('click', 'input[name="show_advance"]', function (e) {
                if ($("input[name='show_advance']").attr("checked")) {
                    $('.advance').css('display', 'block');
                } else {
                    $('.advance').css('display', 'none');
                }
            });
 
            $("select[name='ttype']").on('change', function (e) {
                $(this).val() == 'day' ? $('.ttype_day').css('display', 'block') : $('.ttype_day').css('display', 'none');
                $(this).val() == 'week' ? $('.ttype_week').css('display', 'block') : $('.ttype_week').css('display', 'none');
                if ($(this).val() == 'unlimit') {
                    $('.ttype_day').css('display', 'none');
                    $('.ttype_week').css('display', 'none');
                }
            });
        },
        
        ajax_select :function(){
        	$("#select_cron_config").change(function () {
       		    var select_val = $("#select_cron_config option:selected").val();

       		    if (select_val == 0){//未选择
       		    	$("#config_time").css('display','none'); 
       		    	$(".cron_ordinary").css('display','none'); 
       		    	
       		    	$("#config_time").val('');
       		    	$("#cron_tab").val(''); 
       		    	
       		 	} else if (select_val == 'cron'){//自定义调度任务
        			$("#config_time").css('display','none'); 
         			$(".cron_ordinary").css('display','block'); 
         			
         			$('#config_time').val('');
        			 
        		} else if (select_val == 'manual'){//手动输入表达式
        			$("#config_time").css('display','block'); 
	    			$("#config_time").removeAttr("readonly");
	    			$(".cron_ordinary").css('display','none'); 
	    			
	       	 		$("#config_time").val('');
	    			$("#cron_tab").val(''); 
	    			
        			 
        		} else {//具体设置
	       	    	$(".cron_ordinary").css('display','none'); 
	   		    	$("#cron_tab").val(''); 
	   		    	
        			var url = $("#data-href-law").val();
	   	            var option = {'config_time': select_val}
	   	            $.post(url, option, function (data) {
		                 app.cron.ajax_select_data(data);
		            }, 'json');
	   	            
	   	        }
        	})
        },
           
        ajax_select_data :function(data){
        	$("#config_time").css('display','block'); 
        	$('#config_time').val(data.content);
        	$('#config_time').attr("readonly","readonly");
        }, 
        
        ajax_five :function(){
        	 $('#test').on('click', function (e) {
        		var url    = $("#data-href-five").val();
        		var cron_tab   = $("input[name='cron_tab']").val();
        		var config_time = $("input[name='config_time']").val();
        		
   	            var option = {
   	            	'cron_tab': cron_tab,
   	            	'config_time': config_time
   	            }
   	            $.post(url, option, function (data) {
	                 app.cron.ajax_five_data(data);
	            }, 'json');
   	            
        	})
        },
           
        ajax_five_data :function(data){
        	console.log(data);
        	if (data.state == 'success') {　
            	$('.help-block.cron-five').html('');
            	var date = new Date();
                if (data.content.length > 0) {
                	var opt = '<span class="help-block.cron-five">';
                    for (var i = 0; i < data.content.length; i++) {
                        opt +=data.content[i] + '<br>';
                    };
                    opt += '</span>';
                    $('.help-block.cron-five').append(opt);
                } 
        	} else {
        		 ecjia.admin.showmessage(data);
        	}

        }, 
    }
})(ecjia.admin, jQuery);
 
// end