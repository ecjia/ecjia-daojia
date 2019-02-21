// JavaScript Document
; (function (app, $) {
	app.store_edit = {
		init: function () {
			app.store_edit.get_longitude();
			app.store_edit.gethash();
			app.store_edit.range();
			
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
		},

		get_longitude: function () {
			$('.longitude').on('click', function (e) {
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
			$('[data-toggle="get-gohash"]').on('click', function (e) {
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
		
        range : function(){
            $('.range-slider').jRange({
                from: 0, to: 2880, step:30,
                scale: ['00:00','04:00','08:00','12:00','16:00','20:00',js_lang.next_day+ ':00','04:00','08:00','12:00','16:00','20:00','24:00'],
                format: app.store_edit.formatTimeLabelFunc,
                width: 600,
                showLabels: true,
                isRange : true
            });
        },
        
		formatTimeLabelFunc:function(value, type) {
        	var hours = String(value).substr(0,2);
        	var mins = String(value).substr(3,2);

        	if (hours > 24) {
        		hours = hours - 24;
        		hours = (hours < 10 ? "0"+hours : hours);
        		value = hours+':'+mins;
        		var text = String(js_lang.next_day + '%s').replace('%s', value);
        		return text;
        	}
        	else {
        		return value;
        	}
        },
	};
})(ecjia.admin, jQuery);

// end
