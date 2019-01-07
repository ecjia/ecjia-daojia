//JavaScript Document
;(function (app, $) {
    app.payment_refund_list = {
        init: function () {
        	$(".date").datepicker({
				format: "yyyy-mm-dd"
			});
            $("form[name='searchForm']").on('submit', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var refund_status = $("select[name='refund_status']").val();
                var order_sn = $("input[name='order_sn']").val();
                var keywords = $("input[name='keywords']").val();

                if (refund_status != '') {
                	url += '&refund_status=' + refund_status;
                }
                if (order_sn != '') {
                    url += '&order_sn=' + order_sn;
                }
                if (keywords != '') {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
            $(".select-button").off('click').click(function () {
                var start_date = $("input[name='start_date']").val();
                var end_date = $("input[name='end_date']").val();
                
                if (start_date > end_date && (start_date != '' && end_date != '')) {
                    var data = {
                        message: js_lang.check_time,
                        state: "error",
                    };
                    ecjia.admin.showmessage(data);
                    return false;
                }
                
                var url = $("form[name='searchdateForm']").attr('action');
                if (start_date != '') url += '&start_date=' + start_date;
                if (end_date != '') url += '&end_date=' + end_date;
 
                ecjia.pjax(url);
            });

            app.payment_refund_list.query();
        },

        query: function () {
            $('.payrecord_query').off('click').on('click', function () {
                var $this = $(this),
                    url = $this.attr('data-url');
                $.post(url, function (data) {
                    ecjia.admin.showmessage(data);
                });
            });
        },
    };
})(ecjia.admin, jQuery);
 
// end