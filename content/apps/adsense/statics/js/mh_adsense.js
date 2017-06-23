// JavaScript Document
;(function (app, $) {
    app.merchant_adsense_list = {
        init: function () {
            //搜索功能
            $("form[name='searchForm'] .search_ad").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var keywords = $("input[name='keywords']").val();
                if (keywords != '') {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
 
            //筛选功能
            $('.screen-btn').on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action')
                    url += '&media_type=' + $("#media_type option:selected").val() + '&position_id=' + $("input[name='position_id']").val()+ '&show_client=' + $("input[name='show_client']").val();
                ecjia.pjax(url);
            });
            
            $("[data-toggle='popover']").popover({ 
            	html: true,
	    		content: function() {
	    			var id = $(this).attr('data-id');
	    			return $("#content_" + id).html();
	    		},
    		});
        }
    };
 
    /* **编辑** */
    app.merchant_adsense_edit = {
        init: function () {
        	
            $(".date").datepicker({
                format: "yyyy-mm-dd",
            });

            $("#media_type").change(function () {
                $(this).children().each(function (i) {
                    $("#media_type_" + $(this).val()).hide();
                })
                $("#media_type_" + $(this).val()).show();
            });

            app.merchant_adsense_edit.submit_form();
        },
 
        submit_form: function (formobj) {
            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                    ad_name: {
                        required: true
                    },
                },
                messages: {
                    ad_name: {
                    	required: "请输入广告名称"
                    },
                },
                submitHandler: function () {
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            ecjia.merchant.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
            $form.validate(options);
        }
    };
 
})(ecjia.merchant, jQuery);
 
// end