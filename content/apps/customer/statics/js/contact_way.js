// JavaScript Document
;
(function(app, $) {
    app.contact_way = {
        init: function() {
            app.contact_way.add();
            app.contact_way.edit();
        },
    	add: function () {
			$('.add_contact_way').on('click', function (e) {
				$('.action_title').text($(this).attr('title'));
				$('#movetype').modal('show');
				/*添加表单加入submit事件 */
				var $form = $("form[name='addForm']");
				var sort = $(".contact-order").val();
				$.validator.addMethod("sort_order",function(value){  					
					var isint = /^(\+|-)?\d+$/;
					if(!isint.test(value)){ 						 		//如果用户输入的值不同时满足正整数的正则
       					return false;         								 	//返回一个错误，不向下执行
					} else {
						return true;         								 	
					}
				},"请输入一个正整数！");
				var option = {
						rules:{
							/*添加联系方式必填*/
							way_name: {required : true},
							sort_order:	{sort_order: sort},
						},
						messages:{
							/*添加联系方式必填*/
							way_name: {required : "联系方式名称不能为空!" },
						},
					submitHandler : function() {
						$('#movetype').modal('hide');//点击确认时隐藏框
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
			});
		},
        
	   	edit: function () {
			$('.edit_contact_way').on('click', function (e) {
				var id = $(this).attr('way_id');
				var way_name = $(this).attr('way_name');
				var sort_order = $(this).attr('sort_order');
				$('#way_id').attr('value',id);
				$('.contact_way_name').attr('value',way_name);
				$('.contact-sort').attr('value',sort_order);
				$('.edit_action_title').text($(this).attr('title'));
				$('#movetype_edit').modal('show');
				
				/*添加表单加入submit事件 */
				var $form = $("form[name='editForm']");
				var sort = $(".contact-sort").val();
				$.validator.addMethod("sort_order",function(value){  					
					var isint = /^(\+|-)?\d+$/;
					if(!isint.test(value)){ 						 		//如果用户输入的值不同时满足正整数的正则
       					return false;         								 	//返回一个错误，不向下执行
					} else {
						return true;         								 	
					}
				},"请输入一个正整数！");
				var option = {
						rules:{
							/*联系方式名称必填*/
							way_name: {required : true},
							sort_order: {sort_order : sort},
						},
						messages:{
							/*联系方式名称必填*/
							way_name: {required : "联系方式名称不能为空!" },
						},
					submitHandler : function() {
						$('#movetype_edit').modal('hide');//点击确认时隐藏框
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
			});
		},
    };
})(ecjia.admin, jQuery);

// end
