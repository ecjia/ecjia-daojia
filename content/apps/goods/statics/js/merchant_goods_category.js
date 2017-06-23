// JavaScript Document
;
(function(app, $) {
	app.goods_category_list = {
		init: function() {},
	};

	app.goods_category_info = {
		init: function() {
			app.goods_category_info.submit_info();
			app.goods_category_info.choose_goods_type();
			app.goods_category_info.toggleSpec();
			app.goods_category_info.ajaxremove();
		},

		toggleSpec: function() {
			$(document).off('click', '[data-trigger="toggleSpec"]');
			$(document).on('click', '[data-trigger="toggleSpec"]', function() {
				var $this = $(this);
				var $parent = $this.parents('.goods-span');
				if ($this.find('i').hasClass('fontello-icon-cancel')) {
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

			$('.tigger_add').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					$tmp = $('[data-toggle="clone-category"]').parent('.goods-span').clone();

				$tmp.find('[data-toggle="clone-category"]').removeAttr('data-toggle').attr('data-trigger', 'toggleSpec').find('i').attr('class', 'fontello-icon-cancel ecjiafc-red');
				$tmp.find('input').val('');
				$this.before($tmp);
			});
		},

		choose_goods_type: function() {
			$(document).on('change', '.choose_goods_type', function() {
				var $this = $(this),
					val = $this.val(),
					url = $this.attr('data-url');
				// console.log(url);
				val == 0 ? $this.parents('.goods_type').find('.show_goods_type').html('<option>请选择筛选属性</option>').trigger("liszt:updated") : $.get(url, {
					'cat_id': val
				}, function(data) {
					var opt = '';
					if (data.attr_list.item) {
						for (var item = data.attr_list.item, i = item.length - 1; i >= 0; i--) {
							opt += '<option value="' + item[i].attr_id + '">' + item[i].attr_name + '</option>';
						};
					}
					opt = opt ? opt : '<option>请选择筛选属性</option>';
					$this.parents('.goods_type').find('.show_goods_type').html(opt).trigger("liszt:updated");
				});
			})
		},
		submit_info: function() {
			var $this = $('form[name="theForm"]');
			var option = {
				rules: {
					cat_name: {
						required: true
					}
				},
				messages: {
					cat_name: {
						required: "请输入分类名称"
					}
				},
				submitHandler: function() {
					$this.ajaxSubmit({
						dataType: "json",
						success: function(data) {
							ecjia.merchant.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
			$this.validate(options);
		},
		ajaxremove : function(){
            $('[data-toggle="ajaxremove"]').on('click',function(e){
                e.preventDefault();
                var $this = $(this),
                url = $this.attr('data-href') || $this.attr('href'),
                msg = $this.attr('data-msg') || '您确定进行该操作吗？';
                if(!url){
                    smoke.alert('参数错误！');
                    return false;
                }
                smoke.confirm(msg,function(e){
                    if (e){
                        $.get(url, function(data){
                            ecjia.merchant.showmessage(data);
                        });
                    }
                }, {ok:"确定", cancel:"取消"});
            });
        },
	};

	app.goods_category_move = {
		init: function() {
			app.goods_category_move.submit_info();
		},

		submit_info: function() {
			var $this = $('form[name="theForm"]');
			$this.on('submit', function(e) {
				e.preventDefault();
				smoke.confirm('您确定转移分类下的商品吗？', function(e) {
					if (e) {
						$this.ajaxSubmit({
							dataType: "json",
							success: function(data) {
								ecjia.merchant.showmessage(data);
							}
						});
					}
				}, {
					ok: "确定",
					cancel: "取消"
				});
			});
		}
	};
})(ecjia.merchant, jQuery);


//TODO 当前使用迁移JS
/**
 * 折叠分类列表
 */
var className = "fa fa-plus-square-o cursor_pointer ecjiafc-blue";

function rowClicked(obj) {
	//当前分类的图标样式
	var i = obj.className;
	// 当前图像
	img = obj;
	// 取得上二级tr>td>img对象
	obj = obj.parentNode.parentNode;
	// 整个分类列表表格
	var tbl = document.getElementById("list-table");
	// 当前分类级别
	var lvl = parseInt(obj.className);
	// 是否找到元素
	var fnd = false;
	//var sub_display = img.src.indexOf('menu_minus.gif') > 0 ? 'none' : (ecjia.browser.isIE) ? 'block' : 'table-row' ;
	var sub_display = i == "fa fa-minus-square-o cursor_pointer ecjiafc-blue" ? 'none' : '';
	// 遍历所有的分类
	for (i = 0; i < tbl.rows.length; i++) {
		var row = tbl.rows[i];
		if (row == obj) {
			// 找到当前行
			fnd = true;
		} else {
			if (fnd == true) {
				var cur = parseInt(row.className);
				var icon = 'icon_' + row.id;
				if (cur > lvl) {
					row.style.display = sub_display;
					if (sub_display != 'none') {
						var iconimg = document.getElementById(icon);
						iconimg.className = "fa fa-minus-square-o cursor_pointer ecjiafc-blue";
					}
				} else {
					fnd = false;
					break;
				}
			}
		}
	}
	for (i = 0; i < obj.cells[0].childNodes.length; i++) {
		var imgObj = obj.cells[0].childNodes[i];
		if (imgObj.tagName == "I" && imgObj.ClassName != 'fa fa-arrow-circle-right cursor_pointer ecjiafc-blue') {
			imgObj.className = (imgObj.className == className) ? 'fa fa-minus-square-o cursor_pointer ecjiafc-blue' : className;
		}
	}
}

// end