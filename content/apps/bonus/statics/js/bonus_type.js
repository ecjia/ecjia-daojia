// JavaScript Document
;(function (app, $) {
    app.bonus_type = {
        /**红包类型列表**/
    	list : function () {
            /* 加载日期控件 */
            var url1 = $(".type_name").attr("data-name");
            var url2 = $(".type_money").attr("data-name");
            var url3 = $(".min_amount").attr("data-name");
 
            //筛选功能
            $('.screen-btn').on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action');
                if ($('select[name="send_type"]').val() !== '') {
                    url += '&send_type=' + $('select[name="send_type"]').val();
                }
                ecjia.pjax(url);
            });
            
            $("form[name='searchForm']").on('submit', function(e) {
				e.preventDefault();
				var url = $(this).attr('action');
				var merchant_keywords = $('input[name="merchant_keywords"]').val();
				var type_keywords = $('input[name="type_keywords"]').val();
				
                if (merchant_keywords != '') {
                	url += '&merchant_keywords=' + merchant_keywords;
                }
                
                if (type_keywords != '') {
                	url += '&type_keywords=' + type_keywords;
                }
				ecjia.pjax(url);
			});
 
            $('.type_name').editable({
                name: 'type_name',
                type: 'text',
                dataType: 'json',
                pk: function () {
                    return $(this).prev().attr('value');
                },
                url: url1,
                title: js_lang.edit_bonus_type_name,
                success: function (data) {
                    var pjaxurl = $(this).attr("data-pjax-url");
                    if (data.state == "success") {
                        ecjia.pjax(pjaxurl, function () {
                            ecjia.admin.showmessage(data);
                        });
                    } else {
                        var old_name = $(this).attr('data-name-value');
                        ecjia.pjax(pjaxurl, function () {
                            $(this).attr("value", old_name);
                            ecjia.admin.showmessage(data);
                        });
                    }
                }
            });
 
            $('.type_money').editable({
                name: 'type_money',
                type: 'text',
                dataType: 'json',
                pk: function () {
                    return $(this).prev().attr('value');
                },
                url: url2,
                title: js_lang.edit_bonus_money,
                success: function (data) {
                    var pjaxurl = $(this).attr("data-pjax-url");
                    if (data.state == "success") {
                        ecjia.pjax(pjaxurl, function () {
                            ecjia.admin.showmessage(data);
                        });
                    } else {
                        var old_name = $(this).attr('data-name-value');
                        ecjia.pjax(pjaxurl, function () {
                            $(this).attr("value", old_name);
                            ecjia.admin.showmessage(data);
                        });
                    }
                }
            });
 
            $('.min_amount').editable({
                name: 'min_amount',
                type: 'text',
                dataType: 'json',
                pk: function () {
                    return $(this).prev().attr('value');
                },
                url: url3,
                title: js_lang.edit_order_limit,
                success: function (data) {
                    var pjaxurl = $(this).attr("data-pjax-url");
                    if (data.state == "success") {
                        ecjia.pjax(pjaxurl, function () {
                            ecjia.admin.showmessage(data);
                        });
                    } else {
                        var old_name = $(this).attr('data-name-value');
                        ecjia.pjax(pjaxurl, function () {
                            $(this).attr("value", old_name);
                            ecjia.admin.showmessage(data);
                        });
                    }
                }
            });
        },
 
        /* 红包列表js初始化 */
        init: function () {
            /* 判断按纽是否可点 */
            var inputbool = false;
            $(".smpl_tbl input[type='checkbox']").click(function () {
                if ($(this).attr("data-toggle") == "selectall") {
                    inputbool = $(this).attr("checked") == "checked" ? false : true;
                } else {
                    //获取复选框选中的值
                    inputbool = $("input[name='checkboxes[]']:checked").length > 0 ? false : true;
                }
                $(".btnSubmit").attr("disabled", inputbool);
            });
 
            /*发送红包 */
            $(".insert_mail_list").click(function () {
                $.ajax({
                    type: "POST",
                    url: $(this).attr('data-href'),
                    data: '',
                    dataType: "json",
                    success: function (data) {
                        if (data.state == "success") {
                            if (data.refresh_url != undefined) {
                                var pjaxurl = data.refresh_url;
                                ecjia.pjax(pjaxurl, function () {
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
        /* 自定义submit事件 */
        submit: function () {
            $("form[name='theForm']").ajaxSubmit({
                dataType: "json",
                success: function (data) {
                    ecjia.admin.showmessage(data);
                }
            });
        },
 
    };
 
    /* **红包类型编辑** */
    app.bonus_info_edit = {
        type_info_init: function (get_value) {
            /* 加载日期控件 */
            $(".date").datepicker({
                format: "yyyy-mm-dd",
                container : '.main_content',
            });
 
            $("#use_start_date").on('change', function () {
                var dateText = $(this).val();
                var endDateTextBox = $('#use_end_date').val();
                if (endDateTextBox != '') {
                    var testStartDate = new Date(dateText);
                    var testEndDate = new Date(endDateTextBox);
 
                    if (testStartDate > testEndDate) {
                        $('#use_end_date').val(dateText);
                    }
                } else {
                    endDateTextBox.val(dateText);
                };
            });
 
            $("#use_end_date").on('change', function () {
                var dateText = $(this).val();
                var endDateTextBox = $('#use_start_date').val();
                if (endDateTextBox != '') {
                    var testStartDate = new Date(dateText);
                    var testEndDate = new Date(endDateTextBox);
                    if (testEndDate > testStartDate) {
                        $('#use_start_date').val(dateText);
                    }
                } else {
                    endDateTextBox.val(dateText);
                };
            });
 
            $("#send_start_date").on('change', function () {
                var dateText = $(this).val();
                var endDateTextBox = $('#send_end_date').val();
                if (endDateTextBox != '') {
                    var testStartDate = new Date(dateText);
                    var testEndDate = new Date(endDateTextBox);
 
                    if (testStartDate > testEndDate) {
                        $('#send_end_date').val(dateText);
                    }
                } else {
                    endDateTextBox.val(dateText);
                };
            });
 
            $("#send_end_date").on('change', function () {
                var dateText = $(this).val();
                var endDateTextBox = $('#send_start_date').val();
                if (endDateTextBox != '') {
                    var testStartDate = new Date(dateText);
                    var testEndDate = new Date(endDateTextBox);
                    if (testEndDate > testStartDate) {
                        $('#send_start_date').val(dateText);
                    }
                } else {
                    endDateTextBox.val(dateText);
                };
            });
 
            var $form = $('form[name="typeInfoForm"]');
            /* 给表单加入submit事件 */
            var option = {
                rules: {
                    type_name: {
                        required: true,
                        minlength: 1
                    },
                    type_money: {
                        required: true
                    },
                    min_goods_amount: {
                        required: true
                    }
                },
                messages: {
                    type_name: {
                        required: js_lang.type_name_required,
                        minlength: js_lang.type_name_minlength
                    },
                    type_money: {
                        required: js_lang.type_money_required
                    },
                    min_goods_amount: {
                        required: js_lang.min_goods_amount_required
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
                }
            }
            var options = $.extend(ecjia.admin.defaultOptions.validate, option);
            $form.validate(options);
        },
        /* 添加编辑页面radio事件 */
        type_info_showunit: function (get_value) {
            /* 红包类型按订单金额发放时才填写 */
            var theObj = null;
            var theObjstart = null;
            var theObjend = null;
            if (document.getElementById) {
                theObj = document.getElementById("min_amount_div");
                theObj.style.display = (get_value == 2) ? "" : "none";
 
                theObjstart = document.getElementById("start");
                theObjstart.style.display = (get_value != 0 && get_value != 3) ? "" : "none";
 
                theObjend = document.getElementById("end");
                theObjend.style.display = (get_value != 0 && get_value != 3) ? "" : "none";
 
            }
            //          document.forms['typeInfoForm'].elements['send_start_date'].disabled  = (get_value != 1 && get_value != 2);
            //          document.forms['typeInfoForm'].elements['send_end_date'].disabled  = (get_value != 1 && get_value != 2);
            return;
        },
    };
 
})(ecjia.admin, jQuery);
 
// end