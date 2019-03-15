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
                        return false;
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
 
})(ecjia.admin, jQuery);
 
// end