// JavaScript Document
;
(function(app, $) {
	app.product = {
		init: function() {
			$('input[name="submit"]').on('click', function(e) {
				e.preventDefault();
				var $form = $("form[name='theForm']");
				$form.ajaxSubmit({
					dataType: "json",
					success: function(data) {
						ecjia.merchant.showmessage(data);
					}
				});
			});
			app.product_info.previewImage();
		},

		/**
		 * clone_product 克隆添加一个节点的方法
		 */
		clone_product: function(options) {
			var tmpObj = options.parentobj.clone();

			tmpObj.find('[data-toggle="clone_product"]').attr('data-toggle', 'remove_product').on('click', function() {
				tmpObj.remove()
			}).find('i').attr('class', 'fa fa-times ecjiafc-red');

			$('.product_list').children('tbody').append(tmpObj);
			tmpObj.find('.chzn-container').remove();
			tmpObj.find('select').removeClass('chosen_hide').removeClass('chzn-done').attr({
				'id': ''
			}).chosen();
		}
	};
	
	app.product_info = {
		init: function() {
			app.product_info.previewImage();
			app.product_info.fileupload();
		},

		fileupload: function() {
			$(".fileupload-btn").on('click', function(e) {
				e.preventDefault();
				$(this).parent().find("input").trigger('click');
			})
		},

		previewImage: function(file) {
			if (file == undefined) {
				return false;
			}
			if (file.files && file.files[0]) {
				var reader = new FileReader();
				reader.onload = function(evt) {
					$(file).siblings('.fileupload-btn').addClass('preview-img').css("backgroundImage", "url(" + evt.target.result + ")");
					$('.thumb_img').removeClass('hide').find('.fileupload-btn').addClass('preview-img').css("backgroundImage", "url(" + evt.target.result + ")");
				}
				reader.readAsDataURL(file.files[0]);
			} else {
				$(file).prev('.fileupload-exists').remove();
				$(file).siblings('.fileupload-btn').addClass('preview-img').css("filter", "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src='" + file.value + "'");
			}
		},
	};

	
	app.product_spec = {
		init: function() {
			app.product_spec.select_spec();
			app.product_spec.spec_add_product();
			app.product_spec.clear_data();
			app.product_spec.spec_submint();
		},

		//设置规格属性-checkbox
		select_spec: function() {
            $("a[data-toggle='modal']").off('click').on('click', function (e) {
            	e.preventDefault();
            	
            	$("#myModal2").remove();
                var $this = $(this);
                var goods_id = $this.attr('goods-id');
                var url = $this.attr('attr-url');
                $.post(url, {'goods_id': goods_id}, function (data) {
                	$('.modal').html(data.data);
                	
                	$('.sprc_close').on('click', function (e) {
                		window.location.reload();
    				});
                	 
                	$(".insertSubmit").on('click', function(e) {
        				$("form[name='insertForm']").submit();
        			});	
                	
        			$("form[name='insertForm']").on('submit', function(e) {
        				e.preventDefault();
        			});
        			
        			var $this = $('form[name="insertForm"]');
        			var option = {
        				submitHandler: function() {
        					$this.ajaxSubmit({
        						dataType: "json",
        						success: function(data) {
        							$('#myModal1').modal('hide');
        							$(".modal-backdrop").remove();
        							ecjia.pjax(data.url, function() {
        								ecjia.merchant.showmessage(data);
        							})
        						}
        					});
        				},
        			};

        			var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
        			$this.validate(options);
                }, 'json');
			})
		},
			
		//添加货品-radio
		spec_add_product: function() {
            $("a[data-type='add-pro']").off('click').on('click', function (e) {
            	
            	$("#myModal1").remove();
            	
            	e.preventDefault();
            	
                var $this = $(this);
                var goods_id = $this.attr('goods-id');
                var url = $this.attr('attr-url');
                $.post(url, {'goods_id': goods_id}, function (data) {
                	 $('.add_pro').html(data.data);
                	 if(data.product_sn) {
                      	 var msg = "所选属性已组合成货品，【货号】" + data.product_sn
       	          		 $('.product_sn_msg').html(msg);
                      	 $('.add_pro_submint').hide();
                      	 $('.del_pro_submint').show();
                	 } else {
                		 $('.add_pro_submint').show();
                		 $('.del_pro_submint').hide();
                	 }
                	 
                	 $('.pro_close').on('click', function (e) {
                		 window.location.reload();
    				 });
                	 app.product_spec.ajax_select_radio();
                	 app.product_spec.add_product_submit();
                	 app.product_spec.del_product_submit();
            
                }, 'json');
			})
		},
		
		ajax_select_radio: function() {
			$(":radio").click(function(){
				var goods_id = $("input[name='good_id']").val();
	            var url = $("input[name='ajax_select_radio_url']").val();
	            var radio_value = [];
	            $('input:radio:checked').each(function(){
	            	radio_value.push($(this).val());
	            });
	            var filters = {
		            'goods_id': goods_id,
		            'radio_value_arr': radio_value,
	            };
	            $.post(url, filters, function (data) {
	          		 if(data.product_sn) {
	          			 var msg = "所选属性已组合成货品，【货号】" + data.product_sn
		          		 $('.product_sn_msg').html(msg);
	          			 $('.add_pro_submint').hide();
	          			 $('.del_pro_submint').show();
	          		 } else {
	          			 $('.product_sn_msg').html('');
	          			 $('.add_pro_submint').show();
	          			 $('.del_pro_submint').hide();
	          		 }
	            });
  
			});
		},
	
		//添加货品-处理
		add_product_submit: function() { 
	    	$('.add_pro_submint').on('click', function (e) {
	    		e.preventDefault();
	    		var $this = $(this);
	            var goods_id = $this.attr('goods-id');
	            var url = $this.attr('data-url');
	            var radio_value = [];
			
	            $('input:radio:checked').each(function(){
	            	radio_value.push($(this).val());
	            });
   	            var filters = {
                    'goods_id': goods_id,
                    'radio_value_arr': radio_value,
   	            };
 
  	            $.post(url, filters, function (data) {
	   	          	 if (data.state == 'success'){
	   	          		 var msg = "所选属性已组合成货品，【货号】" + data.product_sn
	   	          		 $('.product_sn_msg').html(msg);
		   	          	 $('.add_pro_submint').hide();
	          			 $('.del_pro_submint').show();
		     		     var $info = $('<div class="staticalert alert alert-success ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
		     		     $info.appendTo('.success-msg').delay(5000).hide(0);
					 } else {
						 var $info = $('<div class="staticalert alert alert-danger ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
						 $info.appendTo('.error-msg').delay(5000).hide(0);
					 }
   	            });
	  	      
        	})
		},

		//删除货品-处理
		del_product_submit: function() { 
	    	$('.del_pro_submint').on('click', function (e) {
	    		
	    		e.preventDefault();
	    		var $this = $(this);
	            var goods_id = $this.attr('goods-id');
	            var url = $this.attr('data-url');
	            var radio_value = [];
			
	            $('input:radio:checked').each(function(){
	            	radio_value.push($(this).val());
	            });
   	            var filters = {
                    'goods_id': goods_id,
                    'radio_value_arr': radio_value,
   	            };
 
  	            $.post(url, filters, function (data) {
	   	          	 if (data.state == 'success'){
	   	          		 $('.product_sn_msg').html('');
		   	          	 $('.add_pro_submint').show();
	          			 $('.del_pro_submint').hide();
		     		     var $info = $('<div class="staticalert alert alert-success ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
		     		     $info.appendTo('.success-msg').delay(5000).hide(0);
					 } else {
						 var $info = $('<div class="staticalert alert alert-danger ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
						 $info.appendTo('.error-msg').delay(5000).hide(0);
					 }
   	            });
	    	})
		},
		
		clear_data: function() { 
			$('[data-toggle="clear_data"]').on('click', function(e) {
				e.preventDefault();
				
				var url = $(this).attr('data-href');
				var goods_id = $(this).attr('goods-id');
				smoke.confirm(js_lang.tip_msg, function(e) {
					if (e) {
						$.ajax({
							type: "POST",
							url:  url,
							data: {
								goods_id: goods_id,
							},
							dataType: "json",
							success: function(data) {
								ecjia.merchant.showmessage(data);
								window.location.href = data.url;
							}
						});
					}
				}, {
					ok: js_lang.ok,
					cancel: js_lang.cancel
				});
			});
		},
		

		spec_submint: function() {
			var $this = $('form[name="theForm"]');
			var option = {
				submitHandler: function() {
					$this.ajaxSubmit({
						dataType: "json",
						success: function(data) {
							ecjia.merchant.showmessage(data);
						}
					});
				}
			};
			var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
			$this.validate(options);
		}
	};
	
	
	/**
	 * clone_product触发器
	 * data-parent 		要复制的父级节点
	 */
	$(document).on('click', '.add_item', function(e) {
		e.preventDefault();
		var $this = $(this),
			$parentobj = $('.clone_div').children().find('.attr_row'),
			option = {
				parentobj: $parentobj
			};
		app.product.clone_product(option);
	});

	/**
	 * remove_product 删除节点obj
	 * data-parent 要删除的父级节点
	 */
	$(document).on('click', '[data-toggle="remove_product"]', function(e) {
		e.preventDefault();
		var $this = $(this),
			$parentobj = $this.parents($this.attr('data-parent'));
		$parentobj.remove();
	});

})(ecjia.merchant, jQuery);

// end