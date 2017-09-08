//JavaScript Document
;(function (app, $) {
    app.payment_record = {
        init: function () {
            app.payment_record.change_status();
        },
        change_status: function () {
            /* 修复订单状态 */
            $('.change_status').on('click', function (e) {
                var url = $(this).attr('data-url');
            	$.get(url, function(data) {
            		ecjia.admin.showmessage(data);
            	});
            });
        },
    };
})(ecjia.admin, jQuery);
 
// end