// JavaScript Document
;(function(app, $) {
	app.push_config = {
		init : function() {
			
		}
	};
	
	app.push_config_edit = {
			init : function() {
				app.push_config_edit.submit_form();
				app.push_config_edit.add_app_push();
				app.push_config_edit.del_app_push();
			},
			
			submit_form : function(formobj) {
				var $form = $("form[name='theForm']");
				var option = {
					rules: {
	                    app_name: {
	                        required: true
	                    }
	                },
	                messages: {
	                    app_name: {
	                        required: js_lang.app_name_required
	                    }
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
			
			add_app_push : function() {
				$('.select_app_type li')
				.on('click', function() {
					var type = $(this).parent().attr('data-type');
					var $this = $(this),
						tmpobj = $( '<li class="ms-elem-selection"><input type="hidden" name="app_'+type+'_id[]" value="' + $this.attr('data-id') + '" />' + $this.text() + '<span class="edit-list"><i class="fontello-icon-minus-circled ecjiafc-red del"></i></span></li>' );
					if (!$this.hasClass('disabled')) {
						tmpobj.appendTo( $( ".ms-selection .nav-list-content-"+ type ) );
						$this.addClass('disabled');
					}
					//给新元素添加点击事件
					tmpobj.on('dblclick', function() {
						$this.removeClass('disabled');
						tmpobj.remove();
					})
					.find('i.del').on('click', function() {
						tmpobj.trigger('dblclick');
					});
				});
			},
			del_app_push : function() {
				$('.ms-elem-selection').each(function(index){
					var type = $(this).parent().attr('shipped');
					var $this = $(this);
					$('.nav-list-ready-'+ type +' li').each(function(i){
						if ($( '.nav-list-ready-'+ type +' li' ).eq(i).attr('id') == 'appId_' + $this.find('input').val()) {
							$( '.nav-list-ready-'+ type +' li' ).eq(i).addClass('disabled');
						}
					});
				}); 
				
				//给右侧元素添加点击事件
				$('.nav-list-content .ms-elem-selection').on('dblclick', function() {
					var type = $(this).parent().attr('shipped');
					var $this = $(this);
					$('.nav-list-ready-'+ type +' li').each(function(index) {
						if ($('.nav-list-ready-'+ type +' li').eq(index).attr('id') == 'appId_' + $this.find('input').val()) {
							$('.nav-list-ready-'+ type +' li').eq(index).removeClass('disabled');
						}
					});
					$this.remove();
				})
				.find('i.del').on('click', function() {
					$(this).parents('li').trigger('dblclick');
				});
			},
		};
	
})(ecjia.admin, jQuery);

// end