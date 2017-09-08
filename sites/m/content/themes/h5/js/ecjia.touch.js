/**
 * 后台综合js文件
 */
;
(function(ecjia, $) {
	ecjia.touch = {
		init: function() {
			if ($.cookie('h5_index') === undefined) {
				var key = $("input[name='key']").val();
				var referer = $("input[name='referer']").val();
				var geolocation = new qq.maps.Geolocation(key, referer);
				geolocation.getLocation(showPosition, showErr);

				function showPosition(result) {
					var lat = result.lat;
					var lng = result.lng;
					var url = $("#get_location").attr('data-url');
					url += '&lat=' + lat + '&lng=' + lng;
					$.ajax({
						url: url,
						type: "GET",
						dataType: "json",
						success: function(data) {
							ecjia.pjax(data.url);
						},
					});
				};
				function showErr(err) {
					console.log(err);
				};
				var date = new Date();
				date.setTime(date.getTime() + (30 * 60 * 1000));
				$.cookie('h5_index', 'first', {expires: date});
			}

			ecjia.touch.setpjax();
			ecjia.touch.asynclist();
			ecjia.touch.ecjia_menu();
			ecjia.touch.region_change();
			ecjia.touch.selectbox();
			ecjia.touch.valid();
			ecjia.touch.toggle_collapse();
			ecjia.touch.close_banner();
			ecjia.touch.close_app_download();
			ecjia.touch.search_header();
			ecjia.touch.del_history();
			ecjia.touch.share_spread();

			$("body").greenCheck();
		},

		//搜索关键词定位开始
		address_list: function() {
			$('#search_location_list').koala({
				delay: 300,
				keyup: function(event) {
					var url = $(this).attr('data-url');
					var region = $(".ecjia-zu").children().html();
					var keywords = $("input[name='address']").val();
					if (region != 'undefined') {
						url += '&region=' + region
					}
					if (keywords != 'undefined') {
						url += '&keywords=' + keywords;
					}
					if (keywords == '') {
						$('.ecjia-zw').show();
						$('.ecjia-list.ecjia-address-list.ecjia-select-address').show();
						$('.ecjia-location-list-wrap.near-location-list').show();
						$('.ecjia-location-list-wrap.location-search-result').html('');
						$('.ecjia-near-address').show();
					} else {
						$('.ecjia-zw').hide();
						$('.ecjia-list.ecjia-address-list.ecjia-select-address').hide();
						$('.ecjia-location-list-wrap.near-location-list').hide();
						$('.ecjia-location-list-wrap.location-search-result').html('');
						$('.ecjia-near-address').hide();
					}
					$.ajax({
						url: url,
						type: "GET",
						dataType: "json",
						success: function(data) {
							ecjia.touch.address_value(data.content.data);
						},
					});
				}
			});
			ecjia.touch.add_link();
		},

		address_value: function(data) {
			if (data) {
				if (data.length > 0) {
					for (var i = 0; i < data.length; i++) {
						var opt = '<li data-lng="' + data[i].location.lng + '" data-lat="' + data[i].location.lat + '"><p class="list_wrapper a1"><span class="ecjia-list_title ecjia-location-list-title">' + data[i].title + '</span><span class="ecjia-list_title ecjia-location-list-address">' + data[i].address + '</span></p></li>'
						$('.ecjia-location-list-wrap.location-search-result').append(opt);
					};
				}
			}
			ecjia.touch.add_link();
		},

		//点击搜索结果事件
		add_link: function() {
			var type = $("#ecjia-zs").attr('data-type');
			if (type == 'index') {
				var Uarry = $(".ecjia-location-list-wrap li");
				$('.ecjia-location-list-wrap li').bind('click', function() {
					var lng = $(this).attr("data-lng");
					var lat = $(this).attr("data-lat");
					var count = $(this).index();
					var Tresult = Uarry.eq(count).text();
					var title = $(this).children().children("span[class*='ecjia-location-list-title']").html();
					var address = $(this).children().children("span[class*='ecjia-location-list-address']").html();
					var city_id = $('input[name="city_id"]').val();
					var city_name = $('input[name="city_name"]').val();

					var date = new Date();
					date.setTime(date.getTime() + (30 * 60 * 1000));

					$.cookie('location_address', address, {
						expires: date
					});
					$.cookie('location_name', title, {
						expires: date
					});
					$.cookie('longitude', lng, {
						expires: date
					});
					$.cookie('latitude', lat, {
						expires: date
					});
					$.cookie('location_address_id', 0, {
						expires: date
					});

					$.cookie('city_id', city_id, {
						expires: date
					});
					$.cookie('city_name', city_name, {
						expires: date
					});

					var referer_url = $.cookie('referer_url');
					var url = $("#ecjia-zs").attr('data-url');
					if (referer_url != undefined && referer_url.length == 0) {
						referer_url = url;
					}
					ecjia.pjax(referer_url);
					$.cookie('referer_url', '', 1);
				});
			} else if (type == 'address') {
				$('.ecjia-location-list-wrap li').bind('click', function() {
					var lng = $(this).attr("data-lng");
					var lat = $(this).attr("data-lat");
					var title = $(this).find(".ecjia-location-list-title").text();
					var address = $(this).find(".ecjia-location-list-address").text();
					var url = $("#ecjia-zs").attr('data-url');
					url += '&addr=' + address + '&name=' + title + '&latng=' + lat + ',' + lng;
					ecjia.pjax(url);
				});
			}
		},
		//搜索关键词定位结束
		
		share_spread : function() {
			var info = {
    			'url' : window.location.href
    		};
			var url = $('input[name="spread_url"]').val();
        	if (url != undefined) {
        		return false;
        	}
			var wxconfig_url = $('input[name="wxconfig_url"]').val();
        	if (wxconfig_url == undefined) {
        		return false;
        	}
        	var desc = $('textarea[name="invite_template"]').val();

        	$.post(wxconfig_url, info, function(response){
        		if (response == '') {return false;}
        		var data = response.data;
        		if (data.appId != '') {
	        		wx.config({
	        			debug: false,
	        			appId: data.appId,
	        			timestamp: data.timestamp,
	        			nonceStr: data.nonceStr,
	        			signature: data.signature,
	        			jsApiList: [
	        				'checkJsApi',
	        				'onMenuShareTimeline',
	        				'onMenuShareAppMessage',
	        				'onMenuShareQQ',
	        				'hideOptionMenu',
	        			]
	        		});
	        		wx.error(function(res){
	        			console.log(res);
	        		    // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
	        		});
	        		var title = document.title;
	        		var link = window.history.state != null ? window.history.state.url : window.location.href;
	        		var image = '';
	        		var desc = link;
	        		wx.ready(function () {
	        			//分享到朋友圈
	        			wx.onMenuShareTimeline({
	        		        title: title, 					// 分享标题【必填】
	        		        link: link, 					// 分享链接【必填】
	        		        imgUrl: image, 					// 分享图标【必填】
	        		        success: function () { 
	        		            // 用户确认分享后执行的回调函数
	        		        },
	        		        cancel: function () { 
	        		            // 用户取消分享后执行的回调函数
	        		        }
	        		    });
	
	        			//分享给朋友
	        		    wx.onMenuShareAppMessage({
	        		        title: title, 					// 分享标题【必填】
	        		        desc: desc,	 					// 分享描述【必填】
	        		        link: link, 					// 分享链接【必填】
	        		        imgUrl: image, 					// 分享图标【必填】
	        		        type: 'link', 					// 分享类型,music、video或link，不填默认为link【必填】
	        		        dataUrl: '', 					// 如果type是music或video，则要提供数据链接，默认为空
	        		        success: function () { 
	        		            // 用户确认分享后执行的回调函数
	        		        	alert(1);
	        		        },
	        		        cancel: function () { 
	        		            // 用户取消分享后执行的回调函数
	        		        }
	        		    });
	
	        		    //分享到QQ
	        		    wx.onMenuShareQQ({
	        		        title: title, 					// 分享标题
	        		        desc: desc, 					// 分享描述
	        		        link: link, 					// 分享链接
	        		        imgUrl: image, 					// 分享图标
	        		        success: function () { 
	        		           // 用户确认分享后执行的回调函数
	        		        },
	        		        cancel: function () { 
	        		           // 用户取消分享后执行的回调函数
	        		        }
	        		    });
	        		});	
        		}
        	});
		},
		
		
		/**
		 * 设置PJAX
		 */
		setpjax: function() { 
			/* PJAX基础配置项 */
			ecjia.pjaxoption = {
				timeout: 10000,
				container: '.ecjia', 	/* 内容替换的容器 */
				cache: false, 			/* 是否使用缓存 */
				storage: false, 		/* 是否使用本地存储 */
				titleSuffix: '.pjax' 	/* 标题后缀 */
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

		pjaxloadding: function() {
			//增加一个加载动画
			$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
		},

		/**
		 * 展示信息，成功和失败。
		 */
		showmessage: function(options) {
			var defaults = {
				message: false, 	/* message 提示信息 */
				is_show: true, 		/* message 提示信息 */
				state: 'success', 	/* state 信息状态 */
				links: false, 		/* links 链接对象 */
				close: true, 		/* close 是否可以关闭 */
				pjaxurl: '' 		/* pjax刷新页面后显示message的时候传递的pjaxURL参数 */
			};

			var options = $.extend({}, defaults, options);
			options.message && options.is_show && alert(options.message);
			options.pjaxurl && ecjia.pjax(options.pjaxurl);
		},

		alert: function(text) {
			var app = new Framework7({
				modalButtonOk: "确定",
				modalTitle: ''
			});
			app.alert(text);
		},

		/**
		 * 加载列表的触发器方法
		 */
		asynclist: function() {
			if ($('[data-toggle="asynclist"]').length) {
				var $this = $('[data-toggle="asynclist"]'),
					options = {
						areaSelect: '[data-toggle="asynclist"]',
						areaClass: $this.attr('class'),
						url: $this.attr('data-url'),
						size: $this.attr('data-size'),
						page: $this.attr('data-page'),
						type: $this.attr('data-type'),
						color: $this.attr('data-color')
					};
				ecjia.touch.more(options);
				$loader = $('<a class="load-list" style="background-color:'+options.color+'" href="javascript:;"><div class="loaders"><div class="loader"><div class="loader-inner ball-pulse"><div></div><div></div><div></div></div></div></div></a>');
				if ($this.parent().find('.load-list').length == 0) {
					$this.after($loader);
				}
			}
		},

		/**
		 * 加载列表方法
		 */
		more: function(options) {
			$('.is-last').remove();
			$(window).scrollTop(0);
			var defaults = {
				url: false, 				//url 			请求地址
				page: 1, 					//page			分页
				size: 10, 					//size			分页数量
				areaSelect: '#J_ItemList', 	//areaSelect	模块select
				areaClass: '', 				//areaClass		模块class
				scroll: true, 				//scroll		滑动加载
				offset: 100, 				//offset		滑动预留
				trigger: '.load-list', 		//trigger		点击的触发器
				lock: false, 				//lock			锁
				type: '',  					//type			类型
			},
				options = $.extend({}, defaults, options),
				scroll_list = function() {
					if (!options.lock && ($(window).scrollTop() > $(document).height() - $(window).height() - options.offset)) {
						var area_class = options.areaClass;
						options.areaClass = options.areaClass.replace(new RegExp(' ', 'gm'), '.'); //替换空格为点，多个class
						if ($('.' + options.areaClass).parent().find('.is-last').length != 0) {
							return false;
						}
						options.areaClass = area_class;
						
						options.lock = true;
						ecjia.touch.load_list(options);
						options.page++;
					}
				};
			scroll_list();
			if (options.scroll) {
				window.onscroll = function() {
					scroll_list();
				};
				$('.wd').scroll(function() {
					scroll_list();
				});
				$('.store-container').scroll(function() {
					scroll_list();
				});
			} else {
				var add_more_btn = '<button id="load_more_btn" class="btn btn-default btn-lg">点击加载更多</button>';
				$('[data-flag="add_load_more_btn"]').after(add_more_btn);
				$("#load_more_btn").on("click", function() {
					scroll_list();
					$(this).attr("data-scroll", "false");
				});
			}
		},
		more_callback: function() {
			ecjia.touch.delete_list_click();
		},

		/**
		 * 数据操作方法
		 */
		load_list: function(options) {
			if (!options.url) return console.log('缺少参数！');
			$(options.trigger).show();
			if ($('[data-toggle="asynclist"]').attr('class') == options.areaClass) {
				$('[data-toggle="asynclist"]').attr('data-page', parseInt(options.page) + 1);
			}
			$.get(options.url, {
				page: options.page,
				size: options.size,
				action_type: options.type
			}, function(data) {
				if ($(options.areaSelect).hasClass(options.areaClass)) {
					var area_class = options.areaClass;
					options.areaClass = options.areaClass.replace(new RegExp(' ', 'gm'), '.'); //替换空格为点，多个class
					$('.' + options.areaClass).append(data.list);
					options.areaClass = area_class;
				}
				options.lock = data.is_last;
				$(options.trigger).hide();
				if (data.is_last == 1) {
					$(options.trigger).addClass('is-last');
					$("#load_more_btn").remove();
				}
				if (data.spec_goods) {
					if (window.releated_goods != undefined) {
						$.extend(window.releated_goods, data.spec_goods);
					} else {
						window.releated_goods = data.spec_goods;
					}
				}
				ecjia.touch.more_callback();
				var list_length = $.trim(data.list).length;
				ecjia.touch.update_hot_time(list_length);
				ecjia.touch.category.add_tocart();
				ecjia.touch.category.remove_tocart();
				ecjia.touch.category.store_toggle();
				ecjia.touch.record_time();
				ecjia.touch.category.image_preview();
			});
		},

		record_time: function() {
			$('.record-time-12:first').show();
			$('.record-time-11:first').show();
			$('.record-time-10:first').show();
			$('.record-time-09:first').show();
			$('.record-time-08:first').show();
			$('.record-time-07:first').show();
			$('.record-time-06:first').show();
			$('.record-time-05:first').show();
			$('.record-time-04:first').show();
			$('.record-time-03:first').show();
			$('.record-time-02:first').show();
			$('.record-time-01:first').show();
		},

		delete_list_click: function() {
			$(document).off('click', '[data-toggle="del_list"]');
			$(document).on('click', '[data-toggle="del_list"]', function(e) {
				e.preventDefault();
				var $this = $(this),
					id = $this.attr('data-id'),
					msg = $this.attr('data-msg') ? $this.attr('data-msg') : '您确定要删除此条信息吗？',
					url = $this.attr('data-url');
				if (id && url) {
					var myApp = new Framework7({
						modalButtonCancel: '取消',
						modalButtonOk: '确定',
						modalTitle: ''
					});
					myApp.confirm(msg, function() {
						ecjia.touch.delete_list({
							id: id,
							url: url
						});
					});
				}
			});
		},

		delete_list: function(options) {
			$.get(options.url, {
				id: options.id
			}, function(data) {
				ecjia.touch.showmessage(data);
			}, 'json');
		},

		/* 下方相关商品滑动块的JS */
		touch_slide: function() {
			TouchSlide({
				slideCell: "#picScroll",
				titCell: ".hd ul", 	//开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
				autoPage: "true", 	//自动分页
				pnLoop: "false", 	// 前后按钮不循环
				switchLoad: "_src" 	//切换加载，真实图片路径为"_src"
			});
		},

		region_change: function() {
			$('[data-toggle="region_change"]').on('change', function() {
				var $this = $(this),
					id = $this.attr("id"),
					index = $this.attr("data-index") || '',
					url = $this.attr("data-url"),
					type = $this.attr("data-type"),
					target = $this.attr("data-target"),
					parent = $this.val();
				if ($("#selCountries" + index).val() == 0) {
					$("#selProvinces" + index).children("option:gt(0)").remove();
					$("#selCities" + index).children("option:gt(0)").remove();
					$("#selDistricts" + index).children("option:gt(0)").remove();
					//$("#selDistricts"+index).hide();
				} else {
					if (id == "selCountries" + index) {
						//$("#selDistricts"+index).hide();
					} else if (id == "selProvinces") {
						//$("#selDistricts"+index).hide();
						if ($("#selProvinces" + index).val() == 0) {
							$("#selCities" + index).children("option:gt(0)").remove();
						}
					} else if (id == "selCities") {
						//$("#selDistricts"+index).show();
						if ($("#selCities" + index).val() == 0) {
							$("#selDistricts" + index).children("option:gt(0)").remove();
						}
					}
					$.get(url, {
						'type': type,
						'target': target,
						'parent': parent
					}, function(data) {
						if (data.state == 'success') {
							var opt = '';
							for (var i = 0; i < data.regions.length; i++) {
								opt += '<option value="' + data.regions[i].region_id + '">' + data.regions[i].region_name + '</option>';
							}
							if (id == "selCountries" + index) {
								$("#selProvinces" + index).children("option:gt(0)").remove();
								$("#selProvinces" + index).children("option").after(opt);
							} else if (id == "selProvinces" + index) {
								$("#selCities" + index).children("option:gt(0)").remove();
								$("#selCities" + index).children("option").after(opt);
							} else if (id == "selCities" + index) {
								$("#selDistricts" + index).children("option:gt(0)").remove();
								$('#selDistricts').show();
								$("#selDistricts" + index).children("option").after(opt);
							}
						} else {
							ecjia.touch.showmessage(data);
						}
					}, 'json');
				}

			});

			$('[data-toggle="choose_address"]').off('click').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					url = $this.attr('href'),
					referer = $this.attr('data-referer');
				if ($this.hasClass('disabled')) {
					return false;
				}
				$('[data-toggle="choose_address"]').addClass('disabled');
				if (url == undefined) {
					iosOverlay({
						text: '该地址超出配送范围',
						duration: 2e3,
						onbeforehide: function() {
							$('[data-toggle="choose_address"]').removeClass('disabled');
						},
					});
					return false;
				}
				if (referer != undefined) {
					referer = encodeURIComponent(referer);
					url += '&referer_url=' + referer;
				}
				$.get(url, function(data) {
					ecjia.pjax(data.pjaxurl);
				});
			})
		},

		ecjia_menu: function() {
			$(document).off('click', '.ecjia-menu .main');
			$(document).on('click', '.ecjia-menu .main', function() {
				if ($('.ecjia-menu').hasClass('active')) {
					$('.ecjia-menu').removeClass('active');
				} else {
					$('.ecjia-menu').addClass('active');
				}
			});
			var _x_start, _y_start, _x_move, _y_move, _x_end, _y_end, left_start, bottom_start, top_start;
			var length = $('.ecjia-menu').length;
			if (length > 0) {
				document.getElementById("ecjia-menu").addEventListener('touchstart', function(e) {
					_x_start = e.touches[0].pageX;
					_y_start = e.touches[0].pageY;
					left_start = $("#ecjia-menu").css("left");
					bottom_start = $("#ecjia-menu").css("bottom");
					top_start = $("#ecjia-menu").offset().top - $("body").scrollTop();
					//阻止浏览器下拉事件
					$('body').css('overflow-y', 'hidden').on('touchmove', function(event) {
						event.preventDefault;
					}, false);
				});
				document.getElementById("ecjia-menu").addEventListener('touchmove', function(e) {
					_x_move = e.touches[0].pageX;
					_y_move = e.touches[0].pageY;
					//$("#ecjia-menu").css("left", parseFloat(_x_move)-parseFloat(_x_start)+parseFloat(left_start)+"px");
					var bottom = parseFloat(_y_start) - parseFloat(_y_move) + parseFloat(bottom_start);
					var top = parseFloat(_y_move) - parseFloat(_y_start) + parseFloat(top_start);
					if (bottom < 100 || top < 250) {
						return false;
					}
					$("#ecjia-menu").css("bottom", bottom + 'px');
				});
				document.getElementById("ecjia-menu").addEventListener('touchend', function(e) {
					var _x_end = e.changedTouches[0].pageX;
					var _y_end = e.changedTouches[0].pageY;
					$('body').css('overflow-y', 'auto').off('touchmove');
				});
				$(".ecjia-menu .icon-top").click(function() {
					$('body,html').animate({
						scrollTop: 0
					}, 300);
					$('.ecjia-menu .main').click();
				});
			}
		},

		toggle_collapse: function() {
			$(document).on('click', '[data-trigger="collapse"]', function(e) {
				e.preventDefault();
				var o_this = $(this),
					o_parent = o_this.attr('data-parent') ? o_this.parents(o_this.attr('data-parent')) : o_this,
					o_toggle = o_parent.find(o_this.attr('href')) || o_this.next();

				o_parent.hasClass('active') ? o_parent.addClass('active') : o_parent.removeClass('active');

				if (o_toggle.is(":visible")) {
					o_toggle.hide();
				} else {
					o_toggle.show();
				}
			});
		},

		selectbox: function() {
			$('.ecjia-form select').each(function(index) {
				var obj_this = $(this),
					obj_abter = $('<div class="select"><i class="iconfont"></i></div>');
				obj_this.after(obj_abter);
				obj_abter.append(obj_this);
			});
		},
		
		valid: function() {
			var $ecjiaform = $(".ecjia-form");
			$ecjiaform.length && $ecjiaform.each(function(index) {
				var need_valid = $(this).attr('data-valid') == 'novalid' ? false : true;
				if (need_valid) {
					$(this).on('submit', function(e) {
						e.preventDefault();
						return false;
					}).Validform({
						tiptype: 4,
						ajaxPost: true,
						callback: function(data) {
							ecjia.touch.showmessage(data);
						}
					});
				}
			});
		},

		close_app_download: function() {
			$('.ecjia-app-download .icon-close').on('click', function() {
				$.cookie('hide_download', 1, {
					expires: 7
				});
				$('.ecjia-app-download').remove();
			});
		},

		close_banner: function() {
			$(document).off('click', '.close-banner');
			$(document).on('click', '.close-banner', function() {
				$('.bottom-banner img').slideUp();
				var url = $(this).attr('data-url');
				$.get(url, function() {});
			});
		},

		search_header: function() {
			var k = $('#keywordBox').val();
			$('#keywordBox').val('').focus().val(k);

			$('.btn-search').off('click').on('click', function(e) {
				var val = $('input[name="keywords"]').val().trim(),
					url = $('.ecjia-form').attr('action'),
					form = $('.ecjia-form');
				
				var is_order_list = $('input[name="keywords"]').attr("data-type");
				if (is_order_list) {
					if (!val) {
//						ecjia.pjax(url);
						return false;
					} else {
						ecjia.pjax(url + '&keywords=' + val);
						return false;
					}
				} else {
					if (!val) {
						$("#keywordBox").blur();
						return false;
					} else {
						ecjia.pjax(url + '&keywords=' + val);
						return false;
					}
				}
			});
			$('.search-goods').off('click').on('click', function() {
				var $this = $(this),
					url = $this.attr('data-url'),
					keywords = $this.attr('data-val');
				if (keywords && keywords != undefined) {
					url += '&keywords=' + keywords;
				};
				ecjia.pjax(url);
			});
		},

		enter_search: function() {
			$("body").keyup(function() {
				if (event.which == 13) {
					$('.btn-search').trigger('click');
				}
			});
		},

		del_history: function() {
			$(document).off('click', '[data-toggle="del_history"]');
			$(document).on('click', '[data-toggle="del_history"]', function(e) {
				e.preventDefault();
				var $this = $(this);
				var url = $this.attr('data-href') || $this.attr('href');

				var myApp = new Framework7();
				myApp.modal({
					title: '确定清空搜索记录？',
					buttons: [{
						text: '取消',
					}, {
						text: '确定',
						onClick: function() {
							$.get(url, function(data) {
								if (data.pjaxurl != '') {
									refresh_url = data.pjaxurl;
								} else {
									refresh_url = window.location.href;
								}
								ecjia.pjax(refresh_url);
							}, 'json');
						},
					}]
				});
			});
		},

		//更新热门推荐时间
		update_hot_time: function(length) {
			if (length != 0) {
				var nowTime = new Date(),
					hour = checkTime(nowTime.getHours()),
					minute = checkTime(nowTime.getMinutes()),
					time = hour + ':' + minute;

				var html = '<i class="icon-goods-hot"></i>' + time + ' 热门推荐已更新';
				$('.ecjia-new-goods').find('.goods-index-title').html(html);
			};
		},
	};

	function checkTime(i) {
		if (i < 10) {
			i = "0" + i;
		}
		return i;
	};
	
	//PJAX跳转执行
	$(document).on('pjax:complete', function() {
		window.onscroll = null;
		ecjia.touch.selectbox();
		ecjia.touch.valid();
		ecjia.touch.more_callback = function() {
			ecjia.touch.delete_list_click();
		};
	});

	//PJAX开始
	$(document).on('pjax:start', function() {
		ecjia.touch.index.removeItem();
		ecjia.touch.pjaxloadding();
		if (window.releated_goods != undefined && window.releated_goods.length != 0) {
			window.releated = $.extend({}, window.releated_goods);
		}
	});

	//PJAX前进、返回执行
//	$(document).on('pjax:popstate', function() {});

	//PJAX历史和跳转都会执行的方法
	$(document).on('pjax:end', function() {
		if (typeof(releated_goods) != "undefined") {
			if (releated_goods.length != 0) {
				window.releated_goods = $.extend({}, releated_goods, window.releated);
			}
		}
		if ($.find('.is-last').length == 0) {
			ecjia.touch.asynclist();
		}
		$('.la-ball-atom').remove();

		//关闭menu
		if ($('.ecjia-menu').hasClass('active')) {
			$('.ecjia-menu').removeClass('active');
		}
		ecjia.touch.search_header();
		ecjia.touch.category.init();
		ecjia.touch.index.swiper_promotion();
		ecjia.touch.ecjia_menu();
		ecjia.touch.region_change();
		ecjia.touch.goods_detail.change();
		ecjia.touch.index.init_swiper();
		ecjia.touch.share_spread();

		var ua = navigator.userAgent.toLowerCase();
		if (ua.match(/MicroMessenger/i) == "micromessenger" || ua.match(/ECJiaBrowse/i) == "ecjiabrowse") {
			var title = $(document).attr('title');
			var $body = $('body');
			document.title = title;
			var $iframe = $("<iframe style='display:none;' src='/favicon.ico'></iframe>");
			$iframe.on('pjax:end', function() {
				setTimeout(function() {
					$iframe.off('pjax:end').remove();
				}, 0);
			}).appendTo($body);
		}

		//从购物车进入商家店铺页面自动弹出购物车
		if ($.find('.ecjia-from-page').length) {
			var from = $('.ecjia-from-page').val();
			if (from == 'cart') {
				//超出范围的店铺
				if ($('.ecjia-from-page').hasClass('out-range')) {
					$('body').css('overflow-y', 'hidden').on('touchmove', function(event) {
						event.preventDefault;
					}, false); //禁用滚动条

					//弹出提示
					var myApp = new Framework7();
					myApp.modal({
						title: '您的定位已超出该店配送区域',
						buttons: [{
							text: '知道了',
							//点击确定后显示购物车
							onClick: function() {
								$('.modal').remove();
								$('.modal-overlay').remove();
								$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条

								//购物车不为空
								if ($('.minicart-goods-list').find('.a5n').length != 0) {
									//显示购物车
									ecjia.touch.category.show_cart();
									$(".ecjia-store-goods .a1n .a1x").css({
										overflow: "hidden"
									}); //禁用店铺商品滚动条
								}
							},
						}]
					});
				} else {
					//购物车不为空
					if ($('.minicart-goods-list').find('.a5n').length != 0) {
						//显示购物车
						ecjia.touch.category.show_cart();
						$(".ecjia-store-goods .a1n .a1x").css({
							overflow: "hidden"
						}); //禁用店铺商品滚动条
					}

				}
				return false;
			}
		}
	});
})(ecjia, jQuery);

$(function() { 
	/* 页面载入后自动执行 */
	ecjia.touch.init();
	window.alert = ecjia.touch.alert;
});

//end