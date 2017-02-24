// JavaScript Document
;(function(app, $) {
	app.order_query = {
		init : function() {
			$(".date").datepicker({
				format: "yyyy-mm-dd",
			});
			app.order_query.theFormsubmit();
		},
		theFormsubmit : function() {
			$("form[name='theForm']").on('submit',  function(e) {
				e.preventDefault();
				app.order_query.search();
			});
		},
		
		search : function() {
			var $this	= $("form[name='theForm']");
			var url		= $this.attr('action');
			
			$this.find("input").not("input[type='submit'],input[type='button'],input[type='reset']").each(function(i){
				if ($(this).attr("name") != undefined) {
					url += "&" + $(this).attr("name") + "=" + $(this).val();
				}
			});
			
			$this.find("select").each(function(i){
				url += "&" + $(this).attr("name") + "=" + $(this).val();
			});
			
			ecjia.pjax(url);
		},
	}
})(ecjia.merchant, jQuery);

// end