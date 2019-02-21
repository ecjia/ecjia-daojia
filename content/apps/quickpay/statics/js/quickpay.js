// JavaScript Document
;(function (app, $) {
    app.quickpay_list = {
        init: function () {
            /* 列表搜索传参 */
            $("form[name='searchForm'] .search_quickpay").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var keyword = $("input[name='keyword']").val();
                var merchant_name = $("input[name='merchant_name']").val();
                if (merchant_name != '') {
                	url += '&merchant_name=' + merchant_name;
                }
                if (keyword != '') {
                	url += '&keyword=' + keyword;
                }
                ecjia.pjax(url);
            });
        },
    }

    app.quickpay_info = {
            init: function () {
            	$('.info-toggle-button').toggleButtons({
            		label: {  
            	         enabled: js_lang.btn_open,  
            	         disabled: js_lang.btn_close 
            	    },  
            	    style: {
            	        enabled: "info",
            	        disabled: "success"
            	    }
            	});
            	
                $(".date").datepicker({
                    format: "yyyy-mm-dd",
                });

                $(".tp_1").datetimepicker({
    				format: "hh:ii",
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 1,
                    forceParse: 0,
                    minuteStep: 5
    			});
                
                $('.fontello-icon-plus').click(function(e) {
    				setTimeout(function () { 
    					$(".tp_1").datetimepicker({
    						format: "hh:ii",
    		                weekStart: 1,
    		                todayBtn: 1,
    		                autoclose: 1,
    		                todayHighlight: 1,
    		                startView: 1,
    		                forceParse: 0,
    		                minuteStep: 5
    					});
    					
    					$(".date").datepicker({
    		                format: "yyyy-mm-dd",
    		            });
    					
    			    }, 1);
    			});

                app.quickpay_info.activity_type_change();
                app.quickpay_info.time_type_change();
                app.quickpay_info.use_bonus_enabled_change();
                app.quickpay_info.select_bonus_change();
                app.quickpay_info.bonus_plus();
                app.quickpay_info.bonus_remove();
                app.quickpay_info.use_integral_enabled_change();
                app.quickpay_info.submit_form();
                
            },
            
            //买单优惠类型处理
            activity_type_change: function () {
        	   $("#activity_type").change(function () {
                   $(this).children().each(function (i) {
                       $("#activity_type_" + $(this).val()).hide();
                       $("#activity_type_" + $(this).val() +" :input").each(function () {
                           $(this).val("");
                       });
                       $("#activity_type_" + $(this).val() +" :input").each(function () {
                           $(this).attr("disabled",true);
                       });
                   })
                   $("#activity_type_" + $(this).val()).show();
                   $("#activity_type_" + $(this).val() +" :input").each(function () {
                       $(this).attr("disabled",false);
                   });
               });
            },
            
            
            //时间类型处理
            time_type_change: function () {
        	   $("#limit_time_type").change(function () {
                   $(this).children().each(function (i) {
                       $("#limit_time_type_" + $(this).val()).hide();
                   })
                   $("#limit_time_type_" + $(this).val()).show();
               });
            },

            
            //开启和关闭是否使用红包抵现
            use_bonus_enabled_change: function () {
            	 $("input[name='use_bonus_enabled']").change(function () {
            		 var use_bonus_enabled = $("input[name='use_bonus_enabled']:checked").val();
                	 if(use_bonus_enabled == 'on'){
                		 $("#use_bonus_select").attr("disabled",false); 
                		 $("#use_bonus_select").trigger("liszt:updated");
                		 $("#keyword").attr("disabled",false);
                		 $("#search").attr("disabled",false);
                	 }else{
                		 $("#use_bonus_select").attr("disabled","disabled");
                		 $("#use_bonus_select").trigger("liszt:updated");
                		 $("#keyword").attr("disabled","disabled");
                		 $("#search").attr("disabled","disabled");
                	 }
            	 })
            },
            
            //获取商家所有红包列表
            select_bonus_change: function () {
                $("#search").on('click', function () {
                    var keyword = document.forms['theForm'].elements['keyword'].value;
                    var searchurl = $(this).attr('data-url');
                    var store_id = $("input[name='store_id']").val()
                    $.ajax({
                        url: searchurl,
                        dataType: "JSON",
                        type: "POST",
                        data: {
                            keyword: keyword,
                            store_id: store_id,
                        },
                        success: function (data) {
                            app.quickpay_info.searchResponse(data);
                        }
                    });
                });
            	
            },
            
            //进行返回的红包列表处理，放入页面中
            searchResponse: function (data) {
                if (data.state == 'success' && data.content) {
                    var $selectbig = $('#selectbig');
                    $selectbig.show();
                    var bonus = data.content;
                    var tmpobj = '';
                    var $select = $('form[name="theForm"] select[name="result"]');
                    for (i = 0; i < bonus.length; i++) {
                        if (bonus[i].level) {
                            tmpobj += '<option value=' + bonus[i].type_id + ' style=padding-left:' + bonus[i].level * 20 + 'px>' + bonus[i].type_name + '</option>';
                        } else {
                            tmpobj += '<option value=' + bonus[i].type_id + ' >' + bonus[i].type_name + '</option>';
                        }
                    }
                    $select.html(tmpobj);
                    $select.trigger("liszt:updated");
                }
            },
            
            //选择可以同时参加买单的红包（可多选）
            bonus_plus: function () {
                $("#result").on('click', function () {
                    var selRange = document.forms['theForm'].elements['use_bonus_select'];
                    if (selRange.value == 0) {
                        var data = {
                            message: js_lang.bouns_range_no,
                            state: "error",
                        }
                        ecjia.admin.showmessage(data);
                        return;
                    }
                    var selResult = document.getElementById('result');
                    if (selResult.value == 0) {
                        var data = {
                            message: js_lang.please_search,
                            state: "error",
                        }
                        ecjia.admin.showmessage(data);
                        return;
                    }
                    var id = selResult.options[selResult.selectedIndex].value;
                    var name = selResult.options[selResult.selectedIndex].text;
                    var exists = false;
                    var eles = document.forms['theForm'].elements;
                    for (var i = 0; i < eles.length; i++) {
                        if (eles[i].type == "hidden" && eles[i].name.substr(0, 13) == 'act_range_ext') {
                            if (eles[i].value == id) {
                                exists = true;
                                var data = {
                                    message: js_lang.option_exists,
                                    state: "error",
                                }
                                ecjia.admin.showmessage(data);
                                break;
                            }
                        }
                    }
                    if (!exists) {
                        var html = '<li>' + name + '<input name="act_range_ext[]" type="hidden" value="' + id + '"/>' +
                            '&nbsp;<a href="javascript:;" class="delact"><i class="fontello-icon-minus-circled ecjiafc-red"></i></a></li>';
                        $("#range-div").show().append(html);
                        app.quickpay_info.bonus_remove();
                    }
                });
            },
            
            //移除所选择的红包
            bonus_remove: function () {
                $(".delact").on('click', function () {
                    $(this).parents("li").remove();
                });
            },	
            
            
            //开启和关闭是否使用积分抵现
            use_integral_enabled_change: function () {
            	 $("input[name='use_integral_enabled']").change(function () {
            		 var use_integral_enabled = $("input[name='use_integral_enabled']:checked").val();
                	 if(use_integral_enabled == 'on'){
                		 $("#use_integral_select").attr("disabled",false); 
                		 $("#use_integral_select").trigger("liszt:updated");
                		 $("#integral_keyword").attr("disabled",false);
                	 }else{
                		 $("#use_integral_select").attr("disabled","disabled");
                		 $("#use_integral_select").trigger("liszt:updated");
                		 $("#integral_keyword").attr("disabled","disabled");
                		 $("#integral_keyword").val("");
                	 }
            	 })
            },
            
    	    submit_form: function (formobj) {
    	        var $form = $("form[name='theForm']");
    	        var option = {
    	            rules: {
    	            	title: {
    	                    required: true
    	                },
    	                activity_discount_value: {
    	                    required: true
    	                }
    	            },
    	            messages: {
    	                title: {
    	                	required: js_lang.please_enter_name
    	                },
    	                activity_discount_value: {
    	                	required: js_lang.please_enter_price
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
    	    }
      };
    
})(ecjia.admin, jQuery);
 
// end