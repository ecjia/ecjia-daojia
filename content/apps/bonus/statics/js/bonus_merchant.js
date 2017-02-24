// JavaScript Document
;(function(app, $) {
	app.bonus = {
		send_by_print_init : function() {
			$form = $('form[name="bonus_thePrintForm"]');
			var option = {
				rules : {
					bonus_sum : { required : true, number : true },
				},
				messages : {
					bonus_sum : { required : "请输入红包数量！", number : "请输入数字" },
				},
				submitHandler : function() {
					$form.ajaxSubmit({
						dataType : "json",
						success : function(data) {
							ecjia.merchant.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
			$form.validate(options);
		},
		addUser : function() {
			var src = document.getElementById('user_search');
			var dest = document.getElementById('user');
			for (var i = 0; i < src.options.length; i++) {
				if (src.options[i].selected) {
					var exist = false;
					for (var j = 0; j < dest.options.length; j++) {
						if (dest.options[j].value == src.options[i].value) {
							exist = true;
							break;
						}
					}
					if (!exist) {
						var opt = document.createElement('OPTION');
						opt.value = src.options[i].value;
						opt.text = src.options[i].text;
						dest.options.add(opt);
					}
				}
			}
		},
		delUser : function() {
			var dest = document.getElementById('user');
			for (var i = dest.options.length - 1; i >= 0 ; i--) {
				if (dest.options[i].selected) {
					dest.options[i] = null;
				}
			}
		},
	}


	/* 关联商品 */
	app.link_goods = {
		init : function() {
//			$( ".nav-list-ready ,.ms-selection .nav-list-content" ).disableSelection();
			app.link_goods.search_link_goods();
			app.link_goods.del_link_goods();
			app.link_goods.submit_link_goods();
		},

		search_link_goods : function() {
			/* 查找商品 */
			$('[data-toggle="searchGoods"]').on('click', function() {
				var $choose_list = $('.choose_lists'),
					searchURL = $choose_list.attr('data-url');
				var filters = {
					'JSON' : {
						'keyword'	: $choose_list.find('[name="keyword"]').val(),
						'cat_id'	: $choose_list.find('[name="cat_id"] option:checked').val(),
						'brand_id'	: $choose_list.find('[name="brand_id"] option:checked').val(),
					}
				};
				$.get(searchURL, filters, function(data) {
					app.link_goods.load_link_goods_opt(data);
				}, "JSON");
			})
		},

		load_link_goods_opt : function(data) {
			$('.nav-list-ready').html('');
			if (data.content.length > 0) {
				for (var i = 0; i < data.content.length; i++) {
					var disable = $('.nav-list-content .ms-elem-selection').find('input[value="' + data.content[i].value + '"]').length ? 'disabled' : '';
					var opt = '<li class="ms-elem-selectable ' + disable + '" id="articleId_' + data.content[i].value + '" data-id="' + data.content[i].value + '"><span>' + data.content[i].text + '</span></li>'
					$('.nav-list-ready').append(opt);
				};
			} else {
				$('.nav-list-ready').html('<li class="ms-elem-selectable disabled"><span>未搜索到商品信息</span></li>');
			}
			app.link_goods.search_link_goods_opt();
			app.link_goods.add_link_goods();
		},

		search_link_goods_opt : function() {
			//li搜索筛选功能
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

		add_link_goods : function() {
			$('.nav-list-ready li')
			.on('click', function() {
				var $this = $(this),
					tmpobj = $( '<li class="ms-elem-selection"><input type="hidden" name="goods_id[]" value="' + $this.attr('data-id') + '" />' + $this.text() + '<span class="edit-list"><i class="fa fa-minus-circle ecjiafc-red del"></i></span></li>' );
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
					if ($( ".nav-list-ready li" ).eq(index).attr('id') == 'articleId_' + $this.find('input').val()) {
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
				var bonus_type_id = $('#bonus_type_id').val();
				var info = {'linked_array' : [], 'bonus_type_id':bonus_type_id};
				$('.nav-list-content li').each(function (index){
					var goods_id = $('.nav-list-content li').eq(index).find('input').val();
					info.linked_array.push({'goods_id' : goods_id});
				});
				$.get(url, info, function(data) {
					ecjia.merchant.showmessage(data);
				});
			})
		}
	}

	/* 用户发放*/
	app.link_user = {
		init : function() {
//			$( ".nav-list-ready ,.ms-selection .nav-list-content" ).disableSelection();
			app.link_user.submit_userRankForm();
			app.link_user.search_link_user();
			app.link_user.del_link_user();
			app.link_user.submit_link_user();
		},

		submit_userRankForm : function() {
			//表单提交
			$('form[name="userRankForm"]').on('submit', function(e) {
				e.preventDefault();
				$(this).ajaxSubmit({
					dataType:"json",
					success:function(data){
						ecjia.merchant.showmessage(data);
					}
				});
			})
		},

		search_link_user : function() {
			/* 查找用户 */
			$('[data-toggle="searchuser"]').on('click', function() {
				var $choose_list = $('#search_user'),
					searchURL = $choose_list.attr('data-url');
				var filters = {
					'JSON' : {
						'keyword': $choose_list.find('[name="keyword"]').val(),
					}
				};
				$.post(searchURL, filters, function(data) {
					if(data.content != null){
						app.link_user.load_link_user_opt(data);
					}
				}, "JSON");
			})
		},

		load_link_user_opt : function(data) {
			$('.nav-list-ready').html('');
			if (data.content.length > 0) {
				for (var i = 0; i < data.content.length; i++) {
					var disable = $('.nav-list-content .ms-elem-selection').find('input[value="' + data.content[i].user_id + '"]').length ? 'disabled' : '';
					var opt = '<li class="ms-elem-selectable ' + disable + '" id="userid_' + data.content[i].user_id + '" data-id="' + data.content[i].user_id + '"><span>' + data.content[i].user_name + '</span></li>'
					$('.nav-list-ready').append(opt);
				};
			} else {
				$('.nav-list-ready').html('<li class="ms-elem-selectable disabled"><span>未搜索到文章信息</span></li>');
			}
			app.link_user.search_link_user_opt();
			app.link_user.add_link_user();
		},

		search_link_user_opt : function() {
			//li搜索筛选功能
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

		add_link_user : function() {
			$('.nav-list-ready li')
			.on('click', function() {
				var $this = $(this),
					tmpobj = $( '<li class="ms-elem-selection"><input type="hidden" name="user_id[]" value="' + $this.attr('data-id') + '" />' + $this.text() + '<span class="edit-list"><i class="fontello-icon-minus-circled ecjiafc-red del"></i></span></li>' );
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

		del_link_user : function() {
			//给右侧元素添加点击事件
			$('.nav-list-content .ms-elem-selection').on('dblclick', function() {
				var $this = $(this);
				$( ".nav-list-ready li" ).each(function(index) {
					if ($( ".nav-list-ready li" ).eq(index).attr('id') == 'UserId_' + $this.find('input').val()) {
						$( ".nav-list-ready li" ).eq(index).removeClass('disabled');
					}
				});
				$this.remove();
			})
			.find('i.del').on('click', function() {
				$(this).parents('li').trigger('dblclick');
			});
		},

		submit_link_user : function() {
			//表单提交
			$('form[name="theForm"]').on('submit', function(e) {
				e.preventDefault();
				var url = $(this).attr('action');
				var bonus_type_id = $('#bonus_type_id').val();
				var info = {'linked_array' : [],'bonus_type_id':bonus_type_id};
				$('.nav-list-content li').each(function (index){
					var user_id = $('.nav-list-content li').eq(index).find('input').val();
					info.linked_array.push({'user_id' : user_id});
				});
				$.get(url, info, function(data) {
					ecjia.merchant.showmessage(data);
				});
			})
		}
	}
})(ecjia.merchant, jQuery);

// end