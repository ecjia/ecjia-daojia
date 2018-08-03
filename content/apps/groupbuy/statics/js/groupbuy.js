// JavaScript Document
;
(function (app, $) {
	app.groupbuy_list = {
		init: function () {
			//搜索功能
			$(".search-btn").off('click').on('click', function (e) {
				e.preventDefault();
				var keywords = $("input[name='keywords']").val();
				var order_sn = $("input[name='order_sn']").val();
				var user_name = $("input[name='user_name']").val();

				var url = $("form[name='searchForm']").attr('action');
				if (keywords != '' && keywords != undefined) {
					url += '&keywords=' + keywords;
				}
				if (order_sn != '' && order_sn != undefined) {
					url += '&order_sn=' + order_sn;
				}
				if (user_name != '' && user_name != undefined) {
					url += '&user_name=' + user_name;
				}
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
					minuteStep: 1,
					container: '.main_content',
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
										ecjia.admin.showmessage(data);
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
										ecjia.admin.showmessage(data);
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
										ecjia.admin.showmessage(data);
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
										ecjia.admin.showmessage(data);
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
							min: '请在添加团购商品区域选择团购商品！'
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
								ecjia.admin.showmessage(data);
							}
						});
					}
				}
				var options = $.extend(ecjia.admin.defaultOptions.validate, option);
				$form.validate(options);
			}
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
})(ecjia.admin, jQuery);
// end