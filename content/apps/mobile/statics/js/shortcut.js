// JavaScript Document
;(function (app, $) {
    app.cycleimage = {
        init: function () {},
        old_js: function () {
            //控制启用按钮出现和隐藏
            $('.wookmark .thumbnail').mouseover(function () {
                if (!$(this).hasClass('choose')) {
                    $(this).find(".input .right").css('opacity', '1');
                }
            }).mouseout(function () {
                if (!$(this).hasClass('choose')) {
                    $(this).find(".input .right").css('opacity', '0');
                }
            });
 
            //预览中的内容填充
            $(document).on('click', 'a[data-toggle="modal"]', function (e) {
                e.preventDefault();
                var $this = $(this);
                var url = $this.closest('.wookmark-cycleimage').attr('data-preview');
                var code = {
                    code: $this.attr('data-code')
                };
 
                var footer_btn = $this.closest('.thumbnail').find('.choose-cycleimage').clone(true);
 
                $.get(url, code, function (data) {
                    var info = '';
                    if (data.content) {
                        info += '<div style="width:100%;">' + data.content + '</div>';
                        info += '<hr />';
                    }
                    if (data.flashtpl.code) {
                        info += '<p><b>' + js_lang.label_brief + '</b>' + data.flashtpl.Description + '</p>';
                    }
 
                    $('#preview .modal-body , #preview .modal-footer').html('');
                    $('#preview .modal-header h3 span').remove();
                    
                    var title = $('#preview .modal-header h3').html();
                    title += '<span> - ' + data.flashtpl.Name + '</span>';
                    $('#preview .modal-header h3').html(title);
                    $('#preview .modal-body').append(info);
                    $('#preview .modal-footer').append(footer_btn);
 
                    $('#preview').modal('show').css({
                        width: 'auto'
                    });
                }, 'json')
            })
 
            $(document).on('click', '.choose-cycleimage', function (e) {
                e.preventDefault();
                var $this = $(this);
                var url = $this.attr('data-href');
                var href = $('.wookmark-cycleimage').attr('data-href');
                var code = {
                    code: $this.attr('data-code')
                };
                $.get(url, code, function (data) {
                    if (data.state == "success") {
                        $('#preview').modal('hide');
                        if ($this.parent().hasClass('right')) {
                            $('.thumbnail').removeClass('choose');
                            $('.thumbnail .choose-cycleimage').removeClass('hide');
                            $this.closest('.thumbnail').addClass('choose');
                            $this.addClass('hide');
                            ecjia.admin.showmessage(data);
                        } else {
                            ecjia.pjax(href, function () {
                                ecjia.admin.showmessage(data);
                            });
                        }
                    } else {
                        ecjia.admin.showmessage(data);
                    }
                });
            })
 
            function select_style(code, t) {
                //弹出对话框渲染
                window.code = code;
                if (t.parent().find(".flash-choose").hasClass("hidden")) {
                    smoke.confirm(js_lang.setupConfirm, function (e) {
                        if (e) {
                            $.get('index.php?m=cycleimage&c=admin&a=apply', 'code=' + code, function (response, status) {
                                if (response.state == 'success') {
                                    var info = '<div class="alert alert-info message"><a class="close" data-dismiss="alert" >×</a><span>' + response.message + '</span></div>';
                                    if (!$(".message").html()) {
                                        $(".heading").eq(0).after(info);
                                    }
                                    $('.flash-choose').addClass('hidden');
                                    t.parent().find(".flash-choose").attr('class', 'flash-choose ecjiafc-red');
                                }
                            }, 'json');
                        }
                    }, {
                        ok: js_lang.ok,
                        cancel: js_lang.cancel
                    });
                }
            }
        }
    };
 
    app.cycleimage_edit = {
        init: function () {
            $("form[name='theForm']").validate({
                onkeyup: false,
                errorPlacement: function (error, element) {
                    error.appendTo(element.closest("div.controls"));
                },
                highlight: function (element) {
                    $(element).closest("div.control-group").addClass("error f_error");
                    var thisStep = $(element).closest('form').prev('ul').find('.current-step');
                    thisStep.addClass('error-image');
                },
                unhighlight: function (element) {
                    $(element).closest("div.control-group").removeClass("error f_error");
                    if (!$(element).closest('form').find('div.error').length) {
                        var thisStep = $(element).closest('form').prev('ul').find('.current-step');
                        thisStep.removeClass('error-image');
                    };
                },
                submitHandler: function () {
                    $("form[name='theForm']").ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            ecjia.admin.showmessage(data);
                        }
                    });
                }
            });
 
            $('#info-toggle-button').toggleButtons({
                style: {
                    enabled: "info",
                    disabled: "success"
                }
            });
        }
    };
    
})(ecjia.admin, jQuery);
 
// end