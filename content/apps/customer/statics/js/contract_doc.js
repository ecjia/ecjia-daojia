// JavaScript Document
;(function(app, $) {
	app.contract_doc = {
		init : function() {
			app.contract_doc.add();
		},
		add : function () {
			var $this = $('form[name="theForm"]');
			$this.on('submit', function(e) {
				e.preventDefault();
			})
			var option = {
					rules:{
						/*必填*/
						doc_name: 			{required : true},
					},
					messages:{
						/*必填*/
						doc_name:	 	{required : "请填写文档名称！"},
					},
				submitHandler: function() {
					$this.ajaxSubmit({
						dataType:"json",
						success:function(data) {
							ecjia.admin.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
		},
	}
})(ecjia.admin, jQuery);

// end
