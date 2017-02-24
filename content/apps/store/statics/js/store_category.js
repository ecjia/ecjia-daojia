// JavaScript Document
;(function(app, $) {
	app.store_category = {
			init : function() {
				app.store_category.submit_form();
				$('#info-toggle-button').toggleButtons({
	                style: {
	                    enabled: "info",
	                    disabled: "success"
	                }
	            });
			},
			submit_form : function() {
				var $form = $("form[name='theForm']");
				var option = {
						rules : {
							cat_name : { required : true }
						},
						messages : {
							cat_name : { required : "请输入分类名称！" }
						},
						submitHandler : function() {
							$form.ajaxSubmit({
								dataType : "json",
								success : function(data) {
									ecjia.admin.showmessage(data);
								}
							});
						}
					}
				var options = $.extend(ecjia.admin.defaultOptions.validate, option);
				$form.validate(options);
			}
		}
})(ecjia.admin, jQuery);



//TODO 当前使用迁移JS
/**
* 折叠分类列表
*/
var className = "fontello-icon-plus-squared-alt cursor_pointer ecjiafc-blue";
function rowClicked(obj) {
//当前分类的图标样式
var i = obj.className;
//当前图像
img = obj;
//取得上二级tr>td>img对象
obj = obj.parentNode.parentNode;
//整个分类列表表格
var tbl = document.getElementById("list-table");
//当前分类级别
var lvl = parseInt(obj.className);
//是否找到元素
var fnd = false;
//var sub_display = img.src.indexOf('menu_minus.gif') > 0 ? 'none' : (ecjia.browser.isIE) ? 'block' : 'table-row' ;
var sub_display = i=="fontello-icon-minus-squared-alt cursor_pointer ecjiafc-blue"?'none':'';
//遍历所有的分类
for (i = 0; i < tbl.rows.length; i++) {
	var row = tbl.rows[i];
	if (row == obj) {
//找到当前行
fnd = true;
} else {
	if (fnd == true) {
		var cur = parseInt(row.className);
		var icon = 'icon_' + row.id;
		if (cur > lvl) {
			row.style.display = sub_display;
			if (sub_display != 'none') {
				var iconimg = document.getElementById(icon);
				iconimg.className = "fontello-icon-minus-squared-alt cursor_pointer ecjiafc-blue";
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
	if (imgObj.tagName == "I" && imgObj.ClassName != 'fontello-icon-angle-circled-right cursor_pointer ecjiafc-blue') {
		imgObj.className = (imgObj.className == className) ? 'fontello-icon-minus-squared-alt cursor_pointer ecjiafc-blue' : className;
	}
}
}

// end
