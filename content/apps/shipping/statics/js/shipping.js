// JavaScript Document
;(function (app, $) {
    app.shippingObj = {
        init: function () {},
 
        /* 配送费用计算方式 */
        area_compute_mode: function (shipping_code, mode) {
            var base_fee = document.getElementById("base_fee");
            var step_fee = document.getElementById("step_fee");
            var item_fee = document.getElementById("item_fee");
            if (shipping_code == 'ship_post_mail' || shipping_code == 'ship_post_express') {
                var step_fee1 = document.getElementById("step_fee1");
            }
            if (mode == 'number') {
                item_fee.style.display = '';
                base_fee.style.display = 'none';
                step_fee.style.display = 'none';
                if (shipping_code == 'ship_post_mail' || shipping_code == 'ship_post_express') {
                    step_fee1.style.display = 'none';
                }
            } else {
                item_fee.style.display = 'none';
                base_fee.style.display = '';
                step_fee.style.display = '';
                if (shipping_code == 'ship_post_mail' || shipping_code == 'ship_post_express') {
                    step_fee1.style.display = '';
                }
            }
        },
        area_region_add: function () {
            var selCountry = document.forms['theForm'].elements['country'];
            var selProvince = document.forms['theForm'].elements['province'];
            var selCity = document.forms['theForm'].elements['city'];
            var selDistrict = document.forms['theForm'].elements['district'];
            var regionCell = '';
            $("#regionCell").children().each(function (i) {
                if (i % 2 == 0) {
                    regionCell += $(this).find(".uni-checked").html();
                } else {
                    regionCell += '<span>' + $(this).html() + '</span>';
                }
            });
            if (selDistrict.selectedIndex > 0) {
                regionId = selDistrict.options[selDistrict.selectedIndex].value;
                regionName = selDistrict.options[selDistrict.selectedIndex].text;
            } else {
                if (selCity.selectedIndex > 0) {
                    regionId = selCity.options[selCity.selectedIndex].value;
                    regionName = selCity.options[selCity.selectedIndex].text;
                } else {
                    if (selProvince.selectedIndex > 0) {
                        regionId = selProvince.options[selProvince.selectedIndex].value;
                        regionName = selProvince.options[selProvince.selectedIndex].text;
                    } else {
                        if (selCountry.selectedIndex >= 0) {
                            regionId = selCountry.options[selCountry.selectedIndex].value;
                            regionName = selCountry.options[selCountry.selectedIndex].text;
                        } else {
                            return;
                        }
                    }
                }
            }
            /* 检查该地区是否已经存在 */
            exists = false;
            for (i = 0; i < document.forms['theForm'].elements.length; i++) {
                if (document.forms['theForm'].elements[i].type == "checkbox") {
                    if (document.forms['theForm'].elements[i].value == regionId) {
                        exists = true;
                        var mesObj = new Object();
                        mesObj.message = $('#region_warn').val();
                        mesObj.state = 'error';
                        ecjia.admin.showmessage(mesObj);
                    }
                }
            }
            /* 创建checkbox */
            if (!exists) {
                regionCell += "<input type='checkbox' class='uni_style' name='regions[]' value='" + regionId + "' checked='true' /><span>" + regionName + "  </span>";
                $("#regionCell").html(regionCell);
                $(".uni_style").uniform();
                /* 显示 */
                $(".select_region").css("display", "block");
            }
        },
        valid: function (input) {
            if (input) {
                if (input.value.length == 0 || input.value.match(/[^0-9]/) != null) {
                    return true;
                }
            } else {
                return false;
            }
        },
 
        /* *配送区域列表界面js初始化* */
        shipping_area_init: function () {
 
        },
        /* 搜索 */
        shipping_area_list_search: function (url) {
            var keywords = $('[name=keywords]').val();
            var code = $('[name=code]').val();
            var shipping_id = $('[name=shipping_id]').val();
            url = url + "&shipping_id=" + shipping_id + "&code=" + code + "&keywords=" + keywords;
            ecjia.pjax(url);
        },
    };
 
    /* 添加编辑配送区域js初始化 */
    app.area_info = {
        init: function () {
            /* 添加编辑配送区域form提交 */
            app.area_info.shipping_submit();
            app.area_info.choose_area();
            app.area_info.selected_area();
            app.area_info.quick_search();
            app.area_info.tpicker();
            app.area_info.datepicker();
        },
        tpicker : function () {
			$('.fontello-icon-plus').click(function(e) {
				setTimeout(function () { 
					$(".tp_1").datetimepicker({
						format: "hh:ii",
		                weekStart: 1,
		                todayBtn: 1,
		                autoclose: 1,
		                todayHighlight: 1,
		                startView: 1,
		                forceParse: 0,
		                minuteStep: 5
					});
			    }, 1000);
			});
		},
		
		datepicker : function(){
			$.fn.datetimepicker.dates['zh'] = {  
                days:       ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六","星期日"],  
                daysShort:  ["日", "一", "二", "三", "四", "五", "六","日"],  
                daysMin:    ["日", "一", "二", "三", "四", "五", "六","日"],  
                months:     ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月","十二月"],  
                monthsShort:  ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月","十二月"], 
                meridiem:    ["上午", "下午"],  
                today:       "今天"  
	        };
            $(".tp_1").datetimepicker({
				format: "hh:ii",
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 1,
                forceParse: 0,
                minuteStep: 5
			});
        },
 
        shipping_submit: function () {
            $('form[name="theForm"]').on('submit', function (e) {
                e.preventDefault();
                var objform = $('form[name="theForm"]')[0];
                var mesObj = new Object();
                mesObj.state = 'error';
                if (objform.shipping_area_name.value.length == 0) {
                    mesObj.message = js_lang.shipping_area_name_required;
                    ecjia.admin.showmessage(mesObj);
                    $(objform.shipping_area_name).focus();
                    return false;
                } else if (app.shippingObj.valid(objform.free_money)) {
                    var text = $(objform.free_money).parent().prev('label').html();
                    mesObj.message = text + ' ' + js_lang.not_empty_message;
                    ecjia.admin.showmessage(mesObj);
                    $(objform.free_money).focus();
                    return false;
                } else if (app.shippingObj.valid(objform.base_fee)) {
                    var text = $(objform.base_fee).parent().prev('label').html();
                    mesObj.message = text + ' ' + js_lang.not_empty_message;
                    ecjia.admin.showmessage(mesObj);
                    $(objform.base_fee).focus();
                    return false;
                } else if (app.shippingObj.valid(objform.pay_fee)) {
                    var text = $(objform.pay_fee).parent().prev('label').html();
                    mesObj.message = text + ' ' + js_lang.not_empty_message;
                    ecjia.admin.showmessage(mesObj);
                    $(objform.pay_fee).focus();
                    return false;
                } else if (app.shippingObj.valid(objform.item_fee)) {
                    var text = $(objform.item_fee).parent().prev('label').html();
                    mesObj.message = text + ' ' + js_lang.not_empty_message;
                    ecjia.admin.showmessage(mesObj);
                    $(objform.item_fee).focus();
                    return false;
                } else if (app.shippingObj.valid(objform.step_fee)) {
                    var text = $(objform.step_fee).parent().prev('label').html();
                    mesObj.message = text + ' ' + js_lang.not_empty_message;
                    ecjia.admin.showmessage(mesObj);
                    $(objform.step_fee).focus();
                    return false;
                }
                /* 确定有区域添加 */
                var regions_chk_cnt = 0;
                for (i = 0; i < document.getElementsByName('regions[]').length; i++) {
                    if (document.getElementsByName('regions[]')[i].checked == true) {
                        regions_chk_cnt++;
                    }
                }
                if (regions_chk_cnt == 0) {
                    mesObj.message = js_lang.shipping_area_region_required;
                    ecjia.admin.showmessage(mesObj);
                    return false;
                }
                $(objform).ajaxSubmit({
                    dataType: "json",
                    success: function (data) {
                        if (data.state == "success") {
                            if (data.refresh_url != undefined) {
                                var url = data.refresh_url;
                                ecjia.pjax(url, function () {
                                    ecjia.admin.showmessage(data);
                                });
                            } else {
                                ecjia.admin.showmessage(data);
                            }
                        } else {
                            ecjia.admin.showmessage(data);
                        }
                    }
                });
            });
        },
 
        choose_area: function () {
            $('.ms-elem-selectable').on('click', function (e) {
                e.preventDefault();
                var $this = $(this),
                    val = $this.attr('data-val'),
                    url = $this.parent().attr('data-url'),
                    $next = $('.' + $this.parent().attr('data-next'));
                /* 如果是县乡级别的，不触发后续操作 */
                if ($this.parent().hasClass('selDistricts')) {
                    $this.siblings().removeClass('disabled');
                    if (val != 0) $this.addClass('disabled');
                    return;
                }
                /* 如果是0的选项，则后续参数也设置为0 */
                if (val == 0) {
                    var $tmp = $('<li class="ms-elem-selectable" data-val="0"><span>' + js_lang.no_select_region + '</span></li>');
                    $next.html($tmp);
                    $tmp.trigger('click');
                    return;
                }
                /* 请求参数 */
                $.get(url, {
                    parent: val
                }, function (data) {
                    $this.siblings().removeClass('disabled');
                    $this.addClass('disabled');
                    var html = '';
                    /* 如果有返回参数，则赋值并触发下一级别的选中 */
                    if (data.regions) {
                        for (var i = data.regions.length - 1; i >= 0; i--) {
                            html += '<li class="ms-elem-selectable" data-val="' + data.regions[i].region_id + '"><span>' + data.regions[i].region_name +
                                '</span><span class="edit-list"><a href="javascript:;">' + js_lang.add + '</a></span></li>';
                        };
                        $next.html(html);
                        app.area_info.quick_search();
                        $('.ms-elem-selectable').unbind("click");
                        $('.ms-elem-selectable .edit-list a').unbind("click");
                        app.area_info.choose_area();
                        app.area_info.selected_area();
                        $next.find('.ms-elem-selectable').eq(0).trigger('click');
                        /* 如果没有返回参数，则直接触发选中0的操作 */
                    } else {
                        var $tmp = $('<li class="ms-elem-selectable" data-val="0"><span>' + js_lang.no_select_region + '</span></li>');
                        $next.html($tmp);
                        $tmp.trigger('click');
                        return;
                    }
                }, 'json');
            });
        },
 
        selected_area: function () {
            $('.ms-elem-selectable .edit-list a').on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var bool = true;
                var $this = $(this),
                    $parent = $this.parents('li.ms-elem-selectable'),
                    val = $parent.attr('data-val'),
                    name = $parent.find('span').eq(0).text(),
                    $tmp = $('<input type="checkbox" checked="checked" value="' + val + '" name="regions[]" /><span class="m_r10">' + name + '</span>');
                $('.selected_area div').each(function (i) {
                    if ($(this).find("input").val() == val) {
                        var data = {
                            message: js_lang.region_selected,
                            state: "error",
                        };
                        ecjia.admin.showmessage(data);
                        bool = false;
                        return false;
                    }
                });
                if (bool) {
                    $('.selected_area').append($tmp);
                    $tmp.uniform();
                }
            });
        },
 
        quick_search: function () {
            var opt = {
                onAfter: function () {
                    $('.ms-group').each(function (index) {
                        $(this).find('.isShow').length ? $(this).css('display', 'block') : $(this).css('display', 'none');
                    });
                    return;
                },
                show: function () {
                    this.style.display = "";
                    $(this).addClass('isShow');
                },
                hide: function () {
                    this.style.display = "none";
                    $(this).removeClass('isShow');
                },
            };
            $('#selCountry').quicksearch($('.selCountry .ms-elem-selectable'), opt);
            $('#selProvinces').quicksearch($('.selProvinces .ms-elem-selectable'), opt);
            $('#selCities').quicksearch($('.selCities .ms-elem-selectable'), opt);
            $('#selDistricts').quicksearch($('.selDistricts .ms-elem-selectable'), opt);
        },
    }
 
})(ecjia.admin, jQuery);
 
// end