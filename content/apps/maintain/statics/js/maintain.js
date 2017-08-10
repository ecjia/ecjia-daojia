// JavaScript Document
;(function (app, $) {
    app.maintain_run = {
        init: function () {
            $("#maintain_run").on('click', function (e) {
            	 $(this).addClass('disabled');
            	 $('#start').html("正在运行");
	             e.preventDefault();
	             var url = $(this).attr('href');
	             var code = $("input[name='code']").val();
	             url += '&code=' + code;
	             $.get(url, function (data) {
	                  ecjia.admin.showmessage(data);
	                  $(this).removeClass('disabled');
	                  $('#start').html("开始运行");
	             }, 'json');
            });
        	
        },
    };
})(ecjia.admin, jQuery);
 
// end