// JavaScript Document
;(function (app, $) {
    app.push_action = {
            init: function () {
                $("input[name='target']").click(function () {
                	$('.push_object').find('input').each(function(){
                		$(this).val('')
                	});
                	$('.push_object').find('select').each(function(){
                		$(this).html('').trigger("liszt:updated").trigger("change");
                	});
                	
                    var targetval = $(this).val();
                    if (targetval == 1) {//单播
                        $("#onediv").show().removeClass("hidden");
                        $("#admindiv").hide().addClass("hidden");
                        $("#userdiv").hide().addClass("hidden");
                        $("#merdiv").hide().addClass("hidden");
                    } else if (targetval == 'admin') {//管理员
                	    $("#onediv").hide().addClass("hidden");
                	    $("#admindiv").show().removeClass("hidden");
                        $("#userdiv").hide().addClass("hidden");
                        $("#merdiv").hide().addClass("hidden");
                    } else if (targetval == 'user') {//用户
                    	$("#onediv").hide().addClass("hidden");
                        $("#admindiv").hide().addClass("hidden");
                        $("#userdiv").show().removeClass("hidden");
                        $("#merdiv").hide().addClass("hidden");
                    } else if (targetval == 'merchant'){//商家用户
                    	$("#onediv").hide().addClass("hidden"); 
                    	$("#admindiv").hide().addClass("hidden");
                        $("#userdiv").hide().addClass("hidden");
                        $("#merdiv").show().removeClass("hidden");
                    } else {//广播
                    	$("#onediv").hide().addClass("hidden"); 
                    	$("#admindiv").hide().addClass("hidden");
                        $("#userdiv").hide().addClass("hidden");
                        $("#merdiv").hide().addClass("hidden");
                    }
                    $('#device_client').trigger("liszt:updated").trigger("click");
                });
                
                app.push_action.search_admin();
                app.push_action.search_user();
                app.push_action.search_mer_user();
            	app.push_action.ajax_event_select();
              	app.push_action.ajax_event_input();
                app.push_action.submit_info();
            },
            
            //搜索管理员
            search_admin : function () {
    			$('.searchAadmin').on('click',function(e){
    				var admin_keywords = $("input[name='admin_keywords']").val();
    				var searchURL = $('.searchAadmin').attr('data-url');
    				var option = {
    					'admin_keywords' : admin_keywords,
    				};
    				$.post(searchURL, option, function(data) {
    					app.push_action.admin_list(data);
    				}, "JSON");
    			});
    		},
    		admin_list : function (data) {
    			$('.admin_list').html('');
    			if (data.content.length > 0) {
    				for (var i = 0; i < data.content.length; i++) {
    					var opt_admin = '<option value="'+data.content[i].value+'">'+data.content[i].text+'</option>'
    					$('.admin_list').append(opt_admin);
    				};
    			} else {
    				$('.admin_list').append('<option value="0">未搜索到管理员信息</option>');
    			}
    			$('.admin_list').trigger("liszt:updated").trigger("change");
    		},
    		
    		
            //搜索会员
            search_user : function () {
    			$('.searchUser').on('click',function(e){
    				var user_keywords = $("input[name='user_keywords']").val();
    				var searchURL = $('.searchUser').attr('data-url');
    				var option = {
    					'user_keywords' : user_keywords,
    				};
    				$.post(searchURL, option, function(data) {
    					app.push_action.user_list(data);
    				}, "JSON");
    			});
    		},
    		user_list : function (data) {
    			$('.user_list').html('');
    			if (data.content.length > 0) {
    				for (var i = 0; i < data.content.length; i++) {
    					var opt_user = '<option value="'+data.content[i].value+'">'+data.content[i].text+'</option>'
    					$('.user_list').append(opt_user);
    				};
    			} else {
    				$('.user_list').append('<option value="0">未搜索到会员信息</option>');
    			}
    			$('.user_list').trigger("liszt:updated").trigger("change");
    		},
    		
    		
    		
    		//搜索商家会员
            search_mer_user : function () {
    			$('.searchMer').on('click',function(e){
    				var mer_keywords = $("input[name='mer_keywords']").val();
    				var searchURL = $('.searchMer').attr('data-url');
    				var option = {
    					'mer_keywords' : mer_keywords,
    				};
    				$.post(searchURL, option, function(data) {
    					app.push_action.merchant_user_list(data);
    				}, "JSON");
    			});
    		},
    		merchant_user_list : function (data) {
    			$('.merchant_user_list').html('');
    			if (data.content.length > 0) {
    				for (var i = 0; i < data.content.length; i++) {
    					var opt_mer = '<option value="'+data.content[i].value+'">'+data.content[i].text+'</option>'
    					$('.merchant_user_list').append(opt_mer);
    				};
    			} else {
    				$('.merchant_user_list').append('<option value="0">未搜索到商家会员信息</option>');
    			}
    			$('.merchant_user_list').trigger("liszt:updated").trigger("change");
    		},
            

            ajax_admin_list :function(data){
            	var object_list = data.object_data;
            	
            	var html = '<option value="0">请选择</option>';
                for (var i in object_list) {
                    var item = object_list[i];
                        html += '<option value="' + item.type + '">' + item.name + '</option>';
                }
                $('.object_html').html(html).show();
                $('select').trigger("liszt:updated");

                
                //点击下拉框触发相应的input
            	$("#object_value").change(function () {
            		var object_type = $("#object_value option:selected").val();
            		var device_code = $("input[type='radio']:checked").val();
	   	           	var url = $("#data-href-input").val();
	   	            var option = {'object_type' : object_type, 'device_code' : device_code};
	   	            $.post(url, option, function (data) {
	   	                app.push_action.ajax_event_input_data(data);
	   	            }, "JSON");
            	})
            }, 
     
            //获取下拉框值
            ajax_event_select :function(){           	   
            	$(".push_radio").change(function () {
            		var device_code = $("input[type='radio']:checked").val();
	   	           	var url = $("#data-href-delect").val();
	   	            var option = {'device_code' : device_code};
	   	            $.post(url, option, function (data) {
	   	                app.push_action.ajax_event_select_data(data);
	   	            }, "JSON");
            		
            	})
            },       
            ajax_event_select_data :function(data){
            	var object_list = data.object_data;
            	var html = '<option value="0">请选择</option>';
                for (var i in object_list) {
                    var item = object_list[i];
                        html += '<option value="' + item.type + '">' + item.name + '</option>';
                }
                $('.object_html').html(html).show();
                $('select').trigger("liszt:updated");
            }, 
            
            ajax_event_input :function() {
            	//点击下拉框触发相应的input
            	$("#object_value").change(function () {
            		var object_type = $("#object_value option:selected").val();
            		var device_code = $("input[type='radio']:checked").val();
	   	           	var url = $("#data-href-input").val();
	   	            var option = {'object_type' : object_type, 'device_code' : device_code};
	   	            $.post(url, option, function (data) {
	   	                app.push_action.ajax_event_input_data(data);
	   	            }, "JSON");
            	})
            },
            
            ajax_event_input_data :function(data){
            	var object_list = data.args_list;
            	$('.custom-div').remove();
            	var k = 0;
                var text = '<div class="custom-div">';
	                for (var i in object_list) {
	            		var li = object_list[i];
	            		var m_t = k == 0 ? 'm_t10' : '';
	                	text += '<div class="control-group '+ m_t +'">';
	                	text += '<label class="control-label">'+ li.name +'：</label>';
	                	text += '<div class="controls"><input type="text" class="span6" name="args['+ li.code +']">';
	                	if (li.description != null) {
	                		text += '<span class="help-block">'+ li.description+'</span>';
	                	}
	                	text += '</div>';
	                	text += '</div>';
	                	k++;
	                }
                text += '</div>'
                $('.open_action').append(text);
            },       
     
            submit_info: function () {
                var option = {
                    rules: {
                    	title: {
                            required: true
                        },
                        content: {
                            required: true
                        }
                    },
                    messages: {
                    	title: {
                            required: '消息主题不能为空！'
                        },
                        content: {
                            required: '消息内容不能为空！'
                        }
                    },
                    submitHandler: function () {
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
        };
 
})(ecjia.admin, jQuery);
 
// end