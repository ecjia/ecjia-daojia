// JavaScript Document
;(function (app, $) {
    app.shopguide = {
        init: function () {
            app.shopguide.submit();
            app.shopguide.range();
        },
 
        submit: function () {
            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                	shop_name: {
                		required: true
                	},
                	shipping_area_name: {
                		required: true
                	},
                    cat_name: {
                        required: true
                    },
                    goods_name: {
                        required: true
                    },
                },
                messages: {
                	shop_notice: {
                		required: '请输入店铺公告',
                	},
                	shop_description: {
                		required: '请输入店铺简介',
                	},
                	cat_name: {
                		required: '请输入商品分类',
                	},
                	goods_name: {
                		required: '请输入商品名称',
                	},
                },
                submitHandler: function () {
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            if (data.message == '') {
                                ecjia.pjax(data.url);
                            } else {
                                ecjia.merchant.showmessage(data);
                            }
                        }
                    });
                }
            }
            var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
            $form.validate(options);
        },
        
        range : function(){
            $('.range-slider').jRange({
                from: 0, to: 1440, step:30,
                scale: ['00:00','03:00','06:00', '09:00','12:00' ,'15:00','18:00','21:00','24:00'],
                format: '%s',
                width: 500,
                showLabels: true,
                isRange : true
            });
        }
    }
})(ecjia.merchant, jQuery);

//end