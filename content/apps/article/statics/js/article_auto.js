// JavaScript Document
;(function (app, $) {
    app.article_auto = {
        init: function () {
            $(".date").datepicker({
                format: "yyyy-mm-dd",
                container : '.main_content',
            });
            app.article_auto.search();
 
            var $datetable = $('[data-trigger="datetable"]');
            $datetable.length && $datetable.each(function () {
                var $this = $(this);
                var oldval = $this.text();
                var url = $this.attr('data-url');
                var name = $this.attr('data-name') || '';
                var pk = $this.attr('data-pk') || 0;
                var title = $this.attr('data-title');
                var type = $this.attr('data-text') || 'text';
                if (!pk || !url) {
                    console.log(js_lang.editable_miss_parameters);
                    return;
                }
                if (!title) title = js_lang.edit_info;
                var pjaxurl = $this.attr('data-pjax-url') || '';
                $this.editable({
                    viewformat: 'YYYY-MM-DD',
                    format: 'YYYY-MM-DD',
                    template: 'YYYYMMDD',
                    language: 'cn',
                    combodate: {
                        minYear: new Date().getFullYear(),
                        maxYear: new Date().getFullYear() + 5,
                        minuteStep: 1
                    },
                    url: url,
                    pk: pk,
                    title: title,
                    type: type,
                    dataType: 'json',
                    success: function (data) {
                        if (data.state == 'error') return data.message;
                        if (pjaxurl != '') {
                            ecjia.pjax(pjaxurl, function () {
                                ecjia.admin.showmessage(data);
                            });
                        } else {
                            ecjia.admin.showmessage(data);
                        }
                    }
                });
                $datetable.on('click', function () {
                    $('.combodate').find('select:eq(0)').css('width', '70px');
                    $('.combodate').find('select:eq(1), select:eq(2)').css('width', '60px');
                    $("select").not(".noselect").chosen();
                    $('.combodate').find('.chzn-container:eq(0), .chzn-container:eq(1)').css('padding-right', '5px');
                });
            });
        },
        search: function () {
            //搜索功能
            $(".search_article").on('click', function (e) {
                e.preventDefault();
                var url = $(".choose_list").attr('data-url');
                var keywords = $("input[name='keywords']").val()
                if (keywords) {
                    url += '&keywords=' + keywords;
                }
                ecjia.pjax(url);
            });
 
            $(".btnSubmit").on('click', function (e) {
                var $this = $(this);
                e.preventDefault();
 
                var $id = $($this.attr('data-idClass')) || $(".checkbox:checked");
                var id = [];
                $id.each(function () {
                    id.push($(this).val());
                });
                var name = $this.attr('data-name') || 'checkboxes';
                var url = $this.attr('data-url');
                var msg = $this.attr('data-msg') || js_lang.operate_selected_confirm;
                var noSelectMsg = $this.attr('data-noSelectMsg') || js_lang.noSelectMsg;
                var time = 'select_time'
                var time_val = $('input[name="select_time"]').val();
 
                var option = {
                    id: id,
                    url: url,
                    msg: msg,
                    name: name,
                    time_val: time_val,
                    time: time
                }
 
                if (id.length == 0) {
                    smoke.alert(noSelectMsg);
                } else if (time_val == '') {
                    smoke.alert(js_lang.select_time);
                } else {
                    app.article_auto.batch(option);
                }
            });
        },
 
        /**
         * batch 批量操作方法
         */
        batch: function (options) {
            var defaults = {
                url: false, 							//url 批量操作访问的url地址
                msg: js_lang.operate_selected_confirm, 	//msg 批量操作的提示信息
                noSelectMsg: js_lang.noSelectMsg, 		//noSelectMsg 没有选中项的提示信息
                name: 'checkboxes', 					//name 对应PHP操作中获取的name
                id: [], 								//obj 批量操作的用户id数组
            }
 
            var options = $.extend({}, defaults, options);
            if (!options.url || options.id.length == 0) return console.log(js_lang.batch_miss_parameters);
            var ajaxinfo = "{" + options.name + ":'" + options.id + "' , " + options.time + ":'" + options.time_val +
                "'}";
            ajaxinfo = eval("(" + ajaxinfo + ")");
            smoke.confirm(options.msg, function (e) {
                if (e) {
                    $.ajax({
                        type: "POST",
                        url: options.url,
                        data: ajaxinfo,
                        dataType: "json",
                        success: function (data) {
                            ecjia.admin.showmessage(data);
                        }
                    });
                }
            }, {
                ok: js_lang.ok,
                cancel: js_lang.cancel
            });
        },
    };
    
})(ecjia.admin, jQuery);
 
// end