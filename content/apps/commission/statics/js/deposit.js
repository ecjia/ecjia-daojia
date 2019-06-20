// JavaScript Document
;
(function(app, $) {
	app.deposit = {
		init : function() {
			app.deposit.subForm();
			app.deposit.time();
			app.deposit.search();
			app.deposit.searchMerchant();

			$('.select-link').off('change').on('change', function () {
				var $this = $(this).find("option:selected");

				var text = $this.text();
				var val = $this.val();
				var html = '';
				if (val != 0) {
					html = text;
				}
				$('.select-link-content').val(html);
			});
		},

		subForm : function () {
			var $form = $("form[name='theForm']");
			var option = {
				rules: {
					store_phone: {
						required: true
					},
					amount: {
						required: true
					},
					admin_note: {
                        required: true
                    }
                },
                messages: {
					store_phone: {
						required: jslang.phone_canot_empty
					},
					amount: {
						required: jslang.deposit_amount_canot_empty
					},
                	admin_note: {
                        required: jslang.desc_canot_empty
                    }
                },
				submitHandler : function() {
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
		},
		
		time: function() {
			$(".date").datepicker({
                format: "yyyy-mm-dd",
			});
		},
		
		search : function() {
			$("form[name='searchForm']").on('submit', function(e) {
				e.preventDefault();
				var start_time = $("input[name='start_time']").val();
				var end_time = $("input[name='end_time']").val();
				var keywords = $("input[name='keywords']").val();
				var merchant_keywords = $("input[name='merchant_keywords']").val();
				
				var url = $("form[name='searchForm']").attr('action'); 
				if (start_time != '') {
					url += '&start_time=' + start_time;
				}
				if (end_time != '') {
					url += '&end_time=' + end_time;
				}
				if (start_time != '' && end_time != '') {
					if (start_time >= end_time) {
						var mesObj = {
							message : jslang.start_time_canot_earlier_than_end_time,
							state : "error",
						};
						ecjia.admin.showmessage(mesObj);
						return false;
					}
				}
				if (keywords != '') {
					url += '&keywords=' + keywords;
				}
				if (merchant_keywords != '') {
					url += '&merchant_keywords=' + merchant_keywords;
				}
				ecjia.pjax(url);
			});
		},

		searchMerchant : function() {
			$(".merchant_search").on('click', function(e) {
				search();
			});
			$("input[name='store_phone']").on('blur', function(e) {
				search();
			});

			$(".btn-clear").on('click', function(e) {
				$(".store-show").hide();
				$('.data-store-name').text('');
				$('.data-staff-name').text('');
				$("input[name='store_phone']").val('');
				$("input[name='store_phone']").removeAttr('readonly');
			});


			function search() {
				var store_phone = $("input[name='store_phone']").val();
				var url = $(".merchant_search").attr('data-url');

				if(store_phone.length < 6) {
					var mesObj = {
						message : jslang.phone_error,
						state : "error",
					};
					return ecjia.admin.showmessage(mesObj);
				}

				$.ajax({
					type: "POST",
					url: url,
					data: {
						store_phone: store_phone
					},
					dataType: "json",
					success: function (data) {

						if (data.state == 'error') {
							$('.data-store-name').text('null');
							$('.data-staff-name').text('null');
							return ecjia.admin.showmessage(data);
						}
						// if (pjaxurl != '') {
						// 	ecjia.pjax(pjaxurl, function() {
						// 		ecjia.admin.showmessage(data);
						// 	});
						// }
						$("input[name='store_phone']").attr('readonly', 'true');
						$('.data-store-name').text(data.store_name);
						$('.data-staff-name').text(data.staff_name);
						$(".store-show").show();
					}
				});
			}
		},
	};
})(ecjia.admin, jQuery);

// end