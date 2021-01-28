;
(function(admin, $) {
    var T = 0;
    var StyleCode = '';
    var StyleTem = '';
    var content = '';
    admin.admin_template = {
        editor: '',
        $check_form: '',
        init: function() {
            admin.admin_template.list_oldjs();
        },
        library: function() {
            $(function() {
                admin.admin_template.set_check_form();
            })
            admin.admin_template.library_search();
            admin.admin_template.library_ace_enlarge();
            admin.admin_template.library_list_choose();
        },
        set_check_form: function() {
            admin.admin_template.$check_form = $('form textarea');
            admin.admin_template.$check_form.each(function() {
                $(this).attr('_value', $(this).val());
            });
        },
        library_search: function() {
            //li搜索筛选功能
            $('#ms-search').quicksearch($('.ms-elem-selectable', '#ms-custom-navigation'), {
                onAfter: function() {
                    $('.ms-group').each(function(index) {
                        $(this).find('.isShow').length ? $(this).css('display', 'block') : $(this).css('display', 'none');
                    });
                    return;
                },
                show: function() {
                    this.style.display = "";
                    $(this).addClass('isShow');
                },
                hide: function() {
                    this.style.display = "none";
                    $(this).removeClass('isShow');
                },
            });
        },
        library_ace_enlarge: function() {
            $('.template_info .enlarge').on('click', function() {
                var $this = $(this);
                var $info = $('.template_info');
                var $list = $('.template_list').parents('.chat_sidebar');
                var $list_choose = $('.list_choose');
                if ($this.hasClass('fontello-icon-resize-full')) {
                    $this.removeClass('fontello-icon-resize-full').addClass('fontello-icon-resize-small');
                    $info.removeClass('span9').addClass('span12');
                    $list.addClass('hide');
                    $list_choose.removeClass('hide');
                } else {
                    $this.removeClass('fontello-icon-resize-small').addClass('fontello-icon-resize-full');
                    $info.removeClass('span12').addClass('span9');
                    setTimeout(function() {
                        $list.removeClass('hide');
                        $list_choose.addClass('hide');
                    }, 500);
                }
            });
        },
        library_list_choose: function() {
            var $list_choose = $('.list_choose');
            $list_choose.on('change', function() {
                var url = $(this).find('option:selected').val();
                if (url) {
                    ecjia.pjax($(this).find('option:selected').val());
                } else {
                    smoke.alert(js_lang_template.url_error);
                }
            })
        },
    }
})(ecjia.admin, $);

//end