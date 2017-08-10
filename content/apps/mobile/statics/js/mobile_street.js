// JavaScript Document
;(function(app, $) {
	app.mobile_street = {
		init : function() {
			ecjia.admin.mobile_street.refresh();
		},
		
		//刷新
		refresh: function (option) {
            $('.toggle_view').on('click', function (e) {
                e.preventDefault();
                var $this = $(this);
                var url = $this.attr('href');
                var val = $this.attr('data-val') || 'allow';
                var data = {
                    check: val,
                }
                 $.post(url, data, function (data) {
                   console.log(data);
                   ecjia.admin.showmessage(data);
                 }, 'json');
            });
        },
	};
})(ecjia.admin, jQuery);

//end