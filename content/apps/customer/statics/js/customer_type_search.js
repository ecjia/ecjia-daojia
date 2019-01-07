// JavaScript Document
;
(function(app, $) {
    app.customer_type_search = {
        init: function() {
            app.customer_type_search.search();
            app.customer_type_search.add();
            app.customer_type_search.edit();
        },
        search: function() {
        	$('.screen-btn').on('click', function(e) {
    			e.preventDefault();
    			var keywords		= $("input[name='keywords']").val(); 		//关键字
    			var url				= $("form[name='theForm']").attr('action'); //请求链接
    			if(keywords		    == 'undefined')keywords ='';
    			if(url        		== 'undefined')url ='';
    			ecjia.pjax(url + '&keywords=' + keywords);
    		});
        },
    	add: function () {
			$('.add_customer_type').on('click', function (e) {
				$('.action_title').text($(this).attr('title'));
				$('#movetype').modal('show');
				/*添加表单加入submit事件 */
				var $form = $("form[name='addForm']");
				var option = {
						rules:{
							/*添加客户类别必填*/
							state_name: {required : true},
						},
						messages:{
							/*添加客户类别必填*/
							state_name: {required : "类别名称不能为空!" },
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
			$('.edit_customer_type').on('click', function (e) {
				var id = $(this).attr('state_id');
				var state_name = $(this).attr('state_name');
				var summary = $(this).attr('summary');
				$('#state_id').attr('value',id);
				$('.customer_type_state_name').attr('value',state_name);
				$('.customer_type_summary').attr('value',summary);
				$('.edit_action_title').text($(this).attr('title'));
				$('#movetype_edit').modal('show');
				
				/*添加表单加入submit事件 */
				var $form = $("form[name='editForm']");
				var option = {
						rules:{
							/*客户类别名称必填*/
							state_name: {required : true},
						},
						messages:{
							/*添加客户类别名称必填*/
							state_name: {required : "类别名称不能为空!" },
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
