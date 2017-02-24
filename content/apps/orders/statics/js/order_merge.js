// JavaScript Document
;(function(app, $) {
	app.order_merge = {
		init : function() {
			/* 给表单加入submit事件 */
			$('#from_list').on('change', app.order_merge.change);
			$('#to_list').on('change', app.order_merge.change);
			app.order_merge.theFormsubmit();
		},
		
		change : function() {
			var from_list = $("#from_list").val();
			$("#from_order_sn").val(from_list);
			
			var to_list = $("#to_list").val();
			$("#to_order_sn").val(to_list);
		},
		
		theFormsubmit : function() {
			/* 给表单加入submit事件 */
			$('form[name="theForm"]').on('submit', function(e){
				e.preventDefault();
				/*获取主订单*/
				var to_order_sn = $("#to_order_sn").val();
				/*获取从订单*/
				var from_order_sn = $("#from_order_sn").val();
				if (to_order_sn == "" || from_order_sn == ""){
					var data = {
						message: js_lang.merge_order_required,
						state : "error",
					};
					ecjia.admin.showmessage(data);
					return false;
				}
				smoke.confirm(js_lang.confirm_merge, function(e){
					if (e) {
						$("form[name='theForm']").ajaxSubmit({
							dataType:"json",
							success:function(data){
								if (data.state == "success") {
									var url = $("form[name='theForm']").attr('data-pjax-url');
									ecjia.pjax(url , function(){
										ecjia.admin.showmessage(data);
									});
								} else {
									ecjia.admin.showmessage(data);
								}	
							}
						});
					}	
                }, {
                    ok: js_lang.ok,
                    cancel: js_lang.cancel
                });
			});
		},
	};
	
})(ecjia.admin, jQuery);

// end