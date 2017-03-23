// JavaScript Document
;(function (app, $) {
    app.appeal_list = {
        init: function () {
            //搜索功能
            $("form[name='searchForm'] .btn-primary").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var keywords = $("input[name='keywords']").val();
                if (keywords != '') {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
            
            
			$('.remove_apply').on('click', function() {
				var $this = $(this),
					message = $this.attr('data-msg'),
					url = $this.attr('data-href');
				if (message != undefined) {
					smoke.confirm(message, function(e) {
						if (e) {
							$.get(url, function(data){
								ecjia.merchant.showmessage(data);
							})
						}
					}, {ok:"确定", cancel:"取消"});
				} 
			});
        }
    };
 
    app.appeal_info = {
        init: function () {   
			$('#appeal_btn').on('click', function() {
				$(".filepath").removeAttr("disabled");
	    		var $form = $("form[name='theForm']");
				var option = {
						submitHandler : function() {
							$form.ajaxSubmit({
								dataType : "json",
								success : function(data) {
									ecjia.merchant.showmessage(data);
								}
							});
						}
					}
				 var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
				$form.validate(options);
			});
        }
    };
})(ecjia.merchant, jQuery);
 
// end