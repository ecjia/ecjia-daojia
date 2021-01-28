// JavaScript Document
;
(function(app, $) {
	app.upgrade = {

	};

    //消息提示
    app.notice = {
        notice_html: '',

        success_notice_template: function (status) {
            let correct_img = $('input[name="correct_img"]').val();
            return "<span class='install_correct'><img alt='' src='" + correct_img + "' />"+ status + "</span><br/>";
        },

        error_notice_template: function (status, msg) {
            let error_img = $('input[name="error_img"]').val();
            return "<span class='install_error'><img alt='' src='" + error_img + "' />" + status + "</span><br/>" +
                "<strong class='m_l30 ecjia-color-red'>"+ msg + "</strong>";
        },

        install_notice_template: function (msg) {
            return '<div class="install_notice">'+ msg + '</div>';
        },

        open: function () {
            $("#js-monitor").css('display', 'block');
            $('#js-monitor-notice').css('display', 'block');
            //清除之前的缓存数据
            app.notice.clear();
        },

        clear: function () {
            app.notice.notice_html = '';
            $('#js-notice').html(app.notice.notice_html);
        },

        show: function (html) {
            app.notice.notice_html += html;
            $('#js-notice').html(app.notice.notice_html);
        },

        stop: function () {
            $("#js-monitor-wait-please").html(js_lang.installation_aborted);
        },

        success: function (html) {
            app.notice.notice_html += html;
            $('#js-notice').html(app.notice.notice_html);
        },

        error: function (html) {
            app.notice.notice_html += html;
            $("#js-monitor-notice").css('display', "block");
            $('#js-notice').html(app.notice.notice_html);
            $('#js-install-return-once').css('display', 'block');
        },

        addSubject: function (text) {
            app.notice.show(app.notice.install_notice_template(text));
        },

        addErrorMessage: function (msg) {
            app.notice.error(app.notice.error_notice_template(js_lang.fail, msg));
        },

        addSuccessMessage: function () {
            app.notice.success(app.notice.success_notice_template(js_lang.success));
        },

        addNumTips: function (num) {
            let text = sprintf(js_lang.remainder, num);
            let html = "<span class='install_correct' id='numtips'>"+ text + "</span>";
            $('#js-notice').append(html);
        },

        updateNumTips: function (num) {
            let text = sprintf(js_lang.remainder, num);
            $('#numtips').html(text);
        },

        removeNumTips: function () {
            $('#numtips').remove();
        }

    };

    //安装进度条
    app.progress_bar = {
        //开启
        reset: function () {
            let val = 0;
            let html = val + '%';
            let progress_bar_el = $('.progress-bar');
            progress_bar_el.css('width', val + '%');
            progress_bar_el.html(html);
        },

        complete: function () {
            let val = 100;
            let html = val + '%';
            let progress_bar_el = $('.progress-bar');
            progress_bar_el.css('width', val + '%');
            progress_bar_el.html(html);
        },

        update: function (val) {
            let html = val + '%';
            let progress_bar_el = $('.progress-bar');
            progress_bar_el.css('width', val + '%');
            progress_bar_el.html(html);
        }
    };

    //更新预览
    app.readme_view = {
	    //打开折叠
        isOpen: function (element) {
            return element.hasClass('fontello-icon-angle-double-up');
        },
	    open: function (element) {
            element.removeClass('fontello-icon-angle-double-down');
            element.addClass('fontello-icon-angle-double-up');
        },

        //关闭折叠
        isClose: function (element) {
            return element.hasClass('fontello-icon-angle-double-down');
        },
        close: function (element) {
            element.removeClass('fontello-icon-angle-double-up');
            element.addClass('fontello-icon-angle-double-down');
        },

        //添加内容
        addReadmeContent: function (element, readme) {
            let files='<ul>' +
                '<li>'+ js_lang.update_content +'</li>' +
                '<li><pre>'+ readme +'</pre></li>' +
                '</ul>';
            element.parent().css({'margin-bottom': 0, 'border-radius': '4px 4px 0 0'});
            element.parent().after(files);
        },

        //获取内容
        getReadmeContent: function (element) {
            return element.parent().next('ul').html();
        }
    };

    app.version = {
	    versions: [],
        count: 0,

        //初始化
        init: function (list) {
            this.versions = list;
            this.count = this.length();
        },

        //获取列表
	    list: function () {
            return this.versions;
        },

        //计算数量
        length: function () {
            return this.versions.length;
        },

        //移除第一个
        shift: function () {
	        this.versions.shift();
        },

        //获取第一个
        first: function () {
	        return this.versions[0];
        },

        //获取步数
        setp: function () {
            return parseInt((this.count - this.length()) / this.count * 100);
        }
    };

    //升级任务
    app.task = {
	    //启动
        startingTask: function(next) {
            console.log('starting');

            $('body').scrollTop(0).css('height', '100%');
            $('#js_ecjia_intro').css('display', 'none');
            $('.path').children('li').removeClass('current').eq(1).addClass('current');

            app.progress_bar.reset();
            app.progress_bar.update(10);

            app.version.init(ver_list);

            next();
        },

        //安装程序
        upgradeTask: function(next) {
            console.log('upgrade');

            app.notice.open();
            app.task.upgradeSubTask(next);
        },

        upgradeSubTask: function(next) {
            console.log('upgradeSubTask');

            if (app.version.length() === 0) {
                next();
            }
            else {
                let version = app.version.first();
                let params = {
                    v: version
                };
                let url = $(".ajax_upgrade_url").val();

                $.post(url, params, function(result) {
                    if (result.state === 'error') {
                        let msg = js_lang.upgrading + version;
                        // ErrorMsg(msg, result.message);
                        app.notice.addSubject(msg);
                        app.notice.addErrorMessage(result.message);
                        return false;
                    }
                    else if (result.state === 'success') {
                        let msg = js_lang.upgrading + version;

                        app.notice.addSubject(msg);
                        app.notice.addSuccessMessage();

                        app.version.shift();

                        app.progress_bar.update(app.version.setp());

                        app.task.upgradeSubTask(next);
                    }
                    else {
                        let msg = js_lang.upgrading + version;
                        app.notice.addSubject(msg);
                        return false;
                    }
                });
            }
        },

        upgradeFinishTask: function (next) {
            console.log('upgradeFinishTask');

            let url = $('input[name="done"]').val();
            window.setTimeout(function() {
                location.href = url;
            }, 2000);

            next();
        },

    }

})(ecjia.front, jQuery);

//end