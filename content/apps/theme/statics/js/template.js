;(function(admin, $) {
    var T = 0;
    var StyleCode = '';
    var StyleTem = '';

    var content = '';

    admin.admin_template = {
        editor : '',
        $check_form : '',
        init : function() {
            admin.admin_template.list_oldjs();
        },

        library : function() {
            $(function() {
                admin.admin_template.set_check_form();
            })
            admin.admin_template.library_init();
            admin.admin_template.library_search();
            admin.admin_template.library_ace_init();
            admin.admin_template.library_ace_enlarge();
            admin.admin_template.library_list_choose();
            admin.admin_template.library_ace_submit();
        },
        set_check_form : function() {
            admin.admin_template.$check_form = $('form textarea');
            admin.admin_template.$check_form.each(function() {
                $(this).attr('_value', $(this).val());
            });
        },
        library_init : function() {
            function is_form_changed() {
                var is_changed = false;
                admin.admin_template.$check_form.each(function() {
                    var _v = $(this).attr('_value');
                    if (_v != $(this).val()) is_changed = true;
                });
                return is_changed;
            }
            window.onbeforeunload = function() {
                if (is_form_changed()) {
                    return admin_template_lang.confirm_leave;
                }
            }
            //PJAX开始
            $(document).off('pjax:beforeSend.library');
            $(document).on('pjax:beforeSend.library', function(){
                if (is_form_changed()) {
                    if (confirm(admin_template_lang.confirm_leave)) {
                        return true;
                    } else {
                        return false;
                    }
                }
            });
            $(document).off('pjax:end.library');
            $(document).on('pjax:end.library', function() {
                admin.admin_template.set_check_form();
            });
        },
        library_search : function() {
            //li搜索筛选功能
            $('#ms-search').quicksearch(
                $('.ms-elem-selectable', '#ms-custom-navigation' ),
                {
                    onAfter : function(){
                        $('.ms-group').each(function(index) {
                            $(this).find('.isShow').length ? $(this).css('display','block') : $(this).css('display','none');
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

        library_ace_init : function() {
            admin.admin_template.editor = ace.edit("editor");
            admin.admin_template.editor.setTheme("ace/theme/eclipse");
            admin.admin_template.editor.session.setMode("ace/mode/html");
            admin.admin_template.editor.setOption("enableEmmet", true);
            admin.admin_template.editor.setFontSize(14);
            admin.admin_template.editor.setOption("wrap", 'off');
            admin.admin_template.editor.setAutoScrollEditorIntoView(true);
            admin.admin_template.editor.setShowPrintMargin(false);
            admin.admin_template.editor.getSession().on('change', function(e) {
                $('#libContent').val(admin.admin_template.editor.getValue());
            });
            admin.admin_template.editor.$blockScrolling = Infinity;
        },

        library_ace_readonly : function(readonly) {
            admin.admin_template.editor.setReadOnly(readonly);
        },

        library_ace_setval : function(value) {
            admin.admin_template.editor.setValue('');
            admin.admin_template.editor.insert(value);
        },

        library_ace_enlarge : function() {
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
                    setTimeout(function() {
                        admin.admin_template.editor.resize();
                    }, 500);
                } else {
                    $this.removeClass('fontello-icon-resize-small').addClass('fontello-icon-resize-full');
                    $info.removeClass('span12').addClass('span9');
                    setTimeout(function() {
                        admin.admin_template.editor.resize();
                        $list.removeClass('hide');
                        $list_choose.addClass('hide');
                    }, 500);
                }
            });
            $('.sidebar_switch').on('click', function() {
                setTimeout(function() {
                    admin.admin_template.editor.resize();
                }, 500);
            });
        },

        library_list_choose : function() {
            var $list_choose = $('.list_choose');
            $list_choose.on('change', function() {
                var url = $(this).find('option:selected').val();
                if (url) {
                    ecjia.pjax($(this).find('option:selected').val());
                } else {
                    smoke.alert(admin_template_lang.connection_error);
                }
            })
        },

        library_ace_submit : function() {
            $('.template_form').on('submit', function(e) {
                e.preventDefault();
                if (!$(this).find('button[type="submit"]').attr('disabled')) {
                    var $this = $(this);
                    smoke.confirm(admin_template_lang.confirm_edit_project,function(e){
                        if (e) {
                            $this.ajaxSubmit({
                                dataType:"json",
                                success:function(data){
                                    admin.admin_template.set_check_form();
                                    ecjia.admin.showmessage(data);
                                }
                            });
                        }
                    }, {ok:admin_template_lang.ok, cancel:admin_template_lang.cancel});

                }
            })
        },

        list_oldjs : function() {
            $('[data-toggle="backupTemplate"]').on('click', function(e) {
                e.preventDefault();
                $this = $(this);
                var code = $this.attr('data-tplcode')
                backupTemplate(code);
            });
            $('[data-toggle="setupTemplate"]').on('click', function(e) {
                e.preventDefault();
                $this = $(this);
                var code = $this.attr('data-tplcode')
                setupTemplate(code);
            });
            $('[data-toggle="setupTemplateFG"]').on('click', function(e) {
                e.preventDefault();
                $this         = $(this);
                var code     = $this.attr('data-tplcode');
                var style     = $this.attr('data-style');
                setupTemplateFG(code,style);
            })
            .on('mouseover', function(e) {
                e.preventDefault();
                $this         = $(this);
                var code     = $this.attr('data-tplcode');
                var style     = $this.attr('data-style');
                var $img    = $this.parents('.showview').length ? $this.parents('.showview').find('.thumbnail img') : $this.parents('.thumbnail').find('img');

                var re = /(\/|\\)([^\/\\])+\.png$/;
                var img_url = $img.attr('src').replace(re, '/screenshot' + (style ? '_'+style : style) + '.png');
                $img.attr('src', img_url);

                // onSOver('screenshot',style);
            })
            .on('mouseout', function(e) {
                e.preventDefault();
                $this.siblings('.active').length ? $this.siblings('.active').trigger('mouseover') : $this.siblings('[data-style=""]').trigger('mouseover');
            })


            function setupTemplate(tpl)
            {
                if (tpl != StyleTem)
                {
                    StyleCode = '';
                }
                smoke.confirm(admin_template_lang.choosetemplateFG,function(e){
                    if (e){
                        $.get('index.php?m=theme&c=admin_template&is_ajax=1&a=install', 'tpl_name=' + tpl + '&tpl_fg='+ StyleCode, function(data){
                            ecjia.admin.showmessage(data);
                        }, 'JSON');
                    }
                }, {ok:admin_template_lang.ok, cancel:admin_template_lang.cancel});
                
            }

            function backupTemplate(tpl)
            {
                $.get('index.php?m=theme&c=admin_template&is_ajax=1&a=backup', 'tpl_name=' + tpl, function(data){
                    backupTemplateResponse(data);
                }, "JSON");
            }

            function backupTemplateResponse(result)
            {
                if (result.message.length>0) smoke.alert(result.message);
                if (result.error == 0) location.href = result.content;
            }

            function showTemplateInfo(res)
            {
                document.getElementById("CurrTplStyleList").innerHTML = res.tpl_style;
                StyleSelected = res.stylename;
                document.getElementById("screenshot").src = res.screenshot;
                document.getElementById("templateName").innerHTML    = res.name;
                document.getElementById("templateDesc").innerHTML    = res.desc;
                document.getElementById("templateVersion").innerHTML = res.version;
                document.getElementById("templateAuthor").innerHTML  = '<a href="' + res.uri + '" target="_blank">' + res.author + '</a>';
                document.getElementById("backup").onclick = function () {backupTemplate(res.code);};
            }

            // function onSOver(tplid, fgid)
            // {
            //     var re = /(\/|\\)([^\/\\])+\.png$/;
            //     var img_url = document.getElementById(tplid).src;
            //     StyleCode = fgid;
            //     StyleTem = tplid;
            //     T = 0;
            //     console.log(tplid);
            //     document.getElementById(tplid).src = tplid != '' && fgid != '' ?
            //     img_url.replace(re, '/screenshot_' + fgid + '.png') :
            //     img_url.replace(re, '/screenshot.png');
            //     return true;
            // }
            //
            // function onSOut(tplid, def)
            // {
            //     if (T == 1) return true;
            //     var re = /(\/|\\)([^\/\\])+\.png$/;
            //     var img_url = document.getElementById(tplid).src;
            //     if ( def != '' ) document.getElementById(tplid).src = def;
            //     return true;
            // }
            function setupTemplateFG(tplNO, TplFG)
            {
                T = 1;
                smoke.confirm(admin_template_lang.choosetemplateFG,function(e){
                    if (e){
                        $.get('index.php?m=theme&c=admin_template&is_ajax=1&a=install', 'tpl_name=' + tplNO + '&tpl_fg=' + TplFG, function(data){
                            ecjia.admin.showmessage(data);
                        }, 'JSON');
                    }
                }, {ok:admin_template_lang.ok, cancel:admin_template_lang.cancel});
                return true;
            }
        },
    }

})(ecjia.admin, $);
