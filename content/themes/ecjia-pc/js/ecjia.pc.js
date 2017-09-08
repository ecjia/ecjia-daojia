/**
 * 后台综合js文件
 */

;
(function(ecjia, $) {
	ecjia.pc = {
		init: function() {
			ecjia.pc.setpjax();
			ecjia.pc.index();
			ecjia.pc.goods_list();

			ecjia.pc.toggle_cat();
			ecjia.pc.show_detail();

			ecjia.pc.move_mouse();
			ecjia.pc.select_standard();
			ecjia.pc.category_list_hidden();

			ecjia.pc.index_swiper();
			ecjia.pc.merchant_swiper();
		},
		/**
		 * 设置PJAX
		 */
		setpjax: function() { 
			/* PJAX基础配置项 */
			ecjia.pjaxoption = {
				timeout: 10000,
				container: '.main_content', /* 内容替换的容器 */
				cache: false, 				/* 是否使用缓存 */
				storage: false, 			/* 是否使用本地存储 */
				titleSuffix: '.pjax' 		/* 标题后缀 */
			};

			/* ecjia.pjax */
			ecjia.extend({
				pjax: function(url, callback) {
					var option = $.extend(ecjia.pjaxoption, {
						url: url,
						callback: function() {
							if (typeof(callback) === 'function') callback();
						}
					});
					$.pjax(option);
					delete ecjia.pjaxoption.url;
				}
			}); 
			/* pjax刷新当前页面 */
			ecjia.pjax.reload = function() {
				$.pjax.reload(ecjia.pjaxoption.container, ecjia.pjaxoption);
			}; 
			/* 移动pjax方法的调用，使用document元素委派pjax点击事件 */
			if ($.support.pjax) {
				$(document).on('click', 'a:not(.nopjax)', function(event) {
					$.pjax.click(event, ecjia.pjaxoption.container, ecjia.pjaxoption);
				});
			}
		},

		pjaxloadding: function() {},

		index: function() {
			$('.ecjia-category-content').each(function() {
				$(this).find('.category-goods').eq(0).removeClass('ecjiaf-dn');
			});

			$('.ecjia-category-item').each(function(i) {
				var cat = $(this).find('.category-list').find('.cat-item').children('.ecjia-back-green');
				if (cat.length != 0) {
					var cat_id = cat.parent('.cat-item').attr('data-id');
					$('.category-goods-' + cat_id).removeClass('ecjiaf-dn').siblings('.category-goods').addClass('ecjiaf-dn');
				} else {
					$(this).find('.category-list').find('.cat-item').eq(0).children('span').addClass('ecjia-back-green');
				}
			});

			var left_position = (($(window).width() - 1200) / 2 - 70);
			if (left_position < 0) {
				left_position = 10;
			}
			$('.lift').css('left', left_position + 'px');
			//当浏览器大小变化时
			$(window).resize(function() {
				var position = (($(window).width() - 1200) / 2 - 70);
				if (position < 0) {
					position = 10;
				}
				$('.lift').css('left', position + 'px');

				//选择城市窗口
				var d_h = $(window).height();
				var d_w = $(window).width();
				var m_l = (d_w - 650) / 2;
				var m_t = (d_h - 350) / 2;
				$(".choose-city-div").css({
					"left": m_l + "px",
					"top": m_t + "px"
				});
			});

			// 效果
			$(".suspension").find(".j-icon").mouseover(

			function() {
				$('.suspension-box-item').children('div').hide();
				$(this).parent('.suspension-box-item').children('div').show();
			});
			//判断ie浏览器
			if (navigator.appVersion.match(/11./i) == '11.' || navigator.appVersion.match(/10./i) == '10.') {
				$(".suspension").css("right", "30px");
			}
			$(".suspension .j-back-top").hide();

			$(window).scroll(function() {
				if ($(window).scrollTop() > 0) {
					$('.ecjia-header').addClass('navbar-transparent');
				} else {
					$('.ecjia-header').removeClass('navbar-transparent');
				}

				if ($(window).scrollTop() > 100) {
					$(".suspension .j-back-top").stop().show()
					$(".suspension-mobile .suspension-box").stop().show()
				} else {
					$(".suspension .j-back-top").stop().hide()
					$(".suspension-mobile .suspension-box").stop().hide()
				}

				if ($(window).scrollTop() > 400) {
					$(".lift").stop().show();
				} else {
					$(".lift").stop().hide();
				}

				var top = $(document).scrollTop(); 											//定义变量，获取滚动条的高度
				var lift = $("#lift"); 														//定义变量，获取分类
				var items = $(".ecjia-category-container").find(".ecjia-category-item"); 	//定义变量，查找.item
				var curId = ""; 															//定义变量，当前所在的item #id 
				items.each(function() {
					var m = $(this); 						//定义变量，获取当前类
					var itemsTop = m.offset().top - 300; 	//定义变量，获取当前类的top偏移量
					if (top > itemsTop) {
						curId = "#" + m.attr("id");
					} else {
						return false;
					}
				});

				var curLink = lift.find(".no-icon");
				if (curId && curLink.attr("data-item") != curId) {
					curLink.removeClass('no-icon').children('img').show();
					curLink.children('span').hide();

					var item = lift.find("[data-item=" + curId + "]");
					item.addClass("no-icon").children('img').hide();
					item.children('span').show();
				}
			});

			$(".lift_item").off('click').on('click', function() {
				var $this = $(this).find('.icon-category');
				var index = $(this).index();
				var top = $('.ecjia-category-item').eq(index).offset().top - 80;
				$('html,body').stop(true, false).animate({
					scrollTop: top
				}, 500);
				return false;
			});

			$(".j-tencent").hover(function() {
				$(".tencent-qq").stop(true, false).animate({
					width: "51",
					height: "59",
					left: "-3"
				});
			}, function() {
				$(".tencent-qq").stop(true, false).animate({
					width: "39",
					height: "45",
					left: "3"
				});
			});

			// 效果
			$(".suspension").mouseleave(function(event) {
				event.preventDefault();
				$(".suspension").find(".j-box").hide();
			});

			$(".j-back-top").off('click').click(function() {
				$("html,body").animate({
					scrollTop: 0
				}, 500);
			});

			if ($.cookie('close_choose_city') == undefined) {
				showDiv();
			}

			$('.choose-city').off('click').on('click', function() {
				showDiv();
			});

			$(".close_div").click(function() {
				hideDiv();
			});

			$(".choose-city-overlay").click(function() {
				hideDiv();
			});

			$('.position-li').off('click').on('click', function() {
				if ($(this).hasClass('active')) {
					hideDiv();
					return false;
				}
				$(this).parents('.content').find('.position-li').removeClass('active');
				$(this).addClass('active');

				var city_id = $(this).attr('data-id');
				var city_name = $(this).text();

				$.cookie('city_id', city_id, {
					expires: 7
				});
				$.cookie('city_name', city_name, {
					expires: 7
				});
				$.cookie('close_choose_city', 1, {
					expires: 7
				});
				
				var location_id = $('.location-position').attr('data-id');
				var location_name = $('.location-position').text();
				$.cookie('location_id', location_id, {
					expires: 7
				});
				$.cookie('location_name', location_name, {
					expires: 7
				});

				location.reload();
				$(document).scrollTop(0);
			});

			$('input[name="keywords"]').koala({
				delay: 200,
				keyup: function(event) {
					var $this = $(this),
						url = $this.parent('.search').attr('data-url'),
						keywords = $this.val();
					var info = {
						'keywords': keywords
					};
					ecjia.pc.search_list(url, info);
				}
			});

			$('input[name="keywords"]').off('blur').on('blur', function() {
				$('.shelper').fadeOut('fast');
			});

			$('input[name="keywords"]').off('focus').on('focus', function() {
				var $this = $(this),
					url = $this.parent('.search').attr('data-url'),
					goods_url = $('.search-button').attr('data-url'),
					keywords = $this.val();

				if ($('.shelper').length != 0) {
					var info = {
						'keywords': keywords
					};
					ecjia.pc.search_list(url, info);
				}
				$("body").keyup(function() {
					if (event.which == 13) {
						var keywords = $('input[name="keywords"]').val();
						if (keywords != '') {
							ecjia.pjax(goods_url + '&keywords=' + keywords);
						}
					}
				});
			});

			$('.search-button').off('click').on('click', function() {
				var $this = $(this),
					url = $this.attr('data-url'),
					keywords = $('input[name="keywords"]').val();
				if (keywords != '') {
					ecjia.pjax(url + '&keywords=' + keywords);
				}
			});

			$('a.merchant-list').off('click').on('click', function(e) {
				e.preventDefault();
				sessionStorage.setItem("index", 0);
				ecjia.pjax($(this).attr('href'));
			});
		},

		toggle_cat: function() {
			$('.cat-item span').off('click').on('click', function() {
				var $this = $(this).parent('.cat-item'),
					cat_id = $this.attr('data-id');

				$this.parent('.category-list').find('span').removeClass('ecjia-back-green');
				$this.children('span').addClass('ecjia-back-green');

				var more_goods = $this.parents('.ecjia-category-content').find('.more-category').children('a');
				var href = more_goods.attr('data-url');
				more_goods.attr('href', href + '&cat_id=' + cat_id);

				$('.category-goods-' + cat_id).removeClass('ecjiaf-dn').siblings('.category-goods').addClass('ecjiaf-dn');
			});
		},

		search_list: function(url, info) {
			$.post(url, info, function(data) {
				$('.shelper').html('').css('display', 'none');
				if (data.length == 0 || data.count.goods_count == 0 && data.count.store_count == 0) {
					return false;
				} else {
					var html = '';
					if (data.count.goods_count != 0) {
						html += '<a class="nopjax" href="' + data.url.goods_url + '"><li><div class="search-item">搜索商品 "' + data.keywords + '"</div><div class="search-count">约' + data.count.goods_count + '个结果</div></li></a>';
					}
					if (data.count.store_count != 0) {
						html += '<a class="nopjax" href="' + data.url.store_url + '"><li><div class="search-item">搜索店铺 "' + data.keywords + '"</div><div class="search-count">约' + data.count.store_count + '个结果</div></li></a>';
					}
					$('.shelper').html(html).css('display', 'block');
				}
			})
		},

		goods_list: function() {
			//店铺首页商品评分
			if ($.find($('.score-val')).length >= 0) {
				$('.score-val').each(function() {
					$(this).html('').raty({
						readOnly: true,
						score: function() {
							return $(this).attr('data-val');
						},
					});
				});
			}
		},

		/*
		 * 移动鼠标显示店铺信息
		 */
		show_detail: function() {
			$(".move-mouse").mouseenter(function() {
				$(".store-detail-info").show();
				$(".triangle").attr('class', 'triangle-b');
			});
			$(".move-mouse").mouseleave(function() {
				$(".store-detail-info").mouseenter(function() {
					$(".store-detail-info").show();
					$(".triangle").attr('class', 'triangle-b');
				});
				$(".store-detail-info").mouseleave(function() {
					$(".store-detail-info").hide();
					$(".triangle-b").attr('class', 'triangle');
				});
				$(".store-detail-info").hide();
				$(".triangle-b").attr('class', 'triangle');
			});
		},

		/*
		 * 移动鼠标显示二维码
		 */
		move_mouse: function() {
			$(".sao_small_img").mouseenter(function() {
				$(".panel_sao").show();
			});
			$(".sao_small_img").mouseleave(function() {
				$(".panel_sao").hide();
			});
			$(".commentimg").mouseenter(function() {
				$(this).removeClass('img_s');
				$(this).addClass('img_b');
			});
			$(".commentimg").mouseleave(function() {
				$(this).removeClass('img_b');
				$(this).addClass('img_s');
			});

			$(".qrcode_small_img").mouseenter(function() {
				$(this).parent().parent().children(".panel_sao").show();
			});
			$(".qrcode_small_img").mouseleave(function() {
				$(this).parent().parent().children(".panel_sao").hide();
			});
		},

		/*
		 * 切换商品规格
		 */
		select_standard: function() {
			$(".goods_attribute ul").each(function() {
				//取出ul下的第一个li
				var li = $(this).children().first();
				li.addClass("green");
			});
			$(".goods_attribute li").on("click", function(e) {
				e.preventDefault();
				$(this).siblings().removeClass('green');
				$(this).siblings().css('border', '1px solid #eaeaea');
				$(this).addClass("green");
				$(this).css({
					'border': '0'
				});

				var price = 0;
				$(".green").each(function() {
					data_price = $(this).attr('data-price');
					if (data_price == '') {
						var data_price = 0;
					};
					price = parseFloat(price) + parseFloat(data_price);
				});
				var goods_promote_price = parseFloat($("input[name='goods_promote_price']").val());
				var total_price = price + goods_promote_price;
				$(".fl_price").html('￥' + total_price);
			})
		},

		category_list_hidden: function() {
			$('.ecjia-category-swiper').mouseenter(function() {
				$('.swiper-button-white').css('display', 'block');
			});

			var index = 0;
			if (sessionStorage.getItem("index")) {
				index = sessionStorage.getItem("index");
			}
			var swiper = new Swiper('#category-swiper-web', {
				slidesPerView: 8,
				paginationClickable: true,
				initialSlide: index,
				spaceBetween: 0,
				prevButton: '.swiper-button-prev',
				nextButton: '.swiper-button-next',
			});

			$('#category-swiper-web .swiper-slide').find('a').off('click').on('click', function(e) {
				e.preventDefault();
				var $this = $(this).parents('.swiper-slide'),
					id = $this.attr('id');
				url = $('#category-swiper-web').attr('data-url');
				if (id != undefined) {
					url += '&cat_id=' + id;
				}
				var i = $(".category_name.swiper-slide-active").index();
				sessionStorage.setItem("index", i);
				ecjia.pjax(url);
			});
		},

		index_swiper: function() {
			if (sessionStorage.getItem("index_swiper") == 1) {
				return false;
			}
			var cycleimage_config = {
				pagination: '.swiper-index-pagination',
				slidesPerView: 1,
				autoplay: 5000,
				effect: 'fade',
				loop: true,
				autoplayDisableOnInteraction: false,
				paginationClickable: true,
			};
			var swiper = new Swiper('#swiper-web', cycleimage_config);
			sessionStorage.setItem("index_swiper", 1);
		},

		merchant_swiper: function() {
			if (sessionStorage.getItem("merchant_swiper") == 1) {
				return false;
			}
			var merchant_cycleimage_config = {
				pagination: '.swiper-merchant-pagination',
				slidesPerView: 1,
				autoplay: 5000,
				effect: 'fade',
				loop: true,
				autoplayDisableOnInteraction: false,
				paginationClickable: true,
			};
			var merchant_swiper = new Swiper('#swiper-merchant-cycleimage', merchant_cycleimage_config);
			sessionStorage.setItem("merchant_swiper", 1);
		},
	};

	function showDiv() {
		$(".choose-city-div").show();
		$(".choose-city-overlay").show();
		var d_h = $(window).height();
		var d_w = $(window).width();
		var m_l = (d_w - 650) / 2;
		var m_t = (d_h - 350) / 2;
		$(".choose-city-div").css({
			"left": m_l + "px",
			"top": m_t + "px"
		});
	}

	function hideDiv() {
		$.cookie('close_choose_city', 1, {
			expires: 7
		});
		$(".choose-city-div").hide();
		$(".choose-city-overlay").hide();
	}

	//PJAX跳转执行
	$(document).on('pjax:complete', function() {});

	//PJAX开始
	$(document).on('pjax:start', function() {
		sessionStorage.removeItem('index_swiper');
		sessionStorage.removeItem('merchant_swiper');
	});

	//PJAX前进、返回执行
	$(document).on('pjax:popstate', function() {});

	//PJAX历史和跳转都会执行的方法
	$(document).on('pjax:end', function() {
		ecjia.pc.init();
	});

})(ecjia, jQuery);

//end