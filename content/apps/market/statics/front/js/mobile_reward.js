// JavaScript Document
;(function(app, $) {
	app.reward = {
		init : function () {
			$('.receive_btn').on('click', function(e) {
				e.preventDefault();
				var url		= $('.reward-button').attr('data-url');
				var token	= $("input[name='token']").val();
				$.ajax({
					type: "POST",
					url: url,
					data: {
						token : token,
					},
					dataType: "json",
					success: function (data) {
						if (data.state == 'error') {
							alert(data.message);
							if (data.url) {
								location.href = data.url;
							}
						} else {
							$("#cover").show();
							$(".success-image").show();
							$('.to-use').attr('data-url', data.url);
							$('.close').attr('data-url', data.close_url);
						}
					}
        		});
			});
			
			$('.close').on('click', function(e) {
				$("#cover").hide();
				$(".success-image").hide();
				var url = $(".close").attr("data-url");
				if (url != '') {
					location.href = url;
				}
			});
			
			$('.to-use').on('click', function(e) {
				var url = $(this).attr('data-url');
				if (url != '') {
					location.href = url;
				}
			});
		},
	};
})(ecjia.front, jQuery);
