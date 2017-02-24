// JavaScript Document

;(function(app, $) {
	app.express = {
		init : function() {
		},
		info : function() {
			app.express.expressForm();
		},
		expressForm : function() {
			$("form[name='expressForm']").on('submit', function(e){
				e.preventDefault();
				$(this).ajaxSubmit({
					dataType:"json",
					success:function(data){
						ecjia.merchant.showmessage(data);
					}
				});
			});
		},
	}
	
})(ecjia.merchant, jQuery);

// end
