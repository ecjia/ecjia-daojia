// JavaScript Document
;
(function(app, $) {
    app.customer_source = {
        init: function() {
            app.customer_source.search();
            app.customer_source.add();
            app.customer_source.edit();
        },
        search: function() {
        	$('.screen-btn').on('click', function(e) {
    			e.preventDefault();
    			var keywords		= $("input[name='keywords']").val(); 		//关键字
    			var url				= $("form[name='theForm']").attr('action'); //请求链接
    			if(keywords			== 'undefined')keywords ='';
    			if(url        		== 'undefined')url ='';
    			ecjia.pjax(url + '&keywords=' + keywords);
    		});
        },
    	add: function () {
			$('.customer_source_add').on('click', function (e) {
				$('.action_title').text($(this).attr('title'));
				$('#movetype').modal('show');
				/*添加表单加入submit事件 */
				var $form = $("form[name='addForm']");
				var option = {
						rules:{
							/*添加客户来源必填*/
							source_name: {required : true},
						},
						messages:{
							/*添加客户来源必填*/
							source_name: {required : "来源名称不能为空!" },
						},
					submitHandler : function() {
						$('#movetype').modal('hide');//点击确认时隐藏框
						$(".modal-backdrop").remove();
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
			$('.edit_customer_source').on('click', function (e) {
				var id = $(this).attr('source_id');
				var source_name = $(this).attr('source_name');
				$('#source_id').attr('value',id);
				$('.customer_source_name').attr('value',source_name);
				$('.edit_action_title').text($(this).attr('title'));
				$('#movetype_edit').modal('show');
				
				/*添加表单加入submit事件 */
				var $form = $("form[name='editForm']");
				var option = {
						rules:{
							/*客户类别名称必填*/
							source_name: {required : true},
						},
						messages:{
							/*添加客户类别名称必填*/
							source_name: {required : "来源名称不能为空!" },
						},
					submitHandler : function() {
						$('#movetype_edit').modal('hide');//点击确认时隐藏框
						$(".modal-backdrop").remove();
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
