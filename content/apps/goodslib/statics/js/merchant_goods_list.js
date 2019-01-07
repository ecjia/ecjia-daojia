// JavaScript Document
;
(function(app, $) {
	app.goods_list = {
		init: function() {
			$(".no_search").chosen({
				allow_single_deselect: false,
				disable_search: true
			});
			app.goods_list.search();
			app.goods_list.insertGoods();
			app.goods_list.integral_market_price();
			app.goods_list.marketPriceSetted();
		},

		search: function() {
			$('.screen-btn').on('click', function(e) {
				e.preventDefault();
				var keywords = $("input[name='keywords']").val(); //关键字

				var url = $("form[name='search_form']").attr('action');

				if (keywords == 'undefind') keywords = '';
				if (keywords != '') {
					url += '&keywords=' + keywords;
				}

				ecjia.pjax(url);
			});

			$("form[name='search_form']").on('submit', function(e) {
				e.preventDefault();
				var keywords = $("input[name='keywords']").val(); //关键字
				var url = $("form[name='search_form']").attr('action');

				if (keywords == 'undefind') keywords = '';

				if (keywords != '') {
					url += '&keywords=' + keywords;
				}
				ecjia.pjax(url);
			});
		},

		insertGoods: function() {
			$(".insert-goods-btn").on('click', function(e) {
				$("div.form-group").removeClass("error");
				$("div.form-group").removeClass("f_error");
				$("label.error").remove();
				$(".insertSubmit").removeAttr('disabled');
				$(".insertSubmit").html('开始导入');
				
				var $this = $(this);
				var goods_id = $this.attr('data-id');
				var goods_name = $this.attr('data-name');
				var goods_sn = $this.attr('data-sn');
				var shop_price = $this.attr('data-shopprice');
				var market_price = $this.attr('data-marketprice');
				
				$("input[name=goods_id]").val(goods_id);
				$("input[name=goods_name]").val(goods_name);
				$("input[name=goods_sn]").val(goods_sn);
				$("input[name=shop_price]").val(shop_price);
				$("input[name=market_price]").val(market_price);
				
				$('#insertGoods').modal('show');
			});
			$(".insertSubmit").on('click', function(e) {
				$(".insertSubmit").attr('disabled', true);
				$(".insertSubmit").html('导入中 <i class="fa fa-circle-o-notch fa-spin"></i>');
				$("form[name='insertForm']").submit();
				//$('#insertGoods').modal('hide');
			});	
			
			$("form[name='insertForm']").on('submit', function(e) {
				e.preventDefault();
			});
			
			
			var $this = $('form[name="insertForm"]');
			var option = {
				rules: {
					goods_name: {
						required: true
					},
					shop_price: {
						required: true
					},
					goods_number: {
						required: true
					}
				},
				messages: {
					goods_name: {
						required: '请填写商品名称'
					},
					shop_price: {
						required: '请填写价格'
					},
					goods_number: {
						required: '请填写库存'
					}
				},
				submitHandler: function() {
					$this.ajaxSubmit({
						dataType: "json",
						success: function(data) {
							if (data.state == 'error') {
								smoke.alert(data.message);
								$(".insertSubmit").removeAttr('disabled');
								$(".insertSubmit").html('开始导入');
								//ecjia.merchant.showmessage(data);
								return false;
							}
							//成功界面
							$('#insertGoods').modal('hide');
							$(".modal-backdrop").remove();
							ecjia.pjax(data.url);
						},
						error: function(data) {
							$(".insertSubmit").removeAttr('disabled');
							$(".insertSubmit").html('开始导入');
						}
					});
				},
				showErrors : function(errorMap, errorList) {
					$(".insertSubmit").removeAttr('disabled');
					$(".insertSubmit").html('开始导入');
			        
			        this.defaultShowErrors();
			    },
			}

			var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
			$this.validate(options);
			
			//下一步
			$(".batchInsert").on('click', function(e) {
				var ids = [];
				var url = $('form[name="insertForm"]').attr('action');
				$(".checkbox:checked").each(function() {
					ids.push($(this).val());
				});
				if (ids == '') {
					smoke.alert("请选择需要导入的商品");
					return false;
				} else {
					$(".batchInsert").attr('disabled', true);
					$(".batchInsert").html('导入中 <i class="fa fa-circle-o-notch fa-spin"></i>');
					$.ajax({
						type: "POST",
						url: url,
						data: {
							goods_ids : ids
						},
						dataType: "json",
						success: function(data){
							if (data.state == 'error') {
								smoke.alert(data.message);
								$(".batchInsert").removeAttr('disabled');
								$(".batchInsert").html('开始导入');
								//ecjia.merchant.showmessage(data);
								return false;
							}
							//成功界面
							ecjia.pjax(data.url);
						},
						error: function() {
							$(".batchInsert").removeAttr('disabled');
							$(".batchInsert").html('开始导入');
						}
					});

				}
			});
			
		},

		integral_market_price: function() {
			$('[data-toggle="integral_market_price"]').on('click', function(e) {
				e.preventDefault();
				var init_val = parseInt($('[name="market_price"]').val());
				$('[name="market_price"]').val(init_val); //'market_price'].value = parseInt(document.forms['theForm'].elements['market_price'].value);
			});
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
				app.goods_list.computePrice(options);
				app.goods_list.set_allprice_note();
			})
		},

		set_allprice_note: function() {
			if (admin_goodsList_lang.user_rank_list) {
				for (var i = admin_goodsList_lang.user_rank_list.length - 1; i >= 0; i--) {
					var options = {
						shop_price: $('[name="shop_price"]').val() || $('[name="market_price"]').val(),
						discount: admin_goodsList_lang.user_rank_list[i].discount || 100,
						rank_id: admin_goodsList_lang.user_rank_list[i].rank_id,
					};
					app.goods_list.set_price_note(options);
				};
			}
		},
		set_price_note: function(options) {
			if (options.shop_price > 0 && options.discount && $('#rank_' + options.rank_id)) { // && parseInt($('#rank_' + options.rank_id).val()) == -1
				var price = parseInt(options.shop_price * options.discount + 0.5) / 100;
				$('#nrank_' + options.rank_id).length && $('#nrank_' + options.rank_id).html('(' + price + ')');
			} else {
				$('#nrank_' + options.rank_id).length && $('#nrank_' + options.rank_id).html('(未计算)')
			}
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
	}

	/* 编辑页 */
	app.goods_info = { /* 添加编辑页 */
		init: function() {

			//清除控件残留
			$('[name="goods_img"]').val('').focus();
			$('.cat_id_error').hide();

			app.goods_info.search_cat_opt();
			app.goods_info.load_cat_list();
			app.goods_info.next_step();
		},


		complete: function(url) {
			var data = {
				'status': 'success',
				'message': js_lang.add_goods_ok,
			};
			ecjia.pjax(url, function() {
				ecjia.merchant.showmessage(data);
			})
		},

		search_cat_opt: function() {
			var opt = {
				onAfter: function() {
					$('.ms-group').each(function(index) {
						$(this).find('.isShow').length ? $(this).css('display', 'block') : $(this).css('display', 'none');
					});
					return;
				},
				show: function() {
					this.style.display = "";
					$(this).addClass('isShow');
				},
				hide: function() {
					this.style.display = "none";
					$(this).removeClass('isShow');
				},
			};
			$('#ms-search_zero').quicksearch($('.level_0 .ms-elem-selectable'), opt);
			$('#ms-search_one').quicksearch($('.level_1 .ms-elem-selectable'), opt);
			$('#ms-search_two').quicksearch($('.level_2 .ms-elem-selectable'), opt);
		},

		load_cat_list: function() {
			$('.nav-list-ready li').off().on('click', function() {
				var $this = $(this);
				if (!$this.hasClass('disabled')) {
					$this.addClass('selected').siblings('li').removeClass('selected');
					$this.addClass('disabled').siblings('li').removeClass('disabled');
				} else {
					return false;
				}

				var cat_id = $this.attr('data-id');
				var level = parseInt($this.attr('data-level')) + 1;
				var url = $('.goods_cat_container').attr('data-url');

				if (cat_id == undefined) {
					return false;
				}
				var info = {
					'cat_id': cat_id,
				};

				$('input[name="cat_id"]').val(cat_id);

				if (cat_id != 0 && cat_id != undefined) {
					$('button[type="button"]').prop('disabled', false);
				}
				var no_content = '<li class="ms-elem-selectable disabled"><span>暂无内容</span></li>';
				$.post(url, info, function(data) {
					if (level == 1) {
						$('.level_1').html('');
						$('.level_2').html(no_content);
					} else if (level == 2) {
						$('.level_2').html('');
					}
					var level_div = $('.level_' + level);

					if (data.content.length > 0) {
						for (var i = 0; i < data.content.length; i++) {
							var opt = '<li class = "ms-elem-selectable selectable" data-id=' + data.content[i].cat_id + ' data-level=' + level + '><span>' + data.content[i].cat_name + '</span></li>'
							level_div.append(opt);
						};
						app.goods_info.search_cat_opt();
					} else {
						level_div.html(no_content);
					}
					app.goods_info.load_cat_list();
				});
			});
		},

		next_step: function() {
			$('.next_step').on('click', function() {
				var $this = $(this);
				var url = $this.attr('data-url');
				var cat_id = $('input[name="cat_id"]').val();
				url += '&cat_id=' + cat_id;
				ecjia.pjax(url);
			})
		}
	}

	/* 商品预览 */
	app.preview = {
		init: function() {
			app.preview.goods_attr();

			var browse = window.navigator.appName.toLowerCase();
			var MyMar;
			var speed = 1; //速度，越大越慢
			var spec = 1; //每次滚动的间距, 越大滚动越快
			var minOpa = 50; //滤镜最小值
			var maxOpa = 100; //滤镜最大值
			var spa = 2; //缩略图区域补充数值
			var w = 0;
			spec = (browse.indexOf("microsoft") > -1) ? spec : ((browse.indexOf("opera") > -1) ? spec * 10 : spec * 20);

			function $(e) {
				return document.getElementById(e);
			}

			function goleft() {
				$('photos').scrollLeft -= spec;
			}

			function goright() {
				$('photos').scrollLeft += spec;
			}

			function setOpacity(e, n) {
				if (browse.indexOf("microsoft") > -1) e.style.filter = 'alpha(opacity=' + n + ')';
				else e.style.opacity = n / 100;
			}
			if ($('goleft') != null) {
				$('goleft').style.cursor = 'pointer';
				$('goright').style.cursor = 'pointer';
				$('mainphoto').onmouseover = function() {
					setOpacity(this, maxOpa);
				}
				$('goleft').onmouseover = function() {
					this.src = images_url + '/goleft2.gif';
					MyMar = setInterval(goleft, speed);
				}
				$('goleft').onmouseout = function() {
					this.src = images_url + '/goleft.gif';
					clearInterval(MyMar);
				}
				$('goright').onmouseover = function() {
					this.src = images_url + '/goright2.gif';
					MyMar = setInterval(goright, speed);
				}
				$('goright').onmouseout = function() {
					this.src = images_url + '/goright.gif';
					clearInterval(MyMar);
				}
				window.onload = function() {
					var rHtml = '';
					var p = $('showArea').getElementsByTagName('img');
					for (var i = 0; i < p.length; i++) {
						w += parseInt(p[i].getAttribute('width')) + spa;
						setOpacity(p[i], minOpa);
						p[i].onmouseover = function() {
							setOpacity(this, maxOpa);
							$('mainphoto').src = this.getAttribute('rel');
							$('mainphoto').setAttribute('name', this.getAttribute('name'));
							setOpacity($('mainphoto'), maxOpa);
						}
						p[i].onmouseout = function() {
							setOpacity(this, minOpa);
						}
						rHtml += '<img src="' + p[i].getAttribute('rel') + '" width="0" height="0" alt="" />';
					}
					$('showArea').style.width = parseInt(w) + 'px';
					var rLoad = document.createElement("div");
					$('photos').appendChild(rLoad);
					rLoad.style.width = "1px";
					rLoad.style.height = "1px";
					rLoad.style.overflow = "hidden";
					rLoad.innerHTML = rHtml;
				};
			}
		},
		
		goods_attr: function() {
			/*
	         * 切换商品规格
	         */
            $(".tb-sku ul").each(function() {
                //取出ul下的第一个li
                var li = $(this).children().first();
                li.addClass("green");
                app.preview.calculate_price();
            });
            $(".goods_spec li").on("click", function(e) {
                e.preventDefault();
                $(this).siblings().removeClass('green');
                $(this).siblings().css('border', '1px solid #eaeaea');
                $(this).addClass("green");
                $(this).css({
                    'border': '0'
                });
                app.preview.calculate_price();
            })
		},
		
		calculate_price: function() {
			var price = 0;
            $(".green").each(function() {
                data_price = $(this).attr('data-price');
                if (data_price == '') {
                    var data_price = 0;
                };
                price = parseFloat(price) + parseFloat(data_price);
            });
            var shop_price = parseFloat($("input[name='original_price']").val());
            var total_price = price + shop_price;
            $(".shop_price").html(total_price.toFixed(2));
		}

	}

})(ecjia.merchant, jQuery);

// end