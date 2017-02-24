// JavaScript Document
;(function(app, $) {
	app.order_query = {
		init : function() {
			$(".date").datepicker({
				format: "yyyy-mm-dd",
				container : '.main_content',
			});
			app.order_query.theFormsubmit();
		},
		
		theFormsubmit : function() {
			$("form[name='theForm']").on('submit', function(e) {
				e.preventDefault();
				app.order_query.search();
			});
		},
		
		search : function() {
			var $this = $("form[name='theForm']");
			var url   = $this.attr('action');
			
			$this.find("input").not("input[type='submit'], input[type='button'], input[type='reset']").each(function(i) {
				var name = $(this).attr("name");
				var val = $(this).val();
				
				if (name != undefined) {
					if (val != '') {
						url += "&" + name + "=" + val;
					}
				}
			});
			
			$this.find("select").each(function(i) {
				var name = $(this).attr("name");
				var val = $(this).val();
				
				if (name != undefined) {
					if (val != '' && val >= 0) {
						url += "&" + name + "=" + val;
					}
				}
			});
			ecjia.pjax(url);
		},
	}
	
})(ecjia.admin, jQuery);

// end