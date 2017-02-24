// JavaScript Document
;
(function(app, $) {
	var bath_url; /* 列表页 */
	app.goods_list = {
		init: function() {
			$(".no_search").chosen({
				allow_single_deselect: false,
				disable_search: true
			});
			bath_url = $("a[name=move_cat_ture]").attr("data-url");
			app.goods_list.list_search();
			app.goods_list.filter();
			app.goods_list.batch_move_cat();
			app.goods_list.review_static();
			app.goods_list.toggle_on_sale();
		},
		review_static: function() {
			$('.review_static').each(function() {
				var $this = $(this);
				var oldval = $this.text();
				var url = $this.attr('data-url');
				var name = $this.attr('data-name') || 0;
				var pk = $this.attr('data-pk') || 0;
				var title = $this.attr('data-title');
				var type = $this.attr('data-text') || 'text';
				if (!name || !pk || !url) {
					console.log('editable缺少参数');
					return;
				}
				if (!title) title = '编辑信息!';
				var pjaxurl = $this.attr('data-pjax-url') || '';
				$this.editable({
					source: [{
						value: 1,
						text: '未审核'
					}, {
						value: 2,
						text: '审核未通过'
					}, {
						value: 3,
						text: '审核已通过'
					}, {
						value: 5,
						text: '无需审核'
					}],
					url: url,
					name: name,
					pk: pk,
					title: '请输入商品货号',
					type: type,
					dataType: 'json',
					success: function(data) {
						if (data.state == 'error') return data.message;
						if (pjaxurl != '') {
							ecjia.pjax(pjaxurl, function() {
								ecjia.admin.showmessage(data);
							});
						} else {
							ecjia.admin.showmessage(data);
						}
					}
				});
			}).on('shown', function(e) {
				if ($(".editable-container select option").length) {
					$(".editable-container select").chosen({
						add_class: "down-menu-language",
						no_results_text: "未找到搜索内容!",
						allow_single_deselect: true,
						disable_search_threshold: 8
					});
				}
			});
		},
		list_search: function() {
			$("form[name='searchForm']").on('submit', function(e) {
				e.preventDefault();
				var cat_id = $("select[name='cat_id']").val(); //分类
				var brand_id = $("select[name='brand_id']").val(); //品牌
				var intro_type = $("select[name='intro_type']").val(); //状态
				var keywords = $("input[name='keywords']").val(); //关键字
				var merchant_keywords = $("input[name='merchant_keywords']").val(); //商家关键字
				var url = $("form[name='searchForm']").attr('action');

				if (cat_id == 'undefind') cat_id = '';
				if (brand_id == 'undefind') brand_id = '';
				if (intro_type == 'undefind') intro_type = '';
				if (keywords == 'undefind') keywords = '';
				if (merchant_keywords == 'undefind') merchant_keywords = '';

				if (cat_id != '') {
					url += '&cat_id=' + cat_id;
				}
				if (brand_id != '') {
					url += '&brand_id=' + brand_id;
				}
				if (intro_type != '') {
					url += '&intro_type=' + intro_type;
				}
				if (keywords != '') {
					url += '&keywords=' + keywords;
				}
				if (merchant_keywords != '') {
					url += '&merchant_keywords=' + merchant_keywords;
				}
				ecjia.pjax(url);
			});
		},
		filter: function() {
			$('.screen-btn').on('click', function(e) {
				e.preventDefault();
				var cat_id = $("select[name='cat_id']").val(); //分类
				var brand_id = $("select[name='brand_id']").val(); //品牌
				var intro_type = $("select[name='intro_type']").val(); //状态
				var keywords = $("input[name='keywords']").val(); //关键字
				var merchant_keywords = $("input[name='merchant_keywords']").val(); //商家关键字
				var url = $("form[name='filterForm']").attr('action');

				if (cat_id == 'undefind') cat_id = '';
				if (brand_id == 'undefind') brand_id = '';
				if (intro_type == 'undefind') intro_type = '';
				if (keywords == 'undefind') keywords = '';
				if (merchant_keywords == 'undefind') merchant_keywords = '';

				if (cat_id != '') {
					url += '&cat_id=' + cat_id;
				}
				if (brand_id != '') {
					url += '&brand_id=' + brand_id;
				}
				if (intro_type != '') {
					url += '&intro_type=' + intro_type;
				}
				if (keywords != '') {
					url += '&keywords=' + keywords;
				}
				if (merchant_keywords != '') {
					url += '&merchant_keywords=' + merchant_keywords;
				}
				ecjia.pjax(url);
			});

			$('.filter-btn').on('click', function(e) {
				e.preventDefault();
				var review_status = $("select[name='review_status']").val(); //分类
				var store_id = $("select[name='store_id']").val(); //品牌

				var url = $("form[name='filterForm']").attr('action');

				if (review_status == 'undefind' || review_status == 0) review_status = '';
				if (store_id == 'undefind' || store_id == 0) store_id = '';

				if (review_status != '') {
					url += '&review_status=' + review_status;
				}
				if (store_id != '') {
					url += '&store_id=' + store_id;
				}
				ecjia.pjax(url);
			});
		},
		batch_move_cat: function() {
			$(".batch-move-btn").on('click', function(e) {
				var checkboxes = [];
				$(".checkbox:checked").each(function() {
					checkboxes.push($(this).val());
				});
				if (checkboxes == '') {
					smoke.alert("请选择需要转移的商品");
					return false;
				} else {
					$('#movetype').modal('show');

				}
			});
			$("a[name=move_cat_ture]").on('click', function(e) {
				$('#movetype').modal('hide');
			});
			$("select[name=target_cat]").on('change', function(e) {
				var target_cat = $(this).val();
				$("a[name=move_cat_ture]").attr("data-url", bath_url + '&target_cat=' + target_cat);
			});
		},

		toggle_on_sale: function() {
			$('[data-trigger="toggle_on_sale"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this);
				var url = $this.attr('data-url');
				var id = $this.attr('data-id');
				var val = $this.hasClass('fontello-icon-cancel') ? 1 : 0;
				var type = $this.attr('data-type') ? $this.attr('data-type') : "POST";
				var pjaxurl = $this.attr('refresh-url');

				var option = {
					obj: $this,
					url: url,
					id: id,
					val: val,
					type: type
				};
				$.ajax({
					url: option.url,
					data: {
						id: option.id,
						val: option.val
					},
					type: option.type,
					dataType: "json",
					success: function(data) {
						data.content ? option.obj.removeClass('fontello-icon-cancel').addClass('fontello-icon-ok') : option.obj.removeClass('fontello-icon-ok').addClass('fontello-icon-cancel');
						ecjia.pjax(pjaxurl, function() {
							ecjia.admin.showmessage(data);
						})
					}
				});
			})
		}
	}

	/* 编辑页 */
	app.goods_info = { /* 添加编辑页 */
		init: function() {
			$(".date").datepicker({
				format: "yyyy-mm-dd",
				container : '.main_content',
			});
			$("#color").colorpicker();

			//记录排序名称
			$('.move-mod-head').attr('data-sortname', 'goods_info');
			//执行排序
			ecjia.admin.set_sortIndex('goods_info');

			//清除控件残留	
			$('[name="goods_img"]').val('').focus();
			$('.cat_id_error').hide();

			app.goods_info.set_allprice_note();

			app.goods_info.goto_newpage();
			app.goods_info.add_volume_price();
			app.goods_info.toggle_promote();
			app.goods_info.integral_market_price();
			app.goods_info.parseint_input();

			app.goods_info.priceSetted();
			app.goods_info.marketPriceSetted();
			app.goods_info.checkGoodsSn();

			app.goods_info.submit_info();

			app.goods_info.fileupload();

			app.goods_info.term_meta();
			app.goods_info.term_meta_key();

			app.goods_info.add_brand();
			app.goods_info.add_cat();
		},
		fileupload: function() {
			$(".fileupload-btn").on('click', function(e) {
				e.preventDefault();
				$(this).parent().find("input").trigger('click');
			})
		},
		goto_newpage: function() {
			$('[data-toggle="goto_newpage"]').on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('data-href') || $(this).attr('href');
				smoke.confirm('您确定放弃当前页面编辑的内容吗？', function(e) {
					if (e) {
						window.location.href = url;
					}
				}, {
					ok: "确定",
					cancel: "取消"
				});
			});
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

				$(this).attr('checked') || $(this).val() > 0 ? $('#promote_1').prop('disabled', false) : $('#promote_1').attr('disabled', true);
				$(this).attr('checked') || $(this).val() > 0 ? $('[name="promote_start_date"]').prop('disabled', false) : $('[name="promote_start_date"]').attr('disabled', true);
				$(this).attr('checked') || $(this).val() > 0 ? $('[name="promote_end_date"]').prop('disabled', false) : $('[name="promote_end_date"]').attr('disabled', true);
			})
		},
		integral_market_price: function() {
			$('[data-toggle="integral_market_price"]').on('click', function(e) {
				e.preventDefault();
				var init_val = parseInt($('[name="market_price"]').val());
				$('[name="market_price"]').val(init_val); //'market_price'].value = parseInt(document.forms['theForm'].elements['market_price'].value);
			});
		},
		parseint_input: function() {
			$('[data-toggle="parseint_input"]').on('blur', function(e) {
				e.preventDefault();
				var init_val = parseInt($(this).val());
				$(this).val(init_val);
			});
		},

		priceSetted: function() {
			$('[data-toggle="priceSetted"]').on('change', function(e) {
				e.preventDefault();
				var $this = $(this),
					price = $this.val() || $('[name="market_price"]').val();
				options = {
					price: price,
					marketRate: admin_goodsList_lang.marketPriceRate,
					integralPercent: admin_goodsList_lang.integralPercent,
					marketPriceObj: $('[name="market_price"]'),
					integralObj: $('[name="integral"]')
				};
				app.goods_info.computePrice(options);
				app.goods_info.set_allprice_note();
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
				app.goods_info.computePrice(options);
				app.goods_info.set_allprice_note();
			})
		},
		checkGoodsSn: function() {
			$('[data-toggle="checkGoodsSn"]').on('blur', function(e) {
				e.preventDefault();
				var $this = $(this),
					goods_id = $this.attr('data-id'),
					goods_url = $this.attr('data-url'),
					goods_sn = $this.val() || '',
					info = {
						goods_id: goods_id,
						goods_sn: goods_sn
					};

				goods_sn == '' && $('#goods_sn_notice').html('');

				$.get(goods_url, info, function(data) {
					data.state == 'success' ? $('#goods_sn_notice').html('').parent().removeClass('f_error') : $('#goods_sn_notice').html(data.message).parent().addClass('f_error');
				}, "JSON");
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
					app.goods_info.set_price_note(options);
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
		previewImage: function(file) {
			if (file.files && file.files[0]) {
				var reader = new FileReader();
				reader.onload = function(evt) {
					$(file).siblings('.fileupload-btn').addClass('preview-img').css("backgroundImage", "url(" + evt.target.result + ")");
					$('.thumb_img').removeClass('hide').find('.fileupload-btn').addClass('preview-img').css("backgroundImage", "url(" + evt.target.result + ")");
				}
				reader.readAsDataURL(file.files[0]);
			} else {
				$(file).prev('.fileupload-exists').remove();
				$(file).siblings('.fileupload-btn').addClass('preview-img').css("filter", "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src='" + file.value + "'");
			}
		},

		submit_info: function() {
			var $this = $('form[name="theForm"]');

			$this.on('submit', function() {
				if ($this.find('[name="cat_id"]').val() < 1) {
					$('.cat_id_error').css('display', 'block');
					$('#collapse002').collapse('show')
				}
			})

			$this.find('[name="cat_id"]').on('change', function() {
				$this.find('[name="cat_id"]').val() < 1 ? $('.cat_id_error').css('display', 'block') : $('.cat_id_error').css('display', 'none');
			});

			var option = {
				rules: {
					goods_name: {
						required: true
					},
					shop_price: {
						required: true,
						min: 0
					},
					goods_number: {
						required: true,
						min: 0
					},
					cat_id: {
						min: 1
					}
				},
				messages: {
					goods_name: {
						required: "请输入商品名称！"
					},
					shop_price: {
						required: "请输入商品价格！",
						min: "请输入正确价格格式！"
					},
					goods_number: {
						required: "请输入商品库存！",
						min: "商品库存最小只能为0！"
					},
					cat_id: {
						required: "请选择商品分类！"
					}
				},
				submitHandler: function() {
					$this.ajaxSubmit({
						dataType: "json",
						success: function(data) {
							ecjia.admin.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);

		},

		term_meta: function() {
			$('[data-toggle="add_term_meta"]').on('click', function(e) {
				e.preventDefault();
				var $add = $('.term_meta_add'),
					key = $add.find('[name="term_meta_key"]').val(),
					value = $add.find('[name="term_meta_value"]').val(),
					id = $add.attr('data-id'),
					extension_code = $add.attr('data-extension-code'),
					active = $add.attr('data-active');

				$.post(active, 'goods_id=' + id + '&extension_code=' + extension_code + '&key=' + key + '&value=' + value, function(data) {
					ecjia.admin.showmessage(data);
				}, 'JSON')

			});
			$('[data-toggle="edit_term_meta"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					$tr = $this.parents('tr'),
					$edit = $('.term_meta_edit'),
					key = $tr.find('[name="term_meta_key"]').val(),
					value = $tr.find('[name="term_meta_value"]').val(),
					meta_id = $tr.find('[name="term_meta_id"]').val(),
					id = $edit.attr('data-id'),
					extension_code = $edit.attr('data-extension-code'),
					active = $edit.attr('data-active');

				$.post(active, 'goods_id=' + id + '&meta_id=' + meta_id + '&extension_code=' + extension_code + '&key=' + key + '&value=' + value, function(data) {
					ecjia.admin.showmessage(data);
				}, 'JSON')

			});
		},

		term_meta_key: function() {
			$('select[data-toggle="change_term_meta_key"]').on('change', function(e) {
				e.preventDefault();
				var $this = $(this),
					$input = $this.parents('.term_meta_add').find('input[name="term_meta_key"]'),
					$checked = $this.find(':checked'),
					value = $checked.val();

				$input.val(value);
			});
			$('[data-toggle="add_new_term_meta"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					$form = $this.parents('.term_meta_add'),
					$select = $form.find('select[data-toggle="change_term_meta_key"]'),
					value = $select.find(':checked').val(),
					$input = $form.find('input[name="term_meta_key"]');

				if ($this.hasClass('new')) {
					$this.removeClass('new').text('添加新栏目');
					// $this.parent().removeClass('p_t5');
					$input.addClass('hide').val(value);
					$select.next('.chzn-container').removeClass('hide');
				} else {
					$this.addClass('new').text('返回选择栏目');
					// $this.parent().addClass('p_t5');
					$input.removeClass('hide').val('');
					$select.next('.chzn-container').addClass('hide');
				}
			});
		},

		add_brand: function() {
			$('.add_brand_link').on('click', function(e) {
				e.preventDefault();
				$(this).hide();
				$('.add_brand_div').show();
			});

			$('.add_brand_ok').on('click', function(e) {
				e.preventDefault();
				var brand_name = $('input[name="brand_name"]').val(),
					url = $('div.add_brand_div').attr('data-url'),
					info = {
						brand_name: brand_name
					};
				if (brand_name.replace(/^\s+|\s+$/g, '') == '') {
					smoke.alert(js_lang.brand_name_empty);
					return false;
				}
				$.post(url, info, function(data) {
					if (data.state == 'success') {
						var opt = '<option value=' + data.content.id + ' selected>' + data.content.name + '</option>';
						$('select[name="brand_id"]').append(opt).trigger("liszt:updated").trigger("change");
						$('.add_brand_cancel').trigger('click');
					}
					ecjia.admin.showmessage(data);
				}, 'json');
			});

			$('.add_brand_cancel').on('click', function(e) {
				e.preventDefault();
				$('input[name="brand_name"]').val('');
				$('.add_brand_link').show();
				$('.add_brand_div').hide();
			});
		},

		add_cat: function() {
			$('.add_cat_link').on('click', function(e) {
				e.preventDefault();
				$(this).hide();
				$('.add_cat_div').show();
			});

			$('.add_cat_ok').on('click', function(e) {
				e.preventDefault();

				var cat_name = $('input[name="cat_name"]').val(),
					cat_id = $('select[name="cat_id"]').val(),
					url = $('div.add_cat_div').attr('data-url'),
					info = {
						cat_name: cat_name,
						cat_id: cat_id,
					};
				if (cat_name.replace(/^\s+|\s+$/g, '') == '') {
					smoke.alert(js_lang.cat_name_empty);
					return false;
				}
				$.post(url, info, function(data) {
					if (data.state == 'success') {
						var content = '<option value="0">' + js_lang.pls_select + '</option>';
						content += data.content;
						$('select[name="cat_id"]').html('').append(content).trigger("liszt:updated").trigger("change");

						var opt = data.opt;
						if (opt !== '') {
							var parent_id = '.cat_' + opt.parent_id;
							var padding = (opt.level * 20) + 'px';
							var label_class = 'cat_' + opt.cat_id;
							var label = '<label style=padding-left:' + padding + ' class=' + label_class + '><input type="checkbox" checked name="other_cat[]" value=' + opt.cat_id + ' style="opacity: 0;"><span class="m_l5">' + opt.cat_name + '</span></label>';
							if (opt.parent_id != 0) {
								$('.goods-cat').children('.goods-span').find(parent_id).after(label);
							} else {
								$('.goods-cat').children('.goods-span').prepend(label);
							}
							$('.goods-cat').children('.goods-span').find('input[name="other_cat[]"]').uniform();
						}
						$('.add_cat_cancel').trigger('click');
					}
					ecjia.admin.showmessage(data);
				}, 'json');
			});

			$('.add_cat_cancel').on('click', function(e) {
				e.preventDefault();
				$('input[name="cat_name"]').val('');
				$('.add_cat_link').show();
				$('.add_cat_div').hide();
			});
		},
	}

	/* 商品预览 */
	app.preview = {
		init: function() {
			app.preview.goods_search();

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

		goods_search: function() {
			$("form[name='searchForm']").bind('form-pre-serialize', function(event, form, options, veto) {
				(typeof(tinyMCE) != "undefined") && tinyMCE.triggerSave();
			}).on('submit', function(e) {
				e.preventDefault();
				var $this = $(this),
					url = $this.attr('action'),
					id = $this.find('[name="keywords"]').val();
				ecjia.pjax(url + '&id=' + id);
			});
		},
	}

	/* 货品列表 */
	app.products_list = {
		init: function() {
			app.products_list.products_submit();
		},
		products_submit: function() {
			var $this = $('form[name="theForm"]');
			var option = {
				rules: {
					product_sn: {
						required: true
					},
					product_number: {
						required: true
					}
				},
				messages: {
					product_sn: {
						required: "请输入货号"
					},
					product_number: {
						required: "请输入库存"
					}
				},
				submitHandler: function() {
					$this.ajaxSubmit({
						dataType: "json",
						success: function(data) {
							ecjia.admin.showmessage(data);
						}
					});
				}
			}

			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
		}
	}

	/* 回收站 */
	app.goods_trash = {
		init: function() {
			app.goods_trash.search();
			app.goods_trash.submit();
		},
		submit: function() {
			var $this = $('form[name="listForm"]');
			var option = {
				submitHandler: function() {
					$this.ajaxSubmit({
						dataType: "json",
						success: function(data) {
							ecjia.admin.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
		},
		search: function() {
			$("form[name='searchForm']").on('submit', function(e) {
				e.preventDefault();
				var url = $("form[name='searchForm']").attr('action');

				var merchant_keywords = $("input[name='merchant_keywords']").val();
				var keywords = $("input[name='keywords']").val();
				var cat_id = $("select[name='cat_id']").val(); //分类

				//
				if (keywords != '') {
					url += '&keywords=' + keywords;
				}
				if (merchant_keywords != '') {
					url += '&merchant_keywords=' + merchant_keywords;
				}
				url += '&cat_id=' + cat_id;
				ecjia.pjax(url);
			});
		}
	}

	/* 商品属性 */
	app.goods_attr = {
		init: function() {
			// $("select").not(".noselect").chosen();
			$('[data-trigger="toggleSpec"]').on('click', function() {
				var $this = $(this);
				var $parent = $this.parents('.control-group');
				if ($this.find('i').hasClass('fontello-icon-minus')) {
					$parent.remove();
				} else {
					var info = $parent.clone(true);
					info.find('.fontello-icon-plus').attr('class', 'fontello-icon-minus');
					$parent.after(info);
					info.find('.chzn-container').remove();
					info.find('select').attr({
						'id': '',
						'class': ''
					}).chosen();
				}
			})

			$('[data-toggle="get_attr_list"]').on('change', function(e) {
				e.preventDefault();
				var $this = $(this),
					url = $this.attr('data-url'),
					type = $this.val();

				$.get(url, {
					goods_type: type
				}, function(data) {
					$('#tbody-goodsAttr').html(data.content);
					$("select").not(".noselect").chosen();
				}, "JSON");
			})

			$('[name="theForm"]').on('submit', function(e) {
				e.preventDefault();
				$(this).ajaxSubmit({
					dataType: "json",
					success: function(data) {
						ecjia.admin.showmessage(data);
					}
				});
			});
		}
	}

	/* 关联商品 */
	app.link_goods = {
		init: function() {
			$(".nav-list-ready ,.ms-selection .nav-list-content").disableSelection();
			app.link_goods.search_link_goods();
			app.link_goods.del_link_goods();
			app.link_goods.change_link_model();
			app.link_goods.submit_link_goods();
		},

		search_link_goods: function() { /* 查找商品 */
			$('[data-toggle="searchGoods"]').on('click', function() {
				var $choose_list = $('.search_link_goods'),
					searchURL = $choose_list.attr('data-url');
				var filters = {
					'JSON': {
						'keyword': $choose_list.find('[name="keyword"]').val(),
						'cat_id': $choose_list.find('[name="cat_id"] option:checked').val(),
						'brand_id': $choose_list.find('[name="brand_id"] option:checked').val(),
					}
				};
				$.get(searchURL, filters, function(data) {
					app.link_goods.load_link_goods_opt(data);
				}, "JSON");
			})
		},
		load_link_goods_opt: function(data) {
			$('.nav-list-ready').html('');
			if (data.content.length > 0) {
				for (var i = 0; i < data.content.length; i++) {
					var disable = $('.nav-list-content .ms-elem-selection').find('input[value="' + data.content[i].value + '"]').length ? 'disabled' : '';
					var opt = '<li class="ms-elem-selectable ' + disable + '" id="goodsId_' + data.content[i].value + '" data-id="' + data.content[i].value + '" data-price="' + data.content[i].data + '"><span>' + data.content[i].text + '</span></li>'
					$('.nav-list-ready').append(opt);
				};
			} else {
				$('.nav-list-ready').html('<li class="ms-elem-selectable disabled"><span>未搜索到商品信息</span></li>');
			}
			app.link_goods.search_link_goods_opt();
			app.link_goods.add_link_goods();
		},
		search_link_goods_opt: function() {
			//li搜索筛选功能
			$('#ms-search').quicksearch(
			$('.ms-elem-selectable', '#ms-custom-navigation'), {
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
			});
		},
		add_link_goods: function() {
			$('.nav-list-ready li').on('click', function() {
				var $this = $(this),
					tmpobj = $('<li class="ms-elem-selection"><input type="hidden" name="goods_id[]" data-double="0" data-price="' + $this.attr('data-price') + '" value="' + $this.attr('data-id') + '" /><span class="link_static m_r5">[单向关联]</span>' + $this.text() + '<span class="edit-list"><a class="change_links_mod" href="javascript:;">切换关联</a><i class="fontello-icon-minus-circled ecjiafc-red del"></i></span></li>');
				if (!$this.hasClass('disabled')) {
					tmpobj.appendTo($(".ms-selection .nav-list-content"));
					$this.addClass('disabled');
				}
				//给新元素添加点击事件
				tmpobj.on('dblclick', function() {
					$this.removeClass('disabled');
					tmpobj.remove();
				}).find('i.del').on('click', function() {
					tmpobj.trigger('dblclick');
				});
			});
		},
		del_link_goods: function() {
			//给右侧元素添加点击事件
			$('.nav-list-content .ms-elem-selection').on('dblclick', function() {
				var $this = $(this);
				$(".nav-list-ready li").each(function(index) {
					if ($(".nav-list-ready li").eq(index).attr('id') == 'goodsId_' + $this.find('input').val()) {
						$(".nav-list-ready li").eq(index).removeClass('disabled');
					}
				});
				$this.remove();
			}).find('i.del').on('click', function() {
				$(this).parents('li').trigger('dblclick');
			});
		},
		change_link_model: function() {
			//切换关联模式
			$(document).off('click.changelinksmod').on('click.changelinksmod', '.change_links_mod', function() {
				var $info = $(this).parents('.ms-elem-selection').find('input[name="goods_id[]"]');
				$info.attr('data-double') == 1 ? $info.attr('data-double', '0').parents('.ms-elem-selection').find('.link_static').text('[单向关联]') : $info.attr('data-double', '1').parents('.ms-elem-selection').find('.link_static').text('[双向关联]');
			});
		},
		submit_link_goods: function() {
			//表单提交
			$('form[name="theForm"]').on('submit', function(e) {
				e.preventDefault();
				var url = $(this).attr('action');
				var info = {
					'linked_array': []
				};
				$('.nav-list-content li').each(function(index) {
					var id = $('.nav-list-content li').eq(index).find('input').val(),
						is_double = $('.nav-list-content li').eq(index).find('input').attr('data-double');
					info.linked_array.push({
						'id': id,
						'is_double': is_double
					});
				});
				$.get(url, info, function(data) {
					ecjia.admin.showmessage(data);
				});
			})
		}
	}

	/* 关联地区 */
	app.link_area = {
		init: function() {
			$(".nav-list-ready ,.ms-selection .nav-list-content").disableSelection();
			app.link_area.search_link_area();
			app.link_area.del_link_area();
			app.link_area.submit_link_goods();
		},

		search_link_area: function() { /* 查找商品 */
			$('[data-toggle="searcharea"]').on('click', function() {
				var $choose_list = $('.choose_list'),
					searchURL = $choose_list.attr('data-url'),
					ra_id = $('.link_area').val();
				$.post(searchURL, {
					'ra_id': ra_id
				}, function(data) {
					app.link_area.load_link_area_opt(data);
				}, "JSON");
			})
		},
		load_link_area_opt: function(data) {
			$('.nav-list-ready').html('');
			if (data.content.length > 0) {
				for (var i = 0; i < data.content.length; i++) {
					var disable = $('.nav-list-content .ms-elem-selection').find('input[value="' + data.content[i].regionId + '"]').length ? 'disabled' : '';
					var opt = '<li class="ms-elem-selectable ' + disable + '" id="ra_id' + data.content[i].regionId + '" data-id="' + data.content[i].regionId + '"><span>' + data.content[i].region_name + '</span></li>'
					$('.nav-list-ready').append(opt);
				};
			} else {
				$('.nav-list-ready').html('<li class="ms-elem-selectable disabled"><span>未搜索到地区信息</span></li>');
			}
			app.link_area.search_link_area_opt();
			app.link_area.add_link_area();
		},
		search_link_area_opt: function() {
			//li搜索筛选功能
			$('#ms-search').quicksearch(
			$('.ms-elem-selectable', '#ms-custom-navigation'), {
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
			});
		},
		add_link_area: function() {
			$('.nav-list-ready li').on('click', function() {
				var $this = $(this),
					tmpobj = $('<li class="ms-elem-selection"><input type="hidden" name="region[]" value="' + $this.attr('data-id') + '" />' + $this.text() + '<span class="edit-list"><i class="fontello-icon-minus-circled ecjiafc-red del"></i></span></li>');
				if (!$this.hasClass('disabled')) {
					tmpobj.appendTo($(".ms-selection .nav-list-content"));
					$this.addClass('disabled');
				}
				//给新元素添加点击事件
				tmpobj.on('dblclick', function() {
					$this.removeClass('disabled');
					tmpobj.remove();
				}).find('i.del').on('click', function() {
					tmpobj.trigger('dblclick');
				});
			});
		},
		del_link_area: function() {
			//给右侧元素添加点击事件
			$('.nav-list-content .ms-elem-selection').on('dblclick', function() {
				var $this = $(this);
				$(".nav-list-ready li").each(function(index) {
					if ($(".nav-list-ready li").eq(index).attr('id') == 'ra_id' + $this.find('input').val()) {
						$(".nav-list-ready li").eq(index).removeClass('disabled');
					}
				});
				$this.remove();
			}).find('i.del').on('click', function() {
				$(this).parents('li').trigger('dblclick');
			});
		},
		submit_link_goods: function() {
			//表单提交
			$('form[name="theForm"]').on('submit', function(e) {
				e.preventDefault();
				var url = $(this).attr('action');
				var info = {
					'linked_array': []
				};
				$('.nav-list-content li').each(function(index) {
					var id = $('.nav-list-content li').eq(index).find('input').val();
					info.linked_array.push({
						'id': id,
					});
				});
				$.post(url, info, function(data) {
					ecjia.admin.showmessage(data);
				});
			})
		}
	}

	/* 关联配件 */
	app.link_parts = {
		init: function() {
			// $( ".nav-list-ready ,.ms-selection .nav-list-content" ).disableSelection();
			app.link_parts.search_link_goods();
			app.link_parts.del_link_goods();
			app.link_parts.change_link_price();
			app.link_parts.submit_link_goods();
		},

		search_link_goods: function() { /* 查找商品 */
			$('[data-toggle="searchGoods"]').on('click', function() {
				var $choose_list = $('.select_goods_parts'),
					searchURL = $choose_list.attr('data-url');
				var filters = {
					'JSON': {
						'keyword': $choose_list.find('[name="keyword"]').val(),
						'cat_id': $choose_list.find('[name="cat_id"] option:checked').val(),
						'brand_id': $choose_list.find('[name="brand_id"] option:checked').val(),
					}
				};
				$.get(searchURL, filters, function(data) {
					app.link_parts.load_link_goods_opt(data);
				}, "JSON");
			})
		},
		load_link_goods_opt: function(data) {
			$('.nav-list-ready').html('');
			if (data.content.length > 0) {
				for (var i = 0; i < data.content.length; i++) {
					var disable = $('.nav-list-content .ms-elem-selection').find('input[value="' + data.content[i].value + '"]').length ? 'disabled' : '';
					var opt = '<li class="ms-elem-selectable ' + disable + '" id="goodsId_' + data.content[i].value + '" data-id="' + data.content[i].value + '" data-price="' + data.content[i].data + '"><span>' + data.content[i].text + '</span></li>'
					$('.nav-list-ready').append(opt);
				};
			} else {
				$('.nav-list-ready').html('<li class="ms-elem-selectable disabled"><span>未搜索到商品信息</span></li>');
			}
			app.link_parts.search_link_goods_opt();
			app.link_parts.add_link_goods();
		},
		search_link_goods_opt: function() {
			//li搜索筛选功能
			$('#ms-search').quicksearch(
			$('.ms-elem-selectable', '#ms-custom-navigation'), {
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
			});
		},
		add_link_goods: function() {
			$('.nav-list-ready li').on('click', function() {
				var $this = $(this),
					tmpobj = $('<li class="ms-elem-selection"><input type="hidden" name="goods_id[]" data-double="0" data-price="' + $this.attr('data-price') + '" value="' + $this.attr('data-id') + '" />' + $this.text() + '<span class="link_price m_l5">[价格:' + $this.attr('data-price') + ']</span><span class="edit-list"><a class="change_link_price" href="javascript:;">修改价格</a><i class="fontello-icon-minus-circled ecjiafc-red del"></i></span></li>');
				if (!$this.hasClass('disabled')) {
					tmpobj.appendTo($(".ms-selection .nav-list-content"));
					$this.addClass('disabled');
				}
				//给新元素添加点击事件
				tmpobj.on('dblclick', function() {
					$this.removeClass('disabled');
					tmpobj.remove();
				}).find('i.del').on('click', function() {
					tmpobj.trigger('dblclick');
				});
			});
		},
		del_link_goods: function() {
			//给右侧元素添加点击事件
			$('.nav-list-content .ms-elem-selection').on('dblclick', function() {
				var $this = $(this);
				$(".nav-list-ready li").each(function(index) {
					if ($(".nav-list-ready li").eq(index).attr('id') == 'goodsId_' + $this.find('input').val()) {
						$(".nav-list-ready li").eq(index).removeClass('disabled');
					}
				});
				$this.remove();
			}).find('i.del').on('click', function() {
				$(this).parents('li').trigger('dblclick');
			});
		},
		change_link_price: function() {
			//切换关联价格
			$(document).on('click', '.change_link_price', function(e) {
				e.preventDefault();
				var $this = $(this),
					$price = $this.parents('li').find('[data-price]'),
					$link_price = $this.parents('li').find('.link_price');

				if ($this.text() == '修改价格') {
					$this.text('保存');
					$link_price.addClass('hide').after('<input class="link_price_input" type="text" name="link_price_input" />');
				} else {
					var price = parseInt($this.parents('li').find('.link_price_input').val());
					$this.parents('li').find('.link_price_input').remove();
					$this.text('修改价格');
					$link_price.text('[价格:' + price + ']').removeClass('hide');
					$price.attr('data-price', price);
				}

			})
		},
		submit_link_goods: function() {
			//表单提交
			$('form[name="theForm"]').on('submit', function(e) {
				e.preventDefault();
				var url = $(this).attr('action');
				var info = {
					'linked_array': []
				};
				$('.nav-list-content li').each(function(index) {
					var id = $('.nav-list-content li').eq(index).find('input').val(),
						price = $('.nav-list-content li').eq(index).find('input').attr('data-price');
					info.linked_array.push({
						'id': id,
						'price': price
					});
				});
				$.get(url, info, function(data) {
					ecjia.admin.showmessage(data);
				});
			})
		}
	}

	/* 关联文章 */
	app.link_article = {
		init: function() {
			$(".nav-list-ready ,.ms-selection .nav-list-content").disableSelection();
			app.link_article.search_article();
			app.link_article.del_link_article();
			app.link_article.submit_link_article();
		},

		search_article: function() { /* 查找商品 */
			$('[data-toggle="searchArticle"]').on('click', function() {
				var $choose_list = $('.choose_list'),
					searchURL = $choose_list.attr('data-url'),
					filters = {
						'article_title': $choose_list.find('[name="article_title"]').val()
					};
				$.get(searchURL, filters, function(data) {
					app.link_article.load_link_article_opt(data);
				}, "JSON");
			})
		},

		load_link_article_opt: function(data) {
			$('.nav-list-ready').html('');
			if (data.content.length > 0) {
				for (var i = 0; i < data.content.length; i++) {
					var disable = $('.nav-list-content .ms-elem-selection').find('input[value="' + data.content[i].value + '"]').length ? 'disabled' : '';
					var opt = '<li class="ms-elem-selectable ' + disable + '" id="articleId_' + data.content[i].value + '" data-id="' + data.content[i].value + '"><span>' + data.content[i].text + '</span></li>'
					$('.nav-list-ready').append(opt);
				};
			} else {
				$('.nav-list-ready').html('<li class="ms-elem-selectable disabled"><span>未搜索到文章信息</span></li>');
			}
			app.link_article.search_link_article_opt();
			app.link_article.add_link_article();
		},

		search_link_article_opt: function() {
			//li搜索筛选功能
			$('#ms-search').quicksearch(
			$('.ms-elem-selectable', '#ms-custom-navigation'), {
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
			});
		},

		add_link_article: function() {
			$('.nav-list-ready li').on('click', function() {
				var $this = $(this),
					tmpobj = $('<li class="ms-elem-selection"><input type="hidden" name="article_id[]" value="' + $this.attr('data-id') + '" />' + $this.text() + '<span class="edit-list"><i class="fontello-icon-minus-circled ecjiafc-red del"></i></span></li>');
				if (!$this.hasClass('disabled')) {
					tmpobj.appendTo($(".ms-selection .nav-list-content"));
					$this.addClass('disabled');
				}
				//给新元素添加点击事件
				tmpobj.on('dblclick', function() {
					$this.removeClass('disabled');
					tmpobj.remove();
				}).find('i.del').on('click', function() {
					tmpobj.trigger('dblclick');
				});
			});
		},

		del_link_article: function() {
			//给右侧元素添加点击事件
			$('.nav-list-content .ms-elem-selection').on('dblclick', function() {
				var $this = $(this);
				$(".nav-list-ready li").each(function(index) {
					if ($(".nav-list-ready li").eq(index).attr('id') == 'articleId_' + $this.find('input').val()) {
						$(".nav-list-ready li").eq(index).removeClass('disabled');
					}
				});
				$this.remove();
			}).find('i.del').on('click', function() {
				$(this).parents('li').trigger('dblclick');
			});
		},

		submit_link_article: function() {
			//表单提交
			$('form[name="theForm"]').on('submit', function(e) {
				e.preventDefault();
				var url = $(this).attr('action');
				var info = {
					'linked_array': []
				};
				$('.nav-list-content li').each(function(index) {
					var article_id = $('.nav-list-content li').eq(index).find('input').val();
					info.linked_array.push({
						'article_id': article_id
					});
				});
				$.get(url, info, function(data) {
					ecjia.admin.showmessage(data);
				});
			})
		}
	}

	/* 商品相册 */
	app.goods_photo = {
		init: function() {
			$(".wookmark_list img").disableSelection();

			$('.move-mod').sortable({
				distance: 0,
				revert: false,
				//缓冲效果   
				handle: '.move-mod-head',
				placeholder: 'ui-sortable-placeholder thumbnail',
				activate: function(event, ui) {
					$('.wookmark-goods-photo').append(ui.helper);
				},
				stop: function(event, ui) {},
				sort: function(event, ui) {}
			});

			var action = $(".fileupload").attr('data-action');
			$(".fileupload").dropper({
				action: action,
				label: '将图片拖动至此处上传',
				maxQueue: 2,
				maxSize: 5242880,
				// 5 mb
				height: 150,
				postKey: "img_url",
				successaa_upload: function(data) {
					ecjia.admin.showmessage(data);
				}
			});

			app.goods_photo.loaded_img();

			app.goods_photo.save_sort();
			app.goods_photo.sort_ok();
			app.goods_photo.edit_title();
			app.goods_photo.sort_cancel();
		},

		save_sort: function() {
			$('.save-sort').on('click', function(e) {
				e.preventDefault();
				var info = {},
					info_str = '{info : [',
					sort_url = $(this).attr('data-sorturl');

				$('.wookmark-goods-photo li').each(function(i) {
					var $this = $(this);

					info_str += i + 1 == $('.wookmark-goods-photo li').length ? '{img_id : ' + $this.find('[data-toggle="ajaxremove"]').attr('data-imgid') + ', img_original : "' + $this.find('[data-original]').attr('data-original') + '"},' : '{img_id : ' + $this.find('[data-toggle="ajaxremove"]').attr('data-imgid') + ', img_original : "' + $this.find('[data-original]').attr('data-original') + '"},';
				});
				info_str += ']}';
				info = eval('(' + info_str + ')');
				$.get(sort_url, info, function(data) {
					ecjia.admin.showmessage(data);
				})
			});
		},
		sort_ok: function() {
			$('[data-toggle="sort-ok"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					url = $this.attr('data-saveurl'),
					id = $this.attr('data-imgid'),
					val = $this.parent().find('.edit-inline').val(),
					info = {
						img_id: id,
						val: val
					};

				$.get(url, info, function(data) {
					$this.parent().find('.edit_title').html(val);
					$this.parent('p').find('.ajaxremove , .move-mod-head , [data-toggle="edit"]').css('display', 'inline-block');
					$this.parent('p').find('[data-toggle="sort-cancel"] , [data-toggle="sort-ok"]').css('display', 'none');
					ecjia.admin.showmessage(data);
				});
			});
		},
		edit_title: function() {
			$('[data-toggle="edit"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					value = $(this).parent().find('.edit_title').text();

				$this.parent('p').find('.edit_title').html('<input class="edit-inline" type="text" value="' + value + '" />').find('.edit-inline').focus().select();
				$this.parent('p').find('.ajaxremove , .move-mod-head, [data-toggle="edit"]').css('display', 'none');
				$this.parent('p').find('[data-toggle="sort-cancel"] , [data-toggle="sort-ok"]').css('display', 'block');
			});
		},

		sort_cancel: function() {
			$('[data-toggle="sort-cancel"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					value = $(this).parent().find('.edit-inline').val();

				$this.parent().find('.edit_title').html(value);
				$this.parent('p').find('.ajaxremove , .move-mod-head, [data-toggle="edit"]').css('display', 'block');
				$this.parent('p').find('[data-toggle="sort-cancel"] , [data-toggle="sort-ok"]').css('display', 'none');
			});
		},

		loaded_img: function() {
			$('div.wookmark_list').imagesLoaded(function() {
				$('div.wookmark_list .thumbnail a.bd').attr('rel', 'gallery').colorbox({
					maxWidth: '80%',
					maxHeight: '80%',
					opacity: '0.8',
					loop: true,
					slideshow: false,
					fixed: true,
					speed: 300,
				});
			});
		}
	}

	app.goods_mode = {
		init: function() {
			app.goods_mode.change_model();
			app.goods_mode._change_model();
			app.goods_mode.mode_submit();
			app.goods_mode.click_edit();
			app.goods_mode.click_model();
		},

		change_model: function() {
			$('input[name="goods_model"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					val = $this.val();
				$("input[name=model_price][value=" + val + "]").prop("checked", true).trigger('change');
				$("input[name=model_inventory][value=" + val + "]").prop("checked", true).trigger("change");
				$.uniform.update($("input[name=model_price]"));
				$.uniform.update($("input[name=model_inventory]"));
			});

			$('input[name="model_price"], input[name="model_inventory"]').on('change', function(e) {
				e.preventDefault();
				app.goods_mode._change_model();
			});
		},

		_change_model: function() {
			var n = $("input[name='model_inventory']:checked").val(),
				p = $("input[name='model_price']:checked").val(),
				$warehouse = $('.goods_warehouse_model'),
				$area = $('.goods_area_model');

			$warehouse.removeClass('area').removeClass('price');
			$area.removeClass('area').removeClass('price');

			p == 1 && $warehouse.addClass('price');
			p == 2 && $area.addClass('price');
			n == 1 && $warehouse.addClass('area');
			n == 2 && $area.addClass('area');

		},

		mode_submit: function() {
			$('form[name="theForm"]').on('submit', function(e) {
				e.preventDefault();
				$(this).ajaxSubmit({
					dataType: "json",
					success: function(data) {
						$('.modal-backdrop').remove();
						$('.close').click();
						ecjia.admin.showmessage(data);
					}
				});
			});
		},

		click_edit: function() {
			$('.goods_model [data-toggle="modal"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					id = $this.attr('data-id'),
					warehouse = $this.attr('data-warehouse'),
					promote = $this.attr('data-promote'),
					price = $this.attr('data-price'),
					number = $this.attr('data-number'),
					region = $this.attr('data-region'),
					$modal = $($this.attr('href')),
					$form = $modal.find('form');

				$form.attr('action', $form.attr('data-editurl'));

				if (region) {
					$modal.find(".modal-header h3 ").text('编辑地区模式');
					$form.find('input[name="region_number"]').val(number);
					$form.find('input[name="region_price"]').val(price);
					$form.find('input[name="region_promote_price"]').val(promote);
					$form.find('input[name="a_id"]').val(id);
					$form.find("select[name='warehouse_area_name'] option[value=" + warehouse + "]").prop("selected", true);
					$form.find("select[name='warehouse_area_name']").trigger("liszt:updated").trigger("change");
				} else {
					$modal.find(".modal-header h3 ").text('编辑仓库模式');
					$form.find('input[name="warehouse_number"]').val(number);
					$form.find('input[name="warehouse_price"]').val(price);
					$form.find('input[name="warehouse_promote_price"]').val(promote);
					$form.find('input[name="w_id"]').val(id);
					$form.find("select[name='warehouse_name'] option[value=" + warehouse + "]").prop("selected", true);
					$form.find("select[name='warehouse_name']").trigger("liszt:updated");
				}
			});
		},

		click_model: function() {
			$('[data-toggle="modal"][data-type="add"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					$modal = $($this.attr('href')),
					$form = $modal.find('form'),
					title = $this.find('span').text();

				$modal.find('.modal-header h3').text(title);
				$form.find('input[type="text"]').val('');
				$form.find('select option').eq('0').prop("selected", true);
				$form.find('select').trigger("liszt:updated");

				$form.attr('action', $form.attr('data-inserturl'));
			});
		}
	};
})(ecjia.admin, jQuery);

// end