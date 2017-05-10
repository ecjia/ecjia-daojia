// JavaScript Document
;(function (app, $) {
    app.adsense_list = {
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
    app.adsense_edit = {
        init: function (get_value) {
            /* 加载日期控件 */
            $(".date").datepicker({
                format: "yyyy-mm-dd",
                container : '.main_content',
            });
 
            var type = $('#type').val();
            if (type == 1) {
                $('#show_src').css("display", "none");
                $("#show_local").css("display", "block");
            }
 
            $("input[name='brand_logo_type']").click(function () {
                var brand_type = $(this).val();
                if (brand_type == 0) {
                    $('#show_src').css("display", "block");
                    $('#show_local').css("display", "none");
                } else {
                    $('#show_src').css("display", "none");
                    $("#show_local").css("display", "block");
                }
            });
 
            $("#media_type").change(function () {
                $(this).children().each(function (i) {
                    $("#media_type_" + $(this).val()).hide();
                })
                $("#media_type_" + $(this).val()).show();
 
            });
 
            /* 生成js代码*/
            $("input[name='gen_code']").click(function () {
                if ($("[name=outside_address]").val() == '') {
                    var mesObj = new Object();
                    mesObj.state = 'error';
                    mesObj.message = js_lang.gen_code_message;
                    ecjia.admin.showmessage(mesObj);
                    return;
                }
                app.adsense_edit.genCode();
                app.adsense_edit.autocopy();
            });
 
            app.adsense_edit.submit_form();
        },
 
        /**
         * 生成代码
         */
        genCode: function () {
            var url = $("input[name='gen_code']").attr('data-jsurl');
            var code = '<script src="' + url;
            code += '&from=' + $("[name=outside_address]").val();
            code += '&charset=' + $("[name=charset]").val();
            code += '"></script\>';
            $("[name=ads_js]").val(code);
        },
 
        /**
         * 复制
         */
        autocopy: function () {
            var Browser = new Object();
            Browser.isMozilla = (typeof document.implementation != 'undefined') && (typeof document.implementation.createDocument !=
                'undefined') && (typeof HTMLDocument != 'undefined');
            Browser.isIE = window.ActiveXObject ? true : false;
            Browser.isFirefox = (navigator.userAgent.toLowerCase().indexOf("firefox") != -1);
            Browser.isSafari = (navigator.userAgent.toLowerCase().indexOf("safari") != -1);
            Browser.isOpera = (navigator.userAgent.toLowerCase().indexOf("opera") != -1);
 
            if (Browser.isIE) {
                window.clipboardData.setData('Text', $("[name=ads_js]").val());
            }
            $("[name=ads_js]").select();
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
                        required: js_lang.ad_name_required
                    },
                },
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
        }
    };
 
})(ecjia.admin, jQuery);
 
// end