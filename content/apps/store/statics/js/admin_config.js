// JavaScript Document
;(function(app, $) {
	app.admin_config = {
		init : function() {
            $("[data-toggle='popover']").popover({ 
            	html: true,
	    		content: function() {
	    			return $("#content_1").html();
	    		},
    		});
			app.admin_config.submit_form();
			app.admin_config.edit();
			app.admin_config.del_link_store();
			app.admin_config.choose_area();
			app.admin_config.quick_search();
	        app.admin_config.selected_area();
			
		},
		submit_form : function() {
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
		
		edit: function() {
			$('input[name="store_model"]').on('click', function() {
				var $this = $(this),
					val = $this.val();
				$('.mode').hide();
				if (val != 0) {
					$('.search_content').show();
				} else {
					$('.search_content').hide();
				}
				$('.mode_' + val).show();
			});
			
			$('.search-store').on('click', function() {
				var url = $('.controls.search').attr('data-url'),
					cat_id = $('select[name="cat_id"]').val(),
					keywords = $('input[name="keywords"]').val(),
					store_model = $('input[name="store_model"]:checked').val();
					
				var info = {
					cat_id: cat_id,
					keywords: keywords
				}
				$.post(url, info, function(data) {
					if (data.length == 0) {
						return false;
					}
					if (store_model == 1) {
						$('.store_list').html('');
						if (data.content.length > 0) {
							for (var i = 0; i < data.content.length; i++) {
								var opt = '<option value="'+data.content[i].store_id+'">'+data.content[i].merchants_name+'</option>'
								$('.store_list').append(opt);
							};
						} else {
							$('.store_list').append('<option value="-1">未搜索到店铺信息</option>');
						}
						$('.store_list').trigger("liszt:updated").trigger("change");
					} else if (store_model == 2) {
						$('.nav-list-ready').html('');
						if (data.content.length > 0) {
							for (var i = 0; i < data.content.length; i++) {
								var disable = $('.nav-list-content .ms-elem-selection').find('input[value="' + data.content[i].store_id + '"]').length ? 'disabled' : '';
								var opt = '<li class="ms-elem-selectable ' + disable + '" id="store_id_' + data.content[i].store_id + '" data-id="' + data.content[i].store_id + '"><span>' + data.content[i].merchants_name + '</span></li>'
								$('.nav-list-ready').append(opt);
							};
						} else {
							$('.nav-list-ready').html('<li class="ms-elem-selectable disabled"><span>未搜索到店铺信息</span></li>');
						}
						app.admin_config.add_link_store();
					}
				});
			});
		},

		add_link_store: function() {
			$('.nav-list-ready li').on('click', function() {
				var $this = $(this),
					tmpobj = $('<li class="ms-elem-selection"><input type="hidden" name="store_id[]" value="' + $this.attr('data-id') + '" />' + $this.text() + '<span class="edit-list"><i class="fontello-icon-minus-circled ecjiafc-red del"></i></span></li>');
				if (!$this.hasClass('disabled')) {
					tmpobj.appendTo($(".ms-selection .nav-list-content"));
					$this.addClass('disabled');
				}
				//给新元素添加点击事件
				tmpobj.on('dblclick', function() {
					$this.removeClass('disabled');
					tmpobj.remove();
				}).find('i.del').on('click', function() {
					tmpobj.trigger('dblclick');
				});
			});
		},
		
		del_link_store: function() {
			//给右侧元素添加点击事件
			$('.nav-list-content .ms-elem-selection').on('dblclick', function() {
				var $this = $(this);
				$(".nav-list-ready li").each(function(index) {
					if ($(".nav-list-ready li").eq(index).attr('id') == 'store_id_' + $this.find('input').val()) {
						$(".nav-list-ready li").eq(index).removeClass('disabled');
					}
				});
				$this.remove();
			}).find('i.del').on('click', function() {
				$(this).parents('li').trigger('dblclick');
			});
		},
		
        choose_area: function () {
            $('.select_hot_city').off('click').on('click', function (e) {
                e.preventDefault();
                var $this = $(this),
                    val = $this.attr('data-val'),
                    url = $this.parent().attr('data-url'),
                    $next = $('.' + $this.parent().attr('data-next'));
                    $next_attr = $this.parent().attr('data-next');
                /* 如果是县乡级别的，不触发后续操作 */
                if ($this.parent().hasClass('selTown')) {
                    $this.siblings().removeClass('disabled');
                    if (val != 0) $this.addClass('disabled');
                    return;
                }
                /* 如果是0的选项，则后续参数也设置为0 */
                if (val == 0) {
                    var $tmp = $('<li class="ms-elem-selectable" data-val="0"><span>' + js_lang.no_select_region + '</span></li>');
                    $next.html($tmp);
                    $tmp.trigger('click');
                    return;
                }
                /* 请求参数 */
                $.get(url, {parent: val}, function (data) {
                    $this.siblings().removeClass('disabled');
                    $this.addClass('disabled');
                    var html = '';
                    /* 如果有返回参数，则赋值并触发下一级别的选中 */
                    if (data.regions) {
                        for (var i = 0; i <= data.regions.length - 1; i++) {
                            html += '<li class="ms-elem-selectable select_hot_city" data-val="' + data.regions[i].region_id + '"><span>' +
                            	data.regions[i].region_name + '</span>';
                            if ($next_attr == 'selCities') {
                                html += '<span class="edit-list"><a href="javascript:;">' + js_lang.add + '</a></span>';
                            }
                            if ($next_attr == 'selDistricts') {
                                html += '<span class="edit-list"><a href="javascript:;">' + js_lang.add + '</a></span>';
                            }
                            if ($next_attr == 'selTown') {
                                html += '<span class="edit-list"><a href="javascript:;">' + js_lang.add + '</a></span>';
                            }
                            html += '</li>';
                        };

                        $next.html(html);
                        app.admin_config.quick_search();
//                        $('.select_hot_city').unbind("click");
//                        $('.select_hot_city .edit-list a').unbind("click");
                        app.admin_config.choose_area();
                        app.admin_config.selected_area();
//                        $next.find('.select_hot_city').eq(0).trigger('click');
                        /* 如果没有返回参数，则直接触发选中0的操作 */
                    } else {
                        var $tmp = $('<li class="ms-elem-selectable" data-val="0"><span>' + js_lang.no_select_region + '</span></li>');
                        $next.html($tmp);
                        $tmp.trigger('click');
                        return;
                    }
                }, 'json');
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

        selected_area: function () {
            $('.ms-elem-selectable .edit-list a').off('click').on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var bool = true;
                var $this = $(this),
                    $parent = $this.parents('li.ms-elem-selectable'),
                    val = $parent.attr('data-val'),
                    name = $parent.find('span').eq(0).text(),
                    $tmp = $('<input type="checkbox" checked="checked" value="' + val + '" name="regions[]" /><span class="m_r10">' + name + '</span>');
                $('.selected_area div').each(function (i) {
                	console.log($(this).find("input").val());
                	console.log(val);
                    if ($(this).find("input").val() == val) {
                        var data = {
                            message: js_lang.region_selected,
                            state: "error",
                        };
                        ecjia.admin.showmessage(data);
                        bool = false;
                        return false;
                    }
                });
                if (bool) {
                    $('.selected_area').append($tmp);
                    $tmp.uniform();
                }
            });
        },
	}
})(ecjia.admin, jQuery);
// end
