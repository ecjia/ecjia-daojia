// JavaScript Document
; (function (app, $) {
    app.merchant_info = {
        init: function () {
            app.merchant_info.submit_form();
            app.merchant_info.ajaxremove();
            app.merchant_info.identity_type();
            app.merchant_info.region_change();
            app.merchant_info.gethash();
            $('.disable input,.disable select, .disable textarea, .disable .btn').attr('disabled', 'disabled');
            $('.nodisabled').attr('disabled', false);
        },

        submit_form: function () {
            var $this = $('form[name="theForm"]');
            var option = {
                rules: {
                },
                messages: {

                },
                submitHandler: function () {
                    $this.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            ecjia.merchant.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
            $this.validate(options);
        },

        ajaxremove: function () {
            $('[data-toggle="ajax_remove"]').on('click', function (e) {
                e.preventDefault();
                var $this = $(this),
                    url = $this.attr('data-href') || $this.attr('href'),
                    msg = $this.attr('data-msg') || '您确定进行该操作吗？';
                if (!url) {
                    smoke.alert('参数错误！');
                    return false;
                }
                smoke.confirm(msg, function (e) {
                    if (e) {
                        $.get(url, function (data) {
                        	ecjia.merchant.showmessage(data);
                        }, 'json');
                    }
                }, { ok: "确定", cancel: "取消" });
            });
        },

        identity_type: function () {
            $("input[name='identity_type']").on('change', function () {
                var $this = $(this),
                    val = $this.val();
                val = (val == 1) ? 1 : 2;
                if (val == 1) {
                    $('.identity_type').addClass('hide');
                } else {
                    $('.identity_type').removeClass('hide');
                }
            });
        },

        region_change: function () {
            $('select[data-toggle="regionSummary"]').on('change', function (e) {
                if ($('.form-address').hasClass('error')) $('.form-address').removeClass('error');
                var $this = $(this);
                var url = $this.attr('data-url') || $this.attr('href') || $('select[data-toggle="regionSummary"]').eq(0).attr('data-url');
                var pid = $this.attr('data-pid') || $this.find('option:checked').val();
                var type = $this.attr('data-type');
                var target = $this.attr('data-target');
                var option = { url: url, pid: pid, type: type, target: target };
                e.preventDefault();
                app.merchant_info.regionSummary(option);
            });
        },

        regionSummary: function (options) {
            if (!options.url) {
                console.log('必须指定地址源');
                return;
            }

            var defaults = {
                pid: 0,
                type: 1,
                target: 'region-summary'
            }

            var options = $.extend({}, defaults, options);
            this.url = options.url ? options.url : this.url;
            app.merchant_info.loadRegions(options.pid, options.type, options.target);
        },

        loadRegions: function (parent, type, target) {
            $.get(this.url, 'type=' + type + '&target=' + target + "&parent=" + parent, app.merchant_info.response, "JSON");
        },

        response: function (result) {
            var sel = $('.' + result.target);
            sel.find('option').eq(0).attr('checked', 'checked');
            sel.find('option:gt(0)').remove();

            if (result.regions) {
                for (i = 0; i < result.regions.length; i++) {
                    var opt = document.createElement("OPTION");
                    opt.value = result.regions[i].region_id;
                    opt.text = result.regions[i].region_name;
                    sel.append(opt);
                }
            }
            sel.trigger("liszt:updated").trigger("change");
        },

        formatTimeLabelFunc: function (value, type) {
            var hours = String(value).substr(0, 2);
            var mins = String(value).substr(3, 2);

            if (hours > 24) {
                hours = hours - 24;
                hours = (hours < 10 ? "0" + hours : hours);
                value = hours + ':' + mins;
                var text = String('次日%s').replace('%s', value);
                return text;
            }
            else {
                return value;
            }
        },

        range: function () {
            $('.range-slider').jRange({
                from: 0, to: 2880, step: 30,
                scale: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '次日00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '24:00'],
                format: app.merchant_info.formatTimeLabelFunc,
                width: 600,
                showLabels: true,
                isRange: true
            });
        },

        gethash: function () {
            $('[data-toggle="get-gohash"]').on('click', function (e) {
                e.preventDefault();
                var province = $('select[name="province"]').val(),
                    city = $('select[name="city"]').val(),
                    district = $('select[name="district"]').val(),
                    address = $('input[name="address"]').val(),
                    url = $(this).attr('data-url');

                var option = {
                    'province': 　province,
                    'city': 　city,
                    'district': 　district,
                    'address': address,
                }
                $.post(url, option, app.merchant_info.sethash, "JSON");
            })
        },

        sethash: function (location) {
            if (location.state == 'error') {
                if (location.element == 'address') {
                    $('input[name="address"]').focus();
                    $('input[name="address"]').parents('.form-group').addClass('f_error');
                } else {
                    $('.form-address').addClass('error');
                }
                ecjia.merchant.showmessage(location);
            } else {
                $('.location-address').removeClass('hide');
                var map, markersArray = [];
                var lat = location.result.location.lat;
                var lng = location.result.location.lng;
                var latLng = new qq.maps.LatLng(lat, lng);
                var map = new qq.maps.Map(document.getElementById("allmap"), {
                    center: latLng,
                    zoom: 16
                });
                $('input[name="longitude"]').val(lng);
                $('input[name="latitude"]').val(lat);
                setTimeout(function () {
                    var marker = new qq.maps.Marker({
                        position: latLng,
                        map: map
                    });
                    markersArray.push(marker);
                }, 500);
                //添加监听事件 获取鼠标单击事件
                qq.maps.event.addListener(map, 'click', function (event) {
                    if (markersArray) {
                        for (i in markersArray) {
                            markersArray[i].setMap(null);
                        }
                        markersArray.length = 0;
                    }
                    $('input[name="longitude"]').val(event.latLng.lng)
                    $('input[name="latitude"]').val(event.latLng.lat)
                    var marker = new qq.maps.Marker({
                        position: event.latLng,
                        map: map
                    });
                    markersArray.push(marker);
                });

            }
        },
        mh_switch: function () {
            $('#danger-toggle-button').toggleButtons({
                style: {
                    enabled: "danger",
                    disabled: "success"
                }
            });
            app.merchant_info.submit_form();

            var InterValObj; 	//timer变量，控制时间
            var count = 120; 	//间隔函数，1秒执行
            var curCount;		//当前剩余秒数

            $("#get_code").on('click', function (e) {
                e.preventDefault();
                var url = $(this).attr('data-url') + '&mobile=' + $("input[name='mobile']").val();
                $.get(url, function (data) {
                    if (!!data && data.state == 'success') {
                        curCount = count;
                        $("#mobile").attr("readonly", "true");
                        $("#get_code").attr("disabled", "true");
                        $("#get_code").html("重新发送" + curCount + "(s)");
                        InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
                    }
                    ecjia.merchant.showmessage(data);
                }, 'json');
            });

            //timer处理函数
            function SetRemainTime() {
                if (curCount == 0) {
                    window.clearInterval(InterValObj);		//停止计时器
                    $("#mobile").removeAttr("readonly");	//启用按钮
                    $("#get_code").removeAttr("disabled");	//启用按钮
                    $("#get_code").html("重新发送验证码");
                } else {
                    curCount--;
                    $("#get_code").attr("disabled", "true");
                    $("#get_code").html("重新发送" + curCount + "(s)");
                }
            };
            $('.unset_SetRemain').on('click', function () {
                window.clearInterval(InterValObj);
            })
        }

    };
})(ecjia.merchant, jQuery);

//end