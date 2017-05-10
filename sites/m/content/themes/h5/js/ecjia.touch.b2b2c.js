;
(function(ecjia, $) {
	ecjia.touch.b2b2c = {
		init: function() {
			ecjia.touch.b2b2c.shop_attention();
			ecjia.touch.b2b2c.address_change();
			ecjia.touch.b2b2c.warehouse();
			ecjia.touch.b2b2c.area_change();
			ecjia.touch.b2b2c.area_change()
		},
		shop_attention: function() {
			$("[data-toggle='is_attention']").on("click", function() {
				var $this = $(this),
					url = $this.attr('data-url'),
					is_attention = $this.attr('data-is_attention'),
					pjaxurl = $this.attr('data-pjaxurl'),
					ru_id = $this.attr('value');
				if (!ru_id || !url) {
					alert('缺少必要的参数')
				} else {
					$.get(url, {
						ru_id: ru_id,
						pjaxurl: pjaxurl,
						is_attention: is_attention
					}, function(data) {
						ecjia.touch.showmessage(data)
					}, 'json')
				}
			})
		},
		address_change: function() {
			$('select[id="selCities"]').on('change', function() {
				$('select[id="selDistricts"]').change()
			});
			$('select[id="selDistricts"]').on('change', function() {
				$('[data-toggle="warehouse"]').change()
			});
			$('[data-toggle="region_change"][id="selProvinces"]').change()
		},
		area_change: function() {
			$('[data-toggle="region_change"]').on('change', function() {
				var $this = $(this),
					id = $this.attr("id"),
					url = $this.attr("data-url"),
					type = $this.attr("data-type"),
					target = $this.attr("data-target"),
					check = $this.attr("data-city"),
					parent = $this.val();
				if ($("#selCountries").val() == 0) {
					$("#selProvinces").children("option:gt(0)").remove();
					$("#selCities").children("option:gt(0)").remove();
					$("#selDistricts").children("option:gt(0)").remove();
					$("#selDistricts").hide()
				} else {
					if (id == "selCountries") {
						$("#selDistricts").hide()
					} else if (id == "selProvinces") {
						$("#selDistricts").hide();
						if ($("#selProvinces").val() == 0) {
							$("#selCities").children("option:gt(0)").remove()
						}
					} else if (id == "selCities") {
						$("#selDistricts").show();
						if ($("#selCities").val() == 0) {
							$("#selDistricts").children("option:gt(0)").remove()
						}
					}
					$.get(url, {
						'type': type,
						'target': target,
						'parent': parent,
						'checked': check
					}, function(data) {
						if (data.state == 'success') {
							var opt = '';
							if (data.regions) {
								for (var i = 0; i < data.regions.length; i++) {
									if (data.check) {
										if (data.regions[i].region_id == data.check) {
											opt += '<option value="' + data.regions[i].region_id + '" selected="selected">' + data.regions[i].region_name + '</option>'
										} else {
											opt += '<option value="' + data.regions[i].region_id + '">' + data.regions[i].region_name + '</option>'
										}
									} else {
										if (i == 0) {
											opt += '<option value="' + data.regions[i].region_id + '" selected="selected">' + data.regions[i].region_name + '</option>'
										} else {
											opt += '<option value="' + data.regions[i].region_id + '">' + data.regions[i].region_name + '</option>'
										}
									}
								}
								if (id == "selCountries") {
									$("#selProvinces").children("option:gt(0)").remove();
									$("#selProvinces").children("option").after(opt)
								} else if (id == "selProvinces") {
									$("#selCities").children("option:gt(0)").remove();
									$("#selCities").children("option").after(opt);
									$('[data-target="selDistricts"][id="selCities"]').change()
								} else if (id == "selCities") {
									$("#selDistricts").children("option:gt(0)").remove();
									$("#selDistricts").children("option").after(opt)
								}
							}
						} else {
							ecjia.touch.showmessage(data)
						}
					}, 'json')
				}
			})
		},
		warehouse: function() {
			$('[data-toggle="warehouse"]').on('change', function() {
				var $this = $(this),
					url = $this.attr('data-url'),
					id = $this.attr('data-id'),
					house = $('select[name="region_id"]').val(),
					province = $('select[id="selProvinces"]').val();
				if (!url || !id) {
					alert('缺少必要参数');
					return
				}
				$.get(url, {
					'id': id,
					'house': house,
					'region_id': province
				}, function(data) {
					if (data.state == 'success') {
						$('#ECS_GOODS_AMOUNT').html(data.goods.goods_price);
						$('.goods-promote-price').html(data.goods.goods_price);
						$('#shop_goods_number').html(data.goods.goods_number);
						if (data.goods.goods_number > 0) {
							$('.goods_show').hide();
							$('.goodsnumber-show-btn').show();
							$('.goodsnumber-none-btn').hide()
						} else {
							$('.goods_show').show();
							$('.goodsnumber-none-btn').show();
							$('.goodsnumber-show-btn').hide()
						}
					}
				}, 'json')
			})
		},
	}
})(ecjia, jQuery);

//end