// JavaScript Document
;(function (app, $) {
    app.sms_events_list = {
        init: function () {
			$('#danger-toggle-button').toggleButtons({
			  style: {
			      enabled: "danger",
			      disabled: "info"
			  }
			});
        	  
	    	$('.change_status').on('click', function() {
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
					}, {ok:js_lang_sms_events.ok, cancel:js_lang_sms_events.cancel});
				} 
			});
        },
    };
})(ecjia.admin, jQuery);
 
// end