// JavaScript Document

;(function(app, $) {
	app.express = {
		info : function() {
			app.express.expressForm();
			app.express.choose_area();
			app.express.selected_area();
			app.express.quick_search();
			app.express.delete_area();
			app.express.close_model();
			app.express.add_shipping();
			app.express.shippingForm();
			app.express.tpicker();
			app.express.datepicker();
			$('.modal-backdrop').remove();
			
		},
		expressForm : function() {
			$("form[name='expressForm']").on('submit', function(e){
				e.preventDefault();
				$(this).ajaxSubmit({
					dataType:"json",
					success:function(data){
						ecjia.merchant.showmessage(data);
					}
				});
			});
			
            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                	template_name: {
                        required: true,
                    }
                },
                messages: {
                	template_name: {
                        required: '请填写模板名称',
                    }
                },
                submitHandler: function () {
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                        	ecjia.merchant.showmessage(data);
                        	return false;
                        }
                    });
                }
            }
            var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
            $form.validate(options);
		},
		
		choose_area: function () {
            $('.ms-elem-selectable').off('click').on('click', function (e) {
                e.preventDefault();
                var $this = $(this),
                    val = $this.attr('data-val'),
                    url = $this.parent().attr('data-url'),
                    $next = $('.' + $this.parent().attr('data-next'));
                	$next_attr = $this.parent().attr('data-next');
                /* 如果是县乡级别的，不触发后续操作 */
                if ($this.parent().hasClass('selStreets')) {
                    $this.siblings().removeClass('disabled');
                    if (val != 0) $this.addClass('disabled');
                    return;
                }
                /* 如果是0的选项，则后续参数也设置为0 */
                if (val == 0) {
                    var $tmp = $('<li class="ms-elem-selectable" data-val="0"><span>没有可选择的地区</span></li>');
                    $next.html($tmp);
                    $tmp.trigger('click');
                    return;
                }
                /* 请求参数 */
                $.get(url, {
                    parent: val
                }, function (data) {
                    $this.siblings().removeClass('disabled');
                    $this.addClass('disabled');
                    var html = '';
                    /* 如果有返回参数，则赋值并触发下一级别的选中 */
                    if (data.regions) {
                    	var region = [];
	                	$('.select-region li').each(function() {
	                		region.push($(this).find('input').val());
	                	});
	                	for (var i = 0; i <= data.regions.length - 1; i++) {
	                		html += '<li class="ms-elem-selectable select_hot_city" data-val="' + data.regions[i].region_id + '"><span>' +
                            data.regions[i].region_name + '</span>';
	                		var region_id = data.regions[i].region_id;
	                		var index = $.inArray(region_id, region);
	                		var hide_add = '<a class="ecjiaf-dn" href="javascript:;">添加</a></span>';
	                		var show_add = '<a href="javascript:;">添加</a></span>';
	                		
	                		if ($next_attr == 'selCities') {
	                			html += '<span class="edit-list">';
                          	}
                        	if ($next_attr == 'selDistricts') {
                             	html += '<span class="edit-list">';
                            }
                            if ($next_attr == 'selStreets') {
                                html += '<span class="edit-list">';
                            }
                            if (index == -1) {
                				html += show_add;
                			} else {
                				html += hide_add;
                			}
                            html += '</li>';
                          };
                        $next.html(html);
                        app.express.quick_search();
                        app.express.choose_area();
                        app.express.selected_area();
                    } else {
                        var $tmp = $('<li class="ms-elem-selectable" data-val="0"><span>没有可选择的地区</span></li>');
                        $next.html($tmp);
                        $tmp.trigger('click');
                        return;
                    }
                }, 'json');
            });
        },
 
        selected_area: function () {
            $('.ms-elem-selectable .edit-list a').off('click').on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var bool = true;
                var $this = $(this),
                    $parent = $this.parents('li.ms-elem-selectable'),
                    val = $parent.attr('data-val'),
                    name = $parent.find('span').eq(0).text(),
                    $tmp = $('<li><input type="hidden" value="' + val + '" name="regions[]" id="regions_' + val + '"/>'+ name +'<span class="delete_area">x</span></li>');
                $('.select-region input').each(function (i) {
                    if ($(this).val() == val) {
                        bool = false;
                        return false;
                    }
                });
                if (bool) {
                	$this.hide();
                    $('.select-region').append($tmp);
                    app.express.delete_area();
                }
            });
        },
 
        quick_search: function () {
            var opt = {
                onAfter: function () {
                    $('.ms-group').each(function (index) {
                        $(this).find('.isShow').length ? $(this).css('display', 'block') : $(this).css('display', 'none');
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
            };
            $('#selCountry').quicksearch($('.selCountry .ms-elem-selectable'), opt);
            $('#selProvinces').quicksearch($('.selProvinces .ms-elem-selectable'), opt);
            $('#selCities').quicksearch($('.selCities .ms-elem-selectable'), opt);
            $('#selDistricts').quicksearch($('.selDistricts .ms-elem-selectable'), opt);
            $('#selStreets').quicksearch($('.selStreets .ms-elem-selectable'), opt);
        },
        
        delete_area: function() {
        	$('.delete_area').off('click').on('click', function() {
        		var $this = $(this);
        		var val = $this.parent('li').find('input').val();
        		$('.ms-elem-selectable').each(function() {
        			if ($(this).attr('data-val') == val) {
        				$(this).find('a').show();
        			}
        		});
        		$this.parent('li').remove();
        	});
        },
        
        close_model: function() {
        	$('#chooseRegion').on('show.bs.modal', function () {
        		var child = $('.content-area-list').html();
        		var length = $('.content-area-list').find('li').length;
        		if (length > 0) {
            		$('.select-region').html('').html(child);
            		var region = [];
            		$('.select-region li').each(function() {
            			$(this).append('<span class="delete_area">x</span>');
            			region.push($(this).find('input').val());
            		});
            		app.express.delete_area();
            		
            		$('.ms-elem-selectable').each(function() {
            			var val = $(this).attr('data-val');
            			var index = $.inArray(val, region);
            			if (index != -1) {
            				$(this).find('a').hide();
            			}
            		});
        		} else {
        			$('.ms-elem-selectable').each(function() {
            			$(this).find('a').show();
            		});
        		}
        	});
        		
        	$('.close_model').off('click').on('click', function() {
        		var $this = $(this);
        		var region = $('.select-region').children();
        		if (region.length > 0) {
        			$('.add_area').hide();
        			$('.content-area').show();
        			$('.content-area-list').show();
        			$('.content-area-list').html(region);
        			$('.content-area-list').find('.delete_area').remove();
        		} else {
        			$('.add_area').show();
        			$('.content-area').hide();
        			$('.content-area-list').hide();
        			$('.content-area-list').html('');
        		}
        	});
        	
        	$('.reset_region').off('click').on('click', function() {
				$('.add_area').show();
    			$('.content-area').hide();
    			$('.content-area-list').hide();
    			$('.content-area-list').html('');
        	});
        },
        
        add_shipping: function() {
        	$('select[name="shipping_id"]').off('change').on('change', function() {
        		$('.modal-content').find('.staticalert').remove();
        		$('#shipping_info').html('');
        		var $this = $(this),
        			val = $this.val(),
        			url = $this.attr('data-url');
        		var shipping_item = $('.template-info-item').find('.shipping-item-' + val);
        		if (val > 0) {
        			var shipping_area_id = $('input[name="shipping_area_id"]').val();
        			var shipping = $('input[name="shipping"]').val();
        			$.post(url, {'shipping_id': val, 'shipping_area_id': shipping_area_id, 'shipping': shipping}, function(data) {
        				$('#shipping_info').append(data.content);
        				app.express.area_compute_mode();
        				app.express.datepicker();
        				app.express.tpicker();
        				app.express.shippingForm();
        			});
        		}
        	});
        	
        	$('.add_shipping').off('click').on('click', function() {
        		var template_name = $('input[name="temp_name"]').val();
        		if (template_name == '') {
        			smoke.alert('请输入模板名称');
        			return false;
        		}
        		
        		var length = $('.content-area-list').find('input').length;
        		if (length == 0) {
        			smoke.alert('请选择地区');
        			return false;
        		}
        		clearForm();
        		$('.add-shipping-btn').attr('data-type', 'add');
        		$('form[name="shippingForm"]').find('input[name="regions[]"]').remove();
        		
        		var shipping_name = $('form[name="theForm"]').find('input[name="temp_name"]').val();
            	$('form[name="shippingForm"]').find('input[name="temp_name"]').val(shipping_name);
            	$('form[name="shippingForm"]').find('input[name="shipping_area_id"]').val(0);
            	
            	var $temp = $('form[name="theForm"]').find('input[name="regions[]"]');
            	$('form[name="shippingForm"]').append($temp.clone(true));
            	
        		$('#addShipping').modal('show');
        	});
        	
        	$('.remove_shipping').off('click').on('click', function() {
        		var message = '您确定要删除该快递方式吗？';
        		var $this = $(this);
				smoke.confirm(message, function(e) {
					if (e) {
						$this.parents('.info-shipping-item').remove();
					}
				}, {ok:"确定", cancel:"取消"});
        	});
        	
        	$('.edit_shipping').off('click').on('click', function() {
        		var length = $('.content-area-list').find('input').length;
        		if (length == 0) {
        			smoke.alert('请选择地区');
        			return false;
        		}
        		
        		var $this = $(this),
        			shipping_id = $this.attr('data-shipping'),
        			shipping_area_id = $this.attr('data-area');
        		$('.add-shipping-btn').attr('data-type', 'edit');
        		$('form[name="shippingForm"]').find('input[name="regions[]"]').remove();
        		
        		var shipping_name = $('form[name="theForm"]').find('input[name="temp_name"]').val();
            	$('form[name="shippingForm"]').find('input[name="temp_name"]').val(shipping_name);
        		$('form[name="shippingForm"]').find('input[name="shipping_area_id"]').val(shipping_area_id);
        		$('form[name="shippingForm"]').find('input[name="shipping"]').val(shipping_id);
        		
        		var $temp = $('form[name="theForm"]').find('input[name="regions[]"]');
            	$('form[name="shippingForm"]').append($temp.clone(true));
            	
            	$('select[name="shipping_id"] option[value='+ shipping_id +']').attr('selected', true);
        		$('select[name="shipping_id"]').trigger("liszt:updated").trigger("change");
        		
        		$('#addShipping').modal('show');
        	});
        },
        
        /* 配送费用计算方式 */
        area_compute_mode: function () {
        	$('input[name="fee_compute_mode"]').off('click').on('click', function() {
        		var base_fee = document.getElementById("base_fee");
                var step_fee = document.getElementById("step_fee");
                var item_fee = document.getElementById("item_fee");
                var $this = $(this),
                	shipping_code = $this.attr('data-code'),
                 	mode = $this.val();
                
                if (shipping_code == 'ship_post_mail' || shipping_code == 'ship_post_express') {
                    var step_fee1 = document.getElementById("step_fee1");
                }
                if (mode == 'by_number') {
                    item_fee.style.display = '';
                    base_fee.style.display = 'none';
                    step_fee.style.display = 'none';
                    $('#item_fee').find('input').removeAttr('disabled');
                    $('#base_fee').find('input').attr('disabled', true);
                   	$('#step_fee').find('input').attr('disabled', true);
                    if (shipping_code == 'ship_post_mail' || shipping_code == 'ship_post_express') {
                    	step_fee1.style.display = 'none';
                    	$('#step_fee1').find('input').attr('disabled', true);
                    }
                } else {
                  	item_fee.style.display = 'none';
                   	base_fee.style.display = '';
                   	step_fee.style.display = '';
                   	$('#item_fee').find('input').attr('disabled', true);
                   	$('#base_fee').find('input').removeAttr('disabled');
                   	$('#step_fee').find('input').removeAttr('disabled');
                    if (shipping_code == 'ship_post_mail' || shipping_code == 'ship_post_express') {
                    	step_fee1.style.display = '';
                    	$('#step_fee1').find('input').removeAttr('disabled');
                    }
              	}
        	});
        },
        
        shippingForm: function () {
            var $form = $("form[name='shippingForm']");
            var option = {
                rules: {
                	shipping_id: {
                        required: true,
                        min: 0
                    },
                    base_fee: {
                    	min: 0
                    },
                    step_fee: {
                    	min: 0
                    },
                    free_money: {
                    	min: 0
                    },
                    pay_fee: {
                    	min: 0
                    },
                    item_fee: {
                    	min: 0
                    }
                },
                messages: {
                	shipping_id: {
                        required: '请选择快递方式',
                        min: '请选择快递方式'
                    },
                    base_fee: {
                    	min: '请输入正确的价格格式',
                    },
                    step_fee: {
                    	min: '请输入正确的价格格式',
                    },
                    free_money: {
                    	min: '请输入正确的价格格式',
                    },
                    pay_fee: {
                    	min: '请输入正确的价格格式',
                    },
                    item_fee: {
                    	min: '请输入正确的价格格式',
                    }
                },
                submitHandler: function () {
                	var val = $('select[name="shipping_id"]').val();
                	var type = $('.add-shipping-btn').attr('data-type');
                	var shipping_item = $('.template-info-item').find('.shipping-item-' + val);
        			
                	if (type == 'add') {
             			if (shipping_item.length > 0) {
             				var data = {
                                message : "该快递方式已存在",
                                state : "error",
                            };
             				app.express.showmessage(data);
             				return false;
             			}
             		}
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                        	if (data.state == 'error') {
                        		app.express.showmessage(data);
                        	} else {
                        		$('#addShipping').modal('hide');
                                ecjia.merchant.showmessage(data);
                        	}
                        	return false;
                        }
                    });
                }
            }
            var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
            $form.validate(options);
        },
        
        datepicker: function(){
			$.fn.datetimepicker.dates['zh'] = {  
                days:       ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六","星期日"],  
                daysShort:  ["日", "一", "二", "三", "四", "五", "六","日"],  
                daysMin:    ["日", "一", "二", "三", "四", "五", "六","日"],  
                months:     ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月","十二月"],  
                monthsShort:  ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月","十二月"], 
                meridiem:    ["上午", "下午"],  
                today:       "今天"  
	        };
            $(".tp_1").datetimepicker({
				format: "hh:ii",
				language: 'zh',
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 1,
                forceParse: 0,
                minuteStep: 5
			});
        },
        
        tpicker: function () {
			$('.fontello-icon-plus').off('click').on('click', function(e) {
				setTimeout(function () { 
					app.express.datepicker();
			    });
			});
		},
		
		showmessage: function(options) {
			options.state = (options.state == 'error')? 'alert-danger': 'alert-success';
			$('.modal-content').find('.staticalert').remove();
			var _close = '<a class="close" data-dismiss="alert">×</a>';
			var alert_obj = $('<div class="staticalert alert alert-dismissable ' + options.state + ' ui_showmessage">' + _close + options.message + '</div>');
			$('.modal-header').after(alert_obj);
			window.setTimeout(function() {alert_obj.remove()}, 5000);
		}
	}
	
	function clearForm() {
		$('select[name="shipping_id"] option').eq(0).attr("selected", true);
		$('select[name="shipping_id"]').trigger("liszt:updated").trigger("change");
		$('#shipping_info').html('');
	};

	
})(ecjia.merchant, jQuery);

// end