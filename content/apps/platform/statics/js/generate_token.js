// JavaScript Document
;(function(app, $) {
	app.generate_token = {
		init : function() {
			ecjia.admin.generate_token.token();
		},
		
		//生成token
		token: function (option) {
            $('.toggle_view').on('click', function (e) {
                e.preventDefault();
                var $this = $(this);
                var url = $this.attr('href');
                var val = $this.attr('data-val') || 'allow';
              
                var data = {
                    check: val,
                }
                 $.post(url, data, function (data) {
                	 if (data.state == 'success') {
                		 $('.generate_token').val(data.token);
                	 }
                   ecjia.admin.showmessage(data);
                 }, 'json');
            });
        },
	};
})(ecjia.admin, jQuery);

//end