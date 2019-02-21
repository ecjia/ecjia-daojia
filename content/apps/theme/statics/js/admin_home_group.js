;(function(admin, $) {
	admin.admin_home_group = {
		init : function() {
			admin.admin_home_group.todrags();
			admin.admin_home_group.save_sort();
		},

		todrags : function() {
			$('#dragslot').dragslot({
				dropCallback: function(el){
				//	alert(el);
				}
			});
		},
		
		save_sort: function() {
			$('.save-sort').on('click', function(e) {
				e.preventDefault();

				var sort_url = $(this).attr('data-sorturl');

				var modules = [];

				$('.opened li').each(function(i) {
					var $this = $(this);
					var code = $this.attr('code');
					if (code) {
						modules.push(code);
					}
				});

				$.post(sort_url, {
					'modules' : modules
				}, function(data) {
					ecjia.admin.showmessage(data);
				})
			});
		}

		
	};
})(ecjia.admin, jQuery);
