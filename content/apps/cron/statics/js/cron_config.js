// JavaScript Document
;(function (app, $) {
    app.cron_config = {
        init: function () {
            app.cron_config.theForm();
            app.cron_config.update_key();
            app.cron_config.get_key();
        },
        
        theForm: function () {
            var $form = $("form[name='theForm']");
            var option = {
                submitHandler: function () {
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            ecjia.admin.showmessage(data);
                        }
                    });
 
                }
            }
            var options = $.extend(ecjia.admin.defaultOptions.validate, option);
            $form.validate(options);
        },
        
        update_key : function() {
			$('.update_key').on('click', function() {
			    var $this = $(this);
			    var message = $this.attr('data-msg');
			    var url = $this.attr('data-href');
			    if (message != undefined) {
			      smoke.confirm(message, function(e) {
			            if (e) {
		                  $.get(url, function(data){
		                        ecjia.admin.showmessage(data);
		                  })
			            }
			      }, {ok:"确定", cancel:"取消"});
			    }
			 });
		},
		
	       
		get_key : function() {
		    $(".get_key").on('click', function (e) {
		         e.preventDefault();
		         var url = $(this).attr('data-href');
		         $.get(url, function (data) {
		              ecjia.admin.showmessage(data);
		         }, 'json');
		   });
		} 
    };
})(ecjia.admin, jQuery);
 
// end