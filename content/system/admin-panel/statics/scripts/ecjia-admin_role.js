;(function(admin, $) {
	admin.admin_role = {
		init : function() {
			admin.admin_role.submit();
		},
		submit : function() {
			var $this = $('form[name="theForm"]');
			var option = {
				rules : {user_name : {required : true}},
				messages : {user_name : {required : admin_role_lang.pls_name}},
				submitHandler : function() {
					$this.ajaxSubmit({
						dataType : "json",
						success : function(data) {
							if ($this.find("input[name='id']").val()) {
								ecjia.admin.showmessage(data);
							} else {
								var url = $this.attr('data-pjaxurl');
								ecjia.pjax(url + '&id=' + data.id, function() {
									ecjia.admin.showmessage(data);
								});
							}
						}
					});
				}
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
		}
	}
})(ecjia.admin, $);
