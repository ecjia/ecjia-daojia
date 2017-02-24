/**
 * 后台综合js文件
 */
;(function(ecjia, $) {
	ecjia.admin = {
		/* ECJiaAdmin下，默认的option参数 */
		defaultOptions : {
			validate : {
				onkeyup: false,
				errorPlacement: function(error, element) {
					error.appendTo( element.closest("div.controls") );
				},
				highlight: function(element) {
					$(element).closest("div.control-group").addClass("error f_error");
					var thisStep = $(element).closest('form').prev('ul').find('.current-step');
					thisStep.addClass('error-image');
				},
				unhighlight: function(element) {
					$(element).closest("div.control-group").removeClass("error f_error");
					if (!$(element).closest('form').find('div.error').length) {
						var thisStep = $(element).closest('form').prev('ul').find('.current-step');
						thisStep.removeClass('error-image');
					};
				}
			}
		},
		init : function() {
	        $('html').addClass('loadding').find('.main_content').css('opacity',1);
	        setTimeout(function(){$('html').removeClass('pjaxLoadding-busy loadding').find('.main_content').css('transition','all 0 ease 0')},500);
			/* search typeahead导航快速搜索的联想方法 */
			$('#side_accordion').on('hidden shown', function () {
				ecjia.admin.sidebar.make_active();
				ecjia.admin.sidebar.update_scroll();
			});
			/* resize elements on window resize */
			var lastWindowHeight = $(window).height();
			var lastWindowWidth = $(window).width();
			$(window).on("debouncedresize",function() {
				if ($(window).height()!=lastWindowHeight || $(window).width()!=lastWindowWidth) {
					lastWindowHeight = $(window).height();
					lastWindowWidth = $(window).width();
					ecjia.admin.sidebar.update_scroll();
				}
			});

            // 设置ajax提交默认项
            ecjia.admin.set_ajax_submit_option();
			/* sidebar */
			ecjia.admin.sidebar.init();
			ecjia.admin.sidebar.make_active();
			/* accordion icons*/
			ecjia.admin.acc_icons.init();

            /* 设置提示插件 */
            ecjia.admin.set_sticky();

			/* 左侧导航状态记录*/
			ecjia.admin.nav_state();
			/* 左侧导航快速搜索 */
			ecjia.admin.nav_search();

			/* main menu mouseover */
			ecjia.admin.nav_mouseover.init();
			/* top submenu */
			ecjia.admin.submenu.init();

			ecjia.admin.sidebar.make_scroll();
			ecjia.admin.sidebar.update_scroll();
			ecjia.admin.sidebar.make_scroll_content();

			/* 新增全局跳转提示方法 */
			ecjia.admin.alert_go();

			/* to top */
			$().UItoTop({inDelay:200,outDelay:200,scrollSpeed: 500});

			$('body').on('touchstart.dropdown', '.dropdown-menu', function (e) { e.stopPropagation(); });
		},

        set_ajax_submit_option : function() {
            $.ajaxSettings.error = function(data) {
              var info = admin_lang.request_failed + data.status + admin_lang.error_msg + data.statusText;
//                var info = '请求失败，错误编号：'+data.status + '，错误信息：' + data.statusText;
                ecjia.admin.showmessage({state: 'error', message:info});
            };
        },

        /**
         * 设置ECJia后台环境支持方法
         */
        set_sticky : function() {
            if (!ecjia.admin.sticky && $.fn.sticky) ecjia.admin.sticky = function(note, options, callback) { return $.fn.sticky(note, options, callback)};
        },

		/* 侧边栏 */
		sidebar : {
			init: function() {
				/*  sidebar onload state */
				if ($(window).width() > 979) {
					if (!$('body').hasClass('sidebar_hidden')) {
						if ( $.cookie('ecjia_sidebar') == "hidden") {
							$('body').addClass('sidebar_hidden');
//                            $('.sidebar_switch').toggleClass('on_switch off_switch').attr('title','显示侧边栏');
							$('.sidebar_switch').toggleClass('on_switch off_switch').attr('title',admin_lang.display_sidebar);
						}
					} else {
//                        $('.sidebar_switch').toggleClass('on_switch off_switch').attr('title','显示侧边栏');
						$('.sidebar_switch').toggleClass('on_switch off_switch').attr('title',admin_lang.display_sidebar);
					}
				} else {
					$('body').addClass('sidebar_hidden');
					$('.sidebar_switch').removeClass('on_switch').addClass('off_switch');
				}

				ecjia.admin.sidebar.info_box();

				/* sidebar visibility switch */
				$('.sidebar_switch').click(function() {
					$('.sidebar_switch').removeClass('on_switch off_switch');
					if ( $('body').hasClass('sidebar_hidden') ) {
						$.cookie('ecjia_sidebar', null);
						$('body').removeClass('sidebar_hidden');
						$('.sidebar_switch').addClass('on_switch').show();
//                        $('.sidebar_switch').attr( 'title', "隐藏侧边栏" );
						$('.sidebar_switch').attr( 'title', admin_lang.hide_sidebar);
					} else {
						$.cookie('ecjia_sidebar', 'hidden');
						$('body').addClass('sidebar_hidden');
						$('.sidebar_switch').addClass('off_switch');
//						$('.sidebar_switch').attr( 'title', "显示侧边栏" );
						$('.sidebar_switch').attr( 'title', admin_lang.display_sidebar);
					};
					ecjia.admin.sidebar.info_box();
					ecjia.admin.sidebar.update_scroll();
					$(window).resize();
				});
				/* prevent accordion link click */
				$('.sidebar .accordion-toggle').click(function(e) {e.preventDefault()});
			},
			info_box: function() {
				 var s_box = $('.sidebar_info');
				 var s_box_height = s_box.actual('height');
				 s_box.css({
				 	'height'		: s_box_height
				 });
				 $('.push').height(s_box_height);
				 $('.sidebar_inner').css({
				 	'margin-bottom' : '-'+s_box_height+'px',
                    'min-height'	: '100%'
				 });
			},
			make_active: function() {
				var thisAccordion = $('#side_accordion');
				thisAccordion.find('.accordion-heading').removeClass('sdb_h_active');
				var thisHeading = thisAccordion.find('.accordion-body.in').prev('.accordion-heading');
				if (thisHeading.length) {
					thisHeading.addClass('sdb_h_active');
				}
			},
			make_scroll: function() {
    			if($('.antiScroll').length) {
    				antiScroll = $('.antiScroll').antiscroll().data('antiscroll');
    			}
			},
			update_scroll: function() {
    			if($('.antiScroll').length) {
    				if( $(window).width() > 979 ){
    					$('.antiscroll-inner,.antiscroll-content').height($(window).height() - 40);
    				} else {
    					$('.antiscroll-inner,.antiscroll-content').height('400px');
    				}
    				antiScroll.refresh();
    			}
			},
			make_scroll_content: function() {
				//if ($('.main_content').length && navigator.userAgent.indexOf("Mac OS X") < 0) {
				//	$('html').niceScroll(
				//		{
				//			cursorcolor:"#424242",
				//			background: "#eee",
				//			bouncescroll: false,
				//			scrollspeed: 100,
				//			cursoropacitymax:1,
				//			touchbehavior:false,
				//			cursorwidth:"8px",
				//			cursorborder:"0",
				//			cursorborderradius:"5px"
				//		}
				//	);
				//}
				// $('.antiscroll-content').niceScroll(
				// 	{
				// 		cursorcolor:"#424242",
				// 		// background: "#eee",
				// 		bouncescroll: false,
				// 		scrollspeed: 100,
				// 		cursoropacitymax:0.55,
				// 		touchbehavior:false,
				// 		cursorwidth:"8px",
				// 		cursorborder:"0",
				// 		cursorborderradius:"5px"
				// 	}
				// );
			}

		},

		/* 子菜单 */
		submenu : {
			init: function() {
				$('.dropdown-menu li').each(function() {
					var $this = $(this);
					if ($this.children('ul').length) {
						$this.addClass('sub-dropdown');
						$this.children('ul').addClass('sub-menu');
					}
				});

				$('.sub-dropdown').on('mouseenter',function() {
					$(this).addClass('active').children('ul').addClass('sub-open');
				}).on('mouseleave', function() {
					$(this).removeClass('active').children('ul').removeClass('sub-open');
				})

			}
		},

		/* 折叠框bs效果加强 */
		acc_icons : {
			init: function() {
				var accordion_t = $('.foldable-list');
				var accordion = $('.accordion');
				ecjia.admin.acc_icons.accordions(accordion_t);
				ecjia.admin.acc_icons.accordions(accordion);
			},
			accordions : function(accordions) {
				accordions.find('.accordion-group').each(function() {
					var acc_active = $(this).find('.accordion-body').filter('.in');
					acc_active.prev('.accordion-heading').find('.accordion-toggle').addClass('acc-in');
				});
				accordions.on('show', function(option) {
					/*其他bootstrap元素在手风琴效果被遮挡的解决方法*/
					var target = option.target.attributes[0].value;
					setTimeout("$('#"+target+"').addClass('in_visable')",300);
					$(this).find('.accordion-toggle').has('.is-accordion').removeClass('acc-in');
					$(option.target).prev('.accordion-heading').find('.accordion-toggle').addClass('acc-in');

					/* 储存当前选择的展开框 */
					var nav_state_id = $(option.target).prev('.accordion-heading').find('.accordion-toggle').attr('href');
					if (nav_state_id != undefined) {
						$.cookie('ecjia_nav_state_id', nav_state_id, { expires: 7});/* '#collapse_search_query' != nav_state_id && $.cookie('sortIndex', str, { expires: 7}); */
					}
				});
				accordions.on('hide', function(option) {
					$(option.target).removeClass('in_visable');
					$(option.target).prev('.accordion-heading').find('.accordion-toggle').removeClass('acc-in');
					$.cookie('ecjia_nav_state_id', null);
				});
			}
		},

		nav_state : function() {
			// $.cookie('ecjia_nav_state_id') && $($.cookie('ecjia_nav_state_id')).collapse('show');
			var showdiv_id = $.cookie('ecjia_nav_state_id') || '#collapse101';
			if ($(showdiv_id).length) {
				$(showdiv_id).addClass('in').css("height","auto").siblings('.accordion-heading').addClass('sdb_h_active').children().addClass("act-in");
			}
		},

		/* 左侧导航快速搜索 */
		nav_search : function() {
			/* li搜索筛选功能 */
			$('.search_query').quicksearch(
				$('#collapse_search_query li' ).not('.search_query_none'),
				{
					onAfter : function(){
						$.trim($('.search_query').val()) == '' && $('#collapse_search_query li' ).not('.search_query_none').removeClass('isShow').css('display','none');
//                        $('#collapse_search_query .accordion-inner .isShow').length == 0 ? ($('.search_query').val() == '' ? $('.search_query_none').text('请先输入搜索信息').show() : $('.search_query_none').text('未搜索到导航信息').show()) : $('.search_query_none').hide();
						$('#collapse_search_query .accordion-inner .isShow').length == 0 ? ($('.search_query').val() == '' ? $('.search_query_none').text(admin_lang.search_check).show() : $('.search_query_none').text(admin_lang.search_no_message).show()) : $('.search_query_none').hide();
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
			$('.search_query_btn').on('click', function() {
				$('.search_query_close').trigger('click');
			});
		},

		/* 导航鼠标经过事件 */
		nav_mouseover : {
			init: function() {
				$('header li.dropdown').mouseenter(function() {
					if ($('body').hasClass('menu_hover')) {
						$(this).addClass('navHover')
					}
				}).mouseleave(function() {
					if ($('body').hasClass('menu_hover')) {
						$(this).removeClass('navHover open')
					}
				});
				$('header li.dropdown > a').click(function() {
					if ($('body').hasClass('menu_hover')) {
						window.location = $(this).attr('href');
					}
				});
			}
		},

		/*
		 * 跳转提示方法
		 */
		alert_go : function() {
			$('a[data-toggle="alertgo"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
//                	message = $this.attr('data-message') || '是否确认跳转？',
					message = $this.attr('data-message') || admin_lang.confirm_jump,
					
					href 	= $this.attr('href') || '#';

				smoke.confirm(message, function(e){
					e && ecjia.pjax(href);
//                }, {ok:'确定', cancel:'取消'});
				}, {ok:admin_lang.ok, cancel:admin_lang.cancel});
			});
		},

		/**
		 * 展示信息，成功和失败。
		 */
		showmessage : function(options) {
			var defaults = {
				message		: false,												/* message 提示信息 */
				state		: 'success',											/* state 信息状态 */
				links		: false,												/* links 链接对象 */
				close		: true,													/* close 是否可以关闭 */
				$areaobj	: $('.breadCrumb') || $('.main_content'),				/* $areaobj 显示提示信息的地方 */
				areaobj		: $('.breadCrumb') ? '.breadCrumb' : '.main_content',	/* areaobj 显示提示信息的地方的名称 */
				pjaxurl		: '',													/* pjax刷新页面后显示message的时候传递的pjaxURL参数 */
				close_self	: 5000,													/* 自动关闭提示内容 */
			}

			var options = $.extend({}, defaults, options);

			var tmp = '<p>';

			if (!options.message) {
//                options.message = (options.state == 'error') ? '操作失败' : '操作成功';
				options.message = (options.state == 'error') ? admin_lang.fail : admin_lang.success;
			}

			options.state = (options.state == 'error')? 'alert-error': 'alert-success';

			if (options.links) {
				for (var i = 0; i < options.links.length; i++) {
					tmp += '<a class="data-pjax m_r15" href="' + options.links[i].href + '">' + options.links[i].text + '</a>';
				}
				tmp += '</p>';
				options.message = '<p>' + options.message + '</p>' + tmp;
			}
			var _close = options.close ? '<a class="close" data-dismiss="alert">×</a>' : '';

			var alert_obj = $('<div class="staticalert alert ' + options.state + ' ui_showmessage">' + _close + options.message + '</div>');

			options.close_self >= 1000 && !options.links && window.setTimeout(function() {alert_obj.remove()}, options.close_self);

			options.pjaxurl &&  ecjia.pjax(options.pjaxurl,function() { $(options.areaobj).after(alert_obj); return; });

			$('.ui_showmessage').find('.close').parent().remove();
			options.$areaobj.after(alert_obj);
			$('#toTop').trigger('click');

				// var alert_obj = $('<div class="staticalert alert '+options.state+' ui_showmessage">' + _close + options.message + '</div>');
				// var alert_obj = $('<div class="staticalert alert '+options.state+' ui_showmessage">' + _close + options.message + '</div>');
				// $('#toTop').trigger('click');
		},



		save_sortIndex : function(name) {
			var elem = [];
			$('.move-mod').not('.not_sortable').each(function() {
				elem.push($(this).sortable("toArray"));
			});
			var str = '',
				m_len = elem.length;
			$.each(elem, function(index,value) {
				var s_len = value.length;
				if (value == '') {
					str += 'null';
				} else {
					$.each(value, function(index,value) {
						str += value;
						if  (index != s_len - 1) {
							str += ","
						}
					});
				}
				if  (index != m_len - 1) {
					str += ";"
				}
			});

			var options = $.extend({}, {name : 'tmp', val : 'tmpinfo'}, {name : name, val : str}),
				sortIndex = JSON.parse($.cookie('ecjia_sortIndex')),
				is_merge = false,
				ecjia_sortIndex = [];

				for (var i in sortIndex) {
					if (sortIndex[i].name == options.name) {
						is_merge = true;
						sortIndex[i].val = options.val;
					}
					ecjia_sortIndex.push(sortIndex[i]);
				}

				if (!is_merge) {
					ecjia_sortIndex.push(options);
				}

			$.cookie('ecjia_sortIndex', JSON.stringify(ecjia_sortIndex), { expires: 31});
		},

		set_sortIndex : function(name) {
			var sortIndex = JSON.parse($.cookie('ecjia_sortIndex')),
				ecjia_sortIndex = null;

			for (var i in sortIndex) {
				if (name == sortIndex[i].name) {
					ecjia_sortIndex = sortIndex[i].val;
					break;
				}
			}

			if (ecjia_sortIndex != null) {
				$.each(ecjia_sortIndex.split(';'),function(i,id) {
					thisSortable = $('.move-mod').not('.not_sortable').get(i);
					if (id != 'null') {
						$.each(id.split(','),function(i,id) {
							$("#"+id).appendTo(thisSortable);
						});
					}
				})
			}
		},

	};

    ecjia.pjaxloadding = function() {
        $('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
    };

    ecjia.setpjax = function() {
		/* PJAX基础配置项 */
		ecjia.pjaxoption = {
			timeout: 10000,
			container: '.main_content', /* 内容替换的容器 */
			cache: false,  /* 是否使用缓存 */
			storage: false,  /* 是否使用本地存储 */
			titleSuffix: '' /* 标题后缀 */
		};

		/* ecjia.pjax */
		ecjia.extend({
			pjax : function(url, callback) {
				var option = $.extend( ecjia.pjaxoption , { url : url, callback : callback } );
				$.pjax(option);
				delete ecjia.pjaxoption.url;
				delete ecjia.pjaxoption.callback;
			}
		});
		/* pjax刷新当前页面 */
		ecjia.pjax.reload = function() {
			$.pjax.reload(ecjia.pjaxoption.container, ecjia.pjaxoption);
		};
		/* 移动pjax方法的调用，使用document元素委派pjax点击事件 */
		if ($.support.pjax) {
			$(document).on('click', 'a.data-pjax', function(event) {
				$.pjax.click(event, ecjia.pjaxoption.container, ecjia.pjaxoption);
			});
		}
    };

    ecjia.setpjax();

    $(function() {
        ecjia.admin.init();
    });


	//PJAX跳转执行
	$(document).on('pjax:complete', function() {
	});

	//PJAX开始
	$(document).on('pjax:start', function(){
        //增加一个加载动画
        $('html').addClass('pjaxLoadding-busy');
	});

	//PJAX前进、返回执行
	$(document).on('pjax:popstate', function() {
	});

	//PJAX历史和跳转都会执行的方法
	$(document).on('pjax:end', function() {
        ecjia.admin.acc_icons.init();
        $('html').addClass('loadding');
        setTimeout(function(){$('html').removeClass('pjaxLoadding-busy loadding')},300);
	});

	/* 页面载入后自动执行 */
	// $(function() {
	// 	ecjia.admin.init();
	// }).on('pjax.end', '.main_content', function() {
	// 	ecjia.admin.acc_icons.init();
	// });
})(ecjia, jQuery);
