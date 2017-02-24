// JavaScript Document
;(function (app, $) {
    /*配送快递单编辑界面js*/
    app.shipTemplate = {
        /*** 切换编辑模式*/
        template_radio_click: function (type) {
            //获取表单对象
            switch (type) {
            case '1':
                //代码模式
                document.getElementById('code_shipping_print').style.display = 'block';
                document.getElementById('code_shipping_help').style.display = 'block';
                document.getElementById('code_submit').style.display = 'block';
                document.getElementById('visual').style.display = 'none';
                break;
            case '2':
                //所见即所得模式
                document.getElementById('code_shipping_print').style.display = 'none';
                document.getElementById('code_shipping_help').style.display = 'none';
                document.getElementById('code_submit').style.display = 'none';
                document.getElementById('visual').style.display = 'block';
                break;
            }
            return true;
        },
        
        init_template_1: function () {
            /* 模板选择 */
            $(document).on('click', '[name="model1"]', function (e) {});
            /* 快递单模板代码模式1保存 */
            $(document).on('click', '#save_template_1', function (e) {
                e.preventDefault();
                var objform = $('form[name="templateForm_1"]');
                app.shipTemplate.submit(objform);
            });
        },
        
        submit: function (objform) {
            objform.ajaxSubmit({
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
        },
    };
 
    /*****配送方式列表界面js******/
    app.shopping_admin = {
        /* 配送方式编辑form提交 */
        editFormSubmit: function () {
            var $form = $('form[name="editForm"]');
            /* 给表单加入submit事件 */
            var option = {
                rules: {
                    shipping_name: {
                        required: true,
                        minlength: 3
                    },
                    shipping_desc: {
                        required: true,
                        minlength: 6
                    },
                },
                messages: {
                    shipping_name: {
                        required: js_lang.shipping_name_required,
                        minlength: js_lang.shipping_name_minlength
                    },
                    shipping_desc: {
                        required: js_lang.shipping_desc_required,
                        minlength: js_lang.shipping_desc_minlength
                    }
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
        },
        
        plugin_state_click: function (url) {
            /* 配送方式关闭与启用 */
            $.get(url, function (data) {
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
            });
        }
    };
 
    /*****配送方式列表界面js******/
    app.shopping_list = {
        init: function () {
            /* 快速编辑 */
        },
        plugin_state_click: function (url) {
            /* 配送方式关闭与启用 */
            $.get(url, function (data) {
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
            });
        }
    };
 
})(ecjia.admin, jQuery);
 
// end