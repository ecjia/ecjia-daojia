// JavaScript Document
;(function (app, $) {
    app.store_list = {
        init: function () {
            //搜索功能
            $("form[name='searchForm'] .search_store").on('click', function (e) {
                e.preventDefault();
                var url = $("form[name='searchForm']").attr('action') + '&keywords=' + $("input[name='keywords']").val();
                ecjia.pjax(url);
            });
        }
    };

    app.store_edit = {
        init: function () {
        	app.store_edit.get_longitude();
        	app.store_edit.gethash();
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
					submitHandler : function() {
						$form.ajaxSubmit({
							dataType : "json",
							success : function(data) {
								ecjia.admin.showmessage(data);
							}
						});
					}
				}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$form.validate(options);
        },

        get_longitude: function() {
        	$('.longitude').on('click', function(e) {
    			e.preventDefault();
    			var address		    = $("input[name='address']").val(); //详细地址
    			var url				= $(".longitude").attr('data-url'); //请求链接
    			if(address	    	== 'undefined')address ='';
    			if(url        		== 'undefined')url ='';
    			var filters = {
						'detail_address': address,
				};
    			$.post(url, filters, function(data) {
					var longitude = data.content.longitude;
					var latitude  = data.content.latitude;
					var geohash   = data.content.geohash;
					$('.long').text(longitude);
					$('.latd').text(latitude);
					//$('.geo').append(geohash);
				}, "JSON");
    		});
        },

        gethash : function(){
            $('[data-toggle="get-gohash"]').on('click',function(e){
                e.preventDefault();
                var province = $('select[name="province"]').val(),
                    city = $('select[name="city"]').val(),
                    district = $('select[name="district"]').val(),
                    address = $('input[name="address"]').val(),
                    url = $(this).attr('data-url');

                    var option = {
                        'province' :　province,
                        'city' :　city,
                        'district' :　district,
                        'address' : address,
                    }
                    $.post(url, option, app.store_edit.sethash, "JSON");
            })
        },

        sethash : function(location){
            if(location.state =='error'){
                if(location.element == 'address'){
                    $('input[name="address"]').focus();
                    $('input[name="address"]').parents('.form-group').addClass('f_error');
                }else{
                    $('.form-address').addClass('error');
                }
                ecjia.admin.showmessage(location);
            }else{
                $('.localtion-address').removeClass('hide');
                var map = new BMap.Map("allmap");
                var point = new BMap.Point(location.lng, location.lat);  // 创建点坐标
                $('input[name="longitude"]').val(location.lng);
                $('input[name="latitude"]').val(location.lat);
                map.centerAndZoom(point,15);
                map.enableScrollWheelZoom();
                var marker = new BMap.Marker(point);  // 创建标注
            	map.addOverlay(marker);               // 将标注添加到地图中
                map.addEventListener("click",function(e){
                    map.removeOverlay(marker);
                    $('input[name="longitude"]').val(e.point.lng)
                    $('input[name="latitude"]').val(e.point.lat)
                    point = new BMap.Point(e.point.lng, e.point.lat);
                    marker = new BMap.Marker(point)
                    map.addOverlay(marker);
                });
            }
        }
    };
    app.store_lock = {
        init: function () {
    		var $form = $("form[name='theForm']");
			var option = {
					submitHandler : function() {
						$form.ajaxSubmit({
							dataType : "json",
							success : function(data) {
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
