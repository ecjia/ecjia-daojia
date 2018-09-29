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
					sort_url = $(this).attr('data-sorturl');
				var info = [];
				$('.opened li').each(function(i) {
					var $this = $(this);
					var codes = $this.attr('code');
					info.push(codes);
				});
				$.get(sort_url, {info}, function(data) {
					ecjia.admin.showmessage(data);
				})
			});
		}

		
	};
})(ecjia.admin, jQuery);
