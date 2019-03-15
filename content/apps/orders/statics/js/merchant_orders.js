// JavaScript Document
;(function (app, $) {
    var html;
    app.order = {
        init: function () {
            html = $(".modal-header").children("h3").html();
            app.order.screen();
            app.order.searchform();
            app.order.batch_print();
            app.order.batch_operate();
//			app.order.operate();
            app.order.batchForm();
            app.order.tooltip();
            app.order.current_order();
            app.order.showSearch();
        },
        tooltip: function () {
            $('span').tooltip({
                trigger: 'hover',
                delay: 0,
                placement: 'right'
            })
        },
        screen: function () {
            //筛选功能
            $(".screen-btn").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action') + '&composite_status=' + $("#select-rank option:selected").val();
                ecjia.pjax(url);
            });
        },
        searchform: function () {
            //搜索功能
            $("form[name='searchForm']").on('submit', function (e) {
                e.preventDefault();
                var url = $(this).attr('action');
                var keywords = $("input[name='keywords']").val();
                if (keywords != '') {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
            $("form[name='advancedSearchForm']").on('submit', function (e) {
                e.preventDefault();
                var $this = $(this);
                url = $this.attr('action'),
                    order_sn = $("input[name='order_sn']").val(),
                    start_time = $("input[name='start_time']").val(),
                    end_time = $("input[name='end_time']").val(),
                    composite_status = $("select[name='composite_status']").val(),
                    shipping_id = $("select[name='shipping_id']").val(),
                    pay_id = $("select[name='pay_id']").val(),
                    referer = $("select[name='referer']").val(),
                    goods_keywords = $("input[name='goods_keywords']").val(),
                    consignee = $("input[name='consignee']").val(),
                    mobile = $("input[name='mobile']").val();
                if (order_sn != '') {
                    url += '&order_sn=' + order_sn;
                }
                if (start_time != '') {
                    url += '&start_time=' + start_time;
                }
                if (end_time != '') {
                    url += '&end_time=' + end_time;
                }
                if (composite_status != '') {
                    url += '&composite_status=' + composite_status;
                }
                if (shipping_id != '') {
                    url += '&shipping_id=' + shipping_id;
                }
                if (pay_id != '') {
                    url += '&pay_id=' + pay_id;
                }
                if (referer != '') {
                    url += '&referer=' + referer;
                }
                if (pay_id != '') {
                    url += '&pay_id=' + pay_id;
                }
                if (goods_keywords != '') {
                    url += '&goods_keywords=' + goods_keywords;
                }
                if (consignee != '') {
                    url += '&consignee=' + consignee;
                }
                if (mobile != '') {
                    url += '&mobile=' + mobile;
                }
                if (start_time != '' && end_time != '') {
                    if (start_time >= end_time) {
                        ecjia.merchant.showmessage({
                            'state': 'error',
                            'message': js_lang.time_error
                        });
                        return false;
                    }
                }
                url += '&show_search=1';
                ecjia.pjax(url);
            });
            //重置
            $('.btn-reset').off('click').on('click', function () {
                $('.search-form').find("input[type='text']").val("");
                $('.search-form').find('select').each(function () {
                    $(this).find('option').eq('').prop("selected", true);
                })
                $('.search-form').find('select').trigger("liszt:updated");
            });
        },
        batch_print: function () {
            //批量打印
            $(".batch-print").on("click", function () {
                var order_id = [];
                $(".checkbox:checked").each(function () {
                    order_id.push($(this).val());
                });
                var url = $(this).attr("data-url") + "&order_id=" + order_id;
                window.open(url);
            });
        },
        batch_operate: function () {
            //批量操作备注
            $(".batch-operate").on('click', function (e) {
                var order_id = [];
                $(".checkbox:checked").each(function () {
                    order_id.push($(this).val());
                });
                if (order_id == '') {
                    smoke.alert(js_lang.operate_order_required);
                    return false;
                } else {
                    $("input[name='order_id']").val(order_id);
                    var operatetype = $(this).attr("data-operatetype")
                    var url = $(".operate_note").attr("data-url") + '&' + operatetype + "=1&order_id=" + order_id;
                    var action_note = $("#cancel_note").val();
                    $.ajax({
                        type: "POST",
                        url: url,
                        dataType: "json",
                        success: function (data) {
                            if (!data.result || (data.require_note && action_note == "")) {
                                $(".lbi_action_note").val(action_note);
                                app.order.operate_note(operatetype, data);
                                $("input[name='batch']").val('1');
                                $("input[name='order_id']").val(order_id);
                                $('#operate').modal('show')
                            } else {
                                app.order.operate(operatetype);
                            }
                        }
                    });
                }
            });
        },
        operate: function (operatetype) {
            //操作
            var order_id = [];
            if ($(".order_id").val() == undefined) {
                $(".checkbox:checked").each(function () {
                    order_id.push($(this).val());
                });
                $("input[name='batch']").val('1');
                $("input[name='order_id']").val(order_id);
            } else {
                order_id = $(".order_id").val()
            }
            var action_note = $(".action_note").val();
            var url = $("form[name='orderpostForm']").attr("action");
            url += "&" + operatetype + "=1";
            if (operatetype == 'remove') {
                smoke.confirm(js_lang.remove_confirm, function (e) {
                    if (e) {
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {order_id: order_id, operation: operatetype, action_note: action_note},
                            dataType: "json",
                            success: function (data) {
                                ecjia.pjax(data.url, function () {
                                    ecjia.merchant.showmessage(data);
                                });
                            }
                        });
                    }
                }, {ok: js_lang.ok, cancel: js_lang.cancel});
            } else {
                if ($("input[name='order_sn']").val() != undefined) {
                    url += "&order_sn=" + $("input[name='order_sn']").val();
                }
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {action_note: action_note, operation: operatetype, order_id: order_id},
                    dataType: "json",
                    success: function (data) {
                        if (data.state == "success") {
                            if (data.url) {
                                var pjaxurl = data.url;
                            } else {
                                var pjaxurl = $("#theForm").attr("data-pjax-url");
                            }
                            ecjia.pjax(pjaxurl, function () {
                                if (data.message) {
                                    ecjia.merchant.showmessage(data);
                                }
                            });
                        } else {
                            ecjia.merchant.showmessage(data);
                        }
                    }
                });
            }
        },
        operate_note: function (operatetype, data) {
            //用户填写备注的js控制
            $("#operate .modal-body").find("fieldset").children().not("div:eq(0)").not("div:last").addClass("ecjiaf-dn");
            $('.batchtype').val(operatetype);
            var arr = new Array();
            arr['confirm'] = js_lang.confirm;
            arr['pay'] = js_lang.pay;
            arr['unpay'] = js_lang.unpay;
            arr['prepare'] = js_lang.prepare;
            arr['unship'] = js_lang.unship;
            arr['receive'] = js_lang.receive;
            arr['cancel'] = js_lang.cancel;
            arr['invalid'] = js_lang.invalid;
            arr['after_service'] = js_lang.after_service;
            arr['confirm_return'] = js_lang.confirm_return;
            arr['return'] = js_lang.return;
            arr['refund'] = js_lang.refund;

            var html = js_lang.label_order_operate;
            $("#operate .modal-header").children("h4").html(html + arr[operatetype]);
            if (data != '') {
                if (data.show_cancel_note) {
                    $(".show_cancel_note").removeClass("ecjiaf-dn")
                }
                if (data.show_invoice_no) {
                    $(".show_invoice_no").removeClass("ecjiaf-dn")
                }
                if (data.show_refund) {
                    $(".show_refund").removeClass("ecjiaf-dn")
                }
                if (data.anonymous) {
                    $(".anonymous").removeClass("ecjiaf-dn")
                }
            }
            if (operatetype == 'refund') {
                $(".show_refund").removeClass("ecjiaf-dn")
                $(".anonymous").removeClass("ecjiaf-dn")
            }
        },

        set_modal_default: function () {
            $('.show_cancel_note').addClass('ecjiaf-dn');
            $(".show_invoice_no").addClass("ecjiaf-dn");
            $(".show_refund").addClass("ecjiaf-dn");
            $(".anonymous").addClass("ecjiaf-dn");
            $(".show_refund").addClass("ecjiaf-dn");
            $(".anonymous").addClass("ecjiaf-dn");
        },

        batchForm: function () {
            var $this = $("form[name='batchForm']");
            var batchtype = $('.batchtype').val();
            var order_id = [];
            if ($(".order_id").val() == undefined || $(".order_id").val() == "") {
                $(".checkbox:checked").each(function () {
                    order_id.push($(this).val());
                });
                $("input[name='batch']").val('1');
                $("input[name='order_id']").val(order_id);
            } else {
                order_id = $(".order_id").val()
            }

            var option = {
                rules: {
                    refund_note: {
                        required: true
                    },
                },
                messages: {
                    refund_note: {
                        required: js_lang.refund_note_required
                    },
                },
                submitHandler: function () {
                    app.order.submitbatch();
                }
            }

            var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
            $this.validate(options);
            if (batchtype == 'cancel') {
                $("#cancel_note").rules("add", {required: true, messages: {required: js_lang.pls_input_cancel}});
            }
            if (batchtype == 'cancel') {
                $("#cancel_note").rules("remove");
            }
        },
        submitbatch: function () {
            //表单提交
            $('#operate').modal('hide')
            var url = $("form[name='orderpostForm']").attr('action');
            var action_note = $(".lbi_action_note").val();
            var order_id = $("input[name='order_id']").val();
            if (order_id == "") {
                order_id = $(".order_id").val();
            }
            var batchtype = $("input[name='operation']").val();
            var msg = $(".batch-operate-" + batchtype).attr("data-" + batchtype + "-msg");
            if (msg != undefined) {
                var cannel_note = $("textarea[name='cancel_note']").val();
                smoke.confirm(msg, function (e) {
                    if (e) {
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {
                                order_id: order_id,
                                operation: batchtype,
                                action_note: action_note,
                                cancel_note: cannel_note
                            },
                            dataType: "json",
                            success: function (data) {
                                ecjia.merchant.showmessage(data);
                            }
                        });
                    }
                }, {ok: js_lang.ok, cancel: js_lang.cancel});
            } else {
                var refund = $("input[name='refund']").val();
                var refund_note = $("textarea[name='refund_note']").val();
                var cannel_note = $("textarea[name='cancel_note']").val();
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        order_id: order_id,
                        operation: batchtype,
                        action_note: action_note,
                        cancel_note: cannel_note,
                        refund: refund,
                        refund_note: refund_note
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.state == "success") {
                            if (data.url) {
                                var pjaxurl = data.url;
                            } else {
                                var pjaxurl = $("#theForm").attr("data-pjax-url");
                            }
                            ecjia.pjax(pjaxurl, function () {
                                if (data.message) {
                                    ecjia.merchant.showmessage(data);
                                }
                            });
                        } else {
                            ecjia.merchant.showmessage(data);
                        }
                    }
                });
            }
        },
        info: function () {
            html = $(".modal-header").children("h3").html();
            app.order.mer_action_return();
            app.order.refund_click();
            app.order.refundsubmit();
            app.order.queryinfo();
            app.order.operatesubmit();
            app.order.batchForm();
            app.order.toggle_view();
            app.order.unconfirmForm();
            app.order.ship_form();
            app.order.change_shipping();
            app.order.showCode();
            app.order.confirm_validate();
        },

        //商家进行退款
        mer_action_return: function () {
            $("#refund_type_select_return").hide();
            $("#refund_type_select").change(function () {
                $(this).children().each(function (i) {
                    $("#refund_type_select_" + $(this).val()).hide();
                })
                $("#refund_type_select_" + $(this).val()).show();
            });

            $("#note_btn").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='actionForm']").attr('action');
                var action_note = $("input[name='action_note']").val();//订单操作备注
                var order_id = $("input[name='order_id']").val();//订单id
                var refund_type = $("select[name='refund_type_select']").val();//退款方式
                var refund_reason = $("select[name='refund_reason_select']").val();//退款原因
                var refund_content = $("textarea[name='refund_content']").val();//退款说明
                var merchant_action_note = $("textarea[name='merchant_action_note']").val();//管理员操作备注

                if (refund_type == '') {
                    var $info = $('<div class="staticalert alert alert-danger ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + js_lang.pls_select_way + '</div>');
                    $info.appendTo('.error-msg').delay(3000).hide(0);
                    return false;
                }
                if (refund_reason == '') {
                    var $info = $('<div class="staticalert alert alert-danger ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + js_lang.pls_select_reason + '</div>');
                    $info.appendTo('.error-msg').delay(3000).hide(0);
                    return false;
                }

                //退货退款
                if (refund_type == 'return') {
                    //选择返还方式
                    var arr = new Array();
                    $("input[name=return_shipping_range]:checked").each(function (key, value) {
                        arr[key] = $(value).val();
                    });
                    var option = {
                        'refund_type': refund_type,
                        'refund_reason': refund_reason,
                        'action_note': action_note,
                        'order_id': order_id,
                        'return_shipping_range': arr,
                        'refund_content': refund_content,
                        'merchant_action_note': merchant_action_note,
                    };
                } else {
                    var option = {
                        'refund_type': refund_type,
                        'refund_reason': refund_reason,
                        'action_note': action_note,
                        'order_id': order_id,
                        'refund_content': refund_content,
                        'merchant_action_note': merchant_action_note,
                    };
                }
                $.post(url, option, function (data) {
                    if (data.state == 'success') {
                        $('#actionmodal').modal('hide');
                        $(".modal-backdrop").remove();
                        ecjia.merchant.showmessage(data);
                    } else {
                        var $info = $('<div class="staticalert alert alert-danger ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
                        $info.appendTo('.error-msg').delay(5000).hide(0);
                    }
                }, 'json');
            });
        },

        //退款按钮
        refund_click: function () {
            $(".refund_click").on('click', function (e) {
                var url = $(this).attr("data-href");
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: "json",
                    success: function (data) {
                        $("#refund_amount").html(data.formated_refund_amount);
                        $("input[name='refund_amount']").val(data.refund_amount);
                        if (data.anonymous == '0') {
                            $("#anonymous").removeClass('ecjiaf-dn');
                        }
                        $("#refund").modal('show');
                    }
                });
            });
        },

        refundsubmit: function () {
            var $form = $('form[name="refundForm"]');
            /* 给表单加入submit事件 */
            var option = {
                rules: {
                    refund_note: {
                        required: true
                    },
                },
                messages: {
                    refund_note: {
                        required: js_lang.refund_note_required
                    }
                },
                submitHandler: function () {
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            $('#refund').modal('hide');
                            $(".modal-backdrop").remove();
                            ecjia.merchant.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
            $form.validate(options);
        },
        queryinfo: function () {
            $('.queryinfo').on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('data-url');
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {keywords: $("input[name='keywords']").val()},
                    dataType: "json",
                    success: function (data) {
                        if (data.state == "success") {
                            ecjia.pjax(data.url);
                        } else {
                            ecjia.merchant.showmessage(data);
                        }
                    }
                });
            });
        },

        operatesubmit: function () {
            $(".operatesubmit").on('click', function (e) {
                app.order.set_modal_default();//修改modal为默认

                e.preventDefault();
                var order_id = $(".order_id").val();
                var operatetype = $(this).attr('name');
                var url = $(".operate_note").attr("data-url") + '&' + operatetype + "=1&order_id=" + order_id;
                var action_note = $(".action_note").val();
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: "json",
                    success: function (data) {
                        if (data.result || (data.require_note && action_note == "")) {

                            $(".lbi_action_note").val(action_note);
                            app.order.operate_note(operatetype, data);
                            $('#operate').modal('show');
                        } else {
                            app.order.operate(operatetype);
                        }
                    }
                });
            });
        },

        unconfirmForm: function () {
            var $this = $("form[name='unconfirm_form']");
            var option = {
                rules: {
                    unconfirm_reason: {required: true},
                },
                messages: {
                    unconfirm_reason: {required: js_lang.unconfirm_reason_required, min: 1},
                },
                submitHandler: function () {
                    $this.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            $('#unconfirmmodal').modal('hide');
                            $(".modal-backdrop").remove();
                            ecjia.merchant.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
            $this.validate(options);
        },

        ship_form: function () {
            $('#shipmodal-btn').off('click').on('click', function () {
                var action_note = $('.action_note').val();
                if (action_note != '' && action_note != undefined) {
                    $("form[name='ship_form']").find('input[name="action_note"]').val(action_note);
                } else {
                    $("form[name='ship_form']").find('input[name="action_note"]').val('');
                }
            });
            var $this = $("form[name='ship_form']");
            var option = {
                rules: {
                    shipping_id: {required: true},
                    invoice_no: {required: true},
                },
                messages: {
                    shipping_id: {required: js_lang.shipping_required, min: 1},
                    invoice_no: {required: js_lang.invoice_no_required},
                },
                submitHandler: function () {

                    $this.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            $('#shipmodal').modal('hide');
                            $(".modal-backdrop").remove();
                            ecjia.merchant.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
            $this.validate(options);
        },

        change_shipping: function () {
            $('select[name="shipping_id"]').on('change', function () {
                var $this = $(this),
                    code = $this.find('option:selected').attr('data-code');
                if (code == 'ship_ecjia_express' || code == 'ship_o2o_express' || code == undefined) {
                    $('#shipmodal').find('.invoice-no-group').addClass('hide');
                } else {
                    $('#shipmodal').find('.invoice-no-group').removeClass('hide');
                }
            });
        },

        showCode: function () {
            $('.show_meta_value').off('click').on('click', function () {
                var $this = $(this).parent(),
                    normal_value = $this.attr('data-val'),
                    enc_value = $this.attr('data-enc'),
                    $i = $this.children('i'),
                    $span = $this.children('span');

                if ($i.hasClass('fa-eye')) {
                    $span.text(normal_value);
                    $i.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    $span.text(enc_value);
                    $i.addClass('fa-eye').removeClass('fa-eye-slash');
                }
            });
        },

        confirm_validate: function () {
            $('.confirm_validate').off('click').on('click', function () {
                var $this = $(this),
                    url = $this.attr('data-url'),
                    refresh_url = $this.attr('data-refresh'),
                    order_id = $('input[name="order_id"]').val();

                $.post(url, {order_id: order_id}, function (data) {
                    ecjia.pjax(refresh_url, function () {
                        ecjia.merchant.showmessage(data);
                    })
                });
            });
        },

        //以下为添加与编辑订单
        addedit: function () {
            $(":radio").click(function () {
                if ($(this).val() == 0) {
                    $('.nav-list-ready li').removeClass('selected');
                    $("input[name='user']").val(0);
                }
            });
            $(".goods_number").spinner({min: 1});

            app.order.searchGoods();
//			$("#goodslist").on('change', app.order.change);
//			$("#userslist").on('change', app.order.userschange);
            app.order.goodsForm();
//			app.order.edit_goodsnumber();
            app.order.updateGoods();
            app.order.submitgoods();
//			app.order.consigneeForm();

            app.order.toggle_address();
            app.order.consigneelistForm();
            app.order.shippingForm();
            app.order.select_shipping();
//			app.order.paymentForm();
            app.order.otherForm();
            app.order.moneyForm();
            app.order.invoiceForm();
            app.order.cancel_order();
        },

        search_opt: function () {
            //li搜索筛选功能
            $('#ms-search').quicksearch(
                $('.ms-elem-selectable', '#ms-custom-navigation'),
                {
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
                }
            );
        },

        searchGoods: function () {
            $(".searchGoods").on('click', function (e) {
                var keyword = $("input[name='keyword']").val();
                var url = $("form[name='goodsForm']").attr('data-search-url');
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {keyword: keyword},
                    dataType: "json",
                    success: function (data) {
                        $(".goods_info").addClass('ecjiaf-dn');
                        $('.nav-list-ready').html('');
                        if (data.goods.length > 0) {
                            for (var i = 0; i < data.goods.length; i++) {
                                var disable = $('.nav-list-content .ms-elem-selection').find('input[value="' + data.goods[i].value + '"]').length ? 'disabled' : '';
                                var opt = '<li class="ms-elem-selectable ' + disable + '" id="articleId_' + data.goods[i].value + '" data-id="' + data.goods[i].value + '"><span>' + data.goods[i].text + '</span></li>'
                                $('.nav-list-ready').append(opt);
                            }
                            ;
                        } else {
                            $('.nav-list-ready').html('<li class="ms-elem-selectable disabled"><span>' + js_lang.select_goods_empty + '</span></li>');
                        }
                        app.order.search_opt();
                        app.order.click_search_goods();
                    }
                });
            });
        },
        click_search_goods: function () {
            $('.order-select-goods li').on('click', function () {
                if ($(this).attr('data-id') > 0) {
                    $('.nav-list-ready li').removeClass('selected');
                    $("input[name='goodslist']").val($(this).attr('data-id'));
                    $(this).addClass('selected');
                    app.order.change($(this).attr('data-id'));
                }
            });
        },
        change: function (goods_id) {
            var url = $("#goodslist").attr("data-change-url");
            var goods_id = goods_id;
            $.ajax({
                type: "post",
                url: url,
                data: {goods_id: goods_id},
                dataType: "json",
                success: function (data) {
                    var goods = data.goods
                    /*给商品赋值*/
                    $("#goods_name").html("<a href=" + goods.preview_url + " target='_blank' title='" + goods.goods_name + "'>" + goods.short_goods_name + "</a>");
                    $("#goods_sn").text(goods.goods_sn);
                    $("#goods_cat").text(goods.cat_name);
                    $("#goods_number").html(goods.goods_number);
                    goods.brand_name = goods.brand_name == null ? js_lang.no_brand_name : goods.brand_name.trim() == '' ? js_lang.no_brand_name : goods.brand_name;
                    var img = '<img src="' + goods.goods_img + '" class="w130"/>'
                    $("#goods_img").html(img);
                    // 显示价格：包括市场价、本店价（促销价）、会员价
                    var priceHtml = '<div>' +
                        '<input type="radio" id="market_price" name="add_price" value="' + goods.market_price + '" />' +
                        '<label for="market_price"><span>' + js_lang.market_price + ' [' + goods.market_price + ']</span></label>' +
                        '</div>' +
                        '<div>' +
                        '<input type="radio" id="shop_price" name="add_price" value="' + goods.shop_price + '" checked/>' +
                        '<label for="shop_price"><span>' + js_lang.market_price + ' [' + goods.shop_price + ']</span></label>' +
                        '</div>';
                    if (goods.user_price != null) {
                        for (var i = 0; i < goods.user_price.length; i++) {
                            priceHtml += '<div>' +
                                '<input type="radio" id="radio_' + i + '" name="add_price" value="' + goods.user_price[i].user_price + '" />' +
                                '<label for="radio_' + i + '">' + goods.user_price[i].rank_name + ' [' + goods.user_price[i].user_price + ']</label>' +
                                '</div>';
                        }
                    }
                    priceHtml += '<div class="form-inline">' +
                        '<input type="radio" id="user_input" name="add_price" value="user_input" />' +
                        '<label for="user_input"><span>' + js_lang.custom_price + '</span></label>&nbsp;&nbsp;' +
                        '<input class="form-control" type="text" name="input_price" value="" />' +
                        '</div>';

                    $("#add_price").html(priceHtml);
                    /*显示商品属性*/
                    // 显示属性
                    var specCnt = 0; // 规格的数量
                    var attrHtml = ''; //不用选择的规格
                    var selattrHtml = '';//需要选择的规格
                    var attrType = '';
                    var attrTypeArray = '';
                    var attrCnt = goods.attr_list.length;
                    for (i = 0; i < attrCnt; i++) {
                        var valueCnt = goods.attr_list[i].length;
                        // 规格
                        if (valueCnt > 1) {
                            selattrHtml += "<div class='form-group'><label class='control-label col-lg-2'>" + goods.attr_list[i][0].attr_name + '：</label><div class="col-lg-8" id="add_price">';
                            for (var j = 0; j < valueCnt; j++) {
                                switch (goods.attr_list[i][j].attr_type) {
                                    case 0 :
                                    case 1 :
                                        attrType = 'radio';
                                        attrTypeArray = '';
                                        break;
                                    case 2 :
                                        attrType = 'checkbox';
                                        attrTypeArray = '[]';
                                        break;
                                }
                                selattrHtml += '<div><input id="' + attrType + '_' + goods.attr_list[i][j].goods_attr_id + '" type="' + attrType + '" name="spec_' + specCnt + attrTypeArray + '" value="' + goods.attr_list[i][j].goods_attr_id + '"';
                                if (j == 0) {
                                    selattrHtml += ' checked';
                                }
                                selattrHtml += ' /><label for="' + attrType + '_' + goods.attr_list[i][j].goods_attr_id + '">' + goods.attr_list[i][j].attr_value;
                                if (goods.attr_list[i][j].attr_price > 0) {
                                    selattrHtml += ' [+' + goods.attr_list[i][j].attr_price + ']';
                                } else if (goods.attr_list[i][j].attr_price < 0) {
                                    selattrHtml += ' [-' + Math.abs(goods.attr_list[i][j].attr_price) + ']';
                                }
                                selattrHtml += '</label></div>';
                            }
                            selattrHtml += '</div></div>';
                            specCnt++;
                        } else {
                            // 属性
                            attrHtml += goods.attr_list[i][0].attr_name + '：' + goods.attr_list[i][0].attr_value + '<br/>';
                        }
                    }
                    $("input[name='spec_count']").val(specCnt);
                    $("#goods_attr").html(attrHtml.trim() == "" ? js_lang.no_other_attr : attrHtml);
                    $("#sel_goodsattr").html(selattrHtml);
                    $(".goods_info").removeClass('ecjiaf-dn');
                }
            });
        },
        goodsForm: function () {
            $(".add-goods").on('click', function (e) {
                /*验证添加订单商品*/
                var $this = $("form[name='goodsForm']");
                var option = {
                    submitHandler: function () {
                        app.order.submitGoodsForm($this);
                    }
                }
                var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
                $this.validate(options);
                $this.submit();
            })
        },
        submitGoodsForm: function (obj) {
            obj.ajaxSubmit({
                dataType: "json",
                success: function (data) {
                    if (data.state == "success") {
                        ecjia.pjax(data.url, function () {
                            ecjia.merchant.showmessage(data);
                        });
                    } else {
                        ecjia.merchant.showmessage(data);
                    }
                }
            });
        },
        updateGoods: function () {
            /*验证更新订单商品*/
            var $this = $("form[name='theForm']");
            var option = {
                submitHandler: function () {
                    app.order.submitTheForm($this);
                }
            }
            var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
            $this.validate(options);
        },
        submitTheForm: function (obj) {
            var url = $("form[name='goodsForm']").attr('data-goods-url');
            obj.ajaxSubmit({
                dataType: "json",
                success: function (data) {
                    if (data.state == "success") {
                        if (data.url) {
                            ecjia.pjax(data.url, function () {
                                ecjia.merchant.showmessage(data);
                            });
                        } else {
                            ecjia.pjax(url, function () {
                                ecjia.merchant.showmessage(data);
                            });
                        }
                    } else {
                        ecjia.merchant.showmessage(data);
                    }
                }
            });
        },
        submitgoods: function () {
            $("form[name='submitgoodsForm']").on('submit', function (e) {
                e.preventDefault();
                if (app.order.checkGoods()) {
                    /*添加订单商品页下一步pjax效果*/
                    $(this).ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            if (data.state == "success") {
                                var url = data.url;
                                ecjia.pjax(url);
                            } else {
                                ecjia.merchant.showmessage(data);
                            }
                        }
                    });
                }
            });
        },
        checkGoods: function () {
            var eles = document.forms['theForm'].elements;
            if (eles.length > 0) {
                if (eles['goods_count'].value <= 0) {
                    var data = {
                        message: js_lang.not_add_goods,
                        state: "error",
                    };
                    ecjia.merchant.showmessage(data);
                    return false;
                }
                return true;
            } else {
                var data = {
                    message: js_lang.not_add_goods,
                    state: "error",
                };
                ecjia.merchant.showmessage(data);
                return false;
            }
        },
        toggle_address: function () {
            $("input[name='user_address']").on('change', function () {
                if ($(this).val() == '-1') {
                    $("#add_address").show("normal");
                } else {
                    $("#add_address").hide("normal");
                }
            })
        },
        consigneelistForm: function () {
            var $this = $("form[name='consigneeForm']");

            var option = {
                rules: {
                    consignee: {required: true},
                    email: {required: true},
                    tel: {required: true},
                    address: {required: true},
                    city: {required: true},
                },
                messages: {
                    consignee: {required: js_lang.consignee_required},
                    email: {required: js_lang.email_required},
                    tel: {required: js_lang.tel_required},
                    address: {required: js_lang.address_required},
                    city: {required: js_lang.city_required},
                },
                submitHandler: function () {
                    app.order.submitConsigneeForm($this);
                }
            }
            var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
            $this.validate(options);
        },
        submitConsigneeForm: function (obj) {
            obj.ajaxSubmit({
                dataType: "json",
                success: function (data) {
                    if (data.state == "success") {
                        var url = data.url;
                        ecjia.pjax(url);
                    } else {
                        ecjia.merchant.showmessage(data);
                    }
                }
            });
        },
        shippingForm: function () {
            $("form[name='shippingForm']").on('submit', function (e) {
                e.preventDefault();
                if (app.order.checkShipping() && app.order.checkPayment()) {
                    $(this).ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            if (data.state == "success") {
                                var url = data.url;
                                ecjia.pjax(url);
                            } else {
                                ecjia.merchant.showmessage(data);
                            }
                        }
                    });
                }
            });
        },
        checkShipping: function () {
            if ($("#exist_real_goods").attr('data-real') == "true") {
                if (!$("input[name='shipping']:radio").is(':checked')) {
                    var data = {
                        message: js_lang.shipping_required,
                        state: "error",
                    };
                    ecjia.merchant.showmessage(data);
                    return false;
                }
            }
            return true;
        },
        select_shipping: function () {
            $("input[name='shipping']").on('change', function () {
                var is_cod = $(this).attr("data-cod");
                $("input[name='payment']").each(function (i) {
                    if ($(this).attr('data-cod') == is_cod || $(this).attr('data-cod') == 0) {
                        $(this).attr('disabled', false);
                    } else {
                        if ($(this).is(':checked')) {
                            $(this).attr('checked', false);
                        }
                        $(this).attr('disabled', true);
                    }
                });

            });
            if ($("input[name='shipping']").is(':checked')) {
                var is_cod = $(this).attr("data-cod");
                $("input[name='payment']").each(function (i) {
                    if ($(this).attr('data-cod') == is_cod || $(this).attr('data-cod') == 0) {
                        $(this).attr('disabled', false);
                    } else {
                        if ($(this).is(':checked')) {
                            $(this).attr('checked', false);
                        }
                        $(this).attr('disabled', true);
                    }
                });
            }
        },
        checkPayment: function () {
            if (!$("input[name='payment']:radio").is(':checked')) {
                var data = {
                    message: js_lang.payment_required,
                    state: "error",
                };
                ecjia.merchant.showmessage(data);
                return false;
            }
            return true;
        },
        /*其他信息*/
        otherForm: function () {
            $("form[name='otherForm']").on('submit', function (e) {
                e.preventDefault();
                $(this).ajaxSubmit({
                    dataType: "json",
                    success: function (data) {
                        if (data.state == "success") {
                            var url = data.url;
                            ecjia.pjax(url);
                        } else {
                            ecjia.merchant.showmessage(data);
                        }
                    }
                });
            });
        },
        /*验证money 信息*/
        moneyForm: function () {
            var $this = $("form[name='moneyForm']");
            var option = {
                submitHandler: function () {
                    $this.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            if (data.state == "success") {
                                var url = data.url;
                                ecjia.pjax(url);
                            } else {
                                ecjia.merchant.showmessage(data);
                            }
                        }
                    });
                }
            }
            var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
            $this.validate(options);
        },

        invoiceForm: function () {
            $("form[name='invoiceForm']").on('submit', function (e) {
                e.preventDefault();
                if (app.order.checkShipping()) {
                    $(this).ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            if (data.state == "success") {
                                var url = data.url;
                                ecjia.pjax(url);
                            } else {
                                ecjia.merchant.showmessage(data);
                            }
                        }
                    });
                }
            });
        },

        cancel_order: function () {
            $(".cancel_order").on('click', function (e) {
                e.preventDefault();
                var url = $(".cancel_order").attr("data-href");
                $.ajax({
                    type: "get",
                    url: url,
                    dataType: "json",
                    success: function (data) {
                        ecjia.pjax(data.url);
                    }
                });
            });
        },
        //生成发货单
        delivery_info: function () {
            app.order.deliveryForm();
        },
        /* 给表单加入submit事件 */
        deliveryForm: function () {
            $("form[name='deliveryForm']").on('submit', function (e) {
                e.preventDefault();
                $(this).ajaxSubmit({
                    dataType: "json",
                    success: function (data) {
                        if (data.state == "success") {
                            ecjia.pjax(data.url, function () {
                                ecjia.merchant.showmessage(data);
                            });
                        } else {
                            ecjia.merchant.showmessage(data);
                        }
                    }
                });
            });
        },

        current_order: function () {
            var InterValObj; 	//timer变量，控制时间
            var count = 20; 	//间隔函数，1秒执行

            //20秒自动刷新
            if (date == 'today') {
                InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
            }
            $('.hand-refresh').on('click', function () {
                ecjia.pjax(location.href);
            });
            var myAuto = document.getElementById('audio');
            var val = $('#onOff:checked').val();
            if (myAuto != null && new_order == 1 && val == 'on') {
                myAuto.play();
            }
            $('#onOff').on('click', function () {
                var val = $('#onOff:checked').val(),
                    url = $('.onoffswitch').attr('data-url');
                val == undefined ? 'off' : 'on';
                var info = {'val': val};
                $.post(url, info);
            })

            //timer处理函数
            function SetRemainTime() {
                if (count == 0) {
                    window.clearInterval(InterValObj);		//停止计时器
                    $('.auto-refresh').html(js_lang.twenty_seconds_refresh);
                    ecjia.pjax(location.href);
                } else {
                    count--;
                    $('.auto-refresh').html(sprintf(js_lang.s_seconds_refresh, count));
                }
            };

            $(document).on('pjax:start', function () {
                window.clearInterval(InterValObj);
            });
        },

        toggle_view: function () {
            $('.toggle_view').off('click').on('click', function (e) {
                e.preventDefault();
                var $this = $(this);
                var url = $this.attr('href');
                $.post(url, function (data) {
                    ecjia.merchant.showmessage(data);
                }, 'json');
            });
        },

        showSearch: function () {
            $(".date").datepicker({
                format: "yyyy-mm-dd",
            });

            $('.show_order_search').off('click').on('click', function () {
                if ($('.ecjia-order-search').hasClass('display-none')) {
                    $('.ecjia-order-search').stop(true).slideDown('slow', 'easeOutQuint');
                    $('.ecjia-order-search').removeClass('display-none');
                } else {
                    $('.ecjia-order-search').stop(true).slideUp('slow', 'easeInQuart');
                    $('.ecjia-order-search').addClass('display-none');
                    $('.nav.nav-pills').find('li a').each(function () {
                        var $this = $(this),
                            href = $this.attr('data-href');
                        $this.attr('href', href);
                    });
                }
            });
        },
    };

})(ecjia.merchant, jQuery);

// end