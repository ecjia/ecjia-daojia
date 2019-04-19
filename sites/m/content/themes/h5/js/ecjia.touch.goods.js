/**
 * 后台综合js文件
 */
;
(function (ecjia, $) {
	ecjia.touch.category = {
		init: function () {
			ecjia.touch.category.openSelection();
			ecjia.touch.category.selectionValue();
			ecjia.touch.category.clear_filter();
			ecjia.touch.category.goods_show();

			ecjia.touch.category.add_tocart();
			ecjia.touch.category.remove_tocart();
			ecjia.touch.category.change_num();

			ecjia.touch.category.toggle_cart();
			ecjia.touch.category.toggle_category();
			ecjia.touch.category.scroll();
			ecjia.touch.category.deleteall();
			ecjia.touch.category.toggle_checkbox();
			ecjia.touch.category.check_cart();

			ecjia.touch.category.check_goods(); //购物车列表 单选多选切换
			ecjia.touch.category.cart_edit(); //购物车列表编辑
			ecjia.touch.category.store_toggle();
			ecjia.touch.category.promotion_scroll();
			ecjia.touch.category.image_preview();

			ecjia.touch.category.add_goods();
			ecjia.touch.category.remove_goods();
			ecjia.touch.category.check_groupbuy_cart();

			//分类列表 点击分类切换 滚动到顶部
			$('.category_left li').on('click', function () {
				$(window).scrollTop(0);
			});
			$('body').css('overflow-y', 'auto').off("touchmove").off('click'); //启用滚动条
			$(".ecjia-store-goods .a1n .a1x").css({
				overflow: "auto"
			}); //启用滚动条

			ecjia.touch.category.follow_store();
		},

		//加入购物车
		add_tocart: function () {
			$("[data-toggle='add-to-cart']").off('click').on('click', function (ev) {
				var $this = $(this);
				if ($this.hasClass('disabled') || $this.parents('.item-goods').hasClass('disabled') || $this.hasClass('limit_click')) {
					return false;
				}
				var rec_id = $this.attr('rec_id');
				var goods_id = $this.attr('goods_id');
				// var product_id = $this.attr('product_id');
				$("[data-toggle='add-to-cart']").addClass('limit_click');
				$("[data-toggle='remove-to-cart']").addClass('limit_click');

				//选择商品规格
				if ($this.hasClass('add_spec')) {
					var spec = [];
					$this.parents('.ecjia-attr-modal').find('.goods-attr-list').find('li.active').each(function () {
						spec.push($(this).attr('data-attr'));
					});
					$this.parents('.ecjia-attr-modal').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
					var store_id = $('input[name="store_id"]').val();

					//加入购物车
					var val = 1;
					//加 按钮
					if ($this.hasClass('add')) {
						val = parseInt($this.siblings('label').html()) + 1;
					}
					if (spec.length == 0) {
						spec = [0];
					}
					ecjia.touch.category.update_cart(rec_id, val, goods_id, '', store_id, spec, 'add');
					return false;
				}
				var bool_spec = false; //购物车中判断是否是有属性的商品
				//购物车列表商品数量加减
				if ($this.hasClass('ecjia-number-group-addon')) {
					$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');

					var val = parseInt($this.siblings('input').val()) + 1;
					$this.siblings('input').val(val);
					var store_id = $this.parent().attr('data-store');

					ecjia.touch.category.update_cart(rec_id, val, goods_id, '', store_id, '', 'add');
				} else {
					//商品详情中点击加入购物车按钮
					if ($this.hasClass('goods-add-cart')) {
						$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
						var show = $this.parent().children('.ecjia-goods-plus-box');
						var val = parseInt(show.children('label').html());
					} else {
						if ($this.hasClass('attr_spec')) {
							bool_spec = true;
						}
						//商品详情页面购物车里加减
						if ($this.hasClass('a5v')) {
							$('.minicart-content').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
							var val = parseInt($this.prev().html()) + 1;
							$this.prev().html(val);
							$('#goods_' + goods_id).children('label').html(val);
						} else {
							//商品详情中商品数量加减按钮、猜你喜欢点击加号
							var show = $this.parent('.box').children('label');
							if (show.html() != '') {
								var val = parseInt(show.html()) + 1;
							} else {
								var val = 1;
							}
							var img = $this.parent().parent().find('img').attr('src');
							if (img != undefined) {
								var offset = $('.store-add-cart .a4x').offset(),
									flyer = $('<img class="u-flyer" src="' + img + '" alt="" style="width:50px;height:50px;">');
							} else {
								$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
							}
						}
						if (offset != undefined && flyer != undefined) {
							flyer.fly({
								start: { // 开始时位置
									left: ev.pageX - 40,
									top: ev.pageY - $('body').scrollTop() - 40
								},
								end: { // 结束时位置
									left: offset.left,
									top: offset.top - $('body').scrollTop() + 60,
									width: 0,
									height: 0,
								},
								vertex_Rtop: 50,
								onEnd: function () { // 回调方法
									!$('.store-add-cart').hasClass('active') && $('.store-add-cart').addClass('active');
									$('img.u-flyer').remove();
								}
							});
						}
					}
					//商品详情点击加入购物车val为1，点击加号val递增，点击猜你喜欢val为NaN，点击店铺首页加号val递增，点击店铺搜索商品结果列表加号val递增
					if (isNaN(val) || val == 0) {
						if ($this.attr('data-num') != 0 && $this.attr('data-num') != undefined) {
							val = parseInt($this.attr('data-num')) + 1;
						} else {
							val = 1;
						}
						$this.attr('data-num', val);
					} else {
						if ($.find('.may_like_' + goods_id)) {
							$('.may_like_' + goods_id).attr('data-num', val);
						}
					}
					var goods_activity_id = $this.attr('act_id');
					ecjia.touch.category.update_cart(rec_id, val, goods_id, '', true, bool_spec, 'add', '', goods_activity_id);
				}
			});
		},

		//加按钮点击
		add_goods: function () {
			$("[data-toggle='add-goods']").off('click').on('click', function (ev) {
				var $this = $(this);
				$('.check_groupbuy_cart').removeClass('disabled');

				$('.check_groupbuy_cart').attr('data-num', 1);
				if ($this.hasClass('detail-add')) {
					var val = parseInt($this.parent().children('label').html());
					val += 1;
					$('.check_groupbuy_cart').attr('data-num', val);
					$this.parent().children('label').html(val);
				} else {
					var box = $this.siblings('.box');
					box.removeClass('hide');
					$this.addClass('hide');
				}

				//显示价格
				var goods_id = $('.goods-add-cart').attr('goods_id');
				var deposit = $('.goods-price-new').attr('data-deposit');
				var price = $('.goods-price-new').attr('data-price');
				var formated_price = '';
				var num = val;
				if (val == 0 || val == undefined) {
					num = 1;
				}
				if (deposit != 0 && deposit != undefined) {
					formated_price = '￥' + (deposit * num).toFixed(2);
				} else {
                    var price_ladder = $('.goods-price-new').attr('data-priceladder');
                    price_ladder = eval(price_ladder);
                    price = calc_price(num, price_ladder, price);
					formated_price = '￥' + (price * num).toFixed(2);
				}
				$('.a4z').addClass('m_l1').html('<div>' + formated_price + '</div>');
			});
		},

		remove_goods: function () {
			$("[data-toggle='remove-goods']").off('click').on('click', function (ev) {
				var $this = $(this);
				var val = parseInt($this.parent().children('label').html());
				val -= 1;

				$('.check_groupbuy_cart').attr('data-num', val);
				if (val != 0) {
					$this.parent().children('label').html(val);
				} else {
					$this.parent().children('label').html(1);
					$('.check_groupbuy_cart').addClass('disabled');
					$this.parent().addClass('hide');
					$('.goods-add-cart').removeClass('hide');

					$('.a4z').removeClass('m_l1').html('');
					return false;
				}

				//显示价格
				var goods_id = $('.goods-add-cart').attr('goods_id');
				var deposit = $('.goods-price-new').attr('data-deposit');
				var price = $('.goods-price-new').attr('data-price');
				var formated_price = '';
				var num = val;
				if (val == 0 || val == undefined) {
					num = 1;
				}
				if (deposit != 0 && deposit != undefined) {
					formated_price = '￥' + (deposit * num).toFixed(2);
				} else {
                    var price_ladder = $('.goods-price-new').attr('data-priceladder');
                    price_ladder = eval(price_ladder);
                    price = calc_price(num, price_ladder, price);
					formated_price = '￥' + (price * num).toFixed(2);
				}
				$('.a4z').addClass('m_l1').html('<div>' + formated_price + '</div>');
			});
		},

		//购物车中移出商品
		remove_tocart: function () {
			$("[data-toggle='remove-to-cart']").off('click').on('click', function (ev) {
				var $this = $(this);
				if ($this.hasClass('disabled') || $this.parents('.item-goods').hasClass('disabled') || $this.hasClass('limit_click')) {
					return false;
				}
				$("[data-toggle='add-to-cart']").addClass('limit_click');
				$("[data-toggle='remove-to-cart']").addClass('limit_click');

				var rec_id = $this.attr('rec_id');
				//选择商品规格
				if ($this.hasClass('remove_spec')) {
					var spec = [];
					$this.parents('.ecjia-attr-modal').find('.goods-attr-list').find('li.active').each(function () {
						spec.push($(this).attr('data-attr'));
					});
					$this.parents('.ecjia-attr-modal').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
					var store_id = $('input[name="store_id"]').val();
					var val = parseInt($this.siblings('label').html()) - 1;
					var goods_id = $this.attr('goods_id');
                    if (spec.length == 0) {
                        spec = [0];
                    }
					ecjia.touch.category.update_cart(rec_id, val, goods_id, '', store_id, spec, 'reduce');
					return false;
				}

				if ($this.hasClass('ecjia-number-group-addon')) {
					$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
					var val = parseInt($this.siblings('input').val()) - 1;
					if (val == 0) {
						var store_id = $this.parent().attr('data-store');
						var li = $this.parents('.item-goods');

						ecjia.touch.category.update_cart(rec_id, '', '', '', store_id, '', 'reduce', li);
					} else {
						$this.siblings('input').val(val);
						var store_id = $this.parent().attr('data-store');
						ecjia.touch.category.update_cart(rec_id, val, '', '', store_id, '', 'reduce');
					}
				} else {
					var bool_spec = false;
					if ($this.hasClass('attr_spec')) {
						bool_spec = true;
					}

					if ($this.hasClass('a5u')) {
						var goods_id = $this.parent('.box').children('.a5v').attr('goods_id');
						// var product_id = $this.parent('.box').children('.a5v').attr('product_id');
						$('.minicart-content').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
						var val = parseInt($this.next().html()) - 1;
						if (val == 0) {
							if ($('.minicart-goods-list').children('li').length == 0) {
								$('.store-add-cart').removeClass('active');
								$('.store-add-cart').children('.a4x').removeClass('light').addClass('disabled').children('.a4y').remove();
								$('.store-add-cart').children('.a4z').children('div').addClass('a50').html(js_lang.cart_empty);
								$('.store-add-cart').children('.a51').addClass('disabled').html(js_lang.go_settlement);
								ecjia.touch.category.hide_cart(true);
							}
							$('#goods_' + goods_id).children('.reduce').removeClass('show').addClass('hide');
							$('#goods_' + goods_id).children('label').removeClass('show').addClass('hide');
							$('#goods_' + goods_id).children('span').attr('rec_id', '');

							//显示商品详情页的移除购物车按钮
							var span_add = $('#goods_' + goods_id).siblings('span');
							if (span_add.hasClass('goods-add-cart')) {
								$('#goods_' + goods_id).children('span').addClass('hide');
								span_add.removeClass('hide').addClass('disabled');
							}
						} else {
							$this.next().html(val);
						}
						$('#goods_' + goods_id).children('label').html(val);
					} else {
						$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
						var show = $this.parent('.box').children('label');
						var span = $this.parent('.box').children('span');
						var val = parseInt(show.html()) - 1;
						if (val == 0) {
							span.attr('rec_id', '');
							var span_add = $this.parent().siblings('span');
							show.html(1);
						} else {
							show.html(val);
						}
						var goods_id = $this.parent('.box').children('.add').attr('goods_id');
					}

					if ($.find('.may_like_' + goods_id)) {
						if (val == 0) {
							$('.may_like_' + goods_id).removeAttr('rec_id');
						}
						$('.may_like_' + goods_id).attr('data-num', val);
					}

					ecjia.touch.category.update_cart(rec_id, val, goods_id, '', true, bool_spec, 'reduce');
				}
			});
		},

		change_num: function () {
			$("[data-toggle='change-number']").off('click').on('click', function (e) {
				var $this = $(this),
					val = $this.attr('goods_num'),
					goods_id = $this.attr('goods_id'),
					rec_id = $this.attr('rec_id');
				$('.ecjia-num-view').find('input[name="value"]').val(val);
				$('.ecjia-num-view').find('input[name="old_value"]').val(val);
				$('.ecjia-num-view').find('input[name="rec_id"]').val(rec_id);
				$('.ecjia-num-view').find('input[name="goods_id"]').val(goods_id);
				$('.ecjia-num-content').addClass('show');
				$('.ecjia-num-view').find('input[name="value"]').focus();
			});

			$('.ecjia-num-view .addNum').off('click').on('click', function (e) {
				var val = parseInt($('.ecjia-num-view').find('input').val());
				val += 1;
				$('.ecjia-num-view').find('input[name="value"]').val(val);
			});

			$('.ecjia-num-view .minusNum').off('click').on('click', function (e) {
				var val = parseInt($('.ecjia-num-view').find('input[name="value"]').val());
				if (val == 1) {
					return false;
				}
				val -= 1;
				$('.ecjia-num-view').find('input[name="value"]').val(val);
			});

			$('.ecjia-num-view .btn-cancel').off('click').on('click', function (e) {
				$('.ecjia-num-content').removeClass('show');
			});

			$('.ecjia-num-view .btn-ok').off('click').on('click', function (e) {
				var $this = $(this),
					goods_id = $('.ecjia-num-view').find('input[name="goods_id"]').val(),
					rec_id = $('.ecjia-num-view').find('input[name="rec_id"]').val(),
					num = $('.ecjia-num-view').find('input[name="value"]').val(),
					old_value = parseInt($('.ecjia-num-view').find('input[name="old_value"]').val());
				if ($this.hasClass('disabled')) {
					return false;
				}
				$this.addClass('disabled');
				if (num == 0 || isNaN(num) || num == undefined) {
					$this.removeClass('disabled');
					alert(js_lang.quantity_out_range);
					return false;
				}
				if (parseInt(num) == old_value) {
					$this.removeClass('disabled');
					$('.ecjia-num-content').removeClass('show');
					return false;
				}
				$('.ecjia-num-view').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
				ecjia.touch.category.update_cart(rec_id, num, goods_id, '', '', '', '');
			});
		},

		//切换购物车 弹出/隐藏 效果
		toggle_cart: function () {
			$('.show_cart').off('click').on('click', function (e) {
				e.preventDefault();
				if ($(this).hasClass('disabled')) {
					return false;
				}
				var bool = $('.store-add-cart').find('.a4x').attr('show');
				if (bool) {
					ecjia.touch.category.show_cart();
					$(".ecjia-store-goods .a1n .a1x").css({
						overflow: "hidden"
					}); //禁用滚动条
				} else {
					ecjia.touch.category.hide_cart();
					$(".ecjia-store-goods .a1n .a1x").css({
						overflow: "auto"
					}); //启用滚动条	
				}
			});

			$('.a53').off('click').on('click', function (e) {
				e.preventDefault();
				ecjia.touch.category.hide_cart();
			});
		},


		//更新购物车
		//rec_id 订单id
		//goods_id 商品id
		//checked 是否选中
		//store 店铺id
		//spec 商品规格
		//type 加/减
		//div 删除指定div
		update_cart: function (rec_id, val, goods_id, checked, store, spec, type, div, act_id) {
			type = (type == undefined) ? '' : type;
			div = (div == undefined) ? '' : div;
			act_id = (act_id == undefined) ? 0 : act_id;

			var url = $('input[name="update_cart_url"]').val();
			var store_id = $('input[name="store_id"]').val();
			// var product_id = $('input[name="product_id"]').val();

			var response;
			if (store_id == undefined) {
				store_id = store;
				response = true; //直接返回
			}
			var info = {
				'val': val,
				'rec_id': rec_id,
				'store_id': store_id,
				'goods_id': goods_id == undefined ? 0 : goods_id,
				'checked': checked == undefined ? '' : checked,
				'response': response,
				'spec': spec,
				'act_id': act_id
			};

			//更新购物车中商品
			$.post(url, info, function (data) {
				$('.la-ball-atom').remove();
				$('.box').children('span').addClass('limit_click'); //禁止其他加减按钮点击
				$('[data-toggle="toggle_checkbox"]').removeClass('limit_click'); //店铺首页 允许其他单选框点击
				$("[data-toggle='add-to-cart']").removeClass('limit_click');
				$("[data-toggle='remove-to-cart']").removeClass('limit_click');

				$('.goods-add-cart').removeClass('disabled');
				$('.ecjia-num-view').find('.btn-ok').removeClass('disabled');

				if (data.state == 'error') {
					var myApp = new Framework7();

					$('.la-ball-atom').remove();
					if (data.referer_url || data.message == 'Invalid session') {
						$(".ecjia-store-goods .a1n .a1x").css({
							overflow: "hidden"
						}); //禁用滚动条
						//禁用滚动条
						$('body').css('overflow-y', 'hidden').on('touchmove', function (event) {
							event.preventDefault;
						}, false);

						myApp.modal({
							title: js_lang.tips,
							text: js_lang.logged_yet,
							buttons: [{
								text: js_lang.cancel,
								onClick: function () {
									$('.modal').remove();
									$('.modal-overlay').remove();
									$(".ecjia-store-goods .a1n .a1x").css({
										overflow: "auto"
									}); //启用滚动条
									$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
									return false;
								}
							}, {
								text: js_lang.go_login,
								onClick: function () {
									$('.modal').remove();
									$('.modal-overlay').remove();
									$(".ecjia-store-goods .a1n .a1x").css({
										overflow: "auto"
									}); //启用滚动条
									$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
									location.href = data.referer_url;
									return false;
								}
							}, ]
						});
						return false;
					} else {
						alert(data.message);
						return false;
					}
				}
				if (val == 0) {
					$('#goods_' + goods_id).children('.reduce').removeClass('show').addClass('hide');
					$('#goods_' + goods_id).children('label').removeClass('show').addClass('hide');
					$('#goods_' + goods_id).children('span.detail-add').removeClass('show').addClass('hide');
					$('#goods_' + goods_id).children('span.goods-detail').addClass('hide');
					$('#goods_' + goods_id).siblings('span').removeClass('hide').attr('rec_id', '')
					$('#setion_' + goods_id).remove();
				}

				if (div != undefined && div != '') {
					if (div.hasClass('other_place')) {
						if (div.parent().find('.other_place').length == 1) {
							$('.a4u.a4u-gray').remove();
						}
					} else if (div.hasClass('current_place')) {
						if (div.parent().find('.current_place').length == 1) {
							$('.a4u.a4u-green').after('<div class="a57"><span>' + js_lang.shop_cart_empty + '</span></div>');
						}
					}
					div.remove();
					if ($('.a57').length == 1 && $('.a4u-gray').length == 0) {
						var index_url = $('input[name="index_url"]').val();
						$('.ecjia-flow-cart-list').html('').html('<div class="flow-no-pro"><div class="ecjia-nolist">' + js_lang.add_goods_yet + '<a class="btn btn-small" type="button" href="' + index_url + '">' + js_lang.go_go + '</a></div>');
					}
					return false;
				}

				if (data.empty == true) {
					var li = $('.check_cart_' + data.store_id).parents('.cart-single');
					li.remove();
					if ($('li.cart-single').length == 0) {
						$('.ecjia-flow-cart').remove();
						$('.flow-no-pro').removeClass('hide');
					}
					return false;
				}
				if (data.response == true) {
					$('.la-ball-atom').remove();
					if (data.count != null) {
						if (data.count.discount != 0) {
							discount_html = '<label class="discount">' + sprintf(js_lang.reduced, data.count.discount) + '<label>';
							$('.price_' + store_id).html(data.count.goods_price + discount_html);
						} else {
							$('.price_' + store_id).html(data.count.goods_price);
						}
						if (data.data_rec) {
							$('.check_cart_' + store_id).attr('data-rec', data.data_rec);
							$('.check_cart_' + store_id).removeClass('disabled');
						} else {
							$('.check_cart_' + store_id).attr('data-rec', '');
							$('.check_cart_' + store_id).addClass('disabled');
						}
					}
					return true;
				}

				if (spec != '' || spec != false) {
					if (type == 'add') {
						if (spec.length != undefined) {
							$('.goods_spec_' + goods_id).find('.choose_attr').attr('data-spec', spec);
						}
						var n = parseInt($('.goods_spec_' + goods_id).children('i').html()) + 1;
						if (isNaN(n)) {
							n = 1;
						}
						if ($('.goods_spec_' + goods_id).find('.attr-number').length == 0) {
							$('.goods_spec_' + goods_id).append('<i class="attr-number" style="right: 0.2em;top: 0.2em;">' + n + '</i>');
						} else {
							$('.goods_spec_' + goods_id).find('.attr-number').html(n);
						}
					} else if (type == 'reduce') {
						var n = parseInt($('.goods_spec_' + goods_id).children('i').html()) - 1;
						if (isNaN(n)) {
							n = 0;
						}
						if (n == 0) {
							$('.goods_spec_' + goods_id).find('.attr-number').remove();
							$('.goods_spec_' + goods_id).children('.choose_attr').attr('data-spec', '');
						} else {
							$('.goods_spec_' + goods_id).find('.attr-number').html(n);
						}
					}
					if (val == 0) {
						val = 1;
						$('.ecjia-attr-modal').find('.add-tocart').addClass('show').removeClass('hide');
						// $('.ecjia-attr-modal').find('#goods_' + goods_id).removeClass('show').addClass('hide').children().attr('rec_id', '');
						$('.ecjia-attr-modal').find('.ecjia-choose-attr-box.box').removeClass('show').addClass('hide').children().attr('rec_id', '');
					} else {
						$('.ecjia-attr-modal').find('.add-tocart').removeClass('show').addClass('hide');
						// $('.ecjia-attr-modal').find('#goods_' + goods_id).addClass('show').removeClass('hide');
						// $('.ecjia-attr-modal').find('#goods_' + goods_id).children().addClass('show').removeClass('hide');
						$('.ecjia-attr-modal').find('.ecjia-choose-attr-box.box').addClass('show').removeClass('hide');
						$('.ecjia-attr-modal').find('.ecjia-choose-attr-box.box').children().addClass('show').removeClass('hide');
						$('.ecjia-attr-modal').find('.ecjia-choose-attr-box.box').attr('id', goods_id);
						$('.ecjia-attr-modal').find('.ecjia-choose-attr-box.box .add.add_spec').attr('goods_id', goods_id).attr('rec_id', data.data_rec);
						$('.ecjia-attr-modal').find('.ecjia-choose-attr-box.box .reduce.remove_spec').attr('goods_id', goods_id).attr('rec_id', data.data_rec);
					}
					$('.ecjia-attr-modal').find('#goods_' + goods_id).children('label').html(val);
					$('.ecjia-attr-modal').find('.ecjia-choose-attr-box.box').children('label').html(val);
				}

				var text = $('.a51').attr('data-text') == undefined ? js_lang.go_settlement : $('.a51').attr('data-text');
				if (data.count == null) {
					ecjia.touch.category.hide_cart(true);
				} else {
					ecjia.touch.category.show_cart(true);
					var goods_number = data.count.goods_number;

					if (spec == '') {
						for (i = 0; i < data.list.length; i++) {
							if (data.say_list) {
								if (data.list[i].id == goods_id) {
									$('#goods_' + goods_id).children('.reduce').removeClass('hide').attr('rec_id', data.list[i].rec_id);
									$('#goods_' + goods_id).children('label').removeClass('hide').html(data.list[i].goods_number);
									$('#goods_' + goods_id).children('.add').removeClass('hide').attr('rec_id', data.list[i].rec_id);
									if ($.find('.may_like_' + goods_id)) {
										$('.may_like_' + goods_id).attr('rec_id', data.list[i].rec_id);
									}
								}
							}
							if (data.list[i].is_checked != 1) {
								data.count.goods_number -= data.list[i].goods_number;
							}
						}
					} else {
						$('#goods_' + goods_id).children('span').attr('rec_id', data.current.rec_id).removeClass('hide');
						// $('.ecjia-attr-modal').find('.ecjia-choose-attr-box.box').children('span').attr('rec_id', data.current.rec_id).removeClass('hide');
						$('#goods_' + goods_id).children('label').removeClass('hide').html(data.current.goods_number);
						// $('.ecjia-attr-modal').find('.ecjia-choose-attr-box.box').children('label').removeClass('hide').html(data.current.goods_number);
					}

					if (data.say_list) {
						$('.minicart-goods-list').html(data.say_list);
						ecjia.touch.category.change_num();
					}

					$('p.a6c').html(sprintf(js_lang.have_select, data.count.goods_number))
					if (goods_number > 99) {
						$('.a4x').html('<i class="a4y">99+</i>');
					} else {
						$('.a4x').html('<i class="a4y">' + goods_number + '</i>');
					}

					if (data.count.goods_number == 0) {
						$('.a51').addClass('disabled').html(text);
					} else {
						$('.a51').removeClass('disabled');
						//隐藏加入购物车按钮 显示加减按钮
						if ($('.goods-add-cart').attr('goods_id') == goods_id) {
							if (spec == '') {
								if (val > 0) {
									$('.goods-add-cart').addClass('hide').removeClass('show');
									$('.ecjia-goods-plus-box').removeClass('hide').addClass('show');
								} else {
									$('.goods-add-cart').removeClass('hide').addClass('show');
									$('.ecjia-goods-plus-box').addClass('hide').removeClass('show');
								}
							} else {
								if (val == 0) val = 1;
								$('.goods-add-cart').not('.choose_attr').addClass('hide');
								$('.ecjia-goods-plus-box').removeClass('hide').children('label').html(val);
								$('.ecjia-goods-plus-box').children().removeClass('hide');
							}
						}
					}
					var discount_html = '';
					if (data.count.discount != 0) {
						discount_html = '<label>' + sprintf(js_lang.reduced, data.count.discount) + '<label>';
					}
					$('.a4z').html('<div>' + data.count.goods_price + discount_html + '</div>');

					if (data.data_rec) {
						$('.check_cart').attr('data-rec', data.data_rec);
						$('.check_cart').removeClass('disabled');
					} else {
						$('.check_cart').attr('data-rec', '');
						$('.check_cart').addClass('disabled');
					}

					ecjia.touch.category.add_tocart();
					ecjia.touch.category.remove_tocart();
					ecjia.touch.category.toggle_checkbox();
					//隐藏修改购物车商品数量弹窗
					$('.ecjia-num-content').removeClass('show');
				}
				ecjia.touch.category.check_all();

				if (data.count != undefined) {
					var count = data.count;
					if (count.meet_min_amount == 1 || !count.label_short_amount) {
						if (count.real_goods_count > 0) {
							$('.check_cart').removeClass('disabled').html(text);
						} else {
							$('.check_cart').html(text);
						}
					} else {
						$('.check_cart').addClass('disabled').html(sprintf(js_lang.deviation_pick_up, count.label_short_amount));
					}
				}
			});
		},

		//显示购物车
		show_cart: function (bool) {
			if (bool) {
				$('.store-add-cart').children('.a4x').addClass('light').removeClass('disabled');
				$('.store-add-cart').children('.a51').removeClass('disabled');
			} else {
				$('.a57').css('display', 'block');
				//禁用滚动条
				$('body').css('overflow-y', 'hidden').on('touchmove', function (event) {
					event.preventDefault;
				}, false);
				$('.minicart-content').on('touchmove', function (e) {
					e.stopPropagation();
				});
				$('.a53').css('display', 'block');
				$('.store-add-cart').children('.a4x').removeClass('show').removeAttr('show');
				$('.store-add-cart').children('.minicart-content').css('transform', 'translateY(-100%)');
				$('.store-add-cart').children('.a4z').css('transform', 'translateX(-60px)');
				$('.minicart-content').children('.a4x').addClass('show').addClass('light').removeClass('disabled');
			}
		},

		//隐藏购物车
		hide_cart: function (bool) {
			//启用滚动条
			$('body').css('overflow-y', 'auto').off("touchmove");

			$('.store-add-cart').find('.a4z').css('transform', 'translateX(0px)');
			$('.a53').css('display', 'none');
			$('.store-add-cart').find('.minicart-content').css('transform', 'translateY(0px)');

			$('.minicart-content').children('.a4x').removeClass('show').attr('show', false);
			$('.store-add-cart').children('.a4x').addClass('show').attr('show', false);

			var text = $('.a51').attr('data-text') == undefined ? js_lang.go_settlement : $('.a51').attr('data-text');
			//购物车完全清空
			if (bool == true) {
				$('.a57').css('display', 'none');
				$('.store-add-cart').removeClass('active');
				$('.a4y').remove();
				$('.store-add-cart').children('.a4x').addClass('disabled').addClass('outcartcontent').removeClass('light').removeClass('incartcontent');
				$('.minicart-content').children('.a4x').removeClass('light').addClass('disabled');
				$('.store-add-cart').children('.a4z').children('div').addClass('a50').html(js_lang.cart_empty);
				$('.store-add-cart').children('.a51').addClass('disabled').html(text);;
				$('.minicart-goods-list').html('');
			}
			//启用用滚动条
			$(".ecjia-store-goods .a1n .a1x").css({
				overflow: "auto"
			});
		},

		//店铺首页切换分类
		toggle_category: function () {
			$('[data-toggle="toggle-category"]').off('click').on('click', function (e) {
				var $this = $(this),
					url = $this.attr('data-href'),
					name = $this.html().trim(),
					category_id = $this.attr('data-category') == undefined ? 0 : $this.attr('data-category'),
					li = $this.parent('li');

				if ($this.hasClass('disabled') || ($this.parent().hasClass('a1r') && $this.parent().find('.a1v').length == 0) || ($this.hasClass('a1u') && $this.hasClass('active'))) {
					return false;
				}
				var bool = true;
				//同一父类下子类切换点击
				if ($this.hasClass('a1u')) {
					$this.addClass('active').siblings('span').removeClass('active');
					//父类单击切换显示
				} else if (li.hasClass('a1t')) {
					bool = false;
					li.removeClass('a1t').addClass('a1r');
				} else {
					//为父类增加选中效果，移除其他父类的选中效果
					li.addClass('a1r').removeClass('a1t').siblings('li').removeClass('a1t').removeClass('a1r');
					//点击父类有子类
					if (li.children('strong').hasClass('a1v')) {
						//移除父类的选中效果
						if (li.hasClass('a1t')) {
							li.removeClass('a1t').addClass('a1r');
						} else if (li.hasClass('a1r')) {
							li.removeClass('a1r').addClass('a1t');
						}
						//默认给父类的第一个子类选中
						if (!$this.siblings('strong').children('span').hasClass('active')) {
							var span_0 = $this.siblings('strong').children('span').eq(0);
							span_0.addClass('active');
							category_id = span_0.attr('data-category');
						} else {
							bool = false;
						}
					}
					//点击无子类的分类，去除其他有子类分类的子类选中效果
					li.siblings('li').children('strong.a1v').children('span').removeClass('active');
				}
				var type = $this.attr('data-type') == undefined ? category_id : $this.attr('data-type');
				$('[data-toggle="asynclist"]').attr('class', 'store_goods_' + type);

				var store_id = $('input[name="store_id"]').val();
				var info = {
					'action_type': type
				};
				$('.wd').find('[data-toggle="asynclist"]').attr('data-type', type);

				if (bool == true) {
					$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>'); //加载动画
					$('[data-toggle="toggle-category"]').addClass('disabled'); //禁止切换

					$loader = $('<a class="load-list" href="javascript:;"><div class="loaders"><div class="loader"><div class="loader-inner ball-pulse"><div></div><div></div><div></div></div></div></div></a>');
					var load_list = $('.store_goods_' + type).parent().find('.load-list');

					if (load_list.length == 0) {
						$('.store_goods_' + type).after($loader);
					}
					$.get(url, info, function (data) {
						$('.wd').find('[data-toggle="asynclist"]').html(''); //清空

						$('.la-ball-atom').remove(); //移出加载动画
						$('[data-toggle="toggle-category"]').removeClass('disabled'); //允许切换
						$('.store_goods_' + type).append(data.list);

						ecjia.touch.category.add_tocart();
						ecjia.touch.category.remove_tocart();
						ecjia.touch.category.store_toggle();

						var info = data.name + '(' + data.num + ')';
						$('.a20').html(info);

						if (data.is_last == null) {
							$('.store_goods_' + type).attr('data-page', 2);
							ecjia.touch.asynclist();
						} else {
							load_list.addClass('is-last').css('display', 'none');
						}
						if (data.spec_goods) {
							window.releated_goods = data.spec_goods;
						}
					});
				}
			});

			$('.store-option dl').off('click').on('click', function () {
				$('.ecjia-store-comment .store-container').css('padding-bottom', 0);

				var $this = $(this),
					url = $this.attr('data-url'),
					type = $this.attr('data-type');

				$('.store-comment').attr('id', 'store-comment-' + type);
				$('.ecjia-seller-comment').find('[data-toggle="asynclist"]').attr('data-type', type);

				if ($this.hasClass('active') || $this.hasClass('disabled')) {
					return false;
				} else {
					$this.addClass('active').siblings('dl').removeClass('active');
					$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>'); //加载动画
					$('body').css('overflow-y', 'hidden').on('touchmove', function (event) {
						event.preventDefault;
					}, false);
					$('.store-option dl').addClass('disabled'); //禁止切换

					$.get(url, function (data) {
						$('.store-container').scrollTop(0);
						$loader = $('<a class="load-list" href="javascript:;"><div class="loaders"><div class="loader"><div class="loader-inner ball-pulse"><div></div><div></div><div></div></div></div></div></a>');
						var load_list = $('#store-comment-' + type).parent().find('.load-list');
						if (load_list.length == 0) {
							$('#store-comment-' + type).after($loader);
						}
						$('#store-comment-' + type).html('');

						$('.la-ball-atom').remove(); //移出加载动画
						$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
						$('.store-option dl').removeClass('disabled'); //允许切换

						if (data.list.length == 0) {
							$('#store-comment-' + type).append('<div class="ecjia-nolist"><img src="' + theme_url + 'images/wallet/null280.png"><p class="tags_list_font">' + js_lang.no_goods_reviews + '</p></div>');
						} else {
							$('#store-comment-' + type).append(data.list);
						}
						if ($('#store-comment-' + type).find('.assess-flat').length != 0) {
							$('.ecjia-store-comment .store-container').css('padding-bottom', '7em');
						}
						//商品详情评分
						$('.score-goods').each(function () {
							$(this).raty({
								readOnly: true,
								score: function () {
									return $(this).attr('data-val');
								},
							});
						});

						if (data.is_last == null) {
							$('#store-comment-' + type).attr('data-page', 2);
							ecjia.touch.asynclist();
						} else {
							$('.ecjia-seller-comment').find('.load-list').addClass('is-last').css('display', 'none');
						}
						ecjia.touch.category.image_preview();
						return false;
					});
				}
			});
		},

		scroll: function () {
			var mybody = document.getElementById('wd_list');
			if (mybody != null) {
				//滑动处理
				var startX, startY, moveEndX, moveEndY, X, Y;
				mybody.addEventListener('touchstart', function (e) {
					startX = e.touches[0].pageX;
					startY = e.touches[0].pageY;
				});
				mybody.addEventListener('touchmove', function (e) {
					var position = $('.wd').find('ul li:first').position();
					if (position != undefined) {
						var top = position.top;
						moveEndX = e.changedTouches[0].pageX;
						moveEndY = e.changedTouches[0].pageY;
						X = moveEndX - startX;
						Y = moveEndY - startY;
						if (Y > 0 && top >= 30) {
							ecjia.touch.category.scroll_show_hide(false);
						} else if (Y < 0) {
							ecjia.touch.category.scroll_show_hide(true);
						}
					}
				});
			};

			var comment_body = document.getElementById('store-scroll');
			if (comment_body != null) {
				//滑动处理
				var startX, startY, moveEndX, moveEndY, X, Y;
				comment_body.addEventListener('touchstart', function (e) {
					startX = e.touches[0].pageX;
					startY = e.touches[0].pageY;
				});
				comment_body.addEventListener('touchmove', function (e) {
					moveEndX = e.changedTouches[0].pageX;
					moveEndY = e.changedTouches[0].pageY;
					X = moveEndX - startX;
					Y = moveEndY - startY;
					if (Y > 0) {
						ecjia.touch.category.scroll_show_hide(false);
					} else if (Y < 0) {
						ecjia.touch.category.scroll_show_hide(true);
					}
				});
			};

			var store_seller = document.getElementById('store-seller');
			if (store_seller != null) {
				//滑动处理
				var startX, startY, moveEndX, moveEndY, X, Y;
				store_seller.addEventListener('touchstart', function (e) {
					startX = e.touches[0].pageX;
					startY = e.touches[0].pageY;
				});
				store_seller.addEventListener('touchmove', function (e) {
					//var top = $('#store-seller').find('div:first').position().top;
					moveEndX = e.changedTouches[0].pageX;
					moveEndY = e.changedTouches[0].pageY;
					X = moveEndX - startX;
					Y = moveEndY - startY;
					if (Y > 0) {
						ecjia.touch.category.scroll_show_hide(false);
					} else if (Y < 0) {
						ecjia.touch.category.scroll_show_hide(true);
					}
				});
			};
		},

		scroll_show_hide: function (e) {
			if (e == true) {
				$('.ecjia-store-banner').css('display', 'none');

				$('.page_hearder_hide').show();
				$('.ecjia-store-goods').children('.a1n').css('top', '6.7em');

				//店铺评论
				$('.ecjia-store-ul').css('top', '3em');
				$('.ecjia-seller-comment').css('top', '6.7em');
				$('.ecjia-store-detail').css('top', '6.7em');
			} else {
				$('.ecjia-store-banner').css('display', 'block');
				$('.page_hearder_hide').hide();
				$('.ecjia-store-goods').children('.a1n').css('top', '15.8em');

				//店铺评论
				$('.ecjia-store-ul').css('top', '11.3em');
				$('.ecjia-seller-comment').css('top', '15.8em');
				$('.ecjia-store-detail').css('top', '15.8em');
			}
		},

		//店铺首页 商品详情 店铺内搜索 清空购物车
		deleteall: function () {
			$('[data-toggle="deleteall"]').off('click').on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('data-url');
				var myApp = new Framework7();
				myApp.modal({
					title: js_lang.empty_cart_all_goods,
					buttons: [{
						text: js_lang.cancel,
						onClick: function () {
							$('.modal').remove();
							$('.modal-overlay').remove();
							return false;
						}
					}, {
						text: js_lang.ok,
						onClick: function () {
							$('.modal').remove();
							$('.modal-overlay').remove();
							var rec_id = [];
							var store_id = $('input[name="store_id"]').val();

							$('input[name="rec_id"]').each(function () {
								rec_id.push($(this).val());
							});
							var info = {
								'store_id': store_id,
								'rec_id': rec_id,
							};
							$.post(url, info, function (data) {
								if (data.state == 'success') {
									ecjia.touch.category.hide_cart(true);
									if ($.find('.box').length != 0) {
										$('.box').each(function () {
											if ($(this).parent().find('.goods-add-cart').length != 0) {
												$(this).removeClass('show').addClass('hide');
												$(this).children('label').html('1');
											} else {
												$(this).children('span.reduce').addClass('hide').removeClass('show');
												$(this).children('label').html('');
											}
											$(this).children('span').attr('rec_id', '');
										});
									}
									if ($.find('.goods-add-cart').length != 0) {
										$('.box').addClass('hide');
										$('.goods-add-cart').removeClass('hide').attr('rec_id', '');
									}
									if ($.find('.goods-price-plus').length != 0) {
										$('.goods-price-plus').attr('rec_id', '').attr('data-num', '');
									}
									if ($.find('i.attr-number').length != 0) {
										$('i.attr-number').remove();
									}
									if ($.find('.choose_attr').length != 0) {
										$('.choose_attr').attr('data-spec', '');
									}
									$('.ecjia-choose-attr-box.box').removeClass('show').addClass('hide'); //隐藏加减按钮
									$('.add-tocart.add_spec').addClass('show').removeClass('hide'); //显示加入购物车按钮
								} else {
									ecjia.touch.showmessage(data);
								}
								return false;
							});
						}
					}, ]
				});
			});
			ecjia.touch.category.delete_line(".ecjia-flow-cart .a4w", ".a4x", ".a4y", ".w4");
		},

		//店铺首页 单选
		toggle_checkbox: function () {
			$('[data-toggle="toggle_checkbox"]').off('click').on('click', function (e) {
				var $this = $(this);
				if ($this.hasClass('disabled') || $this.hasClass('limit_click')) {
					return false;
				}
				$('.box').children('span').addClass('limit_click'); //禁止其他加减按钮点击
				$('.minicart-content').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');

				$('[data-toggle="toggle_checkbox"]').addClass('limit_click'); //禁止其他单选点击

				if ($this.hasClass('checked')) {
					$this.removeClass('checked');
				} else {
					$this.addClass('checked');
				}

				var checked;
				if ($this.attr('data-children')) {
					var children = $this.attr('data-children');
					var options = {
						thisobj: $this,
						children: children
					};
					if (!options.children) options.children = $('.checkbox');
					options.allobj = $(options.children);
					if (!options.thisobj.hasClass("checked")) {
						options.allobj.removeClass("checked");
						checked = 0;
					} else {
						options.allobj.addClass("checked");
						checked = 1;
					}
					var rec_id = [];
					$('.minicart-goods-list .checkbox').each(function () {
						rec_id.push($(this).attr('rec_id'));
					});
				} else {
					checked = $this.hasClass('checked') ? 1 : 0;
					var rec_id = $this.attr('rec_id');
				}
				ecjia.touch.category.update_cart(rec_id, 0, 0, checked, true);
			});

			$('.ecjia-number-contro').off('focus').on('focus', function () {
				if ($(this).hasClass('disabled')) {
					return false;
				}
				var v = $(this).val();

				$(this).off('blur').on('blur', function () {
					var $this = $(this),
						val = $this.val(),
						rec_id = $this.attr('rec_id'),
						store_id = $this.parent().attr('data-store');

					var ex = /^\d+$/;
					if (v == val) {
						return false;
					}
					if (val <= 0 || !ex.test(val)) {
						var myApp = new Framework7();
						myApp.modal({
							title: js_lang.please_enter_than_0,
							buttons: [{
								text: js_lang.ok,
								onClick: function () {
									$('.modal').remove();
									$('.modal-overlay').remove();
									ecjia.pjax(window.location.href);
								},
							}]
						});
					} else {
						$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
						ecjia.touch.category.update_cart(rec_id, val, 0, '', store_id);
					}
					return false;
				});
				return false;
			});
		},

		//店铺首页全选
		check_all: function () {
			var chknum = $(".minicart-goods-list .checkbox").size(); //选项总个数 
			var chk = 0;
			$(".minicart-goods-list .checkbox").each(function () {
				if ($(this).hasClass("checked") == true) {
					chk++;
				}
			});
			if (chknum == chk) { //全选 
				$("#checkall").addClass("checked");
			} else { //不全选 
				$("#checkall").removeClass("checked");
			}
		},

		//店铺首页 去结算 购物车列表列表编辑
		check_cart: function () {
			$('.check_cart, .w4').off('click').on('click', function (e) {
				e.stopPropagation();
				var $this = $(this),
					url = $this.attr('data-href'),
					store_id = $this.attr('data-store'),
					address_id = $this.attr('data-address'),
					rec_id = $this.attr('data-rec');

				var myApp = new Framework7();
				if ($this.hasClass('remove_all')) {
					//禁用滚动条
					$('body').css('overflow-y', 'hidden').on('touchmove', function (event) {
						event.preventDefault;
					}, false);

					myApp.modal({
						title: js_lang.store_delete_all_goods,
						buttons: [{
							text: js_lang.cancel,
							onClick: function () {
								$('.modal').remove();
								$('.modal-overlay').remove();
								$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
								return false;
							}
						}, {
							text: js_lang.ok,
							onClick: function () {
								$('.modal').remove();
								$('.modal-overlay').remove();
								$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
								$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');

								var rec_id = [];
								var div = $this.parent('.a4w');
								div.find('li').each(function () {
									rec_id.push($(this).attr('data-rec'));
								});

								ecjia.touch.category.update_cart(rec_id, 0, 0, '', store_id, '', '', div);
								return false;
							},
						}]
					});
				}
				if ($this.hasClass('disabled') || $this.hasClass('remove_all')) {
					return false;
				}
				if (store_id != undefined) {
					url += '&store_id=' + store_id;
				}

				if (rec_id != undefined && rec_id != '') {
					url += '&rec_id=' + rec_id;
				}
				ecjia.pjax(url);
			});
			$('.modal-inner').click(function (e) {
				e.stopPropagation(); //阻止事件向上冒泡
			});
			$('.modal-buttons').click(function (e) {
				e.stopPropagation(); //阻止事件向上冒泡
			});
		},

		check_groupbuy_cart: function () {
			$('.check_groupbuy_cart').off('click').on('click', function (e) {
				e.preventDefault();
				var $this = $(this),
					url = $this.attr('data-href'),
					store_id = $this.attr('data-store'),
					address_id = $this.attr('data-address'),
					goods_id = $this.attr('data-goods'),
					number = $this.attr('data-num'),
					goods_activity_id = $this.attr('data-act');
				if ($this.hasClass('disabled')) {
					return false;
				}

				var info = {
					goods_id: goods_id,
					number: number,
					store_id: store_id,
					goods_activity_id: goods_activity_id
				}
				$.post(url, info, function (data) {
					if (data.state == 'error') {
						var myApp = new Framework7();

						$('.la-ball-atom').remove();
						if (data.referer_url || data.message == 'Invalid session') {
							$(".ecjia-store-goods .a1n .a1x").css({
								overflow: "hidden"
							}); //禁用滚动条
							//禁用滚动条
							$('body').css('overflow-y', 'hidden').on('touchmove', function (event) {
								event.preventDefault;
							}, false);

							myApp.modal({
								title: js_lang.tips,
								text: js_lang.logged_yet,
								buttons: [{
									text: js_lang.cancel,
									onClick: function () {
										$('.modal').remove();
										$('.modal-overlay').remove();
										$(".ecjia-store-goods .a1n .a1x").css({
											overflow: "auto"
										}); //启用滚动条
										$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
										return false;
									}
								}, {
									text: js_lang.go_login,
									onClick: function () {
										$('.modal').remove();
										$('.modal-overlay').remove();
										$(".ecjia-store-goods .a1n .a1x").css({
											overflow: "auto"
										}); //启用滚动条
										$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
										location.href = data.referer_url;
										return false;
									}
								}, ]
							});
							return false;
						} else {
							alert(data.message);
							return false;
						}
					}
					var redirect_url = data.url;
					if (address_id != undefined && address_id != 0) {
						redirect_url += '&address_id=' + address_id;
					}
					if (store_id != undefined && store_id != 0) {
						redirect_url += '&store_id=' + store_id;
					}
					location.href = redirect_url;
				});
			});
		},

		//购物车列表 单选多选切换
		check_goods: function () {
			$('.cart-checkbox').off('click').on('click', function () {
				var $this = $(this),
					store_id = $this.attr('data-store'),
					checked, rec_id = [];

				//删除
				if ($this.hasClass('edit')) {
					//全部删除
					if ($this.hasClass('check_all')) {
						//禁用滚动条
						$('body').css('overflow-y', 'hidden').on('touchmove', function (event) {
							event.preventDefault;
						}, false);

						rec_id = $('.check_cart_' + store_id).attr('data-rec');
						var myApp = new Framework7();
						myApp.modal({
							title: js_lang.store_delete_all_goods,
							buttons: [{
								text: js_lang.cancel,
								onClick: function () {
									$('.modal').remove();
									$('.modal-overlay').remove();

									$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
									return false;
								}
							}, {
								text: js_lang.ok,
								onClick: function () {
									$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
									ecjia.touch.category.update_cart(rec_id, 0, 0, '', store_id);
									var li = $this.parents('.cart-single');
									li.remove();
									if ($('li.cart-single').length == 0) {
										$('.ecjia-flow-cart').remove();
										$('.flow-no-pro').removeClass('hide');
									}
									return false;
								},
							}]
						});
						//删除单个
					} else {
						$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
						rec_id = $this.attr('rec_id');

						var li = $this.parents('.item-goods');
						ecjia.touch.category.update_cart(rec_id, '', '', '', store_id, '', '', li);
						return false;
					}
				} else {
					//购物车中库存不足的商品不可以修改
					if ($this.hasClass('disabled'))　 {
						return false;
					}
					$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
					if ($this.hasClass('checked')) {
						$this.removeClass('checked');
						checked = 0;
					} else {
						$this.addClass('checked');
						checked = 1;
					}

					var chknum = $(".checkbox_" + store_id).size(); //选项总个数 
					var chk = 0;
					$(".checkbox_" + store_id).each(function () {
						if ($(this).hasClass("checked")) {
							chk++;
						}
						rec_id.push($(this).attr('rec_id'));
					});

					if ($this.hasClass('check_all')) {
						if ($this.hasClass('checked')) {
							$(".checkbox_" + store_id).addClass('checked');
							checked = 1;
						} else {
							$(".checkbox_" + store_id).removeClass('checked');
							checked = 0;
						}
					} else {
						if (chknum == chk) { //全选 
							$("#store_check_" + store_id).addClass("checked");
						} else { //不全选 
							$("#store_check_" + store_id).removeClass("checked");
						}
						rec_id = $this.attr('rec_id');
					}
					ecjia.touch.category.update_cart(rec_id, 0, 0, checked, store_id);
				}
			});
		},

		//购物车列表 编辑
		cart_edit: function () {
			$('.shop-edit').off('click').on('click', function () {
				var $this = $(this),
					store_id = $this.attr('data-store'),
					type = $this.attr('data-type'),
					data_type, text, color, button_text;
				if (type == 'edit') {
					data_type = 'complete';
					text = js_lang.finish;
					button_text = js_lang.all_delete;
					$this.addClass('edit_font_color');
					$('.check_cart_' + store_id).text(button_text).addClass('remove_all');
					$('#store_check_' + store_id).addClass('edit');
					$('.checkbox_' + store_id).addClass('edit');
				} else {
					data_type = 'edit';
					text = js_lang.edit;
					button_text = js_lang.go_settlement;
					$this.removeClass('edit_font_color');
					$('.check_cart_' + store_id).text(button_text).removeClass('remove_all');
					$('#store_check_' + store_id).removeClass('edit');
					$('.checkbox_' + store_id).removeClass('edit');
				}
				$this.attr('data-type', data_type).text(text);
			});
		},

		openSelection: function () { /*商品列表页面点击显示筛选*/
			$('[data-toggle="openSelection"]').on('click', function (e) {
				e.preventDefault();
				$(".goods-filter-box").toggleClass("show");
			}); /*商品列表页面点击隐藏筛选*/
			$('[data-toggle="closeSelection"]').on('click', function (e) {
				e.preventDefault();
				if ($(".goods-filter-box").hasClass("show")) {
					$(".goods-filter-box").removeClass("show");
				} else {
					$(".goods-filter-box").addClass("show");
				}
			});
		},

		/*筛选的属性下拉*/
		selectionValue: function () {
			$('.goods-filter .title').on('click', function (e) {
				e.preventDefault();
				var _find = $(this).find(".icon-jiantou-bottom");
				var _next = $(this).next("ul");
				if (_find.hasClass('down')) {
					_find.removeClass("down");
					_next.removeClass("show");
				} else {
					_find.addClass("down");
					_next.addClass("show");
				}
			});

			/*商品列表页面点击隐藏下拉*/
			$('.goods-filter .goods-filter-box-content .goods-filter-box-listtype ul li a').on('click', function (e) {
				e.preventDefault();
				var click_id = $(this).parent("li").parent("ul").prev(".title").attr("id");
				var str = $(this).attr("value");
				if (click_id == 'filter_brand') {
					$(".brandname").val(str);
				} else {
					var res;
					res = str.split("|");
					$("input[name='price_min']").val(res[0]);
					$("input[name='price_max']").val(res[1]);
				}
				$(this).parent("li").parent("ul").prev(".title").children(".range").text($(this).text());
				$(this).parent("li").parent("ul").removeClass("show");
				$(this).parent("li").parent("ul").prev(".title").children("i").removeClass("down");
			});
			$(".goods-filter .goods-filter-box-content .btns .btn-default").on("click", function (e) {
				e.preventDefault();
				$(".goods-filter .goods-filter-box-content .goods-filter-box-listtype .title").each(function (i) {
					$(this).children(".range").text(js_lang.all);
				});
			});
		},

		clear_filter: function () {
			$('[data-toggle="clear_filter"]').on('click', function (e) {
				e.preventDefault();
				$("input[name='price_min']").val('');
				$("input[name='price_max']").val('');
				$("input[name='brand']").val('');
				$(".touchweb-com_listType .range").text(js_lang.all);
				$(".touchweb-com_listType input").each(function () {
					if ($(this).attr('class') != 'cat') {
						$(this).val("");
					}
				});
			});
		},

		goods_show: function () {
			$(document).off('click', '.view-more');
			$(document).on('click', '.view-more', function (e) {
				e.preventDefault();
				var $this = $(this);

				if ($this.hasClass('retract')) {
					$this.parent().siblings('.single_store').children().find('.goods-hide-list').hide();
				} else {
					$this.parent().siblings('.single_store').children().find('.goods-hide-list').fadeIn("slow");
				}
				$this.addClass('hide').siblings('.goods-info').removeClass('hide');
			});

			$('.category_left li').off('click').on('click', function () {
				$('.ecjia-category-list').removeClass('show');
				var $this = $(this)
				cat_id = $this.children('a').attr('data-val');
				$this.addClass('active').siblings('li').removeClass('active');
				$('#category_' + cat_id).removeClass('hide').siblings('.ecjia-category-list').addClass('hide');
			});
		},

		store_toggle: function () {
			$('li.favourable_notice, .store-description').off('click').on('click', function () {
				var $this = $(this);

				var myApp = new Framework7();
				//禁用滚动条
				$('body').css('overflow-y', 'hidden').on('touchmove', function (event) {
					event.preventDefault;
				}, false);

				var wHeight = $(window).height();
				var scrollTop = $(document).scrollTop();
				var top;
				if (wHeight - 400 < 0) {
					top = scrollTop;
				} else {
					var ua = navigator.userAgent.toLowerCase();
					if (ua.match(/MicroMessenger/i) == "micromessenger") {
						top = scrollTop + (wHeight - 230) / 2;
					} else {
						top = scrollTop + (wHeight - 200) / 2;
					}
				}
				$('.ecjia-store-modal').show().css('top', top);

				$('.ecjia-store-modal-overlay').show();
				myApp.openModal('.ecjia-store-modal');
				$('.modal-overlay').remove();

				$('.ecjia-close-modal-icon').on('click', function () {
					$('.ecjia-store-modal').hide();
					$('.ecjia-store-modal-overlay').hide();
					$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
				});
				return false;
			});
			$('.modal-inners').click(function (e) {
				e.stopPropagation(); //阻止事件向上冒泡
			});

			$('.ecjia-store-li').off('click').on('click', function () {
				var $this = $(this),
					url = $this.attr('data-url');

				if (url != undefined) {
					window.location.href = url;
					return false;
				}

				$this.children('span').addClass('active');
				$this.siblings('li').children('span').removeClass('active');
				var index = $this.index();
				if (index == 0) {
					var show_div = $('.ecjia-store-goods');
					$('.store-add-cart').show();
				} else if (index == 1) {
					var show_div = $('.ecjia-store-comment');
					$('.store-add-cart').hide();
				} else if (index == 2) {
					var show_div = $('.ecjia-store-detail');
					$('.store-add-cart').hide();
				}
				show_div.removeClass('hide').addClass('show');
				show_div.siblings('.ecjia-store-toggle').removeClass('show').addClass('hide');
			});

			//商品详情评分
			if ($.find($('.score-goods')).length >= 0) {
				$('.score-goods').each(function () {
					$(this).raty({
						readOnly: true,
						score: function () {
							return $(this).attr('data-val');
						},
					});
				});
			}


			//店铺首页商品评分
			if ($.find($('.score-val')).length >= 0) {
				$('.score-val').raty({
					readOnly: true,
					score: function () {
						$('.score-val').html('');
						if ($('.score-val').find('img').length == 0) {
							return $(this).attr('data-val') * 5;
						}
					},
				});
			}

			$('.choose_attr').off('click').on('click', function () {
				var $this = $(this);
				var myApp = new Framework7();
				var goods_id = $this.attr('goods_id');
				var store_id = $this.attr('data-store');
				var url = $this.attr('data-url');
				var spec = $this.attr('data-spec');
				var modal = '.ecjia-goodsAttr-modal';

				// var only_goods_id = goods_id.replace('_0', '');

				if (spec != undefined && spec.length != 0) {
					var spec_arr = spec.split(',');
				}
				var error = 0;
				if ($this.hasClass('spec_goods')) {
					var choose_attr = $('.goods_attr.goods_spec_' + goods_id).children('.choose_attr');

					store_id = ecjia._default(store_id, choose_attr.attr('data-store'));
					url = ecjia._default(url, choose_attr.attr('data-url'));
					spec = ecjia._default(spec, choose_attr.attr('data-spec'));

					// if (store_id == undefined) store_id = choose_attr.attr('data-store');
					// if (url == undefined) url = choose_attr.attr('data-url');
					// if (spec == undefined) spec = choose_attr.attr('data-spec');
					if (spec !== undefined && spec.length !== 0) {
						var spec_arr = spec.split(',');
					}

					modal = '.ecjia-attr-static';
					var multi = '';
					for (var i in releated_goods) {
						var r = releated_goods[i];
						if (r.goods_info != undefined && goods_id == r.goods_info.id) {
							$('.ecjia-attr-static .modal-title').html(r.goods_info.name);
							$('.ecjia-attr-static .goods-attr-list').html('');
							var html = '';
							for (var j in r.goods_info.specification) {
								var s = r.goods_info.specification[j];
								if (s.attr_type == '2') {
									multi = 'multi-select';
								} else {
									multi = '';
								}
								html += '<div class="goods-attr" data-index=' + j + '><p class="attr-name">' + s.name + '<p>' + '<ul>';
								for (var k in s.value) {
									var t = s.value[k];
									if (spec_arr != undefined) {
										if ($.inArray(t.id.toString(), spec_arr) !== -1) {
											html += '<li class="active ' + multi + '" data-attr=' + t.id + ' data-price=' + t.price + '>' + t.label + '</li>';
										} else {
											html += '<li class="' + multi + '" data-attr=' + t.id + ' data-price=' + t.price + '>' + t.label + '</li>';
										}
									} else {
										if (k == 0 && multi == '') {
											html += '<li class="active" data-attr=' + t.id + ' data-price=' + t.price + '>' + t.label + '</li>';
										} else if (multi != '') {
											html += '<li class="' + multi + '" data-attr=' + t.id + ' data-price=' + t.price + '>' + t.label + '</li>';
										} else {
											html += '<li class="' + multi + '" data-attr=' + t.id + ' data-price=' + t.price + '>' + t.label + '</li>';
										}
									}
								}
								html += '</ul></div>';
							}
							$('.ecjia-attr-static .goods-attr-list').html(html);
							$('.ecjia-attr-static .ecjia-choose-attr-box').children('span').attr('goods_id', goods_id);
							// $('.ecjia-attr-static input[name="goods_price"]').val(r.goods_price);

							var info = {
								'goods_id': goods_id,
								'spec': spec,
								'store_id': store_id
							};
							var error = 0;

							if (url != null) {
								$.ajax({type: "post", url: url, data: info, async: false, success: function (data) {
										if (data.state == 'error') {
											error = 1;
											if (data.referer_url || data.message == 'Invalid session') {
												$(".ecjia-store-goods .a1n .a1x").css({
													overflow: "hidden"
												}); //禁用滚动条
												//禁用滚动条
												$('body').css('overflow-y', 'hidden').on('touchmove', function (event) {
													event.preventDefault;
												}, false);

												myApp.modal({
													title: js_lang.tips,
													text: js_lang.logged_yet,
													buttons: [{
														text: js_lang.cancel,
														onClick: function () {
															$('.modal').remove();
															$('.modal-overlay').remove();
															$(".ecjia-store-goods .a1n .a1x").css({
																overflow: "auto"
															}); //启用滚动条
															$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
															return false;
														}
													}, {
														text: js_lang.go_login,
														onClick: function () {
															$('.modal').remove();
															$('.modal-overlay').remove();
															$(".ecjia-store-goods .a1n .a1x").css({
																overflow: "auto"
															}); //启用滚动条
															$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
															location.href = data.referer_url;
															return false;
														}
													}, ]
												});
												return false;
											} else {
												ecjia.touch.showmessage(data);
												return false;
											}
										}
										else {

											$(modal).find('.goods-attr-price').html(data.product_spec.product_shop_price_label);
											$(modal).find('.goods-attr-name').html('(' + data.product_spec.product_goods_attr_label + ')');

											if (data.info) {
												$('.ecjia-attr-static .ecjia-choose-attr-box').addClass('show').removeClass('hide').attr('id', 'goods_' + goods_id);
												$('.ecjia-attr-static .ecjia-choose-attr-box').children('span').attr('rec_id', data.info.rec_id);
												$('.ecjia-attr-static .add-tocart').removeClass('show').addClass('hide').attr('goods_id', goods_id);
												$('.ecjia-attr-static .ecjia-choose-attr-box').children('label').html(data.info.goods_number);
											} else {
												$('.ecjia-attr-static .ecjia-choose-attr-box').removeClass('show').addClass('hide').attr('id', 'goods_' + goods_id);
												$('.ecjia-attr-static .ecjia-choose-attr-box').children('span').attr('rec_id', '');
												$('.ecjia-attr-static .add-tocart').addClass('show').removeClass('hide').attr('goods_id', goods_id);
												$('.ecjia-attr-static .ecjia-choose-attr-box').children('label').html('');
											}
										}
									}
								});
							}

							break;
						}
					}
				}
				if (error == 1) {
					return false;
				}
				// spec_html(modal);

				if ($('body').width() < 640) {
					$(modal).css('left', '2.5%');
				}
				$(modal).show();
				var overlay;
				if (modal == '.ecjia-goodsAttr-modal') {
					overlay = '.ecjia-goodsAttr-overlay';
				} else if (modal == '.ecjia-attr-static') {
					overlay = '.ecjia-attr-static-overlay';
				}
				$(overlay).show();

				//禁用滚动条
				$('body').css('overflow-y', 'hidden').on('touchmove', function (event) {
					event.preventDefault();
				}, false);
				$(".ecjia-store-goods .a1n .a1x").css({
					overflow: "hidden"
				}); //禁用滚动条

				myApp.openModal(modal);
				$('.modal-overlay').remove();

				$('.ecjia-close-modal-icon').on('click', function () {
					$(modal).hide();
					$(overlay).hide();
					$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
					$(".ecjia-store-goods .a1n .a1x").css({
						overflow: "auto"
					}); //启用滚动条

					ecjia.touch.category.toggle_product_url(modal);
				});

				$(overlay).off('click').on('click', function (e) {
					$(modal).hide();
					$(overlay).hide();
					$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
					$(".ecjia-store-goods .a1n .a1x").css({
						overflow: "auto"
					}); //启用滚动条

					ecjia.touch.category.toggle_product_url(modal);
				});

				ecjia.touch.category.toggle_spec(modal);
				ecjia.touch.category.add_tocart();
				ecjia.touch.category.remove_tocart();

				$('.goods-attr-list').on('touchmove', function (e) {
					e.stopPropagation();
				});
			});
		},

		toggle_product_url: function(modal) {
			var add_tocart_element = $(modal).find('.add-tocart.add_spec');
			var product_id = add_tocart_element.attr('product_id');

			if (product_id !== 0) {
				var go_url = add_tocart_element.attr('data-url');
				if (go_url != null) {
					go_url += '&product_id=' + product_id;
					location.href = go_url;
				}
			}
		},

		toggle_spec: function (modal) {

			//初始值
			var spec_price_label = $(modal).find('input[name="goods_price_label"]').val();
			var goods_attr_label = $(modal).find('input[name="goods_attr_label"]').val();

			if (spec_price_label && goods_attr_label) {
				$(modal).find('.goods-attr-name').html('(' + goods_attr_label + ')');
				$(modal).find('.goods-attr-price').html(spec_price_label);
			}

			//切换属性
			$('.goods-attr-list .goods-attr li').off('click').on('click', function () {
				var $this = $(this);

				if (!$this.hasClass('multi-select')) {
					if ($this.hasClass('active')) {
						return false;
					}
					$this.addClass('active').siblings('li').removeClass('active');
				} else {
					if (!$this.hasClass('active')) {
						$this.addClass('active');
					} else {
						$this.removeClass('active');
					}
				}

				// $spec_html = '(';

				var spec = [];

				$(modal).find('.goods-attr-list').find('li.active').each(function (n, j) {
					spec.push($(this).attr('data-attr'));
					// if (n == 0) {
					// 	$spec_html += $(this).html();
					// } else {
					// 	$spec_html += '/' + $(this).html();
					// }
					// var sprice = parseFloat($(this).attr('data-price'));
					// if (isNaN(sprice)) {
					// 	sprice = 0;
					// }
					// $spec_price += sprice;
				});
				// $spec_price = $spec_price.toFixed(2);
				// $spec_html += ')';
				// if ($spec_price == 0) {
				// 	$spec_price = js_lang.free;
				// } else {
				// 	$spec_price = '￥' + $spec_price;
				// }
				// if ($spec_html == '()') {
				// 	$spec_html = '';
				// }


				var url = $(modal).find('input[name="check_spec"]').val();
				var goods_id = $(modal).find('.add-tocart.add_spec').attr('goods_id');
				var add_tocart_element = $(modal).find('.add-tocart.add_spec');
				var info = {
					'spec': spec,
					'goods_id': goods_id,
				}
				$.post(url, info, function (data) {
					if (data.state == 'error') {
						var myApp = new Framework7();
						if (data.referer_url || data.message == 'Invalid session') {
							$(".ecjia-store-goods .a1n .a1x").css({
								overflow: "hidden"
							}); //禁用滚动条
							//禁用滚动条
							$('body').css('overflow-y', 'hidden').on('touchmove', function (event) {
								event.preventDefault;
							}, false);

							myApp.modal({
								title: js_lang.tips,
								text: js_lang.logged_yet,
								buttons: [{
									text: js_lang.cancel,
									onClick: function () {
										$(".ecjia-store-goods .a1n .a1x").css({
											overflow: "auto"
										}); //启用滚动条
										$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
										return false;
									}
								}, {
									text: js_lang.go_login,
									onClick: function () {
										$(".ecjia-store-goods .a1n .a1x").css({
											overflow: "auto"
										}); //启用滚动条
										$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
										location.href = data.referer_url;
										return false;
									}
								}, ]
							});
						} else {
							ecjia.touch.showmessage(data);
						}
					}
					else {
						// $('input[name="product_id"]').val(data.product_id);
						// $('input[name="goods_id"]').val(data.id);
						add_tocart_element.attr('goods_id', data.id);
						add_tocart_element.attr('product_id', data.product_id);
						$(modal).find('.goods-attr-price').html(data.product_spec.product_shop_price_label);
						$(modal).find('.goods-attr-name').html('(' + data.product_spec.product_goods_attr_label + ')');
						// $('.ecjia-attr-modal').find('#goods_' + goods_id).attr('id', data.id);

						if (data.info) {
							$(modal).find('.ecjia-choose-attr-box.box').removeClass('hide').addClass('show').children('label').html(data.info.goods_number);
							$(modal).find('.ecjia-choose-attr-box.box').children('span').attr('rec_id', data.info.rec_id);
							$(modal).find('.add-tocart.add_spec').addClass('hide').removeClass('show');
						} else {
							$(modal).find('.ecjia-choose-attr-box.box').removeClass('show').addClass('hide').children('label').html('1');
							$(modal).find('.add-tocart.add_spec').removeClass('hide').addClass('show');
							$(modal).find('.ecjia-choose-attr-box.box').children('span').attr('rec_id', '');
						}
					}
					return false;
				});
			});
		},

		promotion_scroll: function () {
			window.doscroll;
			window.clearInterval(window.doscroll);
			doscroll = window.setInterval(function () {
				var $parent = $('#promotion-scroll');
				var length = $parent.find('li.promotion').length;
				if (length > 1) {
					var $first = $parent.find('li.promotion:first');
					var height = $first.height();
					$first.animate({
						marginTop: -height + 'px'
					}, 600, function () {
						$first.css('margin-top', 0).appendTo($parent);
					});
				}
			}, 3000);
		},

		image_preview: function () {
			var initPhotoSwipeFromDOM = function (gallerySelector) {
				var parseThumbnailElements = function (el) {
					var thumbElements = el.childNodes,
						numNodes = thumbElements.length,
						items = [],
						figureEl, linkEl, size, item, divEl;
					for (var i = 0; i < numNodes; i++) {
						figureEl = thumbElements[i];
						if (figureEl.nodeType !== 1) {
							continue
						}
						divEl = figureEl.children[0];
						linkEl = divEl.children[0];
						//			            size = linkEl.getAttribute('data-size').split('x');
						size = [linkEl.children[0].naturalWidth, linkEl.children[0].naturalHeight];
						item = {
							src: linkEl.getAttribute('href'),
							w: parseInt(size[0], 10),
							h: parseInt(size[1], 10)
						};
						if (figureEl.children.length > 1) {
							item.title = figureEl.children[1].innerHTML
						}
						if (linkEl.children.length > 0) {
							item.msrc = linkEl.children[0].getAttribute('src')
						}
						item.el = figureEl;
						items.push(item)
					}
					return items
				};
				var closest = function closest(el, fn) {
					return el && (fn(el) ? el : closest(el.parentNode, fn))
				};
				var onThumbnailsClick = function (e) {
					e = e || window.event;
					e.preventDefault ? e.preventDefault() : e.returnValue = false;
					var eTarget = e.target || e.srcElement;
					var clickedListItem = closest(eTarget, function (el) {
						return (el.tagName && el.tagName.toUpperCase() === 'FIGURE')
					});
					if (!clickedListItem) {
						return
					}
					var clickedGallery = clickedListItem.parentNode,
						childNodes = clickedListItem.parentNode.childNodes,
						numChildNodes = childNodes.length,
						nodeIndex = 0,
						index;
					for (var i = 0; i < numChildNodes; i++) {
						if (childNodes[i].nodeType !== 1) {
							continue
						}
						if (childNodes[i] === clickedListItem) {
							index = nodeIndex;
							break
						}
						nodeIndex++
					}
					if (index >= 0) {
						openPhotoSwipe(index, clickedGallery)
					}
					return false
				};
				var photoswipeParseHash = function () {
					var hash = window.location.hash.substring(1),
						params = {};
					if (hash.length < 5) {
						return params
					}
					var vars = hash.split('&');
					for (var i = 0; i < vars.length; i++) {
						if (!vars[i]) {
							continue
						}
						var pair = vars[i].split('=');
						if (pair.length < 2) {
							continue
						}
						params[pair[0]] = pair[1]
					}
					if (params.gid) {
						params.gid = parseInt(params.gid, 10)
					}
					return params
				};
				var openPhotoSwipe = function (index, galleryElement, disableAnimation, fromURL) {
					var pswpElement = document.querySelectorAll('.pswp')[0],
						gallery, options, items;
					items = parseThumbnailElements(galleryElement);
					options = {
						barsSize: {
							top: 100,
							bottom: 100
						},
						fullscreenEl: false,
						shareButtons: [{
							id: 'wechat',
							label: js_lang.share_wechat,
							url: '#'
						}, {
							id: 'weibo',
							label: js_lang.sina_weibo,
							url: '#'
						}, {
							id: 'download',
							label: js_lang.save_picture,
							url: '{ { raw_image_url } }',
							download: true
						}],
						galleryUID: galleryElement.getAttribute('data-pswp-uid'),
						getThumbBoundsFn: function (index) {
							var thumbnail = items[index].el.getElementsByTagName('img')[0],
								pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
								rect = thumbnail.getBoundingClientRect();
							return {
								x: rect.left,
								y: rect.top + pageYScroll,
								w: rect.width
							}
						}
					};
					if (fromURL) {
						if (options.galleryPIDs) {
							for (var j = 0; j < items.length; j++) {
								if (items[j].pid == index) {
									options.index = j;
									break
								}
							}
						} else {
							options.index = parseInt(index, 10) - 1
						}
					} else {
						options.index = parseInt(index, 10)
					}
					if (isNaN(options.index)) {
						return
					}
					if (disableAnimation) {
						options.showAnimationDuration = 0
					}
					gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
					gallery.init()
				};
				var galleryElements = document.querySelectorAll(gallerySelector);
				for (var i = 0, l = galleryElements.length; i < l; i++) {
					galleryElements[i].setAttribute('data-pswp-uid', i + 1);
					galleryElements[i].onclick = onThumbnailsClick
				}
				var hashData = photoswipeParseHash();
				if (hashData.pid && hashData.gid) {
					openPhotoSwipe(hashData.pid, galleryElements[hashData.gid - 1], true, true)
				}
			};
			initPhotoSwipeFromDOM('.img-pwsp-list');
			$(".my-gallery>figure>div").each(function () {
				$(this).height($(this).width())
			});

			function more(obj, id) {
				if ($('#txt' + id).is(":hidden")) {
					$('#p' + id).hide();
					$('#txt' + id).show();
					obj.innerHTML = js_lang.collapse
				} else {
					$('#p' + id).show();
					$('#txt' + id).hide();
					obj.innerHTML = js_lang.full_text
				}
			}
		},

		follow_store: function() {
			$('[data-toggle="follow_store"]').off('click').on('click', function() {
				var $this = $(this),
					type = $this.attr('data-type'),
					url = $this.attr('data-url'),
					message = $this.attr('data-message');
				if ($this.hasClass('disabled')) {
					return false;
				}
				$this.addClass('disabled');
				if (message != undefined) {
					var myApp = new Framework7();
					//禁用滚动条
					$('body').css('overflow-y', 'hidden').on('touchmove', function (event) {
						event.preventDefault;
					}, false);

					myApp.modal({
						title: js_lang.cancel_store,
						buttons: [{
							text: js_lang.cancel,
							onClick: function () {
								$('.modal').remove();
								$('.modal-overlay').remove();
								$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
								return false;
							}
						}, {
							text: js_lang.ok,
							onClick: function () {
								$('.modal').remove();
								$('.modal-overlay').remove();
								$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
								$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
								ecjia.touch.category.follow_store_update($this, url, type);
							},
						}]
					});
				} else {
					ecjia.touch.category.follow_store_update($this, url, type);
				}
			});
			ecjia.touch.category.delete_line(".ecjia-follow-list .store-info", ".basic-info", ".basic-info", ".remove-info");
		},

		follow_store_update: function(div, url, type) {
			$.post(url, {type: type}, function(data) {
				$('.la-ball-atom').remove();
				if (data.state == 'error') {
					$('[data-toggle="follow_store"]').removeClass('disabled');
					var myApp = new Framework7();
					if (data.referer_url || data.message == 'Invalid session') {
						$(".ecjia-store-goods .a1n .a1x").css({
							overflow: "hidden"
						}); //禁用滚动条
						//禁用滚动条
						$('body').css('overflow-y', 'hidden').on('touchmove', function (event) {
							event.preventDefault;
						}, false);

						myApp.modal({
							title: js_lang.tips,
							text: js_lang.logged_yet,
							buttons: [{
								text: js_lang.cancel,
								onClick: function () {
									$('.modal').remove();
									$('.modal-overlay').remove();
									$(".ecjia-store-goods .a1n .a1x").css({
										overflow: "auto"
									}); //启用滚动条
									$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
									return false;
								}
							}, {
								text: js_lang.go_login,
								onClick: function () {
									$('.modal').remove();
									$('.modal-overlay').remove();
									$(".ecjia-store-goods .a1n .a1x").css({
										overflow: "auto"
									}); //启用滚动条
									$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
									location.href = data.referer_url;
									return false;
								}
							}, ]
						});
						return false;
					} else {
						alert(data.message);
						return false;
					}
				} else {
					iosOverlay({
						text: data.message,
						duration: 500,
						onhide: function() {
							$('[data-toggle="follow_store"]').removeClass('disabled');
							if ($.find('.ecjia-follow-list').length != 0) {
								div.parent('.store-info').remove();
								if ($('.ecjia-follow-list').find('.store-info').length == 0) {
									$('.ecjia-follow-list').html('<div class="ecjia-empty-list"><div class="ecjia-nolist">' + js_lang.no_attention_store + '</div></div>');
								}
								return false;
							}
							if (type == 1) {
								$('.follower').addClass('not').html(js_lang.has_been_concerned).attr('data-type', 0);
							} else {
								$('.follower').removeClass('not').html('<i class="iconfont icon-add"></i>'+ js_lang.attention).attr('data-type', 1);
							}
						}
					});
				}
			});
		},

		//删除行
		//lines 要删除的行div
		//left 该行显示的div
		//right 该行显示的div
		//btn 删除按钮
		delete_line: function(lines, left, right, btn) {
			// 获取所有行，对每一行设置监听
			var lines = $(lines);
			var len = lines.length;
			var lastX, lastXForMobile;
			// 用于记录被按下的对象
			var pressedObj; // 当前左滑的对象
			var lastLeftObj; // 上一个左滑的对象
			// 用于记录按下的点
			var start;
			// 网页在移动端运行时的监听
			for (var i = 0; i < len; ++i) {
				lines[i].addEventListener('touchstart', function (e) {
					lastXForMobile = e.changedTouches[0].pageX;
					pressedObj = this; // 记录被按下的对象 

					// 记录开始按下时的点
					var touches = e.touches[0];
					start = {
						x: touches.pageX,
						// 横坐标
						y: touches.pageY // 纵坐标
					};
				});

				lines[i].addEventListener('touchmove', function (e) {
					// 计算划动过程中x和y的变化量
					var touches = e.touches[0];
					delta = {
						x: touches.pageX - start.x,
						y: touches.pageY - start.y
					};
					// 横向位移大于纵向位移，阻止纵向滚动
					if (Math.abs(delta.x) > Math.abs(delta.y)) {
						e.preventDefault();
					}
				});

				lines[i].addEventListener('touchend', function (e) {
					var diffX = e.changedTouches[0].pageX - lastXForMobile;
					if (diffX < -110) {
						$(pressedObj).find(left).animate({
							marginLeft: "-60px",
							marginRight: "60px"
						}, 200); // 左滑
						$(pressedObj).find(right).animate({
							marginLeft: "-60px",
							marginRight: "60px"
						}, 200); // 左滑
						$(pressedObj).find(btn).animate({
							width: "60"
						}, 200); // 左滑
					}
					if (diffX > 70) {
						$(pressedObj).find(left).animate({
							marginLeft: "0",
							marginRight: "0"
						}, 200); // 右滑
						$(pressedObj).find(right).animate({
							marginLeft: "0",
							marginRight: "0"
						}, 200); // 右滑
						$(pressedObj).find(btn).animate({
							width: "0"
						}, 200); // 右滑
					}
				});
			}
		}
	};

	ecjia.touch.comment = {
		init: function () {
			ecjia.touch.comment.level_change();
		},

		level_change: function () {
			$('input[name="level-hide"]').val('');
			$('input[name="email"]').val('');
			$('textarea').val('');
			$('.comment-level span').on('mouseover', function () {
				var $this = $(this),
					level = $(this).attr('data-level'),
					hide_level = $('input[name="level-hide"]');
				$this.parent('span').attr('class', 'comment-level rating rating' + level);
				$this.on('click', function () {
					hide_level.val($this.attr('data-level'));
				});
			});
		}
	};

	//切换属性
	function spec_html(modal) {
		// $spec_html = '(';
		// $spec_price = parseFloat($(modal).find($('input[name="goods_price"]')).val());
		// $(modal).find('.goods-attr-list').find('li.active').each(function (n, j) {
		// 	if (n == 0) {
		// 		$spec_html += $(this).html();
		// 	} else {
		// 		$spec_html += '/' + $(this).html();
		// 	}
		// 	var sprice = parseFloat($(this).attr('data-price'));
		// 	if (isNaN(sprice)) {
		// 		sprice = 0;
		// 	}
		// 	$spec_price += sprice;
		// });
		// $spec_price = $spec_price.toFixed(2);
		// $spec_html += ')';
		// if ($spec_price == 0) {
		// 	$spec_price = js_lang.free;
		// } else {
		// 	$spec_price = '￥' + $spec_price;
		// }
		// if ($spec_html == '()') {
		// 	$spec_html = '';
		// }
		// $(modal).find('.goods-attr-name').html($spec_html);
		// $(modal).find('.goods-attr-price').html($spec_price);
	};

	function calc_price(num, price_ladder, price) {
		for (var i=0; i<price_ladder.length; i++) {
			if (num == price_ladder[i]['amount'] || num < price_ladder[i+1]['amount']) {
				return price_ladder[i]['price'];
			} else if (num > price_ladder[i]['amount'] && num >= price_ladder[i+1]['amount']) {
                return price_ladder[i+1]['price'];
			} else {
				return price;
			}
		}
	}

})(ecjia, jQuery);

//end