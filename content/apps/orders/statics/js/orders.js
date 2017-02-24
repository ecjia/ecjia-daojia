// JavaScript Document

;(function(app, $) {
	app.order = {
		init : function() {
			var html = $(".modal-header").children("h3").html();
			app.order.screen();
			app.order.searchform();
			app.order.batch_print();
			app.order.batch_operate();
//			app.order.operate();
			app.order.batchForm();
			app.order.tooltip();
		},
		
		tooltip : function(){
			$('span').tooltip({
				trigger : 'hover',
				delay : 0,
				placement : 'right'
			})
		},
		
		screen : function() {
			//筛选功能
			$(".screen-btn").on('click', function(e){
				e.preventDefault();
				var url = $("form[name='searchForm']").attr('action');
				var composite_status = $("#select-rank option:selected").val();
				if (composite_status != -1) {
					url += '&composite_status=' + composite_status;
				}
				ecjia.pjax(url);
			});
		},
		
		searchform : function() {
			//搜索功能
			$("form[name='searchForm']").on('submit', function(e){
				e.preventDefault();
				var url = $(this).attr('action');
				var keywords = $("input[name='keywords']").val();
				var merchant_keywords = $("input[name='merchant_keywords']").val();
				
				if (keywords != '') {
					url += '&keywords=' + keywords;
				}
				if (merchant_keywords != '') {
					url += '&merchant_keywords=' + merchant_keywords;
				}
				ecjia.pjax(url);
			});
		},
		
		batch_print : function() {
			//批量打印
			$(".batch-print").on("click", function(){
				var order_id = [];
				$(".checkbox:checked").each(function () {
					order_id.push($(this).val());
				});
				var url = $(this).attr("data-url") + "&order_id=" + order_id;
				window.open(url);
			});
		},
		
		batch_operate : function() {
			//批量操作备注
			$(".batch-operate").on('click', function(e){
				var order_id = [];
				$(".checkbox:checked").each(function () {
					order_id.push($(this).val());
				});
				if (order_id == '') {
					smoke.alert(js_lang.operate_order_required);
					return false;
				} else {
					$("input[name='order_id']").val(order_id);
					var operatetype = $(this).attr("data-operatetype")
					var url = $(".operate_note").attr("data-url") + '&' + operatetype + "=1&order_id=" + order_id;
					var action_note = $("#cancel_note").val();
					$.ajax({
						type: "POST",
						url: url,
						dataType: "json",
						success: function(data){
							if(data.result || (data.require_note && action_note=="")) {
								$(".lbi_action_note").val(action_note);
								app.order.operate_note(operatetype,data);
								$("input[name='batch']").val('1');
								$("input[name='order_id']").val(order_id);
								$('#operate').modal('show')
							} else {
								app.order.operate(operatetype);
							}
						}
					});
				}
			});
		},
		
		operate : function(operatetype) {
			//操作
			var order_id = [];
			if($(".order_id").val() == undefined ) {
				$(".checkbox:checked").each(function () {
					order_id.push($(this).val());
				});
				$("input[name='batch']").val('1');
				$("input[name='order_id']").val(order_id);
			} else {
				order_id = $(".order_id").val()
			}
			var action_note = $(".action_note").val();
			var url = $("form[name='orderpostForm']").attr("action");
			url += "&" + operatetype + "=1";
			if (operatetype == 'remove') {
				smoke.confirm(js_lang.remove_confirm, function(e){
					if (e) {
						$.ajax({
							type: "POST",
							url: url,
							data: {order_id : order_id, operation:operatetype,action_note:action_note},
							dataType: "json",
							success: function(data){
								ecjia.pjax(data.url , function(){
									ecjia.admin.showmessage(data);
								});
							}
						});
					}
                }, {
                    ok: js_lang.ok,
                    cancel: js_lang.cancel
                });
			} else {
				if ($("input[name='order_sn']").val()!=undefined) {
					url += "&order_sn=" + $("input[name='order_sn']").val();
				}
				$.ajax({
					type : "POST",
					url : url,
					data : {action_note:action_note , operation:operatetype , order_id:order_id },
					dataType: "json",
					success: function(data){
						if (data.url) {
							var pjaxurl = data.url;
						} else {
							var pjaxurl = $("#theForm").attr("data-pjax-url") || $("#listForm").attr("data-pjax-url");
						}
                        data.pjaxurl = pjaxurl
                        ecjia.admin.showmessage(data);
					}
				});
			}
		},
		operate_note : function (operatetype,data) {
			var html = $(".modal-header").children("h3").html();
			
			//用户填写备注的js控制
			$("#operate .modal-body").find("fieldset").children().not("div:eq(0)").not("div:last").addClass("ecjiaf-dn");
			$('.batchtype').val(operatetype);
			var arr = new Array();
            arr['confirm']  = js_lang.confirm;
            arr['pay']      = js_lang.pay;
            arr['unpay']    = js_lang.unpay;
            arr['prepare']  = js_lang.prepare;
            arr['unship']   = js_lang.unship;
            arr['receive']  = js_lang.receive;
            arr['cancel']   = js_lang.cancel;
            arr['invalid']  = js_lang.invalid;
            arr['after_service'] = js_lang.after_service;
            arr['return']   = js_lang.return_goods;
            arr['refund']   = js_lang.refund;

			$("#operate .modal-header").children("h3").html(html+arr[operatetype]);
			if(data != '') {
				if(data.show_cancel_note) {
					$(".show_cancel_note").removeClass("ecjiaf-dn")
				}
				if(data.show_invoice_no) {
					$(".show_invoice_no").removeClass("ecjiaf-dn")
				}
				if(data.show_refund) {
					$(".show_refund").removeClass("ecjiaf-dn")
				}
				if(data.anonymous) {
					$(".anonymous").removeClass("ecjiaf-dn")
				}
			}
			if (operatetype=='refund') {
				$(".show_refund").removeClass("ecjiaf-dn")
				$(".anonymous").removeClass("ecjiaf-dn")
			}
		},
		batchForm : function() {
			var $this = $("form[name='batchForm']");
			var batchtype = $('.batchtype').val();
			var order_id = [];
			if ($(".order_id").val() == undefined || $(".order_id").val() == "") {
				$(".checkbox:checked").each(function () {
					order_id.push($(this).val());
				});
				$("input[name='batch']").val('1');
				$("input[name='order_id']").val(order_id);
			} else {
				order_id = $(".order_id").val()
			}

			var option = {
				rules:{
					action_note : {
						required : true
					},
				},
				messages:{
					action_note : {
						required: js_lang.pls_input_note
					},
				},
				submitHandler:function(){
					app.order.submitbatch();
				}
			}

			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
			if(batchtype == 'cancel') {
				$("#cancel_note").rules("add",{ required : true,messages:{required : js_lang.pls_input_cancel}});
			}
			if(batchtype == 'cancel') {
				$("#cancel_note").rules("remove");
			}
		},
		submitbatch : function() {
			//表单提交
			$('#operate').modal('hide')
			var url = $("form[name='orderpostForm']").attr('action');
			var action_note = $(".lbi_action_note").val();
			var order_id = $("input[name='order_id']").val();
			if (order_id == "") {
				order_id = $(".order_id").val();
			}
			var batchtype = $("input[name='operation']").val();
			var msg = $(".batch-operate-" + batchtype).attr("data-"+batchtype+"-msg");
			if (msg != undefined) {
				var cannel_note = $("textarea[name='cancel_note']").val();
				smoke.confirm(msg,function(e){
					if (e) {
						$.ajax({
							type: "POST",
							url: url,
							data: {order_id : order_id , operation:batchtype,action_note:action_note,cancel_note : cannel_note},
							dataType: "json",
							success: function(data){
								ecjia.admin.showmessage(data);
							}
						});
					}
                }, {
                    ok: js_lang.ok,
                    cancel: js_lang.cancel
                });
			} else {
				var refund = $("input[name='refund']").val();
				var refund_note = $("textarea[name='refund_note']").val();
				var cannel_note = $("textarea[name='cancel_note']").val();
				$.ajax({
					type: "POST",
					url: url,
					data: {order_id : order_id , operation : batchtype , action_note : action_note ,cancel_note : cannel_note, refund : refund , refund_note : refund_note},
					dataType: "json",
					success: function(data){
						if(data.state == "success") {
							if (data.url) {
								var pjaxurl = data.url;
							} else {
								var pjaxurl = $("#theForm").attr("data-pjax-url");
							}
							ecjia.pjax(pjaxurl , function(){
								if (data.message) {
									ecjia.admin.showmessage(data);
								}
							});
						} else {
							 ecjia.admin.showmessage(data);
						}
					}
				});
			}
		},
		info : function() {
			html = $(".modal-header").children("h3").html();
			app.order.refund_click();
			app.order.refundsubmit();
			app.order.queryinfo();
			app.order.operatesubmit();
			app.order.batchForm();
		},

		//退款按钮
		refund_click : function() {
			$(".refund_click").on('click', function(e) {
				var url = $(this).attr("data-href");
				$.ajax({
					type: "POST",
					url: url,
					dataType: "json",
					success: function(data){
						$("#refund_amount").html(data.formated_refund_amount);
						$("input[name='refund_amount']").val(data.refund_amount);
						if (data.anonymous=='0') {
							$("#anonymous").removeClass('ecjiaf-dn');
						}
						$("#refund").modal('show');
					}
				});
			});
		},
		refundsubmit : function() {
			$("form[name='refundForm']").on('submit', function(e){
				e.preventDefault();
				$(this).ajaxSubmit({
					dataType:"json",
					success:function(data){
						$('#refund').modal('hide');
						ecjia.admin.showmessage(data);
					}
				});
			});
		},
		queryinfo : function() {
			$("form[name='queryinfo']").on('submit', function(e) {
				e.preventDefault();
				$(this).ajaxSubmit({
					dataType:"json",
					success:function(data){
						if(data.state == "success") {
							ecjia.pjax(data.url);
						} else {
							ecjia.admin.showmessage(data);
						}
					}
				});
			});
		},

		operatesubmit : function() {
			$(".operatesubmit").on('click', function(e){
				e.preventDefault();
				var order_id = $(".order_id").val();
				var operatetype = $(this).attr('name');
				var url = $(".operate_note").attr("data-url") + '&' + operatetype + "=1&order_id=" + order_id;
				var action_note = $(".action_note").val();
				$.ajax({
					type: "POST",
					url: url,
					dataType: "json",
					success: function(data){
						if(data.result || (data.require_note && action_note=="")) {
                            $(".lbi_action_note").val(action_note);
							app.order.operate_note(operatetype,data);
							$('#operate').modal('show')
						} else {
							app.order.operate(operatetype);
						}
					}
				});
			});
		},
		//以下为添加与编辑订单
		addedit : function() {
			$(":radio").click(function(){
				if ($(this).val() == 0) {
					$('.nav-list-ready li').removeClass('selected');
					$("input[name='user']").val(0);
				}
			});
			$(".goods_number").spinner({min:1});
			app.order.anonymous_user();
			app.order.searchUser();
			app.order.addUser();
			app.order.searchGoods();
//			$("#goodslist").on('change', app.order.change);
//			$("#userslist").on('change', app.order.userschange);
			app.order.goodsForm();
//			app.order.edit_goodsnumber();
			app.order.updateGoods();
			app.order.submitgoods();
//			app.order.consigneeForm();

			app.order.toggle_address();
			app.order.consigneelistForm();
			app.order.shippingForm();
			app.order.select_shipping();
//			app.order.paymentForm();
			app.order.otherForm();
			app.order.moneyForm();
			app.order.invoiceForm();
			app.order.cancel_order();
		},
		anonymous_user : function() {
			$('.anonymous_user').on('click',function(e){
				e.preventDefault();
				var url = $(this).attr('data-href');
				$.get(url,function(data){
					if(data.state == "success") {
						var url = data.url;
						ecjia.pjax(url);
					} else {
						ecjia.admin.showmessage(data);
					}
				})
			})

		},
		searchUser : function() {
			$(".searchUser").on('click', function() {
				var id_name = $("input[name='keywords']").val();
				var url = $("form[name='userForm']").attr('data-search-url');
				$.ajax({
					type: "POST",
					url: url,
					data: {id_name:id_name},
					dataType: "json",
					success: function(data){
						$('.nav-list-ready').html('');
						if (data.user.length > 0) {
							for (var i = 0; i < data.user.length; i++) {
								var disable = $('.nav-list-content .ms-elem-selection').find('input[value="' + data.user[i].value + '"]').length ? 'disabled' : '';
								var opt = '<li class="ms-elem-selectable ' + disable + '" id="articleId_' + data.user[i].value + '" data-id="' + data.user[i].value + '"><span>' + data.user[i].text + '</span></li>'
								$('.nav-list-ready').append(opt);
							};
						} else {
							$('.nav-list-ready').html('<li class="ms-elem-selectable disabled"><span>' + js_lang.select_user_empty + '</span></li>');
						}
						$(".users_info").addClass("ecjiaf-dn");
						app.order.search_opt();
						app.order.click_search_user();
					}
				});
			});
		},
		search_opt : function() {
			//li搜索筛选功能
			$('#ms-search').quicksearch(
				$('.ms-elem-selectable', '#ms-custom-navigation' ),
				{
					onAfter : function(){
						$('.ms-group').each(function(index) {
							$(this).find('.isShow').length ? $(this).css('display','block') : $(this).css('display','none');
						});
						return;
					},
					show: function () {
						this.style.display = "";
						$(this).addClass('isShow');
					},
					hide: function () {
						this.style.display = "none";
						$(this).removeClass('isShow');
					},
				}
			);
		},
		click_search_user : function() {
			$('.order-select-users li').on('click', function() {
				if ($("input:radio:checked").val() == 1){
					$("input:radio:checked").parent().removeClass('uni-checked');
					$("input:radio[id='user_useridname']").attr('checked',true).parent().addClass('uni-checked');
				}
				var $this = $(this);
				$('.nav-list-ready li').removeClass('selected');
				var user_id = $this.attr('data-id');
				if (user_id == undefined) {
					return false;
				}
				$("input[name='user']").val(user_id);
				$this.addClass('selected');
				var url = $("#userslist").attr("data-change-url");

				$.ajax({
					type : "post",
					url  : url,
					data : {user_id : user_id},
					dataType : "json",
					success : function(data){
						if (data.state =='success') {
							var user = data.user;
							$("#user_name").html(user.user_name);
							$("#user_email").html(user.email);
							$("#user_mobile").html(user.mobile_phone);
							$("#user_rank").html(user.user_rank);
							$("#user_regtime").html(user.reg_time);
							$("#user_isvalidated").html(user.is_validated);
							$("#user_lasttime").html(user.last_login);
							$("#user_lastip").html(user.last_ip);
							$(".users_info").removeClass("ecjiaf-dn");
						} else {
							$(".users_info").addClass("ecjiaf-dn");
							ecjia.admin.showmessage(data);
						}
					}
				});
			});
		},
		addUser : function() {
			$("form[name='userForm']").on('submit', function(e){
				e.preventDefault();
				if (app.order.checkUser()) {
					$(this).ajaxSubmit({
						dataType:"json",
						success:function(data) {
							if(data.state == "success") {
								var url = data.url;
								ecjia.pjax(url);
							} else {
								ecjia.admin.showmessage(data);
							}
						}
					});
				}
			});
		},
		checkUser : function() {
			/* 如果搜索会员，检查是否找到 */
			if ($("input[name='user']").val()<1) {
				var data = {
					message : js_lang.pls_search_user,
					state : "error",
				};
				ecjia.admin.showmessage(data);
				return false;
			}
			return true;
		},
		searchGoods : function() {
			$(".searchGoods").on('click', function(e){
				var keyword = $("input[name='keyword']").val();
				var url = $("form[name='goodsForm']").attr('data-search-url');
				$.ajax({
					type: "POST",
					url: url,
					data: {keyword:keyword},
					dataType: "json",
					success: function(data){
						$(".goods_info").addClass('ecjiaf-dn');
						$('.nav-list-ready').html('');
						if (data.goods.length > 0) {
							for (var i = 0; i < data.goods.length; i++) {
								var disable = $('.nav-list-content .ms-elem-selection').find('input[value="' + data.goods[i].value + '"]').length ? 'disabled' : '';
								var opt = '<li class="ms-elem-selectable ' + disable + '" id="articleId_' + data.goods[i].value + '" data-id="' + data.goods[i].value + '"><span>' + data.goods[i].text + '</span></li>'
								$('.nav-list-ready').append(opt);
							};
						} else {
							$('.nav-list-ready').html('<li class="ms-elem-selectable disabled"><span>' + js_lang.select_goods_empty + '</span></li>');
						}
						app.order.search_opt();
						app.order.click_search_goods();
					}
				});
			});
		},
		click_search_goods : function() {
			$('.order-select-goods li').on('click', function() {
				if ($(this).attr('data-id') > 0) {
					$('.nav-list-ready li').removeClass('selected');
					$("input[name='goodslist']").val($(this).attr('data-id'));
					$(this).addClass('selected');
					app.order.change($(this).attr('data-id'));
				}
			});
		},
		change : function(goods_id) {
			var url = $("#goodslist").attr("data-change-url");
			var goods_id = goods_id;
			$.ajax({
				type : "post",
				url  : url,
				data : {goods_id : goods_id},
				dataType : "json",
				success : function(data){
					var goods = data.goods
					/*给商品赋值*/
					$("#goods_name").html("<a href="+goods.preview_url+" target='_blank' title='"+goods.goods_name+"'>" + goods.short_goods_name + "</a>");
					$("#goods_sn").text(goods.goods_sn);
					$("#goods_cat").text(goods.cat_name);
					$("#goods_number").html(goods.goods_number);
					goods.brand_name = goods.brand_name == null ? js_lang.no_brand_name : goods.brand_name.trim()=='' ? js_lang.no_brand_name : goods.brand_name;
					var img = '<img src="'+ goods.goods_img + '" class="w130"/>'
					$("#goods_img").html(img);
					// 显示价格：包括市场价、本店价（促销价）、会员价
					var priceHtml = '<input type="radio" name="add_price" value="' + goods.market_price + '" /><span>' + js_lang.market_price + ' [' + goods.market_price + ']</span><br />' +
									'<input type="radio" name="add_price" value="' + goods.goods_price + '" checked /><span>' + js_lang.goods_price + ' [' + goods.goods_price + ']</span><br />';
					if(goods.user_price != null) {
						for (var i = 0; i < goods.user_price.length; i++) {
							priceHtml += '<input type="radio" name="add_price" value="' + goods.user_price[i].user_price + '" />' + goods.user_price[i].rank_name + ' [' + goods.user_price[i].user_price + ']<br />';
						}
					}
					priceHtml += '<div><input type="radio" name="add_price" value="user_input" /><span>' + js_lang.custom_price + '</span>&nbsp;&nbsp;<input class="w100" type="text" name="input_price" value="" /></div>';
					$("#add_price").html(priceHtml);
					/*显示商品属性*/
					// 显示属性
					var specCnt = 0; // 规格的数量
					var attrHtml = ''; //不用选择的规格
					var selattrHtml = '';//需要选择的规格
					var attrType = '';
					var attrTypeArray = '';
					var attrCnt = goods.attr_list.length;
					for (i = 0; i < attrCnt; i++) {
						var valueCnt = goods.attr_list[i].length;
						// 规格
						if (valueCnt > 1) {
							selattrHtml += "<div class='control-group control-group-small'><label class='control-label'>"+goods.attr_list[i][0].attr_name + '：</label><div class="goods_attr_sel controls">';
							for (var j = 0; j < valueCnt; j++) {
								switch (goods.attr_list[i][j].attr_type) {
									case 0 :
									case 1 :
										attrType = 'radio';
										attrTypeArray = '';
										break;
									case 2 :
									attrType = 'checkbox';
									attrTypeArray = '[]';
									break;
								}
								selattrHtml += '<div><input type="' + attrType + '" name="spec_' + specCnt + attrTypeArray + '" value="' + goods.attr_list[i][j].goods_attr_id + '"';
								if (j == 0) {
									selattrHtml += ' checked';
								}
								selattrHtml += ' />' + goods.attr_list[i][j].attr_value;
								if (goods.attr_list[i][j].attr_price > 0) {
									selattrHtml += ' [+' + goods.attr_list[i][j].attr_price + ']';
								} else if (goods.attr_list[i][j].attr_price < 0) {
									selattrHtml += ' [-' + Math.abs(goods.attr_list[i][j].attr_price) + ']';
								}
								selattrHtml += '</div>';
							}
							selattrHtml += '</div></div>';
							specCnt++;
						} else {
							// 属性
							attrHtml += goods.attr_list[i][0].attr_name + '：' + goods.attr_list[i][0].attr_value + '<br/>';
						}
					}
					$("input[name='spec_count']").val(specCnt);
					$("#goods_attr").html(attrHtml.trim()=="" ? js_lang.no_other_attr : attrHtml);
					$("#sel_goodsattr").html(selattrHtml);
					$("input[type='radio'],input[type='checkbox']").uniform();
					$(".goods_info").removeClass('ecjiaf-dn');
				}
			});
		},
		goodsForm : function() {
			$(".add-goods").on('click',function(e){
				/*验证添加订单商品*/
				var $this = $("form[name='goodsForm']");
				var option = {
					 submitHandler:function(){
						 app.order.submitGoodsForm($this);
					 }
				}
				var options = $.extend(ecjia.admin.defaultOptions.validate, option);
				$this.validate(options);
				$this.submit();
			})
		},
		submitGoodsForm : function(obj) {
			obj.ajaxSubmit({
				dataType:"json",
				success:function(data){
					if (data.state == "success") {
						ecjia.pjax(data.url , function() {
							ecjia.admin.showmessage(data);
						});
					} else {
						ecjia.admin.showmessage(data);
					}
				}
			});
		},
		updateGoods : function() {
			/*验证更新订单商品*/
			var $this = $("form[name='theForm']");
			var option = {
				 submitHandler:function(){
					 app.order.submitTheForm($this);
				 }
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
		},
		submitTheForm : function(obj) {
			var url = $("form[name='goodsForm']").attr('data-goods-url');
			obj.ajaxSubmit({
				dataType:"json",
				success:function(data){
					if (data.state == "success") {
						if (data.url) {
							ecjia.pjax(data.url , function() {
								ecjia.admin.showmessage(data);
							});
						} else {
							ecjia.pjax(url , function() {
								ecjia.admin.showmessage(data);
							});
						}
					} else {
						ecjia.admin.showmessage(data);
					}
				}
			});
		},
		submitgoods : function() {
			$("form[name='submitgoodsForm']").on('submit', function(e){
				e.preventDefault();
				if (app.order.checkGoods()) {
					/*添加订单商品页下一步pjax效果*/
					$(this).ajaxSubmit({
						dataType:"json",
						success:function(data) {
							if(data.state == "success") {
								var url = data.url;
								ecjia.pjax(url);
							} else {
								ecjia.admin.showmessage(data);
							}
						}
					});
				}
			});
		},
		checkGoods : function() {
			var eles = document.forms['theForm'].elements;
			if (eles.length>0) {
				if (eles['goods_count'].value <= 0){
					var data = {
						message: js_lang.not_add_goods,
						state : "error",
					};
					ecjia.admin.showmessage(data);
					return false;
				}
				return true;
			} else {
				var data = {
					message: js_lang.not_add_goods,
					state : "error",
				};
				ecjia.admin.showmessage(data);
				return false;
			}
		},
		toggle_address: function() {
			$("input[name='user_address']").on('change',function(){
				if ($(this).val() =='-1') {
					$("#add_address").show("normal");
				} else {
					$("#add_address").hide("normal");
				}
			})
		},
		consigneelistForm : function() {
			var $this = $("form[name='consigneeForm']");

				var option = {
					rules : {
						consignee 	: {required : true},
						email		: {required : true},
						tel			: {required : true},
						address		: {required : true},
						city		: {required : true}
					},
					messages : {
						consignee: {
	                        required: js_lang.consignee_required
	                    },
	                    email: {
	                        required: js_lang.email_required
	                    },
	                    tel: {
	                        required: js_lang.tel_required
	                    },
	                    address: {
	                        required: js_lang.address_required
	                    },
	                    city: {
	                        required: js_lang.city_required
	                    }
					},
					submitHandler:function(){
						app.order.submitConsigneeForm($this);
					}
				}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
		},
		submitConsigneeForm : function(obj) {
			obj.ajaxSubmit({
				dataType:"json",
				success:function(data){
					if (data.state == "success") {
						var url = data.url;
						ecjia.pjax(url);
					} else {
						ecjia.admin.showmessage(data);
					}
				}
			});
		},
		shippingForm : function() {
			$("form[name='shippingForm']").on('submit', function(e){
				e.preventDefault();
				if (app.order.checkShipping() && app.order.checkPayment()) {
					$(this).ajaxSubmit({
						dataType:"json",
						success:function(data) {
							if(data.state == "success") {
								var url = data.url;
								ecjia.pjax(url);
							} else {
								ecjia.admin.showmessage(data);
							}
						}
					});
				}
			});
		},
		checkShipping : function() {
			if ($("#exist_real_goods").attr('data-real')=="true") {
				if (!$("input[name='shipping']:radio").is(':checked')) {
					var data = {
						message: js_lang.shipping_required,
						state: "error",
					};
					ecjia.admin.showmessage(data);
					return false;
				}
			}
			return true;
		},
		select_shipping : function() {
			$("input[name='shipping']").on('change',function(){
				var is_cod = $(this).attr("data-cod")=='0';
				if (is_cod) {
					$("input[name='payment']").each(function(i){
						if ($(this).attr("data-cod")=='1') {
							$(this).attr('checked',false)
							$(this).attr('disabled',true);
						}
					});
				} else {
					$("input[name='payment']").each(function(i){
						if ($(this).attr("data-cod")=='1') {
							$(this).attr('disabled',false);
						}
					});
				}
				$.uniform.update && $.uniform.update($('input[name="payment"]'));
			});
			if ($("input[name='payment']:radio").is(':checked')) {
				var is_cod = $("input[name='payment']:checked").attr("data-cod")=='0';
				if (is_cod) {
					$("input[name='payment']").each(function(i){
						if ($(this).attr("data-cod")=='1') {
							$(this).attr('checked',false)
							$(this).attr('disabled',true);
						}
					});
				} else {
					$("input[name='payment']").each(function(i){
						if ($(this).attr("data-cod")=='1') {
							$(this).attr('disabled',false);
						}
					});
				}
				$.uniform.update && $.uniform.update($('input[name="payment"]'));
			}
		},
		checkPayment : function() {
			if (!$("input[name='payment']:radio").is(':checked')) {
                var data = {
                    message: js_lang.payment_required,
                    state: "error",
                };
				ecjia.admin.showmessage(data);
				return false;
			}
			return true;
		},
		/*其他信息*/
		otherForm : function() {
			$("form[name='otherForm']").on('submit', function(e){
				e.preventDefault();
				$(this).ajaxSubmit({
					dataType:"json",
					success:function(data){
						if (data.state == "success") {
							var url = data.url;
							ecjia.pjax(url);
						} else {
							ecjia.admin.showmessage(data);
						}
					}
				});
			});
		},
		/*验证money 信息*/
		moneyForm : function() {
			var $this = $("form[name='moneyForm']");
			var option = {
					submitHandler:function(){
						$this.ajaxSubmit({
							dataType:"json",
							success:function(data){
								if (data.state == "success") {
									var url = data.url;
									ecjia.pjax(url);
								} else {
									ecjia.admin.showmessage(data);
								}
							}
						});
					}
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
		},

		invoiceForm : function() {
			$("form[name='invoiceForm']").on('submit', function(e){
				e.preventDefault();
				if (app.order.checkShipping()) {
					$(this).ajaxSubmit({
						dataType:"json",
						success:function(data) {
							if(data.state == "success") {
								var url = data.url;
								ecjia.pjax(url);
							} else {
								ecjia.admin.showmessage(data);
							}
						}
					});
				}
			});
		},

		cancel_order : function() {
			$(".cancel_order").on('click', function(e){
				e.preventDefault();
				var url = $(".cancel_order").attr("data-href");
				$.ajax({
					type : "get",
					url  : url,
					dataType : "json",
					success : function(data){
						ecjia.pjax(data.url);
					}
				});
			});
		},
		//生成发货单
		delivery_info : function() {
			app.order.deliveryForm();
		},
		/* 给表单加入submit事件 */
		deliveryForm : function() {
			$("form[name='deliveryForm']").on('submit', function(e){
				e.preventDefault();
				$(this).ajaxSubmit({
					dataType:"json",
					success:function(data){
						if (data.state == "success") {
							ecjia.pjax(data.url , function(){
								ecjia.admin.showmessage(data);
							});
						} else {
							ecjia.admin.showmessage(data);
						}
					}
				});
			});
		},
	};

})(ecjia.admin, jQuery);

// end