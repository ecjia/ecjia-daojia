// JavaScript Document
;(function (app, $) {
    app.email_list = {
        init: function () {
            /* 判断按纽是否可点 */
            var inputbool = false;
            $(".smpl_tbl input[type='checkbox']").on('click', function () {
                if ($(this).attr("data-toggle") == "selectall") {
                    inputbool = $(this).attr("checked") == "checked" ? false : true;
                } else {
                    //获取复选框选中的值
                    inputbool = $("input[name='checkboxes[]']:checked").length > 0 ? false : true;
                }
                $(".btnSubmit").attr("disabled", inputbool);
            });
 
            $form = $("form[name='listForm']");
            /* 给表单加入submit事件 */
            $form.on('submit', function (e) {
                e.preventDefault();
                var option = {
                    submitHandler: function () {
                        $form.bind('form-pre-serialize', function (event, form, options, veto) {
                            (typeof (tinyMCE) != "undefined") && tinyMCE.triggerSave();
                        }).ajaxSubmit({
                            dataType: "json",
                            success: function (data) {
                                if (data.state == "success") {
                                    var url = $("form[name='listForm']").attr('data-edit-url');
                                    ecjia.pjax(url, function () {
                                        ecjia.admin.showmessage(data);
                                    });
                                } else {
                                    ecjia.admin.showmessage(data);
                                }
                            }
                        });
                    }
                }
                var options = $.extend(ecjia.admin.defaultOptions.validate, option);
                $form.validate(options);
            });
 
            $('.export_btn').on('click', function () {
                var url = $(this).attr('data-url');
                location.href = url;
            });
        },
    };
    
})(ecjia.admin, jQuery);
 
// end