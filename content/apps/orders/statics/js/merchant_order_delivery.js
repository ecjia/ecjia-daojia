// JavaScript Document
;(function(app, $) {
	app.order_delivery = {
		init : function() {
			app.order_delivery.screen();
			app.order_delivery.searchform();
			app.order_delivery.consignee_info();
		},
		screen : function() {
			//筛选功能
			$(".screen-btn").on('click', function(e){
				e.preventDefault();
				var url = $("form[name='searchForm']").attr('action') + '&status=' + $("#select-rank option:selected").val();
				ecjia.pjax(url);
			});
		},
		searchform : function() {
			//搜索功能
			$("form[name='searchForm']").on('submit', function(e){
				e.preventDefault();
				var url = $("form[name='searchForm']").attr('action') + '&keywords=' +$("input[name='keywords']").val() + '&delivery_sn='+$("input[name='delivery_sn']").val();
				ecjia.pjax(url);
			});
		},
		consignee_info : function() {
			$(".consignee_info").on('click',function(){
				var url = $(this).attr("data-url");
				$.ajax({
					type: "POST",
					url: url,
					dataType: "json",
					success: function(data){
						if (data.state=="error") {
							ecjia.merchant.showmessage(data); 
						} else {
							$("#consignee").html(data.consignee);
							$("#email").html(data.email);
							$("#address").html("["+data.region+"] "+data.address);
							$("#zipcode").html(data.zipcode);
							$("#tel").html(data.tel);
							$("#mobile").html(data.mobile);
							$("#building").html(data.sign_building);
							$("#shipping_best_time").html(data.best_time);
							$('#consignee_info').modal('show')
						}
					}
				});
				
			})
		},
		info : function() {
			app.order_delivery.deliveryForm();
		},
		deliveryForm : function() {
			$("form[name='deliveryForm']").on('submit', function(e){
				e.preventDefault();
				$(this).ajaxSubmit({
					dataType:"json",
					success:function(data){
						ecjia.merchant.showmessage(data);
					}
				});
			});
		},
		back_init : function() {
			app.order_delivery.back_searchform();
			app.order_delivery.consignee_info();
		},
		back_searchform : function() {
			//搜索功能
			$("form[name='searchForm']").on('submit', function(e){
				e.preventDefault();
				var url = $("form[name='searchForm']").attr('action') + '&keywords=' +$("input[name='keywords']").val() + '&delivery_sn='+$("input[name='delivery_sn']").val();
				ecjia.pjax(url);
			});
		},
	}
	
})(ecjia.merchant, jQuery);

// end