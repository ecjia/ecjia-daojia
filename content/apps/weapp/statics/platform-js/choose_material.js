// JavaScript Document
;
(function (app, $) {
    app.choose_material = {
        init: function () {
            app.choose_material.choose_material();
            app.choose_material.link_del();
            app.choose_material.page_click();
        },
        choose_material: function () {
            $('.nav-item').off('click').on('click', function (e) {
                var $this = $(this),
                    type = $this.attr('data-type');
                if (type != 'text') {
                    $('#chat_editor').hide();
                    $('.js_appmsgArea').show();
                } else {
                    $('#chat_editor').show();
                    $('.js_appmsgArea').hide();
                }
                $('.material-table').find('.img_preview').remove();
                $('.material-table').find('.weui-desktop-media__list-col').remove();
                $('.link_dele').remove();
                $('.create-type__list').show();
                $('.choose_material').attr('data-type', type);
                $('input[name="content_type"]').val(type); //群发消息类型
            });

            $('.choose_material').off('click').on('click', function () {
                var $this = $(this);
                url = $this.attr('data-url'),
                    type = $this.attr('data-type');
                var info = {
                    type: type
                }
                $.post(url, info, function (data) {
                    $('#choose_material').find('.page-item').remove();
                    $('#choose_material').find('.inner_main').html(data.data);
                    $('#choose_material').find('.inner_main').after('<div class="page-item">' + data.page + '</div>');
                    $('#choose_material').find('.modal-title').html(data.title);
                    $('#choose_material').modal('show');
                    app.choose_material.img_item_click();
                    app.choose_material.page_click();
                })
            });

            $('.js-btn').off('click').on('click', function () {
                var $this = $('.inner_main .img_item_bd.selected'),
                    media_id = $this.find('.pic').attr('data-id'),
                    src = $this.find('.pic').attr('src');
                var inner_html = '<div class="img_preview"><img class="preview_img margin_10" src="' + src + '" alt=""><input type="hidden" name="media_id" value=' + media_id + '><a href="javascript:;" class="jsmsgSenderDelBt link_dele">' + jslang.delete + '</a></div>';

                if (media_id == undefined) {
                    var html = $('.inner_main .grid-item.selected');
                    media_id = html.attr('data-id');
                    inner_html = '<div class="weui-desktop-media__list-col margin_10">' + html[0]['outerHTML'] + '<input type="hidden" name="media_id" value=' + media_id + '></div><a href="javascript:;" class="jsmsgSenderDelBt link_dele p_l0">' + jslang.delete + '</a>';
                }
                $('.js_appmsgArea .create-type__list').hide();
                $('.js_appmsgArea').append(inner_html);
                $('#choose_material').modal('hide');
                $(".modal-backdrop").remove();
                app.choose_material.link_del();
            });
        },

        img_item_click: function () {
            $('.img_item').off('click').on('click', function () {
                var $this = $(this),
                    child = $this.children('.img_item_bd');

                if (child.hasClass('selected')) {
                    child.removeClass('selected');
                    return false;
                }
                child.addClass('selected');
                $this.siblings('li').children('.img_item_bd').removeClass('selected');
            });

            $('.grid-item').off('click').on('click', function () {
                var $this = $(this);
                if ($this.hasClass('selected')) {
                    $this.removeClass('selected');
                    return false;
                }
                $this.addClass('selected').siblings('li').removeClass('selected');
                $this.parent().siblings('div').find('.grid-item').removeClass('selected');
            });
        },

        link_del: function () {
            $('.link_dele').off('click').on('click', function (e) {
                e.preventDefault();
                var $this = $(this),
                    parent = $this.parents('.js_appmsgArea');
                parent.find('.img_preview').remove();
                parent.find('.weui-desktop-media__list-col').remove();
                parent.find('.link_dele').remove();
                parent.find('.create-type__list').show();
            });
        },

        page_click: function () {
            $('#choose_material .page-link').off('click').on('click', function (e) {
                e.preventDefault();
                var $this = $(this),
                    url = $this.attr('href'),
                    type = $('.material-table').find('.nav-link.active').parent().attr('data-type');
                if (url == undefined) {
                    return false;
                }
                $.post(url, {
                    type: type
                }, function (data) {
                    $('#choose_material').find('.page-item').remove();
                    $('#choose_material').find('.inner_main').html(data.data);
                    $('#choose_material').find('.inner_main').after('<div class="page-item">' + data.page + '</div>');
                    $('#choose_material').find('.modal-title').html(data.title);
                    $('#choose_material').modal('show');
                    app.choose_material.img_item_click();
                    app.choose_material.page_click();
                });
            });
        }
    };
})(ecjia.platform, jQuery);

// end