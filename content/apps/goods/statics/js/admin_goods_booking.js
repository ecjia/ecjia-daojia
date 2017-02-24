// JavaScript Document
;
(function(app, $) {
	app.goods_booking = {
		init: function() {
			app.goods_booking.searchform();
		},
		searchform: function() {
			//搜索功能
			$("form[name='searchForm']").on('submit', function(e) {
				e.preventDefault();
				var $this = $("form[name='searchForm']");
				var url = $this.attr('action');
				var keywords = $this.find("input[name='keywords']").val();
				ecjia.pjax(url + "&keywords=" + keywords);
			});
		},
		info: function() {
			app.goods_booking.theformsubmit();
			app.goods_booking.remail();
		},
		theformsubmit: function() {
			var $this = $('form[name="theForm"]');
			var option = {
				submitHandler: function() {
					$this.ajaxSubmit({
						dataType: "json",
						success: function(data) {
							ecjia.admin.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
		},
		remail: function() {
			$('#sticky_a').on('click', function() {
				if ($("form[name='theForm']").validate().form()) {
					var url = $(this).attr("data-url"),
						rec_id = $("input[name='rec_id']").val(),
						dispose_note = $("textarea[name='dispose_note']").val();
					$.ajax({
						type: "POST",
						data: {
							rec_id: rec_id,
							dispose_note: dispose_note,
							remail: 1
						},
						url: url,
						dataType: "json",
						success: function(data) {
							ecjia.admin.showmessage(data);
						}
					});
				}
			});
		}
	};
})(ecjia.admin, jQuery);

// end