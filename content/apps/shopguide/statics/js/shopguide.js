// JavaScript Document
;(function (app, $) {
    app.shopguide = {
        init: function () {
            app.shopguide.submit();
            app.shopguide.choose_area();
            app.shopguide.fileupload();
 
            $('select[name="shipping"]').on('change', function () {
                if ($(this).val() != '') {
                    $('.shipping_area').show();
                } else {
                    $('.shipping_area').hide();
                }
            });
 
            $('select[name="payment"]').on('change', function () {
                if ($(this).val() != '') {
                    var url = $(this).attr('data-url');
                    var value = $(this).val();
 
                    $.post(url, {
                        code: value
                    }, function (data) {
                        app.shopguide.load_pay_tmp(data);
                    });
                } else {
                    $('.payment_area').hide();
                }
            });
        },
        
		fileupload: function() {
			$(".shop-logo").on('click', function(e) {
				e.preventDefault();
				$(this).parent().find("input").trigger('click');
			})
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
                    store_cat: {
                    	required: true
                    },
                },
                messages: {
                	shop_name: {
                		required: js_lang.shop_name_required
                	},
                	shipping_area_name: {
                		required: js_lang.area_name_required
                	},
                    cat_name: {
                        required: js_lang.goods_cat_required
                    },
                    goods_name: {
                        required: js_lang.goods_name_required
                    },
                    store_cat: {
                    	required: js_lang.store_cat_required
                    },
                },
                submitHandler: function () {
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            if (data.message == '') {
                                ecjia.pjax(data.url);
                            } else {
                                ecjia.admin.showmessage(data);
                            }
                        }
                    });
                }
            }
            var options = $.extend(ecjia.admin.defaultOptions.validate, option);
            $form.validate(options);
        },
 
        choose_area: function () {
            $('.sel_region').on('change', function (e) {
                e.preventDefault();
                var $this = $(this),
                    val = $this.val(),
                    url = $this.attr('data-url'),
                    $next = $('.' + $this.attr('data-next'));
                /* 如果是县乡级别的，不触发后续操作 */
                if ($this.parent().hasClass('selDistricts')) {
                    return;
                }
                $next.html('');
                /* 如果是0的选项，则后续参数也设置为0 */
                if (url == undefined) {
                    var $tmp = $('<option value="0">'+ js_lang.pls_select +'</option>');
                    $next.html($tmp);
                    $tmp.trigger('change');
                    return;
                }
                /* 请求参数 */
                $.get(url, {
                    parent: val
                }, function (data) {
                    var html = ('<option value="0">'+ js_lang.pls_select +'</option>');
                    /* 如果有返回参数，则赋值并触发下一级别的选中 */
                    if (data.regions) {
                        for (var i = data.regions.length - 1; i >= 0; i--) {
                            html += '<option value="' + data.regions[i].region_id + '">' + data.regions[i].region_name +
                                '</option>';
                        };
                        $next.html(html).trigger("liszt:updated").find('option:selected').trigger('change');
                        /* 如果没有返回参数，则直接触发选中0的操作 */
                    } else {
                        $next.html(html).trigger("liszt:updated").trigger('change');
                        return;
                    }
                }, 'json');
            });
        },
 
        load_pay_tmp: function (data) {
            var config = data.content.pay_config;
            if (config.length > 0) {
                $('.payment_area').show();
                var html = '';
                for (var i = 0; i < config.length; i++) {
                    html += '<div class="control-group formSep"><label class="control-label">' + config[i].label +
                        '</label><div class="controls">';
 
                    if (config[i].type == 'text') {
                        html += '<input class="w350" id="cfg_value[]" name="cfg_value[]" type="' + config[i].type +
                            '" value="" size="40" />';
                    } else if (config[i].type == 'textarea') {
                        html +=
                            '<textarea class="w350" id="cfg_value[]" name="cfg_value[]" cols="80" rows="5"></textarea>';
                    } else if (config[i].type == 'select') {
                        html += '<select class="w350" id="cfg_value[]" name="cfg_value[]">';
                        html += '<option value="">'+ js_lang.pls_select +'</option>';
                        for (var j = 0; j < config[i].range.length; j++) {
                            html += '<option value="' + j + '">' + config[i].range[j] + '</option>';
                        }
                        html += '</select>';
                    }
                    html += '<input name="cfg_name[]" type="hidden" value="' + config[i].name + '" />' +
                        '<input name="cfg_type[]" type="hidden" value="' + config[i].type + '" />' +
                        '<input name="cfg_lang[]" type="hidden" value="' + config[i].lang + '" /></div></div>';
                }
                $('.payment_area').html(html).show();
                $('.payment_area').find('select').chosen();
            } else {
                $('.payment_area').html('').hide();
                return false;
            }
        },
    }
})(ecjia.admin, jQuery);

//end