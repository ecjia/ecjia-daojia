// JavaScript Document
;(function (app, $) {
    app.push_template_list = {
        init: function () {
            app.push_template_list.data_table();
        },
 
        data_table: function () {
            $('#plugin-table').dataTable({
                "sDom": "<'row page'<'span6'<'dt_actions'>l><'span6'f>r>t<'row page pagination'<'span6'i><'span6'p>>",
                "sPaginationType": "bootstrap",
                "iDisplayLength": 15,
                "aLengthMenu": [15, 25, 50, 100],
                "aaSorting": [[2, "asc"]],
                "oLanguage": {
                    "oPaginate": {
                        "sFirst": js_lang.sFirst,
                        "sLast": js_lang.sLast,
                        "sPrevious": js_lang.sPrevious,
                        "sNext": js_lang.sNext,
                    },
                    "sInfo": js_lang.sInfo,
                    "sZeroRecords": js_lang.sZeroRecords,
                    "sEmptyTable": js_lang.sEmptyTable,
                    "sInfoEmpty": js_lang.sInfoEmpty,
                    "sInfoFiltered": js_lang.sInfoFiltered,
                },
                "aoColumns": [
                    {
                        "sType": "string"
                    },
                    {
                        "bSortable": false
                    },
                    {
                        "bSortable": false
                    }
                ],
                "fnInitComplete": function () {
                    $("select").not(".noselect").chosen({
                        add_class: "down-menu-language",
                        allow_single_deselect: true,
                        disable_search_threshold: 8
                    })
                },
            });
        },
 
    };
    
    app.push_template_test = {
            init: function () {
                $("input[name='target']").click(function () {
                	$('.push_object').find('input').each(function(){
                		$(this).val('')
                	});
                	$('.push_object').find('select').each(function(){
                		$(this).html('').trigger("liszt:updated").trigger("change");
                	});
                	
                    var targetval = $(this).val();
                    if (targetval == 'admin') {//管理员
                	    $("#admindiv").show().removeClass("hidden");
                        $("#userdiv").hide().addClass("hidden");
                        $("#merdiv").hide().addClass("hidden");
                    } else if (targetval == 'merchant'){//商家用户
                    	$("#merdiv").show().removeClass("hidden");
                    	$("#admindiv").hide().addClass("hidden");
                        $("#userdiv").hide().addClass("hidden");
                    } else {
                    	$("#userdiv").show().removeClass("hidden");
                	    $("#admindiv").hide().addClass("hidden");
                        $("#merdiv").hide().addClass("hidden");
                    }
                    $('#device_client').trigger("liszt:updated").trigger("click");
                });
                
                app.push_template_test.search_user();
                app.push_template_test.search_mer_user();
                app.push_template_test.search_admin();
            	app.push_template_test.submit_info();
            },
            
            //搜索会员
            search_user : function () {
            	$('#user_keywords').bind('keypress',function(event){ 
                    if(event.keyCode == 13) {  
                    	var user_keywords = $("input[name='user_keywords']").val();
        				var searchURL = $('.searchUser').attr('data-url');
        				var option = {
        					'user_keywords' : user_keywords,
        				};
        				$.post(searchURL, option, function(data) {
        					app.push_template_test.user_list(data);
        				}, "JSON");
        				return false;
                    } else {
                    	$('.searchUser').on('click',function(e){
                          	var user_keywords = $("input[name='user_keywords']").val();
            				var searchURL = $('.searchUser').attr('data-url');
            				var option = {
            					'user_keywords' : user_keywords,
            				};
            				$.post(searchURL, option, function(data) {
            					app.push_template_test.user_list(data);
            				}, "JSON");
            			});
                    }
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
    			$('#mer_keywords').bind('keypress',function(event){ 
                    if(event.keyCode == 13) {  
        				var mer_keywords = $("input[name='mer_keywords']").val();
        				var searchURL = $('.searchMer').attr('data-url');
        				var option = {
        					'mer_keywords' : mer_keywords,
        				};
        				$.post(searchURL, option, function(data) {
        					app.push_template_test.merchant_user_list(data);
        				}, "JSON");
        				return false;
                    } else {
                    	$('.searchMer').on('click',function(e){
            				var mer_keywords = $("input[name='mer_keywords']").val();
            				var searchURL = $('.searchMer').attr('data-url');
            				var option = {
            					'mer_keywords' : mer_keywords,
            				};
            				$.post(searchURL, option, function(data) {
            					app.push_template_test.merchant_user_list(data);
            				}, "JSON");
            			});
                    }
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

    		
    		
            //搜索管理员
            search_admin : function () {
    			$('#admin_keywords').bind('keypress',function(event){ 
                    if(event.keyCode == 13) {  
                    	var admin_keywords = $("input[name='admin_keywords']").val();
        				var searchURL = $('.searchAadmin').attr('data-url');
        				var option = {
        					'admin_keywords' : admin_keywords,
        				};
        				$.post(searchURL, option, function(data) {
        					app.push_template_test.admin_list(data);
        				}, "JSON");
        				return false;
                    } else {
                    	$('.searchAadmin').on('click',function(e){
                    		var admin_keywords = $("input[name='admin_keywords']").val();
            				var searchURL = $('.searchAadmin').attr('data-url');
            				var option = {
            					'admin_keywords' : admin_keywords,
            				};
            				$.post(searchURL, option, function(data) {
            					app.push_template_test.admin_list(data);
            				}, "JSON");
            			});
                    }
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
            
            submit_info: function () {
            	 var option = {
                     rules: {
                         mobile: {
                             required: true
                         }
                     },
                     messages: {
                     	mobile: {
                             required: "请输入手机号"
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
    
    
    app.push_template_info = {
            init: function () {
            	app.push_template_info.ajax_event();
                app.push_template_info.submit_info();
            },
     
            ajax_event :function(){
            	$("#template_code").change(function () {
        		    var subject_text = $("#template_code option:selected").text();
           		    var subject_val = $("#template_code option:selected").val();
           		    subject = subject_text.replace('['+ subject_val + ']',"");
           		    
            		if (subject_val != 0){
    	           		 $('#subject').val(subject);
    	   	           	 var url = $("#data-href").val();
    	   	             var filters = {
    	   	                 'JSON': {
    	   	                     'code': subject_val,
    	   	                     'channel_code': $("#channel_code").val(),
    	   	                 }
    	   	             };
    	   	             $.post(url, filters, function (data) {
    	   	                 app.push_template_info.ajax_event_data(data);
    	   	             }, "JSON");
            		} else {
            			 $('#subject').val('');
            			 $('#content').val('');
            			 $('.help-block').text('')
            		}
            	})
            },
                    
            ajax_event_data :function(data){
            	$('#content').val(data.template);
            	$('.help-block').html('');
                if (data.content.length > 0) {
                	var opt = '<span class="help-block">';
                    for (var i = 0; i < data.content.length; i++) {
                        opt +=data.content[i] + '<br>';
                    };
                    opt += '</span>';
                    $('.help-block').append(opt);
                } 
                
            },       
     
            submit_info: function () {
                var option = {
                    rules: {
                        subject: {
                            required: true
                        },
                        content: {
                            required: true
                        }
                    },
                    messages: {
                        subject: {
                            required: '消息主题不能为空！'
                        },
                        content: {
                            required: '模板内容不能为空！'
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