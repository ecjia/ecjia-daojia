// JavaScript Document
;(function (app, $) {
    app.push_list = {
        init: function () {
            $("form[name='searchForm'] .search_push").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action') + '&keywords=' + $("input[name='keywords']").val();
                ecjia.pjax(url);
            });
 
            //筛选功能
            $('.screen-btn').on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action')
                if ($("#select-status option:selected").val() != '') {
                    url += '&status=' + $("#select-status option:selected").val();
                }
                ecjia.pjax(url);
            })
 
            $(".ajaxpush").on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                $.get(url, function (data) {
                    ecjia.admin.showmessage(data);
                }, 'json');
            });
        }
    };
 
    app.push_send = {
        init: function () {
            var actionval = $("input[name='action']:checked").val();
            var targetval = $("input[name='target']:checked").val();
            if (actionval == 'webview') {
                $("#urldiv").show().removeClass("hide");
            } else if (actionval == 'search') {
                $("#keyworddiv").show().removeClass("hide");
            } else if (actionval == 'goods_list') {
                $("#catdiv").show().removeClass("hide");
            } else if (actionval == 'goods_comment' || actionval == 'goods_detail') {
                $("#goodsdiv").show().removeClass("hide");
            } else if (actionval == 'orders_detail') {
                $("#ordersdiv").show().removeClass("hide");
            }
 
            if (targetval == 1) {
                $("#onediv").show().removeClass("hide");
            }
 
            $("input[name='action']").click(function () {
                var actionval = $(this).val();
                if (actionval == 'webview') {
                    $("#urldiv").show().removeClass("hidden");
                    $("#keyworddiv").hide().addClass("hidden");
                    $("#catdiv").hide().addClass("hidden");
                    $("#goodsdiv").hide().addClass("hidden");
                    $("#ordersdiv").hide().addClass("hidden");
                    $("#sellerlist").hide().addClass("hidden");
                    $("#merchant").hide().addClass("hidden");
                } else if (actionval == 'search') {
                    $("#keyworddiv").show().removeClass("hidden");
                    $("#urldiv").hide().addClass("hidden");
                    $("#catdiv").hide().addClass("hidden");
                    $("#goodsdiv").hide().addClass("hidden");
                    $("#ordersdiv").hide().addClass("hidden");
                    $("#sellerlist").hide().addClass("hidden");
                    $("#merchant").hide().addClass("hidden");
                } else if (actionval == 'goods_list' || actionval == 'goods_seller_list') {
                    $("#catdiv").show().removeClass("hidden");
                    $("#keyworddiv").hide().addClass("hidden");
                    $("#urldiv").hide().addClass("hidden");
                    $("#goodsdiv").hide().addClass("hidden");
                    $("#ordersdiv").hide().addClass("hidden");
                    $("#sellerlist").hide().addClass("hidden");
                    $("#merchant").hide().addClass("hidden");
                } else if (actionval == 'goods_comment' || actionval == 'goods_detail') {
                    $("#goodsdiv").show().removeClass("hidden");
                    $("#keyworddiv").hide().addClass("hidden");
                    $("#catdiv").hide().addClass("hidden");
                    $("#urldiv").hide().addClass("hidden");
                    $("#ordersdiv").hide().addClass("hidden");
                    $("#sellerlist").hide().addClass("hidden");
                    $("#merchant").hide().addClass("hidden");
                } else if (actionval == 'orders_detail') {
                    $("#ordersdiv").show().removeClass("hidden");
                    $("#urldiv").hide().addClass("hidden");
                    $("#keyworddiv").hide().addClass("hidden");
                    $("#catdiv").hide().addClass("hidden");
                    $("#goodsdiv").hide().addClass("hidden");
                    $("#sellerlist").hide().addClass("hidden");
                    $("#merchant").hide().addClass("hidden");
                } else if (actionval == 'seller') {
                	$("#sellerlist").show().removeClass("hidden");
                    $("#urldiv").hide().addClass("hidden");
                    $("#keyworddiv").hide().addClass("hidden");
                    $("#catdiv").hide().addClass("hidden");
                    $("#goodsdiv").hide().addClass("hidden");
                    $("#ordersdiv").hide().addClass("hidden");
                    $("#merchant").hide().addClass("hidden");
                } else if (actionval == 'merchant' || actionval == 'merchant_detail' || actionval == 'merchant_suggest_list' || actionval == 'merchant_goods_list') {
                	$("#merchant").show().removeClass("hidden");
                    $("#urldiv").hide().addClass("hidden");
                    $("#keyworddiv").hide().addClass("hidden");
                    $("#catdiv").hide().addClass("hidden");
                    $("#goodsdiv").hide().addClass("hidden");
                    $("#ordersdiv").hide().addClass("hidden");
                    $("#sellerlist").hide().addClass("hidden");
                    if (actionval == 'merchant' || actionval == 'merchant_detail') {
                    	$("#merchant_category").hide();
                    	$("#merchant_suggest").hide();
                    } else if (actionval == 'merchant_suggest_list') {
                    	$("#merchant_category").hide();
                    	$("#merchant_suggest").show();
                    } else if (actionval == 'merchant_goods_list') {
                    	$("#merchant_category").show();
                    	$("#merchant_suggest").hide();
                    }
                }
                else {
                    $("#urldiv").hide().addClass("hidden");
                    $("#keyworddiv").hide().addClass("hidden");
                    $("#catdiv").hide().addClass("hidden");
                    $("#goodsdiv").hide().addClass("hidden");
                    $("#ordersdiv").hide().addClass("hidden");
                    $("#sellerlist").hide().addClass("hidden");
                    $("#merchant").hide().addClass("hidden");
                }
            });
 
            $("input[name='target']").click(function () {
                var targetval = $(this).val();
                if (targetval == 1) {
                    $("#onediv").show().removeClass("hidden");
                    $("#userdiv").hide().addClass("hidden");
                    $("#admindiv").hide().addClass("hidden");
                    $('#device_client').attr("disabled", false);
                } else if (targetval == 2) {
                    $("#onediv").hide().addClass("hidden");
                    $("#admindiv").hide().addClass("hidden");
                    $("#userdiv").show().removeClass("hidden");
                    $('#device_client').attr("disabled", true);
                } else if (targetval == 3) {
                    $("#userdiv").hide().addClass("hidden");
                    $("#onediv").hide().addClass("hidden");
                    $("#admindiv").show().removeClass("hidden");
                    $('#device_client').attr("disabled", true);
                } else {
                    $("#onediv").hide().addClass("hidden");
                    $("#userdiv").hide().addClass("hidden");
                    $("#admindiv").hide().addClass("hidden");
                    $('#device_client').attr("disabled", false);
                }
                $('#device_client').trigger("liszt:updated").trigger("click");
 
            });
            app.push_send.submit_form();
        },
        
        submit_form: function (formobj) {
            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                    title: {
                        required: true
                    },
                    content: {
                        required: true
                    },
                },
                messages: {
                    title: {
                        required: js_lang.title_required
                    },
                    content: {
                        required: js_lang.content_required
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