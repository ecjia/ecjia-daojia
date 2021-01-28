;(function(admin, $) {
	admin.admin_license = {
		init : function() {
			var action = $('.fileupload').attr('data-action');
			$(".fileupload").dropper({
				action 			: action,
				label 			: admin_license_lang.upload_msg,
				maxQueue		: 2,
				maxSize 		: 5242880, // 5 mb
				height 			: 150,
				postKey			: "license",
				successaa_upload: function(data) {
					// if(data.state == 'success') {
					// 	$('.license-info .company-name').text(data.company_name);
					// 	$('.license-info .license-app').text(data.license_app);
					// 	$('.license-info .license-lv').text(data.license_lv);
					// 	$('.license-info .license-time .time').text(data.license_time);

					// 	$('.license-info').removeClass('hide');
					// 	$('.fileupload').addClass('hide');
					// }
					ecjia.admin.showmessage(data);
				}
			});

			// bind events
			$('.license-del').on('click', admin.admin_license.events('license_del'));
		},

		events: function(name) {

			var events = new Map();
			events.set('license_del', function(event) {
					event.preventDefault();
					var href = $(this).attr('href');
					smoke.confirm(admin_license_lang.delete_check,function(e){
						if (e) {
							$.get(href, '', function(data) {
								if(data.state === 'success') {
									$('.license-info').addClass('hide');
									$('.fileupload').removeClass('hide');
								}
								ecjia.admin.showmessage(data);
							});
						}
					}, {ok:admin_license_lang.ok, cancel:admin_license_lang.cancel});
				});

			return events.get(name);
		}

	}
})(ecjia.admin, jQuery);
