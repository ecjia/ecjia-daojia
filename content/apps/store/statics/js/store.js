// JavaScript Document
; (function (app, $) {
	app.store_list = {
		init: function () {
			//搜索功能
			$("form[name='searchForm'] .search_store").on('click', function (e) {
				e.preventDefault();
				var url = $("form[name='searchForm']").attr('action') + '&keywords=' + $("input[name='keywords']").val()+ '&cat_id=' + $("select[name='cat_id']").val();
				ecjia.pjax(url);
			});
			app.store_list.toggle_view();
		},
		toggle_view : function (option) {
			$('.toggle_view').on('click', function (e) {
				e.preventDefault();
				var $this = $(this);
				var href = $this.attr('href');
				var val = $this.attr('data-val') || 'allow';
				var option = {href : href, val : val};
				var url = option.href;
				var val = {check:option.val}
				var msg = $this.attr("data-msg");
				if (msg) {
					smoke.confirm( msg , function(e){
						if (e) {
							$.get(url, val, function(data){
								var url = $this.attr("data-pjax-url");
								ecjia.pjax(url , function(){
									ecjia.admin.showmessage(data);
								});
							},'json');
						}
					}, {ok:'确定', cancel:'取消'});
				} else {
					$.get(url, val, function(data){
						var url = $this.attr("data-pjax-url");
						ecjia.pjax(url , function(){
							ecjia.admin.showmessage(data);
						});
					},'json');
				}
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
					url = $(this).attr('data-url');

				var option = {
					'province': province,
					'city': city,
					'district': district,
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
		}
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
