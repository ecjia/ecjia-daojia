/**
 * 后台综合js文件
 */
;
(function(ecjia, $) {
	ecjia.touch.index = {
		init: function() {
			this.removeItem();
			this.substr();
			this.init_swiper();
			this.change_index();
			this.swiper_promotion();
			this.promote_time();
			this.close_download();
			this.discover_swiper();
			this.discover_cycleimage();
			this.discover_cat();
			this.discover_init();
			this.article_cat_click();
		},
		
		removeItem() {
			sessionStorage.removeItem('swiper');				//首页轮播图
			
			sessionStorage.removeItem('discover_swiper');		//发现页滚动图标
			sessionStorage.removeItem('discover_cycleimage');	//发现页轮播图
			sessionStorage.removeItem('discover_cat');			//发现页滚动分类
		},

		substr: function() {
			var str = $(".address-text").html();
			if (str) {
				str = str.length > 20 ? str.substring(0, 20) + '...' : str;
				var str = $(".address-text").html(str);
			}
		},

		init_swiper: function() {
			if ($.find('.ecjia-mod-cycleimage').length != 0) {
				var width = $('.ecjia-mod-cycleimage').find('.swiper-slide ').width();
				$('.ecjia-mod-cycleimage').find('.swiper-slide').css('height', width * 2 / 5 + 'px');
				$('.ecjia-mod-cycleimage').find('.swiper-slide').find('img').css('height', width * 2 / 5 + 'px');
			}
			if (sessionStorage.getItem("swiper") == 1) {
				return false;
			}
			var swiper = new Swiper('#swiper-touchIndex', {
				pagination: '.swiper-pagination',
				speed: 800,
				grabCursor: true,
				centeredSlides: true,
				coverflow: {
					rotate: 50,
					stretch: 0,
					depth: 100,
					modifier: 1,
					slideShadows: true
				},
				//无限滚动
				slidesPerView: 1,
				loop: true,
				//自动播放
				autoplay: 2500,
				autoplayDisableOnInteraction: false,
			});
			sessionStorage.setItem("swiper", 1);

			$('.ecjia-zx').off('click').on('click', function() {
				sessionStorage.removeItem('swiper');
			});
		},
		swiper_promotion: function() {
			var swiper = new Swiper('.swiper-promotion', {
				slidesPerView: 2.5,
				spaceBetween: 10,
				freeMode: true,
				freeModeMomentumVelocityRatio: 5,
			});
		},
		promote_time: function() {
			var serverTime = Math.round(new Date().getTime() / 1000) * 1000; //服务器时间，毫秒数 
			var dateTime = new Date();
			var difference = dateTime.getTime() - serverTime; //客户端与服务器时间偏移量 
			var InterValObj;
			clearInterval(InterValObj);

			InterValObj = setInterval(function() {
				$(".promote-time").each(function() {
					var obj = $(this);
					var endTime = new Date((parseInt(obj.attr('value')) + 8 * 3600) * 1000);
					var nowTime = new Date();
					var nMS = endTime.getTime() - nowTime.getTime() + difference;
					var myD = Math.floor(nMS / (1000 * 60 * 60 * 24)); //天 
					var myH = Math.floor(nMS / (1000 * 60 * 60)) % 24; //小时 
					var myM = Math.floor(nMS / (1000 * 60)) % 60; //分钟 
					var myS = Math.floor(nMS / 1000) % 60; //秒 

					var type = obj.attr('data-type');
					var hh = checkTime(myH);
					var mm = checkTime(myM);
					var ss = checkTime(myS);

					if (myD >= 0) {
						if (type == 1) {
							msg = '距离活动结束还有';
							var str = msg + myD + '天 &nbsp;&nbsp;<span class="end-time">' + hh + '</span> : <span class="end-time">' + mm + '</span> : <span class="end-time">' + ss + '</span>';
						} else {
							msg = '剩余';
							var str = msg + myD + "天&nbsp;" + hh + ":" + mm + ":" + ss;
						}
					} else {
						var str = "已结束！";
					}
					obj.html(str);
				});
			}, 1000); //每隔1秒执行一次 
		},

		close_bottom_banner: function() {
			$.cookie('hide_bottom_banner', 1, {
				expires: 7
			});
			$('.bottom-banner').remove();
		},

		click_header: function() {
			$('.ecjia-header.ecjia-header-index').removeClass('active');
			$('.search-header.index-header').addClass('active');
			$('.search_fixed_mask').toggleClass('active');
			$("#keywordBox").val('').focus().click();
			$('.search-history').toggleClass('active');
			if ($('.ecjia-app-download').length > 0) {
				$('.ecjia-app-download').css('margin-top', '3.5em');
			} else {
				$('.focus').css('margin-top', '3.5em');
			}
		},

		change_index: function() {
			$('[data-toggle="change_index"]').on('click', function() {
				$('.ecjia-header.ecjia-header-index').addClass('active');
				$('.search-header.index-header').removeClass('active');
				$('.search_fixed_mask').toggleClass('active');
				$('.search-history').toggleClass('active');
				if ($('.ecjia-app-download').length > 0) {
					$('.ecjia-app-download').css('margin-top', '');
				} else {
					$('.focus').css('margin-top', '');
				}
			})
		},
		close_download: function() {
			$('.close_tip').on('click', function() {
				$.cookie('close_download', true, {
					expires: 7
				});
				$('.ecjia-download').remove();
			})
		},
		
		//发现页顶部滚动图标
		discover_swiper: function() {
			var index = 0;
			if (sessionStorage.getItem("discover_swiper")) {
				index = sessionStorage.getItem("discover_swiper");
			}
			var swiper = new Swiper('#swiper-discover-icon', {
				slidesPerView: 5,
				paginationClickable: true,
				initialSlide: index,
				spaceBetween: 0,
			});
			
			$('#swiper-discover-icon .swiper-slide').find('a').off('click').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					url = $this.attr('href');
				var i = $("#swiper-discover-icon").find('.swiper-slide.swiper-slider-active').index();
				sessionStorage.setItem("discover_swiper", i);
				ecjia.pjax(url);
			});
		},
		
		//发现页轮播图
		discover_cycleimage: function() {
			if ($.find('.ecjia-discover-cycleimage').length != 0) {
				var width = $('.ecjia-discover-cycleimage').find('.swiper-slide ').width();
				$('.ecjia-discover-cycleimage').find('.swiper-slide').css('height', width * 2 / 5 + 'px');
				$('.ecjia-discover-cycleimage').find('.swiper-slide').find('img').css('height', width * 2 / 5 + 'px');
			}
			if (sessionStorage.getItem("discover_cycleimage") == 1) {
				return false;
			}
			var discover_cycleimage = new Swiper('#swiper-discover-cycleimage', {
				pagination: '.swiper-pagination',
				speed: 800,
				grabCursor: true,
				centeredSlides: true,
				coverflow: {
					rotate: 50,
					stretch: 0,
					depth: 100,
					modifier: 1,
					slideShadows: true
				},
				//无限滚动
				slidesPerView: 1,
				loop: true,
				//自动播放
				autoplay: 2500,
				autoplayDisableOnInteraction: false,
			});
			sessionStorage.setItem("discover_cycleimage", 1);
		},
		
		//发现页分类滚动
		discover_cat: function() {
			var index = 0;
			if (sessionStorage.getItem("discover_cat")) {
				index = sessionStorage.getItem("discover_cat");
			}
			var swiper = new Swiper('#swiper-article-cat', {
				slidesPerView: 4,
				paginationClickable: true,
				initialSlide: index,
				spaceBetween: 0,
			});
			
			$('.navi-list li').off('click').on('click', function() {
				var cat_id = $(this).attr('data-id');
				$(this).addClass('active').siblings('li').removeClass('active');
				$(".ecjia-discover-article .swiper-slide[data-type='"+cat_id+"']").trigger('click').addClass('active');
				$('.ecjia-discover').css('display', 'block');
				$('.ecjia-down-navi').css('display', 'none');
				var index = $(this).index();
				swiper.slideTo(index, 1000, false);//切换到制定slide，速度为1秒
				
				$('.ecjia-discover .article-add').children('i').removeClass('expanded');
				$('.ecjia-down-navi').removeClass('show');
				$('.ecjia-down-navi').off('touchmove');
				$('.ecjia-down-navi').css('height', 0);
			});
		},
		
		discover_init: function() {
			$('.ecjia-discover .article-add').off('click').on('click', function() {
				var $this = $(this);
					children = $this.children('i');
					
				if ($this.hasClass('disabled')) {
					return false;
				}	
				if (children.hasClass('expanded')) {
					children.removeClass('expanded');
					$('.ecjia-down-navi').removeClass('show');
					$('.ecjia-down-navi').off('touchmove');
					$('.ecjia-down-navi').css('height', 0);
				} else {
					children.addClass('expanded');
					$('.ecjia-down-navi').addClass('show');
					var height = $('.article-container').height();
					if (height < 800) {
						height = 800;
					}
					$('.ecjia-down-navi').css('height', height);
					//阻止浏览器下拉事件
					$('.ecjia-down-navi').on('touchmove', function(event) {
						event.preventDefault;
					}, false);
				}
			});
			
			$('.article-appreciate').off('click').on('click', function() {
				var $this = $(this);
				if ($this.hasClass('disabled')) {
					return false;
				}
				var val = parseInt($this.find('span').text());
				$this.addClass('disabled');
				
				var type = 'add';
				if ($this.hasClass('active')) {
					type = 'cancel';
				}
				var info = {
					'type': type,
				}
				var url = $('input[name="like_article"]').val();
				$.post(url, info, function(data) {
					if (data.state == 'success') {
						if (type == 'cancel') {
							$this.removeClass('active');
							$this.find('span').text(val - 1);
							iosOverlay({
								text: '取消点赞',
								duration: 2e3,
								onhide: function() {
									$this.removeClass('disabled');
								},
							});
						} else {
							$this.addClass('active');
							$this.find('span').text(val + 1);
							iosOverlay({
								text: '点赞成功！',
								duration: 2e3,
								onhide: function() {
									$this.removeClass('disabled');
								},
							});
						}
					} else {
						$this.removeClass('disabled');
						if (data.referer_url) {
							ecjia.touch.index.show_login_message(data.referer_url);
						} else {
							alert(data.message);
						}
					}
				});
			});
			
			$('.article-bianji').off('click').on('click', function(e) {
				e.preventDefault();
				var $this = $(this);
				var url = $('input[name="add_comment"]').val();
				
				var info = {
					'type': 'check',
				}
				$.post(url, info, function(data) {
					if (data.state == 'success') {
						$('.nav-bt-fix').hide();
						$('.ecjia-discover-detail .box_overlay').show();
						$('.send-box').show();
					} else {
						if (data.referer_url) {
							ecjia.touch.index.show_login_message(data.referer_url);
						} else {
							alert(data.message);
						}
					}
				});
			});
			
			$('.send-btn').off('click').on('click', function(e) {
				e.preventDefault();
				var textarea = $('.textarea-box').find('textarea');
				var length = textarea.val().length;
				if (length == 0) {
					textarea.focus();
					return false;
				}
				
				var url = $('input[name="add_comment"]').val();
				var info = {
					val: textarea.val(),
				}
				$.post(url, info, function(data) {
					if (data.state == 'success') {
						iosOverlay({
							text: '发表成功！',
							duration: 2e3,
						});
						textarea.val('');
						ecjia.touch.index.hide_box();
					} else {
						if (data.referer_url) {
							ecjia.touch.index.show_login_message(data.referer_url);
						} else {
							alert(data.message);
						}
					}
				});
			});
			
			$('.box_overlay').off('click').on('click', function() {
				ecjia.touch.index.hide_box();
			});
		},
		
		hide_box: function() {
			$('.nav-bt-fix').show();
			$('.send-box').hide();
			$('.ecjia-discover-detail .box_overlay').hide();
		},
		
		article_cat_click: function() {
			$('.ecjia-discover-article .swiper-slide').off('click').on('click', function() {
				$('.ecjia-discover .article-add').children('i').removeClass('expanded');
				$('.ecjia-down-navi').removeClass('show');
				$('.ecjia-down-navi').off('touchmove');
				$('.ecjia-down-navi').css('height', 0);
				
				var $this = $(this),
					url = $this.attr('data-url'),
					type = $this.attr('data-type');

				$('li.navi').removeClass('active');
				$('li.navi').each(function() {
					if ($(this).attr('data-id') == type) {
						$(this).addClass('active');
					}
				})
				$('.ecjia-article.article-list').attr('id', 'discover-article-' + type);
				$('.article-container').find('[data-toggle="asynclist"]').attr('data-type', type);

				if ($this.hasClass('active') || $this.hasClass('disabled')) {
					return false;
				} else {
					$this.addClass('active').siblings('div').removeClass('active');
					$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>'); //加载动画
					$('body').css('overflow-y', 'hidden').on('touchmove', function(event) {
						event.preventDefault;
					}, false);
					$('.ecjia-discover .article-add').addClass('disabled');
					$('.ecjia-discover-article .swiper-slide').addClass('disabled'); //禁止切换

					$.get(url, function(data) {
						$('body').scrollTop(0);
						$('.ecjia-discover .article-add').removeClass('disabled');
						
						$loader = $('<a class="load-list" href="javascript:;"><div class="loaders"><div class="loader"><div class="loader-inner ball-pulse"><div></div><div></div><div></div></div></div></div></a>');
						var load_list = $('#discover-article-' + type).parent().find('.load-list');
						if (load_list.length == 0) {
							$('#discover-article-' + type).after($loader);
						}
						$('#discover-article-' + type).html('');

						$('.la-ball-atom').remove(); //移出加载动画
						$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
						$('.ecjia-discover-article .swiper-slide').removeClass('disabled'); //允许切换

						if (data.list.length == 0) {
							$('#discover-article-' + type).append('<div class="ecjia-nolist"><img src="' + theme_url + 'images/wallet/null280.png"><p class="tags_list_font">暂无文章</p></div>');
						} else {
							$('#discover-article-' + type).append(data.list);
						}
						if (data.is_last == 1) {
							$('.article-container').find('.load-list').addClass('is-last').css('display', 'none');
						} else {
							$('#discover-article-' + type).attr('data-page', 2);
							ecjia.touch.asynclist();
						}
						return false;
					});
				}
			});
		},
		
		show_login_message: function(referer_url) {
			var myApp = new Framework7();
			//禁用滚动条
			$('body').css('overflow-y', 'hidden').on('touchmove', function(event) {
				event.preventDefault;
			}, false);

			myApp.modal({
				title: '温馨提示',
				text: '您还没有登录',
				buttons: [{
					text: '取消',
					onClick: function() {
						$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
						return false;
					}
				}, {
					text: '去登录',
					onClick: function() {
						$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
						location.href = referer_url;
						return false;
					}
				}, ]
			});
			return false;
		}
	};

	function checkTime(i) {
		if (i < 10) {
			i = "0" + i;
		}
		return i;
	}
	
})(ecjia, jQuery);

//end