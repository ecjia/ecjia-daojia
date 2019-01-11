// JavaScript Document
;(function (app, $) {
    app.bulk_goods_info = {
        init: function () {
        	$(".date").datepicker({
				format: "yyyy-mm-dd"
			});
        	//获取截止日期
        	$(".generate-date").blur(function(){
         		 var $this = $(this);
         		 var url = $this.attr('action');
                 var generate_date = $this.val();
                 if (generate_date) {
                	 $('input[name="generatedate"]').val(generate_date);
                 }
                 var limitday = $('input[name="limitdays"]').val();
                 var unit = $('input[name="dayunit"]').val();
                 var data = {
             		  produce_date:generate_date,
             		  limit_days: limitday,
             		  limit_unit: unit
                 }
                 if (generate_date && limitday && unit) {
                 	  $.post(url, data, function (data) {
       	      			if (data.state == 'error') {
       	                 ecjia.admin.showmessage(data);
       	                } 
       	               	if (data.status == 1) {
       	               		$('input[name="expiry_date"]').val(data.expiry_date);
       	               	}
       	            }, 'json');
                 }
              });
        	//获取截止日期
        	$(".limitday").blur(function(){
        		 var $this = $(this);
        		 var url = $this.attr('action');
                 var limitday = $this.val();
                 var unit = $('input[name="dayunit"]').val();
                 var generate_date = $('input[name="generatedate"]').val();
                 if (limitday) {
               	  	$('input[name="limitdays"]').val(limitday);
                 }
                 var data = {
              		   produce_date:generate_date,
              		   limit_days: limitday,
              		   limit_unit: unit
                 }
                 if (generate_date && limitday && unit) {
              	   $.post(url, data, function (data) {
    	      			 if (data.state == 'error') {
    	                 	ecjia.admin.showmessage(data);
    	                 } 
    	               	 if (data.status == 1) {
    	               		$('input[name="expiry_date"]').val(data.expiry_date);
    	               	 }
    	             }, 'json');
                 }
             });
        	app.bulk_goods_info.set_allprice_note();
        	app.bulk_goods_info.add_volume_price();
        	app.bulk_goods_info.toggle_promote();
            app.bulk_goods_info.marketPriceSetted();
            app.bulk_goods_info.expire_date();
            app.bulk_goods_info.submit_info();
        },
        marketPriceSetted: function() {
			$('[data-toggle="marketPriceSetted"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					price = $('[name="market_price"]').val(),
					options = {
						price: price,
						marketRate: 1 / admin_goodsList_lang.marketPriceRate,
						integralPercent: admin_goodsList_lang.integralPercent,
						shopPriceObj: $('[name="shop_price"]'),
						integralObj: $('[name="integral"]')
					};
				app.bulk_goods_info.computePrice(options);
				app.bulk_goods_info.set_allprice_note();
			})
		},
		computePrice: function(options) {
			// 计算商店价格
			var shopPrice = $.trim(options.price) != '' ? (parseFloat(options.price) * options.marketRate).toString() : '0';
			shopPrice = shopPrice.lastIndexOf(".") > -1 ? shopPrice.substr(0, shopPrice.lastIndexOf(".") + 3) : shopPrice;
			options.marketPriceObj && options.marketPriceObj.val(shopPrice);
			options.shopPriceObj && options.shopPriceObj.val(shopPrice);
			// 是否计算积分
			if (options.integralObj && options.integralPercent) {
				var integral = $.trim(options.price) != '' ? (parseFloat(options.price) * options.integralPercent / 100).toString() : '0';
				integral = integral.lastIndexOf(".") > -1 ? integral.substr(0, integral.lastIndexOf(".") + 3) : integral;
				options.integralObj.val(integral);
			}
		},
		set_allprice_note: function() {
			if (admin_goodsList_lang.user_rank_list) {
				for (var i = admin_goodsList_lang.user_rank_list.length - 1; i >= 0; i--) {
					var options = {
						shop_price: $('[name="shop_price"]').val() || $('[name="market_price"]').val(),
						discount: admin_goodsList_lang.user_rank_list[i].discount || 100,
						rank_id: admin_goodsList_lang.user_rank_list[i].rank_id,
					};
					app.bulk_goods_info.set_price_note(options);
				};
			}
		},
		set_price_note: function(options) {
			if (options.shop_price > 0 && options.discount && $('#rank_' + options.rank_id)) { // && parseInt($('#rank_' + options.rank_id).val()) == -1
				var price = parseInt(options.shop_price * options.discount + 0.5) / 100;
				$('#nrank_' + options.rank_id).length && $('#nrank_' + options.rank_id).html('(' + price + ')');
			} else {
				$('#nrank_' + options.rank_id).length && $('#nrank_' + options.rank_id).html('(' + js_lang.not_calculate + ')')
			}
		},
		add_volume_price: function() {
			$('.add_volume_price').on('click', function(e) {
				e.preventDefault();
				$(this).parent().find('.fontello-icon-plus').trigger('click');
			});
		},
		toggle_promote: function() {
			$('.toggle_promote').on('change', function(e) {
				e.preventDefault();
				$(this).is(":checked") == true ? $('#promote_1').prop('disabled', false) : $('#promote_1').attr('disabled', true);
			})
		},
		
		//获取截止日期
		expire_date: function () {
        	$('select[name="limit_days_unit"]').off('change').on('change', function () {
          		   var $this = $(this);
                   var url = $this.attr('action');
                   var unit = $this.val();
                   var limit_day = $('input[name="limitdays"]').val();
                   var generate_date = $('input[name="generatedate"]').val();
                   
                   $('input[name="dayunit"]').val(unit);
                   
                   var data = {
                		   produce_date:generate_date,
                		   limit_days: limit_day,
                		   limit_unit: unit
                   }
                   if (generate_date && limit_day && unit) {
                	   $.post(url, data, function (data) {
      	      			 if (data.state == 'error') {
      	                 	ecjia.admin.showmessage(data);
      	                 } 
      	               	 if (data.status == 1) {
      	               		$('input[name="expiry_date"]').val(data.expiry_date);
      	               	 }
      	             }, 'json');
                   }
               });
        },        
		submit_info: function() {
			$('button[type="submit"]').on('click', function() {
				$form = $('form[name="theForm"]');
				var option = {
					rules: {
						goods_name: {
							required: true
						},
						goods_sn: {
							required: true
						},
						shop_price: {
							required: true,
							min: 0
						},
						weight_stock: {
							required: true,
							min: 0
						},
						merchant_cat_id: {
							required: true,
							min: 1
						}
					},
					messages: {
						goods_name: {
							required: js_lang.goods_name_required
						},
						goods_sn: {
							required: js_lang.goods_sn_required
						},
						shop_price: {
							required: js_lang.shop_price_required,
							min: js_lang.shop_price_limit
						},
						weight_stock: {
							required: js_lang.weight_stock_required,
							min: js_lang.goods_number_limit
						},
						merchant_cat_id: {
							required: js_lang.category_id_select,
							min: js_lang.category_id_select
						}
					},
					submitHandler: function() {
						$form.ajaxSubmit({
							dataType: "json",
							success: function(data) {
								if (data.message) {
									ecjia.merchant.showmessage(data);
								} else {
									ecjia.pjax(data.url);
								}
							}
						});
					}
				}
				var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
				$form.validate(options);
			})
		},
    };
    
})(ecjia.merchant, jQuery);
 
// end