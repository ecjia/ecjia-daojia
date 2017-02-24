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
						message : "还没有选择完需要合并的订单哦！",
						state : "error",
					};
					ecjia.merchant.showmessage(data);
					return false;
				}
				if (to_order_sn == from_order_sn){
					var data = {
						message : "要合并的两个订单号不能相同！",
						state : "error",
					};
					ecjia.merchant.showmessage(data);
					return false;
				}
				smoke.confirm('你确定要合并这两个订单吗？',function(e){
					if (e) {
						$("form[name='theForm']").ajaxSubmit({
							dataType:"json",
							success:function(data){
								if (data.state == "success") {
									var url = $("form[name='theForm']").attr('data-pjax-url');
									ecjia.pjax(url , function(){
										ecjia.merchant.showmessage(data);
									});
								} else {
									ecjia.merchant.showmessage(data);
								}	
							}
						});
					}	
				}, {ok:'确定', cancel:'取消'});
			});
		},
	};
	
})(ecjia.merchant, jQuery);

// end