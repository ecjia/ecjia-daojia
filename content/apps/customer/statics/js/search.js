// JavaScript Document
;
(function(app, $) {
	var batch_url;
	var batch_type_url;
	var batch_assign_url;
	var batch_share_url;
	
	
    app.search = {
        init: function() {
        	batch_url = $("a[name=change_source_ture]").attr("data-url");
        	batch_type_url = $("a[name=change_type_ture]").attr("data-url");
        	batch_assign_url = $("a[name=assign_customer_ture]").attr("data-url");
        	batch_share_url = $("a[name=share_customer_ture]").attr("data-url");
        	
        	app.search.insert();
            app.search.search_source();
            app.search.toggle_view();
            app.search.change_source();
            app.search.change_type();
            app.search.assign_customer();
            app.search.share_customer();
            app.search.submit_share();
        },
        insert: function() {
        	$('.screen-btn').on('click', function(e) {
    			e.preventDefault();
//    			var customer_fields	= $("select[name='customer_fields']").val(); //自定义字段
    			var keywords		= $("input[name='keywords']").val(); 		//关键字
    			var url				= $("form[name='theForm']").attr('action'); //请求链接
//    			if(customer_fields	== 'undefined')customer_fields ='';
    			if(keywords		    == 'undefined')keywords ='';
    			if(url        		== 'undefined')url ='';
    			ecjia.pjax(url + '&keywords=' + keywords);
    		});
        },
        search_source: function() {
        	$('.btn-select').on('click', function(e) {
    			e.preventDefault();
    			var view			= $("select[name='view']").val(); //类别
    			var type_customer	= $("select[name='type_customer']").val(); //类别
    			var source_customer	= $("select[name='source_customer']").val(); //来源
    			var url				= $("form[name='searchForm']").attr('action'); //请求链接
    			if(type_customer	== 'undefined')type_customer ='';
    			if(source_customer	== 'undefined')source_customer ='';
    			if(url        		== 'undefined')url ='';
    			ecjia.pjax(url + '&type_customer=' + type_customer  + '&source_customer=' + source_customer + '&view=' + view);
    		});
        },
        common_search: function() {
        	$('.screen-btn').on('click', function(e) {
    			e.preventDefault();
    			var keywords		= $("input[name='keywords']").val(); 		//关键字
    			var type_customer	= $("select[name='type_customer']").val(); //类别
//    			var source_customer	= $("select[name='source_customer']").val(); //来源
    			var url				= $("form[name='searchForm']").attr('action'); //请求链接
    			if(keywords		    == 'undefined')keywords ='';
    			if(type_customer	== 'undefined')type_customer ='';
//    			if(source_customer	== 'undefined')source_customer ='';
    			if(url        		== 'undefined')url ='';
    			ecjia.pjax(url + '&keywords=' + keywords + '&type_customer=' + type_customer);
    		});
        },
        toggle_view: function(option) {
            $('.toggle_view').on('click', function(e) {
                e.preventDefault();
                var $this = $(this);
                var href = $this.attr('href');
                var val = $this.attr('data-val') || 'quit';
                var option = {href: href, val: val};
                var url = option.href;
                var val = {change: option.val};
                var msg = $this.attr("data-msg");
                if (msg) {
                    smoke.confirm(msg, function(e) {
                        if (e) {
                            $.get(url, val, function(data) {
                                var url = $this.attr("data-pjax-url");
                                ecjia.pjax(url, function() {
                                    ecjia.admin.showmessage(data);
                                });
                            }, 'json');
                        }
                    }, {ok: '确定', cancel: '取消'});
                } else {
                    $.get(url, val, function(data) {
                        var url = $this.attr("data-pjax-url");
                        ecjia.pjax(url, function() {
                            ecjia.admin.showmessage(data);
                        });
                    }, 'json');
                }
            });
        },
        change_source : function() {
			$(".batch-change-customer-source").on('click', function(e) {
				var checkboxes = [];
				$(".checkbox:checked").each(function() {
					checkboxes.push($(this).val());
				});
				if (checkboxes == '') {
					smoke.alert("请选择需要修改的客户");
					return false;
				} else {
					$('#movetype').modal('show');
					
				}
			});
			$("a[name=change_source_ture]").on('click', function(e) {
				$('#movetype').modal('hide');
				$(".modal-backdrop").remove();
			});
			$("select[name=customer_source]").on('change', function(e) {
				var customer_source = $(this).val();
				$("a[name=change_source_ture]").attr("data-url",batch_url+'&customer_source='+customer_source);
			});
		},
	  change_type : function() {
			$(".batch-change-customer-type").on('click', function(e) {
				var checkboxes = [];
				$(".checkbox:checked").each(function() {
					checkboxes.push($(this).val());
				});
				if (checkboxes == '') {
					smoke.alert("请选择需要修改的客户");
					return false;
				} else {
					$('#move_customer_type').modal('show');
					
				}
			});
			$("a[name=change_type_ture]").on('click', function(e) {
				$('#move_customer_type').modal('hide');
				$(".modal-backdrop").remove();
			});
			$("select[name=customer_type]").on('change', function(e) {
				var customer_type = $(this).val();
				$("a[name=change_type_ture]").attr("data-url",batch_type_url+'&customer_type='+customer_type);
			});
		},
		assign_customer : function() {
			$(".batch-assign-customer").on('click', function(e) {
				var checkboxes = [];
				$(".checkbox:checked").each(function() {
					checkboxes.push($(this).val());
				});
				if (checkboxes == '') {
					smoke.alert("请选择需要指派的客户");
					return false;
				} else {
					$('#batch_assign_customers_model').modal('show');
					
				}
			});
			$("a[name=assign_customer_ture]").on('click', function(e) {
				$('#batch_assign_customers_model').modal('hide');
				$(".modal-backdrop").remove();
			});
			$("select[name=customer_assign]").on('change', function(e) {
				var customer_assign = $(this).val();
				var reason = $("textarea[name=reason]").val();
				var send_email = $("input[name=send_email_notice]").val();
				$("a[name=assign_customer_ture]").attr("data-url",batch_assign_url+'&customer_assign='+customer_assign+'&reason='+reason+'&send_email='+send_email);
			});
			$("textarea[name=reason]").on('change', function(e) {
				var customer_assign = $("select[name=customer_assign]").val();
				var reason = $(this).val();
				var send_email = $("input[name=send_email_notice]").val();
				$("a[name=assign_customer_ture]").attr("data-url",batch_assign_url+'&customer_assign='+customer_assign+'&reason='+reason+'&send_email='+send_email);
			});
		},
		share_customer : function() {
			$(".batch-share-customer").on('click', function(e) {
				var checkboxes = [];
				$(".checkbox:checked").each(function() {
					checkboxes.push($(this).val());
				});
				if (checkboxes == '') {
					smoke.alert("请选择需要分享的客户");
					return false;
				} else {
					$('#share-customers').modal('show');
					
				}
			});
			$("a[name=share_customer_ture]").on('click', function(e) {
				$('#share-customers').modal('hide');
				$(".modal-backdrop").remove();
			});
			$("select[name=share]").on('change', function(e) {
				var share = $(this).val();
				$("a[name=share_customer_ture]").attr("data-url",batch_share_url+'&share='+share);
			});
		},
		submit_share: function () {
			$('.customer_single_share').on('click', function (e) {
				var id = $(this).attr('customer_id');
				$('#customer_new_id').attr('value',id);
				$('#movetype_share').modal('show');
				/* 给表单加入submit事件 */
				var $form = $("form[name='shareForm']");
				var option = {
					submitHandler : function() {
						$('#movetype_share').modal('hide');//点击确认时隐藏框
						$(".modal-backdrop").remove();
						$form.ajaxSubmit({
							dataType : "json",
							success : function(data) {
								ecjia.admin.showmessage(data);
							}
						});
					}
				}
				var options = $.extend(ecjia.admin.defaultOptions.validate, option);
				$form.validate(options);
			});
		},
    };
})(ecjia.admin, jQuery);

// end
