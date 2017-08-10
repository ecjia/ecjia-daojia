/**
 * 后台综合js文件
 */
;
(function(ecjia, $) {
	ecjia.touch.category = {
		init: function() {
			ecjia.touch.category.openSelection();
			ecjia.touch.category.selectionValue();
			ecjia.touch.category.clear_filter();
			ecjia.touch.category.goods_show();

			ecjia.touch.category.add_tocart();
			ecjia.touch.category.remove_tocart();
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

			//分类列表 点击分类切换 滚动到顶部
			$('.category_left li').on('click', function() {
				$(window).scrollTop(0);
			});
			$('body').css('overflow-y', 'auto').off("touchmove").off('click'); //启用滚动条
			$(".ecjia-store-goods .a1n .a1x").css({
				overflow: "auto"
			}); //启用滚动条	
		},

		//加入购物车
		add_tocart: function() {
			$("[data-toggle='add-to-cart']").off('click').on('click', function(ev) {
				var $this = $(this);
				if ($this.hasClass('disabled') || $this.parents('.item-goods').hasClass('disabled') || $this.hasClass('limit_click')) {
					return false;
				}
				var rec_id = $this.attr('rec_id');
				var goods_id = $this.attr('goods_id');
				$("[data-toggle='add-to-cart']").addClass('limit_click');
				$("[data-toggle='remove-to-cart']").addClass('limit_click');

				//选择商品规格
				if ($this.hasClass('add_spec')) {
					var spec = [];
					$this.parents('.ecjia-attr-modal').find('.goods-attr-list').find('li.active').each(function() {
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
								onEnd: function() { // 回调方法
									!$('.store-add-cart').hasClass('active') && $('.store-add-cart').addClass('active');
									$('img.u-flyer').remove();
								}
							});
						}
					}
					//商品详情点击加入购物车val为1，点击加号val递增，点击猜你喜欢val为NaN，点击店铺首页加号val递增，点击店铺搜索商品结果列表加号val递增
					if (isNaN(val)) {
						if ($this.attr('data-num') != 0) {
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
					ecjia.touch.category.update_cart(rec_id, val, goods_id, '', true, bool_spec, 'add');
				}
			});
		},

		//购物车中移出商品
		remove_tocart: function() {
			$("[data-toggle='remove-to-cart']").off('click').on('click', function(ev) {
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
					$this.parents('.ecjia-attr-modal').find('.goods-attr-list').find('li.active').each(function() {
						spec.push($(this).attr('data-attr'));
					});
					$this.parents('.ecjia-attr-modal').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
					var store_id = $('input[name="store_id"]').val();
					var val = parseInt($this.siblings('label').html()) - 1;
					var goods_id = $this.attr('goods_id');
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
						$('.minicart-content').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
						var val = parseInt($this.next().html()) - 1;
						if (val == 0) {
							if ($('.minicart-goods-list').children('li').length == 0) {
								$('.store-add-cart').removeClass('active');
								$('.store-add-cart').children('.a4x').removeClass('light').addClass('disabled').children('.a4y').remove();
								$('.store-add-cart').children('.a4z').children('div').addClass('a50').html('购物车是空的');
								$('.store-add-cart').children('.a51').addClass('disabled');
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
							show.removeClass('show').addClass('hide');
							$this.parent('.box').children('.reduce').removeClass('show').addClass('hide');
							span.attr('rec_id', '');
							var span_add = $this.parent().siblings('span');
							if (span_add.hasClass('goods-add-cart')) {
								$this.parent().children('span').addClass('hide');
								span_add.removeClass('hide').addClass('disabled').attr('rec_id', '');
							}
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

		//切换购物车 弹出/隐藏 效果
		toggle_cart: function() {
			$('.show_cart').off('click').on('click', function(e) {
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

			$('.a53').off('click').on('click', function(e) {
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
		update_cart: function(rec_id, val, goods_id, checked, store, spec, type, div) {
			var url = $('input[name="update_cart_url"]').val();
			var store_id = $('input[name="store_id"]').val();

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
			};

			//更新购物车中商品
			$.post(url, info, function(data) {
				$('.la-ball-atom').remove();
				$('.box').children('span').addClass('limit_click'); //禁止其他加减按钮点击
				$('[data-toggle="toggle_checkbox"]').removeClass('limit_click'); //店铺首页 允许其他单选框点击
				$("[data-toggle='add-to-cart']").removeClass('limit_click');
				$("[data-toggle='remove-to-cart']").removeClass('limit_click');

				$('.goods-add-cart').removeClass('disabled');
				if (data.state == 'error') {
					var myApp = new Framework7();

					$('.la-ball-atom').remove();
					if (data.referer_url || data.message == 'Invalid session') {
						$(".ecjia-store-goods .a1n .a1x").css({
							overflow: "hidden"
						}); //禁用滚动条
						//禁用滚动条
						$('body').css('overflow-y', 'hidden').on('touchmove', function(event) {
							event.preventDefault;
						}, false);

						myApp.modal({
							title: '温馨提示',
							text: '您还没有登录',
							buttons: [{
								text: '取消',
								onClick: function() {
									$('.modal').remove();
									$('.modal-overlay').remove();
									$(".ecjia-store-goods .a1n .a1x").css({
										overflow: "auto"
									}); //启用滚动条
									$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
									return false;
								}
							}, {
								text: '去登录',
								onClick: function() {
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

				if (div != undefined) {
					if (div.hasClass('other_place')) {
						if (div.parent().find('.other_place').length == 1) {
							$('.a4u.a4u-gray').remove();
						}
					} else if (div.hasClass('current_place')) {
						if (div.parent().find('.current_place').length == 1) {
							$('.a4u.a4u-green').after('<div class="a57"><span>当前位置购物车空空如也哦～</span></div>');
						}
					}
					div.remove();
					if ($('.a57').length == 1 && $('.a4u-gray').length == 0) {
						var index_url = $('input[name="index_url"]').val();
						$('.ecjia-flow-cart-list').html('').html('<div class="flow-no-pro"><div class="ecjia-nolist">您还没有添加商品<a class="btn btn-small" type="button" href="' + index_url + '">去逛逛</a></div>');
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
							discount_html = '<label class="discount">(已减' + data.count.discount + ')<label>';
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
						if (isNaN(n)) n = 1;
						if ($('.goods_spec_' + goods_id).find('.attr-number').length == 0) {
							$('.goods_spec_' + goods_id).append('<i class="attr-number">' + n + '</i>');
						} else {
							$('.goods_spec_' + goods_id).find('.attr-number').html(n);
						}
					} else if (type == 'reduce') {
						var n = parseInt($('.goods_spec_' + goods_id).children('i').html()) - 1;
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
						$('.ecjia-attr-modal').find('#goods_' + goods_id).removeClass('show').addClass('hide').children().attr('rec_id', '');
					} else {
						$('.ecjia-attr-modal').find('.add-tocart').removeClass('show').addClass('hide');
						$('.ecjia-attr-modal').find('#goods_' + goods_id).addClass('show').removeClass('hide');
						$('.ecjia-attr-modal').find('#goods_' + goods_id).children().addClass('show').removeClass('hide');
					}
					$('.ecjia-attr-modal').find('#goods_' + goods_id).children('label').html(val);
				}

				if (data.count == null) {
					ecjia.touch.category.hide_cart(true);
				} else {
					ecjia.touch.category.show_cart(true);
					var goods_number = data.count.goods_number;

					if (spec == '') {
						for (i = 0; i < data.list.length; i++) {
							if (data.say_list) {
								if (data.list[i].goods_id == goods_id) {
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
						$('#goods_' + goods_id).children('label').removeClass('hide').html(data.current.goods_number);
					}

					if (data.say_list) {
						$('.minicart-goods-list').html(data.say_list);
					}

					$('p.a6c').html('(已选' + data.count.goods_number + '件)')
					if (goods_number > 99) {
						$('.a4x').html('<i class="a4y">99+</i>');
					} else {
						$('.a4x').html('<i class="a4y">' + goods_number + '</i>');
					}

					if (data.count.goods_number == 0) {
						$('.a51').addClass('disabled');
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
						discount_html = '<label>(已减' + data.count.discount + ')<label>';
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
				}
				ecjia.touch.category.check_all();
			});
		},

		//显示购物车
		show_cart: function(bool) {
			if (bool) {
				$('.store-add-cart').children('.a4x').addClass('light').removeClass('disabled');
				$('.store-add-cart').children('.a51').removeClass('disabled');
			} else {
				//禁用滚动条
				$('body').css('overflow-y', 'hidden').on('touchmove', function(event) {
					event.preventDefault;
				}, false);
				$('.minicart-content').on('touchmove', function(e) {
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
		hide_cart: function(bool) {
			//启用滚动条
			$('body').css('overflow-y', 'auto').off("touchmove");

			$('.store-add-cart').find('.a4z').css('transform', 'translateX(0px)');
			$('.a53').css('display', 'none');
			$('.store-add-cart').find('.minicart-content').css('transform', 'translateY(0px)');

			$('.minicart-content').children('.a4x').removeClass('show').attr('show', false);
			$('.store-add-cart').children('.a4x').addClass('show').attr('show', false);

			//购物车完全清空
			if (bool == true) {
				$('.store-add-cart').removeClass('active');
				$('.a4y').remove();
				$('.store-add-cart').children('.a4x').addClass('disabled').addClass('outcartcontent').removeClass('light').removeClass('incartcontent');
				$('.minicart-content').children('.a4x').removeClass('light').addClass('disabled');
				$('.store-add-cart').children('.a4z').children('div').addClass('a50').html('购物车是空的');
				$('.store-add-cart').children('.a51').addClass('disabled');
				$('.minicart-goods-list').html('');
			}
			//启用用滚动条
			$(".ecjia-store-goods .a1n .a1x").css({
				overflow: "auto"
			});
		},

		//店铺首页切换分类
		toggle_category: function() {
			$('[data-toggle="toggle-category"]').off('click').on('click', function(e) {
				var $this = $(this),
					url = $this.attr('data-href'),
					name = $this.html().trim(),
					category_id = $this.attr('data-category') == undefined ? 0 : $this.attr('data-category'),
					li = $this.parent('li');

				if ($this.hasClass('disabled') || $this.parent().hasClass('a1r') || ($this.hasClass('a1u') && $this.hasClass('active'))) {
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
					$.get(url, info, function(data) {
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

			$('.store-option dl').off('click').on('click', function() {
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
					$('body').css('overflow-y', 'hidden').on('touchmove', function(event) {
						event.preventDefault;
					}, false);
					$('.store-option dl').addClass('disabled'); //禁止切换

					$.get(url, function(data) {
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
							$('#store-comment-' + type).append('<div class="ecjia-nolist"><img src="' + theme_url + 'images/wallet/null280.png"><p class="tags_list_font">暂无商品评论</p></div>');
						} else {
							$('#store-comment-' + type).append(data.list);
						}
						if ($('#store-comment-' + type).find('.assess-flat').length != 0) {
							$('.ecjia-store-comment .store-container').css('padding-bottom', '7em');
						}
						//商品详情评分
						$('.score-goods').each(function() {
							$(this).raty({
								readOnly: true,
								score: function() {
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

		scroll: function() {
			var mybody = document.getElementById('wd_list');
			if (mybody != null) {
				//滑动处理
				var startX, startY, moveEndX, moveEndY, X, Y;
				mybody.addEventListener('touchstart', function(e) {
					startX = e.touches[0].pageX;
					startY = e.touches[0].pageY;
				});
				mybody.addEventListener('touchmove', function(e) {
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
				comment_body.addEventListener('touchstart', function(e) {
					startX = e.touches[0].pageX;
					startY = e.touches[0].pageY;
				});
				comment_body.addEventListener('touchmove', function(e) {
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
				store_seller.addEventListener('touchstart', function(e) {
					startX = e.touches[0].pageX;
					startY = e.touches[0].pageY;
				});
				store_seller.addEventListener('touchmove', function(e) {
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

		scroll_show_hide: function(e) {
			if (e == true) {
				$('.ecjia-store-banner').css('height', 0);

				$('.page_hearder_hide').show();
				$('.ecjia-store-goods').children('.a1n').css('top', '6.6em');

				//店铺评论
				$('.ecjia-store-ul').css('top', '3em');
				$('.ecjia-seller-comment').css('top', '6.6em');
				$('.ecjia-store-detail').css('top', '6.6em');
			} else {
				$('.ecjia-store-banner').css('height', '12.5em');
				$('.page_hearder_hide').hide();
				$('.ecjia-store-goods').children('.a1n').css('top', '16em');

				//店铺评论
				$('.ecjia-store-ul').css('top', '11.5em');
				$('.ecjia-seller-comment').css('top', '16em');
				$('.ecjia-store-detail').css('top', '16em');
			}
		},

		//店铺首页 商品详情 店铺内搜索 清空购物车
		deleteall: function() {
			$('[data-toggle="deleteall"]').off('click').on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('data-url');
				var myApp = new Framework7();
				myApp.modal({
					title: '清空购物车中所有商品？',
					buttons: [{
						text: '取消',
						onClick: function() {
							$('.modal').remove();
							$('.modal-overlay').remove();
							return false;
						}
					}, {
						text: '确定',
						onClick: function() {
							$('.modal').remove();
							$('.modal-overlay').remove();
							var rec_id = [];
							var store_id = $('input[name="store_id"]').val();

							$('input[name="rec_id"]').each(function() {
								rec_id.push($(this).val());
							});
							var info = {
								'store_id': store_id,
								'rec_id': rec_id,
							};
							$.post(url, info, function(data) {
								if (data.state == 'success') {
									ecjia.touch.category.hide_cart(true);
									if ($.find('.box').length != 0) {
										$('.box').each(function() {
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

			// 获取所有行，对每一行设置监听
			var lines = $(".ecjia-flow-cart .a4w");
			var len = lines.length;
			var lastX, lastXForMobile;
			// 用于记录被按下的对象
			var pressedObj; // 当前左滑的对象
			var lastLeftObj; // 上一个左滑的对象
			// 用于记录按下的点
			var start;
			// 网页在移动端运行时的监听
			for (var i = 0; i < len; ++i) {
				lines[i].addEventListener('touchstart', function(e) {
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

				lines[i].addEventListener('touchmove', function(e) {
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

				lines[i].addEventListener('touchend', function(e) {
					var diffX = e.changedTouches[0].pageX - lastXForMobile;
					if (diffX < -110) {
						$(pressedObj).find('.a4x').animate({
							marginLeft: "-60px",
							marginRight: "60px"
						}, 200); // 左滑
						$(pressedObj).find('.a4y').animate({
							marginLeft: "-60px",
							marginRight: "60px"
						}, 200); // 左滑
						$(pressedObj).find('.w4').animate({
							width: "60"
						}, 200); // 左滑
					}
					if (diffX > 70) {
						$(pressedObj).find('.a4x').animate({
							marginLeft: "0",
							marginRight: "0"
						}, 200); // 右滑
						$(pressedObj).find('.a4y').animate({
							marginLeft: "0",
							marginRight: "0"
						}, 200); // 右滑
						$(pressedObj).find('.w4').animate({
							width: "0"
						}, 200); // 右滑
					}
				});
			}
		},

		//店铺首页 单选
		toggle_checkbox: function() {
			$('[data-toggle="toggle_checkbox"]').off('click').on('click', function(e) {
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
					$('.minicart-goods-list .checkbox').each(function() {
						rec_id.push($(this).attr('rec_id'));
					});
				} else {
					checked = $this.hasClass('checked') ? 1 : 0;
					var rec_id = $this.attr('rec_id');
				}
				ecjia.touch.category.update_cart(rec_id, 0, 0, checked, true);
			});

			$('.ecjia-number-contro').off('focus').on('focus', function() {
				if ($(this).hasClass('disabled')) {
					return false;
				}
				var v = $(this).val();

				$(this).off('blur').on('blur', function() {
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
							title: '修改数量失败请重试',
							buttons: [{
								text: '确定',
								onClick: function() {
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
		check_all: function() {
			var chknum = $(".minicart-goods-list .checkbox").size(); //选项总个数 
			var chk = 0;
			$(".minicart-goods-list .checkbox").each(function() {
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
		check_cart: function() {
			$('.check_cart, .w4').off('click').on('click', function(e) {
				e.stopPropagation();
				var $this = $(this),
					url = $this.attr('data-href'),
					store_id = $this.attr('data-store'),
					address_id = $this.attr('data-address'),
					rec_id = $this.attr('data-rec');

				var myApp = new Framework7();
				if ($this.hasClass('remove_all')) {
					//禁用滚动条
					$('body').css('overflow-y', 'hidden').on('touchmove', function(event) {
						event.preventDefault;
					}, false);

					myApp.modal({
						title: '确定删除该店铺下全部商品？',
						buttons: [{
							text: '取消',
							onClick: function() {
								$('.modal').remove();
								$('.modal-overlay').remove();
								$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
								return false;
							}
						}, {
							text: '确定',
							onClick: function() {
								$('.modal').remove();
								$('.modal-overlay').remove();
								$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
								$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');

								var rec_id = [];
								var div = $this.parent('.a4w');
								div.find('li').each(function() {
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

//        		if (address_id != undefined && address_id != '') {
//        			url += '&address_id=' + address_id;
//        		} else {
//        			//禁用滚动条
//                	$('body').css('overflow-y', 'hidden').on('touchmove',function(event){event.preventDefault;}, false);
//                	
//                	var height = ($('body').scrollTop() + 160) + 'px';
//        			$('.ecjia-modal').show().css('top', height);
//        			$('.ecjia-modal-overlay').show();
//        			myApp.openModal('.ecjia-modal');
//        			$('.modal-overlay').remove();
//        			
//        			$('body').on('click', function(){
//        				$('.ecjia-modal').hide();
//        				$('.ecjia-modal-overlay').hide();
//        				$('body').css('overflow-y', 'auto').off("touchmove");		//启用滚动条
//        			});
//        			return false;
//        		}
				if (rec_id != undefined) {
					url += '&rec_id=' + rec_id;
				}
				ecjia.pjax(url);
			});
			$('.modal-inner').click(function(e) {
				e.stopPropagation(); //阻止事件向上冒泡
			});
			$('.modal-buttons').click(function(e) {
				e.stopPropagation(); //阻止事件向上冒泡
			});
		},

		//购物车列表 单选多选切换
		check_goods: function() {
			$('.cart-checkbox').off('click').on('click', function() {
				var $this = $(this),
					store_id = $this.attr('data-store'),
					checked, rec_id = [];

				//删除
				if ($this.hasClass('edit')) {
					//全部删除
					if ($this.hasClass('check_all')) {
						//禁用滚动条
						$('body').css('overflow-y', 'hidden').on('touchmove', function(event) {
							event.preventDefault;
						}, false);

						rec_id = $('.check_cart_' + store_id).attr('data-rec');
						var myApp = new Framework7();
						myApp.modal({
							title: '确定删除该店铺下全部商品？',
							buttons: [{
								text: '取消',
								onClick: function() {
									$('.modal').remove();
									$('.modal-overlay').remove();

									$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
									return false;
								}
							}, {
								text: '确定',
								onClick: function() {
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
//            			if (li.siblings('li').length == 0) {
//            				li.parents('.cart-single').remove();
//            				if ($('li.cart-single').length == 0) {
//            					$('.ecjia-flow-cart').remove();
//            					$('.flow-no-pro').removeClass('hide');
//            				}
//            			}
//            			li.remove();
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
					$(".checkbox_" + store_id).each(function() {
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
		cart_edit: function() {
			$('.shop-edit').off('click').on('click', function() {
				var $this = $(this),
					store_id = $this.attr('data-store'),
					type = $this.attr('data-type'),
					data_type, text, color, button_text;
				if (type == 'edit') {
					data_type = 'complete';
					text = '完成';
					button_text = '全部删除';
					$this.addClass('edit_font_color');
					$('.check_cart_' + store_id).text(button_text).addClass('remove_all');
					$('#store_check_' + store_id).addClass('edit');
					$('.checkbox_' + store_id).addClass('edit');
				} else {
					data_type = 'edit';
					text = '编辑';
					button_text = '去结算';
					$this.removeClass('edit_font_color');
					$('.check_cart_' + store_id).text(button_text).removeClass('remove_all');
					$('#store_check_' + store_id).removeClass('edit');
					$('.checkbox_' + store_id).removeClass('edit');
				}
				$this.attr('data-type', data_type).text(text);
			});
		},

		openSelection: function() { /*商品列表页面点击显示筛选*/
			$('[data-toggle="openSelection"]').on('click', function(e) {
				e.preventDefault();
				$(".goods-filter-box").toggleClass("show");
			}); /*商品列表页面点击隐藏筛选*/
			$('[data-toggle="closeSelection"]').on('click', function(e) {
				e.preventDefault();
				if ($(".goods-filter-box").hasClass("show")) {
					$(".goods-filter-box").removeClass("show");
				} else {
					$(".goods-filter-box").addClass("show");
				}
			});
		},

		/*筛选的属性下拉*/
		selectionValue: function() {
			$('.goods-filter .title').on('click', function(e) {
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
			$('.goods-filter .goods-filter-box-content .goods-filter-box-listtype ul li a').on('click', function(e) {
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
			$(".goods-filter .goods-filter-box-content .btns .btn-default").on("click", function(e) {
				e.preventDefault();
				$(".goods-filter .goods-filter-box-content .goods-filter-box-listtype .title").each(function(i) {
					$(this).children(".range").text("全部");
				});
			});
		},

		clear_filter: function() {
			$('[data-toggle="clear_filter"]').on('click', function(e) {
				e.preventDefault();
				$("input[name='price_min']").val('');
				$("input[name='price_max']").val('');
				$("input[name='brand']").val('');
				$(".touchweb-com_listType .range").text("全部");
				$(".touchweb-com_listType input").each(function() {
					if ($(this).attr('class') != 'cat') {
						$(this).val("");
					}
				});
			});
		},

		goods_show: function() {
			$(document).off('click', '.view-more');
			$(document).on('click', '.view-more', function(e) {
				e.preventDefault();
				var $this = $(this);

				if ($this.hasClass('retract')) {
					$this.parent().siblings('.single_store').children().find('.goods-hide-list').hide();
				} else {
					$this.parent().siblings('.single_store').children().find('.goods-hide-list').fadeIn("slow");
				}
				$this.addClass('hide').siblings('.goods-info').removeClass('hide');
			});

			$('.category_left li').off('click').on('click', function() {
				$('.ecjia-category-list').removeClass('show');
				var $this = $(this)
				cat_id = $this.children('a').attr('data-val');
				$this.addClass('active').siblings('li').removeClass('active');
				$('#category_' + cat_id).removeClass('hide').siblings('.ecjia-category-list').addClass('hide');
			});
		},

		store_toggle: function() {
			$('li.favourable_notice, .store-description').off('click').on('click', function() {
				var $this = $(this);

				var myApp = new Framework7();
				//禁用滚动条
				$('body').css('overflow-y', 'hidden').on('touchmove', function(event) {
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

				$('.ecjia-close-modal-icon').on('click', function() {
					$('.ecjia-store-modal').hide();
					$('.ecjia-store-modal-overlay').hide();
					$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
				});
				return false;
			});
			$('.modal-inners').click(function(e) {
				e.stopPropagation(); //阻止事件向上冒泡
			});

			$('.ecjia-store-li').off('click').on('click', function() {
				var $this = $(this),
					url = $this.attr('data-url');

				if (url != undefined) {
					ecjia.pjax(url);
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
				$('.score-goods').each(function() {
					$(this).raty({
						readOnly: true,
						score: function() {
							return $(this).attr('data-val');
						},
					});
				});
			}


			//店铺首页商品评分
			if ($.find($('.score-val')).length >= 0) {
				$('.score-val').raty({
					readOnly: true,
					score: function() {
						$('.score-val').html('');
						if ($('.score-val').find('img').length == 0) {
							return $(this).attr('data-val') * 5;
						}
					},
				});
			}

			$('.choose_attr').off('click').on('click', function() {
				var $this = $(this);
				var myApp = new Framework7();
				var goods_id = $this.attr('goods_id');
				var store_id = $this.attr('data-store');
				var url = $this.attr('data-url');
				var spec = $this.attr('data-spec');
				var modal = '.ecjia-goodsAttr-modal';

				if (spec != undefined && spec.length != 0) {
					var spec_arr = spec.split(',');
				}
				var error = 0;
				if ($this.hasClass('spec_goods')) {
					var choose_attr = $('.goods_attr.goods_spec_' + goods_id).children('.choose_attr');
					if (store_id == undefined) store_id = choose_attr.attr('data-store');
					if (url == undefined) url = choose_attr.attr('data-url');
					if (spec == undefined) spec = choose_attr.attr('data-spec');
					if (spec != undefined && spec.length != 0) {
						var spec_arr = spec.split(',');
					}
					var modal = '.ecjia-attr-static';
					for (var i in releated_goods) {
						var r = releated_goods[i];
						if (r.goods_info != undefined && goods_id == r.goods_info.goods_id) {
							$('.ecjia-attr-static .modal-title').html(r.goods_info.name);
							$('.ecjia-attr-static .goods-attr-list').html('');
							var html = '';
							for (var j in r.goods_info.specification) {
								var s = r.goods_info.specification[j];
								html += '<div class="goods-attr" data-index=' + j + '><p class="attr-name">' + s.name + '<p>' + '<ul>';
								for (var k in s.value) {
									var t = s.value[k];
									if (spec_arr != undefined) {
										if ($.inArray(t.id, spec_arr) != -1) {
											html += '<li class="active" data-attr=' + t.id + ' data-price=' + t.price + '>' + t.label + '</li>';
										} else {
											html += '<li data-attr=' + t.id + ' data-price=' + t.price + '>' + t.label + '</li>';
										}
									} else {
										if (k == 0) {
											html += '<li class="active" data-attr=' + t.id + ' data-price=' + t.price + '>' + t.label + '</li>';
										} else {
											html += '<li data-attr=' + t.id + ' data-price=' + t.price + '>' + t.label + '</li>';
										}
									}
								}
								html += '</ul></div>';
							}
							$('.ecjia-attr-static .goods-attr-list').html(html);
							$('.ecjia-attr-static .ecjia-choose-attr-box').children('span').attr('goods_id', goods_id);
							$('.ecjia-attr-static input[name="goods_price"]').val(r.goods_price);

							var info = {
								'goods_id': goods_id,
								'spec': spec,
								'store_id': store_id
							};
							var error = 0;
							$.ajax({
								type: "post",
								url: url,
								data: info,
								async: false,
								success: function(data) {
									if (data.state == 'error') {
										error = 1;
										if (data.referer_url || data.message == 'Invalid session') {
											$(".ecjia-store-goods .a1n .a1x").css({
												overflow: "hidden"
											}); //禁用滚动条
											//禁用滚动条
											$('body').css('overflow-y', 'hidden').on('touchmove', function(event) {
												event.preventDefault;
											}, false);

											myApp.modal({
												title: '温馨提示',
												text: '您还没有登录',
												buttons: [{
													text: '取消',
													onClick: function() {
														$('.modal').remove();
														$('.modal-overlay').remove();
														$(".ecjia-store-goods .a1n .a1x").css({
															overflow: "auto"
														}); //启用滚动条
														$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
														return false;
													}
												}, {
													text: '去登录',
													onClick: function() {
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
									} else {
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
								},
							});
						}
					}
				}
				if (error == 1) {
					return false;
				}
				spec_html(modal);

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
				$('body').css('overflow-y', 'hidden').on('touchmove', function(event) {
					event.preventDefault();
				}, false);
				$(".ecjia-store-goods .a1n .a1x").css({
					overflow: "hidden"
				}); //禁用滚动条

				myApp.openModal(modal);
				$('.modal-overlay').remove();

				$('.ecjia-close-modal-icon').on('click', function() {
					$(modal).hide();
					$(overlay).hide();
					$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
					$(".ecjia-store-goods .a1n .a1x").css({
						overflow: "auto"
					}); //启用滚动条
				});

				$(overlay).off('click').on('click', function(e) {
					$(modal).hide();
					$(overlay).hide();
					$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
					$(".ecjia-store-goods .a1n .a1x").css({
						overflow: "auto"
					}); //启用滚动条
				});

				ecjia.touch.category.toggle_spec(modal);
				ecjia.touch.category.add_tocart();
				ecjia.touch.category.remove_tocart();

				$('.goods-attr-list').on('touchmove', function(e) {
					e.stopPropagation();
				});
			});
		},

		toggle_spec: function(modal) {
			//切换属性
			$('.goods-attr-list .goods-attr li').off('click').on('click', function() {
				var $this = $(this);
// 				var index = $this.parents('.goods-attr').attr('data-index');
// 				if (index == 0) {
// 					$('div.goods-attr:gt(0)').find('li:eq(0)').addClass('active').siblings('li').removeClass('active');
// 				}
				$this.addClass('active').siblings('li').removeClass('active');

				$spec_html = '(';
				$spec_price = parseFloat($(modal).find('input[name="goods_price"]').val());
				var spec = [];

				$(modal).find('.goods-attr-list').find('li.active').each(function(n, j) {
					spec.push($(this).attr('data-attr'));
					if (n == 0) {
						$spec_html += $(this).html();
					} else {
						$spec_html += '/' + $(this).html();
					}
					var sprice = parseFloat($(this).attr('data-price'));
					if (isNaN(sprice)) {
						sprice = 0;
					}
					$spec_price += sprice;
				});
				$spec_price = $spec_price.toFixed(2);
				$spec_html += ')';
				if ($spec_price == 0) {
					$spec_price = '免费';
				} else {
					$spec_price = '￥' + $spec_price;
				}
				$(modal).find('.goods-attr-name').html($spec_html);
				$(modal).find('.goods-attr-price').html($spec_price);

				var url = $(modal).find('input[name="check_spec"]').val();
				var goods_id = $(modal).find('.add-tocart.add_spec').attr('goods_id');

				var info = {
					'spec': spec,
					'goods_id': goods_id,
				}
				$.post(url, info, function(data) {
					if (data.state == 'error') {
						var myApp = new Framework7();
						if (data.referer_url || data.message == 'Invalid session') {
							$(".ecjia-store-goods .a1n .a1x").css({
								overflow: "hidden"
							}); //禁用滚动条
							//禁用滚动条
							$('body').css('overflow-y', 'hidden').on('touchmove', function(event) {
								event.preventDefault;
							}, false);

							myApp.modal({
								title: '温馨提示',
								text: '您还没有登录',
								buttons: [{
									text: '取消',
									onClick: function() {
										$(".ecjia-store-goods .a1n .a1x").css({
											overflow: "auto"
										}); //启用滚动条
										$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
										return false;
									}
								}, {
									text: '去登录',
									onClick: function() {
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
					} else {
						if (data.info) {
							$(modal).find('.ecjia-choose-attr-box.box').removeClass('hide').addClass('show').children('label').html(data.info.goods_number);
							$(modal).find('.ecjia-choose-attr-box.box').children('span').attr('rec_id', data.info.rec_id);
							$(modal).find('.add-tocart.add_spec').addClass('hide').removeClass('show');
						} else {
							$(modal).find('.ecjia-choose-attr-box.box').addClass('hide').removeClass('show').children('label').html('1');
							$(modal).find('.add-tocart.add_spec').removeClass('hide').addClass('show');
							$(modal).find('.ecjia-choose-attr-box.box').children('span').attr('rec_id', '');
						}
					}
					return false;
				});
			});
		},

		promotion_scroll: function() {
			window.doscroll;
			window.clearInterval(window.doscroll);
			doscroll = window.setInterval(function() {
				var $parent = $('#promotion-scroll');
				var length = $parent.find('li.promotion').length;
				if (length > 1) {
					var $first = $parent.find('li.promotion:first');
					var height = $first.height();
					$first.animate({
						marginTop: -height + 'px'
					}, 600, function() {
						$first.css('margin-top', 0).appendTo($parent);
					});
				}
			}, 3000);
		},

		image_preview: function() {
			var initPhotoSwipeFromDOM = function(gallerySelector) {
					var parseThumbnailElements = function(el) {
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
					var onThumbnailsClick = function(e) {
						e = e || window.event;
						e.preventDefault ? e.preventDefault() : e.returnValue = false;
						var eTarget = e.target || e.srcElement;
						var clickedListItem = closest(eTarget, function(el) {
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
					var photoswipeParseHash = function() {
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
					var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
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
								label: '分享微信',
								url: '#'
							}, {
								id: 'weibo',
								label: '新浪微博',
								url: '#'
							}, {
								id: 'download',
								label: '保存图片',
								url: '{ { raw_image_url } }',
								download: true
							}],
							galleryUID: galleryElement.getAttribute('data-pswp-uid'),
							getThumbBoundsFn: function(index) {
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
			$(".my-gallery>figure>div").each(function() {
				$(this).height($(this).width())
			});

			function more(obj, id) {
				if ($('#txt' + id).is(":hidden")) {
					$('#p' + id).hide();
					$('#txt' + id).show();
					obj.innerHTML = '收起'
				} else {
					$('#p' + id).show();
					$('#txt' + id).hide();
					obj.innerHTML = '全文'
				}
			}
		},
	};

	ecjia.touch.comment = {
		init: function() {
			ecjia.touch.comment.level_change();
		},

		level_change: function() {
			$('input[name="level-hide"]').val('');
			$('input[name="email"]').val('');
			$('textarea').val('');
			$('.comment-level span').on('mouseover', function() {
				var $this = $(this),
					level = $(this).attr('data-level'),
					hide_level = $('input[name="level-hide"]');
				$this.parent('span').attr('class', 'comment-level rating rating' + level);
				$this.on('click', function() {
					hide_level.val($this.attr('data-level'));
				});
			});
		}
	};

	ecjia.touch.goods = {
		init: function() {
			ecjia.touch.goods.collect_click();
			ecjia.touch.goods.open_options();
			ecjia.touch.goods.open_booking();
			ecjia.touch.goods.addToCart_click();
			ecjia.touch.goods.changeprice_click();
			ecjia.touch.goods.changeprice_once();
			ecjia.touch.goods.goods_img();
			ecjia.touch.goods.choose_option();
			ecjia.touch.goods.area_change();
			ecjia.touch.goods.address_change();
			ecjia.touch.goods.warehouse();
		},

		area_change: function() {
			$('[data-toggle="region_change"]').on('change', function() {
				var $this = $(this),
					id = $this.attr("id"),
					url = $this.attr("data-url"),
					type = $this.attr("data-type"),
					target = $this.attr("data-target"),
					check = $this.attr("data-city"),
					parent = $this.val();
				if ($("#selCountries").val() == 0) {
					$("#selProvinces").children("option:gt(0)").remove();
					$("#selCities").children("option:gt(0)").remove();
					$("#selDistricts").children("option:gt(0)").remove();
					$("#selDistricts").hide();
				} else {
					if (id == "selCountries") {
						$("#selDistricts").hide();
					} else if (id == "selProvinces") {
						$("#selDistricts").hide();
						if ($("#selProvinces").val() == 0) {
							$("#selCities").children("option:gt(0)").remove();
						}
					} else if (id == "selCities") {
						$("#selDistricts").show();
						if ($("#selCities").val() == 0) {
							$("#selDistricts").children("option:gt(0)").remove();
						}
					}
					$.get(url, {
						'type': type,
						'target': target,
						'parent': parent,
						'checked': check
					}, function(data) {
						if (data.state == 'success') {
							var opt = '';
							if (data.regions) {
								for (var i = 0; i < data.regions.length; i++) {
									if (data.check) {
										if (data.regions[i].region_id == data.check) {
											opt += '<option value="' + data.regions[i].region_id + '" selected="selected">' + data.regions[i].region_name + '</option>';
										} else {
											opt += '<option value="' + data.regions[i].region_id + '">' + data.regions[i].region_name + '</option>';
										}
									} else {
										if (i == 0) {
											opt += '<option value="' + data.regions[i].region_id + '" selected="selected">' + data.regions[i].region_name + '</option>';
										} else {
											opt += '<option value="' + data.regions[i].region_id + '">' + data.regions[i].region_name + '</option>';
										}
									}
								}
								if (id == "selCountries") {
									$("#selProvinces").children("option:gt(0)").remove();
									$("#selProvinces").children("option").after(opt);
								} else if (id == "selProvinces") {
									$("#selCities").children("option:gt(0)").remove();
									$("#selCities").children("option").after(opt);
									$('[data-target="selDistricts"][id="selCities"]').change();
								} else if (id == "selCities") {
									$("#selDistricts").children("option:gt(0)").remove();
									$("#selDistricts").children("option").after(opt);
								}
							}
						} else {
							ecjia.touch.showmessage(data);
						}
					}, 'json');
				}
			})
		},

		address_change: function() {
			$('select[id="selCities"]').on('change', function() {
				$('select[id="selDistricts"]').change();
			});
			$('select[id="selDistricts"]').on('change', function() {
				$('[data-toggle="warehouse"]').change();
			});
			$('[data-toggle="region_change"][id="selProvinces"]').change();
		},

		warehouse: function() {
			$('[data-toggle="warehouse"]').on('change', function() {
				var $this = $(this),
					url = $this.attr('data-url'),
					id = $this.attr('data-id'),
					house = $('select[name="region_id"]').val(),
					province = $('select[id="selProvinces"]').val();
				if (!url || !id) {
					alert('缺少必要参数');
					return;
				}
				$.get(url, {
					'id': id,
					'house': house,
					'region_id': province
				}, function(data) {
					if (data.state == 'success') {
						$('#ECS_GOODS_AMOUNT').html(data.goods.goods_price);
						$('.goods-promote-price').html(data.goods.goods_price);

						$('#shop_goods_number').html(data.goods.goods_number);
						if (data.goods.goods_number > 0) {
							$('.goods_show').hide();
							$('.goodsnumber-show-btn').show();
							$('.goodsnumber-none-btn').hide();
						} else {
							$('.goods_show').show();
							$('.goodsnumber-none-btn').show();
							$('.goodsnumber-show-btn').hide();
						}
					}
				}, 'json');
			});
		},

		collect_click: function() {
			$('[data-toggle="collect"]').on('click', function() {
				var $this = $(this),
					url = $this.attr('data-url'),
					id = $this.attr('data-id'),
					act = $this.hasClass('active');
				if (!url || !id) {
					alert('缺少必要参数，收藏失败');
					return;
				}
				ecjia.touch.goods.collect({
					thisobj: $this,
					url: url,
					id: id,
					act: act
				});
			});
		},

		collect: function(options) {
			$.get(options.url, {
				id: options.id
			}, function(data) {
				if (data.state == 'success') {
					options.thisobj.toggleClass('active');
					var num = $('.goods-like span').text();
					num = parseInt(num);
					if (options.act) {
						num = parseInt(num) - 1;
					} else {
						num = parseInt(num) + 1;
					}
					$('.goods-like span').text(num + "个");
				}
				ecjia.touch.showmessage(data);
			}, 'json');
		},

		open_options: function() {
			var $options = $('.alert-goods-attribute');

			$('[data-toggle="openOptions"]').on('click', function(e) {
				e.preventDefault();
				$options.addClass('active');
				$('.goods-option-conr label.option-radio').each(function(i) {
					if ($(this).prev('input').is(':checked')) {
						$(this).addClass('active');
					}
				});
				$('.goods-option-conr label.option-checkbox').removeClass('active').prev('input').prop('checked', false);
				$('[data-toggle="addToCart"]').attr('data-pjaxurl', $(this).attr('data-pjaxurl'));
				var alt = $(this).attr('data-message');
				alt || $('[data-toggle="addToCart"]').attr('data-message', '1');
			});

			$options.find('.hd i').on('click', function() {
				$options.removeClass('active');
			});
		},

		open_booking: function() {
			$('[data-toggle="booking"]').on('click', function(e) {
				e.preventDefault();
				var pjaxurl = $(this).attr('data-pjaxurl');
				if (window.confirm("商品库存不足\n是否添加缺货登记？", "标题")) {
					ecjia.pjax(pjaxurl);
				}
			});
		},

		addToCart_click: function() {
			$('[data-toggle="addToCart"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					options = {
						$form: $('#ECS_FORMBUY'),
						id: $this.attr('data-id'),
						message: $this.attr('data-message'),
						url: $this.attr('data-url'),
						pjaxurl: $this.attr('data-pjaxurl'),
						parentid: $this.attr('data-parentid'),
						number: $('input[name="number"]').val(),
						quick: 0,
						alt: $this.attr('data-message')
					};
				if (!options.url || !options.id) {
					alert('缺少必要参数，添加购物车失败');
					return;
				}
				ecjia.touch.goods.addToCart(options);
			});
		},

		addToCart: function(options) {
			var $form = options.$form,
				quick = options.quick,
				number = options.number,
				id = options.id,
				message = options.message,
				url = options.url,
				pjaxurl = options.pjaxurl,
				parentid = options.parentid,
				alt = options.alt,
				spec_arr = [];
			// 检查是否有商品规格
			if ($form.length) {
				var j = 0;
				$form.find('[name^=spec_]').each(function(i) {
					var $this = $(this),
						type = $this.attr('type');
					if (type == 'checkbox') {
						if ($this.is(':checked')) {
							spec_arr[j] = $this.val();
							j++;
						}
					} else if ((type == 'radio' && $this.is(':checked')) || $this.is('select')) {
						spec_arr[j] = $this.val();
						j++;
					}
				});
				if ($('[name="number"]').length) number = $('[name="number"]').val();
				quick = 1;
			}

			var goods = {
				quick: quick,
				spec: spec_arr,
				goods_id: id,
				number: number,
				parent: parentid
			};
			$.post(url, {
				goods: goods
			}, function(data) {
				//TODO:加入购物车的错误处理未完成
				if (data.state == 'success') {
					if (alt) {
						if (window.confirm("商品已成功加入购物车\n是否去购物车查看？", "标题")) {
							ecjia.pjax(pjaxurl);
						} else {
							ecjia.pjax(data.link);
						}
					} else {
						ecjia.pjax(data.pjaxurl);
					}
				} else {
					alert(data.message);
				}
			}, 'json');
		},

		changeprice_click: function() {
			$('[data-toggle="changeprice"]').on('click', function() {
				var $this = $(this),
					option = $this.attr('data-option'),
					number = $('#goods_number').val(),
					options = {
						id: $this.attr('data-id'),
						url: $this.attr('data-url')
					};
				if (option == 'del') {
					if (number == 1) {
						number = 1;
						$('#goods_number').val(number);
					} else {
						number = parseInt(number) - 1;
						$('#goods_number').val(number);
					}
				} else {
					number = parseInt(number) + 1;
					$('#goods_number').val(number);
				}
				ecjia.touch.goods._change_price(options, number);
			});
			$('[data-toggle="changeprice_change"]').on('change', function() {
				var $this = $(this),
					number = $('#goods_number').val(),
					options = {
						id: $this.attr('data-id'),
						url: $this.attr('data-url')
					};
				ecjia.touch.goods._change_price(options, number);
			});
			$('[data-toggle="changeprice_blur"]').on('blur', function() {
				var $this = $(this),
					number = $('#goods_number').val(),
					options = {
						id: $this.attr('data-id'),
						url: $this.attr('data-url')
					};
				if (number <= 0) {
					number = 1;
					$('#goods_number').val(1);
				}
				ecjia.touch.goods._change_price(options, number);
			});
			$('[data-toggle="changeprice_parts"]').on('click', function() {
				var $this = $(this),
					number = $('#goods_number').val(),
					options = {
						id: $this.attr('data-id'),
						url: $this.attr('data-url')
					};
				ecjia.touch.goods._change_price(options, number);
			});
		},

		changeprice_once: function() {
			var $this = $('[data-toggle="changeprice"]'),
				id = $this.attr('data-id'),
				url = $this.attr('data-url'),
				options = $this.attr('data-option'),
				number = $('#goods_number').val();
			if (options == 'del') {
				if (number == 1) {
					number = 1;
					$('#goods_number').val(number);
				} else {
					number = parseInt(number) - 1;
					$('#goods_number').val(number);
				}
			} else {
				number = parseInt(number) + 1;
				$('#goods_number').val(number);
			}
			$.get(url, {
				'id': id,
				'attr': '',
				'number': number
			}, function(data) {
				$('#ECS_GOODS_AMOUNT').html(data.message);
			}, 'json');
		},

		_change_price: function(options, number) {
			var val = '';
			for (var i = 0; i < $('[data-toggle="changeprice_change"]').length; i++) {
				val += $('[data-toggle="changeprice_change"]').eq(i).val() + ',';
			}
			for (var i = 0; i < $('[data-toggle="changeprice_parts"]').length; i++) {
				if ($('[data-toggle="changeprice_parts"]').eq(i).is(":checked")) {
					val = val + "," + $('[data-toggle="changeprice_parts"]').eq(i).val();
				} else {
					val = val;
				}
			}
			$.get(options.url, {
				'id': options.id,
				'attr': val,
				'number': number
			}, function(data) {
				$('#ECS_GOODS_AMOUNT').html(data.message);
			}, 'json');

		},

		goods_img: function() {
			var startX, moveEndX, next_has_class, obj_nextmsg = $('.scroller-slidenext .slidenext-msg'),
				obj_nexticon = $('.scroller-slidenext .slidenext-icon');
			var swiper = new Swiper('.goods-imgshow', {
				grabCursor: true,
				centeredSlides: true,
				coverflow: {
					rotate: 50,
					stretch: 0,
					depth: 100,
					modifier: 1,
					slideShadows: true
				},
				//无限滚动
				slidesPerView: 1,
				onTouchStart: function(s, e) {
					startX = e.touches && e.touches[0].pageX ? e.touches[0].pageX : e.pageX;
				},
				onTouchMove: function(s, e) {
					if (s.isEnd) {
						moveEndX = e.touches && e.touches[0].pageX ? e.touches[0].pageX : e.pageX;
						next_has_class = obj_nexticon.hasClass("active");

						if (moveEndX - startX < -80) {
							!next_has_class && obj_nexticon.addClass("active");
							!next_has_class && obj_nextmsg.text('释放查看详情');
						} else {
							next_has_class && obj_nexticon.removeClass("active");
							next_has_class && obj_nextmsg.text('滑动查看详情');
						}
					}
				},
				onTouchEnd: function(s, e) {
					if (s.isEnd) {
						moveEndX = e.changedTouches && e.changedTouches[0].pageX ? e.changedTouches[0].pageX : e.pageX;
						if (moveEndX - startX < -80) {
							$('.goods_info').trigger('click');
						}
					}
				}
			});
		},

		goods_link: function() {
			var swiper = new Swiper('.goods-link-likeshow', {
				slidesPerView: 2,
				paginationClickable: true,
				spaceBetween: 30,
				freeMode: true,
				//无限滚动
				loop: 1
			});
		},

		choose_option: function() {
			$('.goods-option-conr label').on('click', function(e) {
				var $this = $(this);
				if ($this.hasClass('option-checkbox')) {
					if ($this.prev('input').is(':checked')) {
						$this.removeClass('active');
					} else {
						$this.addClass('active');
					}
				} else {
					$this.addClass('active').siblings('label').removeClass('active');
				}
			});
		},

		tmp_good_info: {},

		add_quick: function() {
			$('.addToCart_quick').on('click', function(e) {
				var $this = $(this),
					url = $this.attr('data-url'),
					id = $this.attr('data-id'),
					parent = $this.attr('data-parent');
				ecjia.touch.goods.tmp_good_info.img = $this.parents('li').find('.ecjiaf-fl img').attr('src');
				ecjia.touch.goods.tmp_good_info.name = $this.parents('li').find('.goods-fitting p').eq(0).find('a').text();
				ecjia.touch.goods.tmp_good_info.price = $this.parents('li').find('.goods-fitting p').eq(1).find('span').eq(1).text();
				ecjia.touch.goods.tmp_good_info.id = $this.attr('data-id');
				ecjia.touch.goods.tmp_good_info.parentid = $this.attr('data-parent') || 0;
				$.post(url, {
					goods: {
						goods_id: id,
						parent: parent,
						number: 1,
						spec: {}
					}
				}, function(data) {
					//TODO:加入购物车的错误处理未完成
					if (data.state == 'error' && data.error == 6) {
						ecjia.touch.goods.openSpeDiv(data.message, data.goods_id, data.parent);
					} else {
						ecjia.touch.showmessage(data);
					}
				}, 'json');
			});
		},

		openSpeDiv: function(message, goods_id, parent) {
			// 展示商品信息
			$('.alert-goods-attribute > .hd').html('<img src="' + ecjia.touch.goods.tmp_good_info.img + '" alt="' + ecjia.touch.goods.tmp_good_info.name + '"/><i class="glyphicon glyphicon-remove"></i><p class="alert-goods-name">商品名称' + ecjia.touch.goods.tmp_good_info.name + '</p><p class="alert-price"><b id="ECS_GOODS_AMOUNT">' + ecjia.touch.goods.tmp_good_info.price + '</b></p>');

			// 确认按钮属性
			$('.alert-goods-attribute form .ft [data-toggle="addToCart"]').attr({
				'data-parentid': ecjia.touch.goods.tmp_good_info.parentid,
				'data-id': ecjia.touch.goods.tmp_good_info.id
			});

			// 展示商品属性
			$('.alert-goods-attribute form .bd').html('');
			for (var spec = 0; spec < message.length; spec++) {
				var new_div = $('<div class="goods-option-con"><div class="goods-option-conr"></div>'),
					new_div_con = new_div.find('.goods-option-conr');
				// newDiv.innerHTML += '<hr style="color: #EBEBED; height:1px;"><h6 style="text-align:left; background:#ffffff; margin-left:15px;">' +  message[spec]['name'] + '</h6>';
				new_div_con.before('<span class="spec-name">' + message[spec]['name'] + '</span>');

				if (message[spec]['attr_type'] == 1) {
					for (var val_arr = 0; val_arr < message[spec]['values'].length; val_arr++) {
						if (val_arr == 0) {
							new_div_con.append('<label class="option-radio active"><input name="spec_' + message[spec]['attr_id'] + '" type="radio" checked="checked" value="' + message[spec]['values'][val_arr]['id'] + '" />' + message[spec]['values'][val_arr]['label'] + '[' + message[spec]['values'][val_arr]['format_price'] + ']</label>');
						} else {
							new_div_con.append('<label class="option-radio"><input name="spec_' + message[spec]['attr_id'] + '" type="radio" value="' + message[spec]['values'][val_arr]['id'] + '" />' + message[spec]['values'][val_arr]['label'] + '[' + message[spec]['values'][val_arr]['format_price'] + ']</label>');
						}
					}
					new_div_con.append("<input type='hidden' name='spec_list' value='" + val_arr + "' />");
				} else {
					for (var val_arr = 0; val_arr < message[spec]['values'].length; val_arr++) {
						new_div_con.append('<label class="option-checkbox"><input name="spec_' + message[spec]['attr_id'] + '" type="checkbox" value="' + message[spec]['values'][val_arr]['id'] + '" /><i class="glyphicon glyphicon-ok"></i>' + message[spec]['values'][val_arr]['label'] + '[' + message[spec]['values'][val_arr]['format_price'] + ']</label>');
					}
					new_div_con.append("<input type='hidden' name='spec_list' value='" + val_arr + "' />");
				}
				$('.alert-goods-attribute form .bd').append(new_div);
			}

			$('.alert-goods-attribute').css('display', 'block');

			// 关闭按钮方法
			$('.glyphicon-remove').on('click', function() {
				$('.alert-goods-attribute').css('display', 'none');
			});

			// 属性选择方法
			$('.alert-goods-attribute form .bd label').on('click', function() {
				var $this = $(this);
				$('.alert-goods-attribute form .goods-option-conr label.option-radio').each(function(i) {
					if ($this.find('input').is(':checked')) {
						$this.addClass('active');
					} else {
						$this.removeClass('active');
					}
				});

				if ($this.hasClass('option-checkbox')) {
					if ($this.find('input').is(':checked')) {
						$this.removeClass('active');
					} else {
						$this.addClass('active');
					}
				} else {
					$this.addClass('active').siblings('label').removeClass('active');
				}
			});

			// 确认按钮提交事件
			$('.alert-goods-attribute form .ft [data-toggle="addToCart"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					options = {
						$form: $('.alert-goods-attribute form'),
						id: $this.attr('data-id'),
						message: $this.attr('data-message'),
						url: $this.attr('data-url'),
						pjaxurl: $this.attr('data-pjaxurl'),
						parentid: $this.attr('data-parentid'),
						number: 1,
						quick: 1
					};
				if (!options.url || !options.id) {
					alert('缺少必要参数，添加购物车失败');
					return;
				}
				ecjia.touch.goods.addToCart(options);
			});
		}
	};

	//切换属性
	function spec_html(modal) {
		$spec_html = '(';
		$spec_price = parseFloat($(modal).find($('input[name="goods_price"]')).val());
		$(modal).find('.goods-attr-list').find('li.active').each(function(n, j) {
			if (n == 0) {
				$spec_html += $(this).html();
			} else {
				$spec_html += '/' + $(this).html();
			}
			var sprice = parseFloat($(this).attr('data-price'));
			if (isNaN(sprice)) {
				sprice = 0;
			}
			$spec_price += sprice;
		});
		$spec_price = $spec_price.toFixed(2);
		$spec_html += ')';
		if ($spec_price == 0) {
			$spec_price = '免费';
		} else {
			$spec_price = '￥' + $spec_price;
		}
		$(modal).find('.goods-attr-name').html($spec_html);
		$(modal).find('.goods-attr-price').html($spec_price);
	};
})(ecjia, jQuery);

//end