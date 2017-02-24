// JavaScript Document
;(function (app, $) {
    app.favourable_list = {
        init: function () {
            /* 列表搜索传参 */
            $("form[name='searchForm'] .search_articles").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                var keyword = $("input[name='keyword']").val();
                var merchant_name = $("input[name='merchant_name']").val();
                if (!!merchant_name) {
                	url += '&merchant_name=' + merchant_name;
                }
                if (keyword != '') {
                	url += '&keyword=' + keyword;
                }
                ecjia.pjax(url);
            });
        },
    }

    /* 文章编辑新增js初始化 */
    app.favourable_info = {
        init: function () {
            /* 加载日期控件 */
			$.fn.datetimepicker.dates['zh'] = {  
                days:       ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六","星期日"],  
                daysShort:  ["日", "一", "二", "三", "四", "五", "六","日"],  
                daysMin:    ["日", "一", "二", "三", "四", "五", "六","日"],  
                months:     ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月","十二月"],  
                monthsShort:  ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月","十二月"], 
                meridiem:    ["上午", "下午"],  
                today:       "今天"  
	        };
            $(".date").datetimepicker({
                format: "yyyy-mm-dd hh:ii",
                language: 'zh',  
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0,
                minuteStep: 1
            });

            app.favourable_info.submitfavourable();
            app.favourable_info.act_range(true);
            app.favourable_info.act_type();
            app.favourable_info.act_range_plus();
            app.favourable_info.act_type_plus();
            app.favourable_info.remove();
            app.favourable_info.remove1();


            $('#act_range_id').change(function () {
                app.favourable_info.act_range(false);
            });
            $('#act_type_id').change(function () {
                app.favourable_info.act_type();
            });

            $("#search").on('click', function () {
                var keyword = document.forms['theForm'].elements['keyword'].value;
                var act_range = document.forms['theForm'].elements['act_range'].value;
                var searchurl = $(this).attr('data-url');
                $.ajax({
                    url: searchurl,
                    dataType: "JSON",
                    type: "POST",
                    data: {
                        keyword: keyword,
                        act_range: act_range
                    },
                    success: function (data) {
                        app.favourable_info.searchResponse(data);
                    }
                });
            });
            $("#search1").on('click', function () {
                var keyword = document.forms['theForm'].elements['keyword1'].value;
                var act_range = 3;
                var searchurl = $(this).attr('data-url');
                $.ajax({
                    url: searchurl,
                    dataType: "JSON",
                    type: "POST",
                    data: {
                        keyword: keyword,
                        act_range: act_range
                    },
                    success: function (data) {
                        app.favourable_info.searchResponse1(data);
                    }
                });
            });
        },

        submitfavourable: function () {
            var $form = $('form[name="theForm"]');
            var start_time = $("input[name='start_time']").val();
            /* 给表单加入submit事件 */
            var option = {
                rules: {
                    act_name: {
                        required: true,
                        minlength: 1
                    },
                    start_time: {
                        required: true,
                        date: false
                    },
                    end_time: {
                        required: true,
                        date: false
                    },
                },
                messages: {
                    act_name: {
                        required: js_lang.act_name_not_null
                    },
                    start_time: {
                        required: "",
                    },
                    end_time: {
                        required: "",
                    }
                },
                submitHandler: function () {
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            if (data.state == "success") {
                                if (data.refresh_url != undefined) {
                                    var pjaxurl = data.refresh_url;
                                    ecjia.pjax(pjaxurl, function () {
                                        ecjia.merchant.showmessage(data);
                                    });
                                } else {
                                    ecjia.merchant.showmessage(data);
                                }
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

        searchResponse: function (data) {
            if (data.state == 'success' && data.content) {
                var $selectbig1 = $('#selectbig1');
                $selectbig1.show();
                var goods = data.content;
                var tmpobj = '';
                var $select = $('form[name="theForm"] select[name="result"]');
                for (i = 0; i < goods.length; i++) {
                    if (goods[i].level) {
                        tmpobj += '<option value=' + goods[i].id + ' style=padding-left:' + goods[i].level * 20 + 'px>' + goods[i].name + '</option>';
                    } else {
                        tmpobj += '<option value=' + goods[i].id + ' >' + goods[i].name + '</option>';
                    }
                }
                $select.html(tmpobj);
                $select.trigger("liszt:updated");
            }
        },

        searchResponse1: function (data) {
            if (data.state == 'success' && data.content) {
                var $selectbig = $('#selectbig');
                $selectbig.show();
                var goods = data.content;
                var tmpobj = '';
                var $select = $('form[name="theForm"] select[name="result1"]');
                for (i = 0; i < goods.length; i++) {
                    tmpobj += '<option value=' + goods[i].id + ' data-url=' + goods[i].url + '>' + goods[i].name + '</option>';
                }
                $select.html(tmpobj);
                $select.trigger("liszt:updated");
            }
        },

        act_range: function (isInit) {
            var act_range_id = $('#act_range_id').val();
            var $actionDiv = $('#range_search');
            var isok = $('#isok').val();

            if (isok == 0) {
                $('#range-div').html('');
                if (act_range_id <= 0) {
                    $actionDiv.hide();
                    $('#selectbig1').hide();
                } else {
                    $('#selectbig1').hide();
                    $actionDiv.show();
                    var tmpobj = '';
                    var $select = $('form[name="theForm"] select[name="result"]');
                    $select.html(tmpobj);
                    $select.trigger("liszt:updated");
                }

            } else {
                //编辑
                if (act_range_id <= 0) {
                    $actionDiv.hide();
                    $('#range-div').html('');
                    $('#selectbig1').hide();
                } else {
                    if (!isInit) {
                        $('#range-div').html('');
                    }
                    $actionDiv.show();
                    $('#selectbig1').hide();
                    var tmpobj = '';
                    var $select = $('form[name="theForm"] select[name="result"]');
                    $select.html(tmpobj);
                    $select.trigger("liszt:updated");
                }
            }
        },

        act_type: function () {
            var act_type_id = $('#act_type_id').val();
            var $actionDivtwo = $('#type_search');
            $actionDivtwo.css("border-top", '1px dashed #ccc');
            if (act_type_id > 0) {
                $actionDivtwo.hide();
                $('#selectbig').hide();
                $('#gift-table').html('');
                var tmpobj = '';
                var $select = $('form[name="theForm"] select[name="result1"]');
                $select.html(tmpobj);
                $select.trigger("liszt:updated");
            } else {
                $actionDivtwo.show();
            }
        },

        act_range_plus: function () {
            $("#result").on('click', function () {
                var selRange = document.forms['theForm'].elements['act_range'];
                if (selRange.value == 0) {
                    var data = {
                        message: js_lang.all_need_not_search,
                        state: "error",
                    }
                    ecjia.merchant.showmessage(data);
                    return;
                }
                var selResult = document.getElementById('result');
                if (selResult.value == 0) {
                    var data = {
                        message: js_lang.pls_search,
                        state: "error",
                    }
                    ecjia.merchant.showmessage(data);
                    return;
                }
                var id = selResult.options[selResult.selectedIndex].value;
                var name = selResult.options[selResult.selectedIndex].text;
                var exists = false;
                var eles = document.forms['theForm'].elements;
                for (var i = 0; i < eles.length; i++) {
                    if (eles[i].type == "hidden" && eles[i].name.substr(0, 13) == 'act_range_ext') {
                        if (eles[i].value == id) {
                            exists = true;
                            var data = {
                                message: js_lang.range_exists,
                                state: "error",
                            }
                            ecjia.merchant.showmessage(data);
                            break;
                        }
                    }
                }
                if (!exists) {
                    var html = '<li>' + name + '<input name="act_range_ext[]" type="hidden" value="' + id + '"/>' +
                        '<a href="javascript:;" class="delact1"><i class="fa fa-minus-circle ecjiafc-red"></i></a></li>';
                    $("#range-div").show().append(html);
                    app.favourable_info.remove1();
                }
            });
        },

        act_type_plus: function () {
            $("#result1").on('click', function () {
                var selType = document.forms['theForm'].elements['act_type'];
                if (selType.value == 1) {
                    var data = {
                        message: js_lang.price_need_not_search,
                        state: "error",
                    }
                    ecjia.merchant.showmessage(data);
                    return;
                }
                var selResult = document.getElementById('result1');
                if (selResult.value == 0) {
                    var data = {
                        message: js_lang.pls_search,
                        state: "error",
                    }
                    ecjia.merchant.showmessage(data);
                    return;
                }
                var id = selResult.options[selResult.selectedIndex].value;
                var name = selResult.options[selResult.selectedIndex].text;
                var url = $(this).children().eq(selResult.selectedIndex).attr('data-url');
                // 检查是否已经存在
                var exists = false;
                var eles = document.forms['theForm'].elements;
                for (var i = 0; i < eles.length; i++) {
                    if (eles[i].type == "hidden" && eles[i].name.substr(0, 7) == 'gift_id') {
                        if (eles[i].value == id) {
                            exists = true;
                            var data = {
                                message: js_lang.range_exists,
                                state: "error",
                            }
                            ecjia.merchant.showmessage(data);
                            break;
                        }
                    }
                }

                if (!exists) {
                    if ($("#gift-table").find("tr").length == 0) {
                        $("#gift-div").addClass("m_b15");
                        $("#gift-table").html("<tr align='center'><td><strong>" + js_lang.gift + "</strong></td><td><strong>" + js_lang.price + "</strong></td></tr>")
                    }
                    if (name.length > 13) {
                        name = name.substr(0, 11) + "...";
                    }
                    var new_html = '<tr align="center"><td class="w180"><a href="' + url + '" target="_blank">' + name +
                        '</a></td><td><input name="gift_price[]" type="text" value="0" class="w100 form-control" />' +
                        '<input name="gift_id[]" type="hidden" value="' + id + '" />' +
                        '<input name="gift_name[]" type="hidden" value="' + name + '" />' +
                        '<a href="javascript:;" class="delact"><i class="fa fa-minus-circle ecjiafc-red m_l15"></i></a></td></tr>';
                    $("#gift-table").append(new_html);
                    app.favourable_info.remove();
                }
            });
        },

        remove: function () {
            $(".delact").on('click', function () {
                $(this).parents("tr").remove();
                var length = $("#gift-table").find("tr").length;
                if (length == 1) {
                    $('#gift-table').html('');
                    $("#gift-div").removeClass("m_b15");
                }
            });
        },

        remove1: function () {
            $(".delact1").on('click', function () {
                $(this).parents("li").remove();
            });
        }
    }

})(ecjia.merchant, jQuery);

// end