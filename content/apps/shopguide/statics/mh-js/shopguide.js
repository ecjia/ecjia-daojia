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
        
        formatTimeLabelFunc:function(value, type) {
        	var hours = String(value).substr(0,2);
        	var mins = String(value).substr(3,2);

        	if (hours > 24) {
        		hours = hours - 24;
        		hours = (hours < 10 ? "0"+hours : hours);
        		value = hours+':'+mins;
        		var text = String('次日%s').replace('%s', value);
        		return text;
        	}
        	else {
        		return value;
        	}
        },

        range : function(){
            $('.range-slider').jRange({
                from: 0, to: 2880, step:30,
                scale: ['00:00','04:00','08:00','12:00','16:00','20:00','次日00:00','04:00','08:00','12:00','16:00','20:00','24:00'],
                format: app.shopguide.formatTimeLabelFunc,
                width: 700,
                showLabels: true,
                isRange : true
            });
        }
    }
})(ecjia.merchant, jQuery);

//end