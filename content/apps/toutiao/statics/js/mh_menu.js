// JavaScript Document
;
(function(app, $) {
    app.menu = {
        init: function() {
            app.menu.add();
            app.menu.edit();
            app.menu.remove();
            app.menu.save();
            app.menu.btn_save();
        },
        add: function() {
            $('[data-toggle="add-menu"]').off('click').on('click', function() {
                var $this = $(this),
                    pid = $this.attr('data-pid'),
                    url = $('input[name="add_url"]').val(),
                    count = $this.attr('data-count');
                var info = {
                    pid: pid
                }
                if (count == 0) {
                    smoke.confirm('添加子菜单后，一级菜单的内容将被清除。确定添加子菜单？', function(e) {
                        if (e) {
                            $.post(url, info, function(data) {
                                $('#weixin-menu').html(data.data);
                                $('.weixin-menu-right-content').html(data.result);
                                app.menu.init();
                            });
                        }
                    }, {
                        ok: "确定",
                        cancel: "取消"
                    });
                } else {
                    $.post(url, info, function(data) {
                        $('#weixin-menu').html(data.data);
                        $('.weixin-menu-right-content').html(data.result);
                        app.menu.init();
                    });
                }
            });
        },
        edit: function() {
            $('[data-toggle="edit-menu"]').off('click').on('click', function() {
                var $this = $(this),
                    id = $this.attr('data-id'),
                    pid = $this.attr('data-pid'),
                    url = $('input[name="edit_url"]').val();
                var info = {
                    id: id,
                    pid: pid
                }
                $.post(url, info, function(data) {
                    $('.menu-sub-item').removeClass('current');
                    $('.menu-item').removeClass('size1of1');
                    if ($this.parent().hasClass('menu-item')) {
                        $this.parent('.menu-item').addClass('size1of1');
                        $('.weixin-sub-menu').addClass('hide');
                        $this.parent('.menu-item').find('.weixin-sub-menu').removeClass('hide');
                    } else {
                        $this.parent('.menu-sub-item').addClass('current');
                    }
                    $('.weixin-menu-right-content').html(data.data);
                    app.menu.init();
                });
            });
        },
        remove: function() {
            $('[data-toggle="del-menu"]').off('click').on('click', function() {
                var $this = $(this),
                    id = $this.attr('data-id'),
                    url = $('input[name="del_url"]').val();
                var info = {
                    id: id
                }
                smoke.confirm('您确定要删除该菜单吗？', function(e) {
                    if (e) {
                        $.post(url, info, function(data) {
                            ecjia.merchant.showmessage(data);
                        });
                    }
                }, {
                    ok: "确定",
                    cancel: "取消"
                });
            });
        },
        save: function() {
            $('[data-toggle="btn-create"]').off('click').on('click', function() {
                var $this = $(this),
                    url = $('input[name="check_url"]').val();
                $.post(url, function(data) {
                    if (data.id != 0) {
                        $('#weixin-menu').html(data.data);
                        $('.weixin-menu-right-content').html(data.result);
                        app.menu.init();
                        $('.div-input').find('.menu-tips').removeClass('hide');
                    } else {
                        var $this = $('[data-toggle="btn-create"]');
                        var url = $this.attr('data-url');
                        var message = $this.attr('data-msg');
                        if (message) {
                            smoke.confirm(message, function(e) {
                                e && $.get(url, function(data) {
                                    ecjia.merchant.showmessage(data);
                                }, 'json');
                            }, {
                                ok: '确定',
                                cancel: '取消'
                            });
                        } else {
                            $.get(url, function(data) {
                                ecjia.merchant.showmessage(data);
                            }, 'json');
                        }
                    }
                });
            });
        },
        btn_save: function() {
            $('.btn-save').off('click').on('click', function() {
                var $form = $("form[name='the_form']");
                var option = {
                    submitHandler: function() {
                        $form.ajaxSubmit({
                            dataType: "json",
                            success: function(data) {
                                ecjia.merchant.showmessage(data);
                                $('#weixin-menu').html(data.data);
                                $('.weixin-menu-right-content').html(data.result);
                                app.menu.init();
                            }
                        });
                    }
                }
                var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
                $form.validate(options);
            });
        }
    };
})(ecjia.merchant, jQuery);
// end