// JavaScript Document
;(function (app, $) {
    app.quickpay_list = {
        init: function () {
        	//开启买单
        	$("#ajaxopen").on('click', function (e) {
        		e.preventDefault();
        		var url = $(this).attr('href');
        		$.get(url, function (data) {
        			ecjia.merchant.showmessage(data);
        		}, 'json');
        	});
        	
        	//关闭买单
            $('#ajaxclose').on('click', function() {
                var $this = $(this);
                var message = $this.attr('data-msg');
                var url = $this.attr('data-href');
                if (message != undefined) {
                      smoke.confirm(message, function(e) {
                            if (e) {
                                  $.get(url, function(data){
                                        ecjia.merchant.showmessage(data);
                                  })
                            }
                      }, {ok:"确定", cancel:"取消"});
                }
            });

	    	 
        	//筛选功能
			$("form[name='selectFrom'] .screen-btn").on('click', function (e) {
				e.preventDefault();
				var activity_type = $("select[name='activity_type']").val();
				var url = $("form[name='searchForm']").attr('action');
				if (activity_type != '') {
	                   url += '&activity_type=' + activity_type;
	            }
                ecjia.pjax(url);
			});
        	 
	    	 
            //搜索功能
            $("form[name='searchForm'] .btn-primary").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var keywords = $("input[name='keywords']").val();
                if (keywords != '') {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
        }
    };
 
    app.quickpay_info = {
        init: function () {
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
        	 $("input[name='use_bonus_enabled']").click(function () {
        		 var use_bonus_enabled = $("input[name='use_bonus_enabled']:checked").val();
            	 if(use_bonus_enabled == 'open'){
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
                $.ajax({
                    url: searchurl,
                    dataType: "JSON",
                    type: "POST",
                    data: {
                        keyword: keyword,
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
                        message: "优惠范围是全部红包，不需要此操作",
                        state: "error",
                    }
                    ecjia.merchant.showmessage(data);
                    return;
                }
                var selResult = document.getElementById('result');
                if (selResult.value == 0) {
                    var data = {
                        message: "请先搜索相应的数据",
                        state: "error",
                    }
                    ecjia.merchant.showmessage(data);
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
                                message: "该选项已存在",
                                state: "error",
                            }
                            ecjia.merchant.showmessage(data);
                            break;
                        }
                    }
                }
                if (!exists) {
                    var html = '<li>' + name + '<input name="act_range_ext[]" type="hidden" value="' + id + '"/>' +
                        '&nbsp;<a href="javascript:;" class="delact"><i class="fa fa-minus-circle ecjiafc-red"></i></a></li>';
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
        	 $("input[name='use_integral_enabled']").click(function () {
        		 var use_integral_enabled = $("input[name='use_integral_enabled']:checked").val();
            	 if(use_integral_enabled == 'open'){
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
	                	required: "请输入买单名称"
	                },
	                activity_discount_value: {
	                    required: "请输入折扣价格"
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
	    }
  };
})(ecjia.merchant, jQuery);
 
// end