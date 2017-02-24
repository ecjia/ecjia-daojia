// JavaScript Document
;(function(app, $) {
	app.commission = {
		init : function() {
			app.commission.theForm();
			app.commission.percent_form();
			app.commission.get_shop_name();
			app.commission.search();
		},
		
		theForm : function() {
			var $form = $("form[name='theForm']");
			var option = {
				rules : {
					suppliers_percent : {required : true}
				},
				messages : {
					suppliers_percent : {required : "请选择佣金比例！"}
				},
				submitHandler : function() {
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
		},
		
		percent_form : function() {
			var $form = $("form[name='percent_form']");
			var option = {
				rules : {
					percent_value : {required : true}
				},
				messages : {
					percent_value : {required : "请输入奖励额度！"}
				},
				submitHandler : function() {
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
		},
		
		get_shop_name : function() {
			$('.show_div').css('display','none');
			$("select[name='merchants_name']").on('change', function(e) {
				$('.shop_name').html('');
				e.preventDefault();
				var $choose_list = $('.choose_list'),
				searchURL = $choose_list.attr('data-url');
				var filters = {
					'JSON' : {
						'user_id' : $("select[name='merchants_name'] option:selected").val()
					}
				};
				$.get(searchURL, filters, function(data) {
					app.commission_info.load_shop_name(data);
				}, "JSON");
			});
		},
		load_shop_name : function(data) {
			$('.shop_name').html('');
			if (data.content.value || data.content.text) {
				$('.show_div').css('display','block');
				var opt = '<span>'+data.content.value+data.content.text+'</span>';
				$('.shop_name').append(opt);
			} else {
				$('.show_div').css('display','none');
			}
		},
		search : function() {
			$(".start_time,.end_time").datepicker({
				format: "yyyy-mm-dd",
				container : '.main_content',
			});
			$("form[name='searchForm']").on('submit', function(e) {
				e.preventDefault();
				var start_time = $("input[name='start_time']").val();
				var end_time = $("input[name='end_time']").val();
				if(start_time ==''){
					var mesObj = new Object ();
			        mesObj.state   = 'error';
				    mesObj.message = '请输入开始时间！';
				    ecjia.admin.showmessage(mesObj);
					return;
				}
				
				if(end_time ==''){
					var mesObj = new Object ();
			        mesObj.state   = 'error';
				    mesObj.message = '请输入结束时间！';
				    ecjia.admin.showmessage(mesObj);
					return;
				}
				
				if (start_time != '' && end_time != '') {
					if (start_time >= end_time) {
						var mesObj = new Object ();
				        mesObj.state   = 'error';
					    mesObj.message = '开始时间不能超于结束时间！';
					    ecjia.admin.showmessage(mesObj);
						return;
					}
				}
				var url = $("form[name='searchForm']").attr('action');
				ecjia.pjax(url + '&start_time=' + start_time + '&end_time=' + end_time);
			});
		},
	};
	
})(ecjia.admin, jQuery);

// end