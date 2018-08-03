// JavaScript Document
;
(function (app, $) {
	app.groupbuy_list = {
		init: function () {
			//搜索功能
			$("form[name='searchForm'] .search_groupgoods").on('click', function (e) {
				e.preventDefault();
				var url = $("form[name='searchForm']").attr('action') + '&keywords=' + $("input[name='keywords']").val();
				ecjia.pjax(url);
			});
		}
	}

	app.groupbuy_info = {
			init: function () {
				/* 加载日期控件 */
				$(".date").datetimepicker({
					format: "yyyy-mm-dd hh:ii:ss",
					weekStart: 1,
					todayBtn: 1,
					autoclose: 1,
					todayHighlight: 1,
					startView: 2,
					forceParse: 0,
					minuteStep: 1
				});

				$(".all").on('click', function (e) {
					e.preventDefault();
					var $form = $("form[name='theForm']");
					var submitname = $(this).attr('name');
					if (submitname == 'finish') {
						smoke.confirm("修改活动结束时间为当前时间？", function (e) {
							if (e) {
								$form.ajaxSubmit({
									dataType: "json",
									data: {
										submitname: submitname
									},
									success: function (data) {
										ecjia.merchant.showmessage(data);
									}
								});
							}
						}, {
							ok: '确定',
							cancel: '取消'
						});
					} else if (submitname == 'succeed') {
						smoke.confirm("此操作不可逆，您确定要设置该团购活动成功吗？", function (e) {
							if (e) {
								$form.ajaxSubmit({
									dataType: "json",
									data: {
										submitname: submitname
									},
									success: function (data) {
										ecjia.merchant.showmessage(data);
									}
								});
							}
						}, {
							ok: '确定',
							cancel: '取消'
						});
					} else if (submitname == 'sms') {
						smoke.confirm("通知客户付清余款，以便发货", function (e) {
							if (e) {
								$form.ajaxSubmit({
									dataType: "json",
									data: {
										submitname: submitname
									},
									success: function (data) {
										ecjia.merchant.showmessage(data);
									}
								});
							}
						}, {
							ok: '确定',
							cancel: '取消'
						});
					} else if (submitname == 'fail') {
						smoke.confirm("此操作不可逆，您确定要设置该团购活动失败吗？", function (e) {
							if (e) {
								$form.ajaxSubmit({
									dataType: "json",
									data: {
										submitname: submitname
									},
									success: function (data) {
										ecjia.merchant.showmessage(data);
									}
								});
							}
						}, {
							ok: '确定',
							cancel: '取消'
						});
					}
				});

				app.groupbuy_info.submit_form();
				app.groupbuy_info.search_goods();
			},
			submit_form: function (formobj) {
				var $form = $("form[name='theForm']");
				var option = {
					rules: {
						goods_id: {
							required: true,
							min: 1
						},
						start_time: {
							required: true,
							date: false
						},
						end_time: {
							required: true,
							date: false
						},
					},
					messages: {
						goods_id: {
							required: '请选择商品'
						},
						start_time: {
							required: "",
						},
						end_time: {
							required: "",
						}
					},
					submitHandler: function () {
						$form.ajaxSubmit({
							dataType: "json",
							success: function (data) {
								ecjia.merchant.showmessage(data);
							}
						});
					}
				}
				var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
				$form.validate(options);
			},

			search_goods: function () {
				$('.searchGoods').on('click', function (e) {
					var keyword = $("input[name='keywords']").val();
					var searchURL = $('.searchGoods').attr('data-url');
					var filters = {
						'keyword': keyword,
					};
					$.post(searchURL, filters, function (data) {
						app.groupbuy_info.goods_list(data);
					}, "JSON");
				});

				$("select[name='goods_id']").change(function (e) {
					var price = $(".goods_list option:selected").attr('data-price');
					$('#shop_price').html(price);
				});
			},

			goods_list: function (data) {
				$('.goods_list').html('');
				if (data.content.length > 0) {
					for (var i = 0; i < data.content.length; i++) {
						var opt = '<option value="' + data.content[i].value + '" data-price="' + data.content[i].data + '">' + data.content[i].text + '</option>'
						$('.goods_list').append(opt);
						if (i == 0) {
							$('#shop_price').html(data.content[i].data);
						}
					};
				} else {
					$('.goods_list').append('<option value="-1">未搜索到商品信息</option>');
				}
				$('.goods_list').trigger("liszt:updated").trigger("change");
			},
		},

		/* 搜索商品 */
		app.link_goods = {
			init: function () {
				$(".nav-list-ready ,.ms-selection .nav-list-content").disableSelection();
				app.link_goods.search_link_goods();
			},

			search_link_goods: function () {
				/* 查找商品 */
				$('[data-toggle="searchGoods"]').on('click', function () {
					var $choose_list = $('.choose_list'),
						searchURL = $choose_list.attr('data-url');
					var filters = {
						'JSON': {
							'keyword': $choose_list.find('[name="keyword"]').val(),
							'cat_id': $choose_list.find('[name="cat_id"] option:checked').val(),
							'brand_id': $choose_list.find('[name="brand_id"] option:checked').val(),
						}
					};
					$.get(searchURL, filters, function (data) {
						app.link_goods.load_link_article_opt(data);
					}, "JSON");
				})
			},

			load_link_article_opt: function (data) {
				$('.selectgoods').html('');
				if (data.content.length > 0) {
					for (var i = 0; i < data.content.length; i++) {
						var opt = '<option value="' + data.content[i].value + '">' + data.content[i].text + '</option>'
						$('.selectgoods').append(opt);
					};
				} else {
					$('.selectgoods').append('<option value="0">未搜索到商品信息</option>');
				}

				$('.selectgoods').trigger("liszt:updated").trigger("change");
			}
		}
})(ecjia.merchant, jQuery);
// end