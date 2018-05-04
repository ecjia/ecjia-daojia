// JavaScript Document
;(function(app, $) {
	app.store_business_city = {
			init : function() {
				app.store_business_city.submit_form();
				app.store_business_city.store_business_city_add();
				app.store_business_city.store_business_city_edit();
				app.store_business_city.store_business_district_add();
				
			},
			submit_form : function() {
				var $form = $("form[name='Form']");
				var option = {
						submitHandler : function() {
							$form.ajaxSubmit({
								dataType : "json",
								success : function(data) {
									$('#myModal1').modal('hide');
									$('#myModal2').modal('hide');
									$('#myModal4').modal('hide');
									ecjia.admin.showmessage(data);
								}
							});
						}
					}
				var options = $.extend(ecjia.admin.defaultOptions.validate, option);
				$form.validate(options);
			},
			
			store_business_city_add :function(){
	            $(".add-business-city-modal").on('click', function (e) {
	            	e.preventDefault();
	                var $this = $(this);
	                var url = $this.attr('add-business-city-url');
	                $.post(url, function (data) {
	                	$('.add-business-city').html(data.data);
	                	app.store_business_city.submit_form();
	                }, 'json');
				})
	        },
	        
	        store_business_city_edit :function(){
	            $(".edit-business-city-modal").on('click', function (e) {
	            	e.preventDefault();
	                var $this = $(this);
	                var url = $this.attr('edit-business-city-url');
	                $.post(url, function (data) {
	                	$('.edit-business-city').html(data.data);
	                	app.store_business_city.submit_form();
	                }, 'json');
				})
	        },
	        
	        store_business_district_add :function(){
	            $(".add-business-district-modal").on('click', function (e) {
	            	e.preventDefault();
	            	
	                var $this = $(this);
	                var url = $this.attr('add-business-district-url');
	                var href = $this.attr('data-href');
	                $.post(url, function (data) {
	                	$(href).modal('show');
	                	$('.add-business-district').html(data.data)
	                	$('.modal-body').find('input[type="checkbox"]').uniform();
	                	app.store_business_city.submit_form();
	                }, 'json');
				})
	        },
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
