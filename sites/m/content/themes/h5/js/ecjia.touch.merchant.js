/**
 * 后台综合js文件
 */
;
(function(ecjia, $) {
	ecjia.touch.merchant = {
		init: function() {
			$('.datePicker').scroller('destroy').scroller(
			$.extend({
				preset: 'date',
				minDate: new Date(1950, 0, 1),
				maxDate: new Date(2100, 0, 1),
				stepMinute: 5
			}, {
				theme: 'android-holo light',
				mode: 'scroller',
				lang: 'zh',
				display: 'bottom',
				animate: 'date'
			}));

			$('form[name="theForm"]').on('submit', function(e) {
				e.preventDefault();
			});

			//有'.reimg'的file元素修改触发事件
			$(document).off('change', 'input[type="file"]');
			$(document).on('change', 'input[type="file"]', function(e) {
				var img = $(this).val();
				$(this).parent().find('.reimg').text(img);
			});

			//地区改变元素方法
			ecjia.touch.region_change();

			//选择店铺类型触发方法
			$('#shoprz_type').on('change', function() {
				var $this = $(this),
					val = $this.val(),
					$subShoprz_type = $('#subShoprz_type'),
					$subShoprz_type2 = $('.subShoprz_type2'),
					$shop_hypermarketFile = $('.shop_hypermarketFile');

				if (val == 1) {
					$subShoprz_type.removeClass('hide');
				} else {
					$subShoprz_type.addClass('hide');
					$subShoprz_type2.addClass('hide');
					$shop_hypermarketFile.addClass('hide');

				}
				$subShoprz_type.on('change', function() {
					var tmp_val = $(this).val();

					$subShoprz_type2.addClass('hide');
					$shop_hypermarketFile.addClass('hide');

					if (tmp_val == 2) {
						$subShoprz_type2.removeClass('hide');
					} else if (tmp_val == 3) {
						$shop_hypermarketFile.removeClass('hide');
					}
				});
			});

			//出现详细类目操作列表的触发方法
			$('.toggle_category').on('click', function(e) {
				e.preventDefault();
				if ($('.choose-category').hasClass('hide')) {
					$('.choose-category').removeClass('hide');
				} else {
					$('.choose-category').addClass('hide');
				}
			});

			//选择一级类目触发事件
			$('select[name="parent_name"]').on('change', function(e) {
				e.preventDefault();
				var $this = $(this),
					val = $this.val(),
					url = $this.attr('data-url');

				$.get(url, {
					parent_id: val
				}, function(data) {
					var obj_tmp = '';
					for (var i = data.content.length - 1; i >= 0; i--) {
						obj_tmp += '<label><input data-trigger="checkbox" type="checkbox" value="' + data.content[i].value + '"/>' + data.content[i].text + '</label>';
					};
					if (obj_tmp == '') obj_tmp = '请选择一级类目..';
					$('.cat_list').html(obj_tmp);
					$(document).winderCheck();
				}, 'json');
			});

			//点击添加详细分类事件
			$('.addDetailCategoryBtn').on('click', function(e) {
				e.preventDefault();
				var obj_checkbox = $('.cat_list').find('input[type="checkbox"]:checked'),
					url = $(this).attr('data-url');
				var cat_id = '';
				for (var i = obj_checkbox.length - 1; i >= 0; i--) {
					cat_id += obj_checkbox.eq(i).val() + ',';
				};

				$.get(url, {
					cat_id: cat_id
				}, function(data) {
					$('.cat_content').html(data.content).append(data.catePermanent);
					// 执行日期控件方法
					$('.datePicker').scroller('destroy').scroller(
					$.extend({
						preset: 'date',
						minDate: new Date(1950, 0, 1),
						maxDate: new Date(2100, 0, 1),
						stepMinute: 5
					}, {
						theme: 'android-holo light',
						mode: 'scroller',
						lang: 'zh',
						display: 'bottom',
						animate: 'date'
					}));
				}, 'json');
			});

			//点击删除分类事件
			$(document).off('click', '.removeCategoryBtn');
			$(document).on('click', '.removeCategoryBtn', function(e) {
				e.preventDefault();
				var url = $(this).attr('data-url');

				$.get(url, '', function(data) {
					$('.cat_content').html(data.content).append(data.catePermanent);
				}, 'json');
			});

			//查看已有品牌列表的事件
			$('.select_brand_info').on('click', function(e) {
				e.preventDefault();
				if ($('.brand_list').hasClass('hide')) {
					$('.brand_list').removeClass('hide');
				} else {
					$('.brand_list').addClass('hide');
				}
			});

			//点击删除品牌事件
			$('.deleteBrand').on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('data-url');
				$.get(url, '', function(data) {
					ecjia.touch.showmessage(data);
				}, 'json');
			});

		}
	};
	ecjia.touch.region_list = {
		init: function() {
			ecjia.touch.region_list.area_click();
			$('[data-toggle="search_key"]').change();
			ecjia.touch.region_list.search_change();

		},

		area_click: function() {
			$('[data-trigger="change_area"]').on('click', function(e) {
				e.preventDefault();
				var obj_this = $(this),
					url = obj_this.attr('data-url');
				if (confirm('你确定要切换此地址吗？')) {
					$.get(url, '', function(data) {
						ecjia.touch.showmessage(data);
					});
				}
			});
		},

		search_change: function() {
			$('[data-toggle="search_key"]').on('change', function() {
				var val = $.trim($(this).val());
				if (val.length > 0) {
					$('[data-trigger="change_area"]').each(function() {
						var area = $(this).text();
						if (area.indexOf(val) == -1) {
							$(this).removeClass('active');
						} else {
							if (!$(this).hasClass('active')) {
								$(this).addClass('active');
							}
						}
					});
				} else {
					$('[data-trigger="change_area"]').each(function() {
						$(this).attr('class', 'active');
					});
				}
			});
		}
	};

	//PJAX前进、返回执行
	$(document).on('pjax:popstate', function() {})
})(ecjia, jQuery);

//end