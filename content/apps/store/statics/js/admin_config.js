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
	}
})(ecjia.admin, jQuery);
// end
