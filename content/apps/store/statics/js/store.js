// JavaScript Document
;(function (app, $) {
    app.store_list = {
        init: function () {
            //搜索功能
            $("form[name='searchForm'] .search_store").off('click').on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action'),
                    keywords = $("input[name='keywords']").val(),
                    cat_id = $("select[name='cat_id']").val();
                if (keywords != '' && keywords != undefined) {
                    url += '&keywords=' + keywords;
                }
                if (cat_id != '' && cat_id != undefined) {
                    url += '&cat_id=' + cat_id;
                }
                ecjia.pjax(url);
            });
            app.store_list.toggle_view();
            app.store_list.delete();
        },
        toggle_view: function (option) {
            $('.toggle_view').off('click').on('click', function (e) {
                e.preventDefault();
                var $this = $(this);
                var href = $this.attr('href');
                var val = $this.attr('data-val') || 'allow';
                var option = {href: href, val: val};
                var url = option.href;
                var val = {check: option.val}
                var msg = $this.attr("data-msg");
                if (msg) {
                    smoke.confirm(msg, function (e) {
                        if (e) {
                            $.get(url, val, function (data) {
                                var url = $this.attr("data-pjax-url");
                                ecjia.pjax(url, function () {
                                    ecjia.admin.showmessage(data);
                                });
                            }, 'json');
                        }
                    }, {ok: js_lang.ok, cancel: js_lang.cancel});
                } else {
                    $.get(url, val, function (data) {
                        var url = $this.attr("data-pjax-url");
                        ecjia.pjax(url, function () {
                            ecjia.admin.showmessage(data);
                        });
                    }, 'json');
                }
            });
        },

        delete: function () {
            $('.delete_confirm').off('click').on('click', function (e) {
                e.preventDefault();
                var $this = $(this),
                    msg = $this.attr('data-msg'),
                    url = $this.attr('href');

                smoke.confirm(msg, function (e) {
                    if (e) {
                        $.post(url, function (data) {
                            if (data.state == 'success') {
                                ecjia.admin.showmessage(data);
                                window.setTimeout(function () {
                                    window.location.href = data.url;
                                }, 1000);
                            } else {
                                ecjia.admin.showmessage(data);
                            }
                        });
                    }
                }, {ok: js_lang.ok, cancel: js_lang.cancel});
            });

            $('[data-toggle="store_ajaxremove"]').off('click').on('click', function (e) {
                e.preventDefault();
                var $this = $(this),
                    msg = $this.attr('data-msg'),
                    confirm = $this.attr('data-confirm'),
                    url = $this.attr('href');
                smoke.confirm(msg, function (f) {
                    if (f) {
                        smoke.confirm(confirm, function (g) {
                            if (g) {
                                $.post(url, function (data) {
                                    ecjia.admin.showmessage(data);
                                });
                            }
                        }, {ok: store_js_lang.ok, cancel: store_js_lang.cancel});
                    }
                }, {ok: store_js_lang.ok, cancel: store_js_lang.cancel});
            });

            $('[data-toggle="store_ajaxduplicate"]').off('click').on('click', function (e) {
                e.preventDefault();
                var $this = $(this),
                    url = $this.attr('href');

                $.post(url, function (data) {
                    ecjia.admin.showmessage(data);
                });
            });
        },
    };

    app.store_edit = {
        init: function () {
            app.store_edit.get_longitude();
            app.store_edit.gethash();

            $(".date").datepicker({
                format: "yyyy-mm-dd",
                container: '.main_content',
            });
            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                    identity_type: {
                        required: true,
                        min: 1
                    },
                },
                messages: {
                    identity_type: {
                        min: ''
                    },
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


            //地图弹窗
            $("a[data-toggle='modal']").off('click').on('click', function (e) {
                var $this = $(this);
                var lng = $this.attr('exlng');
                var lat = $this.attr('exlat');
                var name = $this.attr('exname');
                var adddress = $this.attr('data-address');

                //腾讯地图加载
                var map, markersArray = [];
                var latLng = new qq.maps.LatLng(lat, lng);
                var map = new qq.maps.Map(document.getElementById("allmap"), {
                    center: latLng,
                    zoom: 18
                });

                //创建一个Marker(自定义图片)
                var marker = new qq.maps.Marker({
                    position: latLng,
                    map: map
                });

                //设置Marker自定义图标的属性，size是图标尺寸，该尺寸为显示图标的实际尺寸，origin是切图坐标，该坐标是相对于图片左上角默认为（0,0）的相对像素坐标，anchor是锚点坐标，描述经纬度点对应图标中的位置
                var anchor = new qq.maps.Point(0, 39),
                    size = new qq.maps.Size(40, 40),
                    origin = new qq.maps.Point(0, 0),
                    icon = new qq.maps.MarkerImage(
                        "content/apps/store/statics/images/map_marker.png",
                        size,
                        origin,
                        anchor
                    );
                marker.setIcon(icon);

                //创建描述框,https://lbs.qq.com/javascript_v2/doc/overlay.html
                var Label = function (opts) {
                    qq.maps.Overlay.call(this, opts);
                }
                //继承Overlay基类
                Label.prototype = new qq.maps.Overlay();
                //定义construct,实现这个接口来初始化自定义的Dom元素
                Label.prototype.construct = function () {
                    this.dom = document.createElement('div');
                    this.dom.style.cssText =
                        'background-color:#0087CB;width:300px;height:auto;position:absolute;' +
                        'text-align:left;color:white;padding:8px 20px;border-radius:10px;';
                    this.dom.innerHTML = name + '<br>' + adddress;
                    //将dom添加到覆盖物层，overlayLayer的顺序为容器 1，此容器中包含Polyline、Polygon、GroundOverlay等
                    this.getPanes().overlayLayer.appendChild(this.dom);

                }
                //绘制和更新自定义的dom元素
                Label.prototype.draw = function () {
                    //获取地理经纬度坐标
                    var position = this.get('position');
                    if (position) {
                        //根据经纬度坐标计算相对于地图外部容器左上角的相对像素坐标
                        //var pixel = this.getProjection().fromLatLngToContainerPixel(position);
                        //根据经纬度坐标计算相对于地图内部容器原点的相对像素坐标
                        var pixel = this.getProjection().fromLatLngToDivPixel(position);
                        this.dom.style.left = pixel.getX() + 'px';
                        this.dom.style.top = pixel.getY() + 'px';
                    }
                }

                Label.prototype.destroy = function () {
                    //移除dom
                    this.dom.parentNode.removeChild(this.dom);
                }
                var label = new Label({
                    map: map,
                    position: latLng
                });
            })
        },

        get_longitude: function () {
            $('.longitude').off('click').on('click', function (e) {
                e.preventDefault();
                var address = $("input[name='address']").val(); //详细地址
                var url = $(".longitude").attr('data-url'); //请求链接
                if (address == 'undefined') address = '';
                if (url == 'undefined') url = '';
                var filters = {
                    'detail_address': address,
                };
                $.post(url, filters, function (data) {
                    var longitude = data.content.longitude;
                    var latitude = data.content.latitude;
                    var geohash = data.content.geohash;
                    $('.long').text(longitude);
                    $('.latd').text(latitude);
                }, "JSON");
            });
        },

        gethash: function () {
            $('[data-toggle="get-gohash"]').off('click').on('click', function (e) {
                e.preventDefault();
                var province = $('select[name="province"]').val(),
                    city = $('select[name="city"]').val(),
                    district = $('select[name="district"]').val(),
                    address = $('input[name="address"]').val(),
                    street = $('select[name="street"]').val(),
                    url = $(this).attr('data-url');

                var option = {
                    'province': province,
                    'city': city,
                    'district': district,
                    'street': street,
                    'address': address,
                }
                $.post(url, option, app.store_edit.sethash, "JSON");
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
                ecjia.admin.showmessage(location);
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
    };
    app.store_lock = {
        init: function () {
            var $form = $("form[name='theForm']");
            var option = {
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
    };
})(ecjia.admin, jQuery);

// end