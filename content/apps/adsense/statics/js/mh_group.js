// JavaScript Document
;(function (app, $) {
    app.merhcant_group_list = {
        init: function () {
        	 $("#ajaxstart").on('click', function (e) {
                 e.preventDefault();
                 var url = $(this).attr('href');
                 $.get(url, function (data) {
                     ecjia.merchant.showmessage(data);
                 }, 'json');
             });
        }
    };
 
    
    /* **编辑** */
    app.merchant_group_edit = {
        init: function () {
            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                    position_name: {
                        required: true
                    },
                    position_code: {
                        required: true
                    }
                },
                messages: {
                    position_name: {
                        required: "请输入广告组名称"
                    },
                    position_code: {
                        required: "请输入广告组代号"
                    }
                },
                submitHandler: function () {
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            ecjia.merchant.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
            $form.validate(options);
        }
	};

    app.link_goods = {
    		init : function() {    	
    			app.link_goods.search_link_goods_opt();
    			app.link_goods.add_link_goods();
    			app.link_goods.del_link_goods();
    			app.link_goods.submit_link_goods();
    			app.link_goods.movemod();
    		},
    		
    		movemod: function() {
    			$(".nav-list-content").sortable({
    				placeholder: 'ui-sortable-placeholder',
    				items: "li:not(.ms-elem-selection1)",
    				sort: function() {
    					$(this).removeClass("ui-state-default");
    				}
    			});
    		},
    		
    		//对该列表关键词快捷筛选
    		search_link_goods_opt : function() {
    			$('#ms-search').quicksearch(
    				$('.ms-elem-selectable', '#ms-custom-navigation' ), 
    				{
    					onAfter : function(){
    						$('.ms-group').each(function(index) {
    							$(this).find('.isShow').length ? $(this).css('display','block') : $(this).css('display','none');
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
    				}
    			);
    		},

    		//点击左侧列表中项触发
    		add_link_goods : function() {
    			$('.nav-list-ready li')
    			.on('click', function() {
    				var $this = $(this),
    					tmpobj = $( '<li class="ms-elem-selection"><input type="hidden" name="sort_order[]" value="' + $this.attr('sort_order') + '" /><input type="hidden" name="position_id[]"  value="' + $this.attr('data-id') + '" />' + $this.text() + '<span class="edit-list"><i class="fa fa-minus-circle ecjiafc-red del"></i></span></li>');
    				if (!$this.hasClass('disabled')) {
    					tmpobj.appendTo( $( ".ms-selection .nav-list-content" ) );
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

    		del_link_goods : function() {
    			//给右侧元素添加点击事件
    			$('.nav-list-content .ms-elem-selection').on('dblclick', function() {
    				var $this = $(this);
    				$( ".nav-list-ready li" ).each(function(index) {
    					if ($( ".nav-list-ready li" ).eq(index).attr('id') == $this.find('input').val()) {
    						$( ".nav-list-ready li" ).eq(index).removeClass('disabled');
    					}
    				});
    				$this.remove();
    			})
    			.find('i.del').on('click', function() {
    				$(this).parents('li').trigger('dblclick');
    			});
    		},
    		
    		submit_link_goods : function() {
    			//表单提交
    			$('form[name="theForm"]').on('submit', function(e) {
    				e.preventDefault();
    				var url = $(this).attr('action');
    				var info = {'linked_array' : []};
    				$('.nav-list-content li').each(function (index){
    					var position_id = $('.nav-list-content li').eq(index).find('input[name="position_id[]"]').val();
    					info.linked_array.push(position_id);
    				});
    				$.get(url, info, function(data) {
    					ecjia.merchant.showmessage(data);
    				});
    			})
    		}
    	}
})(ecjia.merchant, jQuery);

//end