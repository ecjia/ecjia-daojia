// JavaScript Document
;
(function(app, $) {
	app.mh_comment = {
		list_search: function() {
			$(".no-show-rank").on('click', function(e) {
				$('.hide-rank').hide();
			});
			$(".no-show-img").on('click', function(e) {
				$('.hide-img').hide();
			});
			$(".search_comment").on('click', function(e) {
				var url = $("form[name='searchForm']").attr('action');
				var keywords = $("input[name='keyword']").val();
				if (keywords != '') {
					url += '&keywords=' + keywords;
				}
				ecjia.pjax(url);
			});
		},

		comment_list: function() {
			$(".edit-hidden").mouseover(function() {
				$(this).children().find(".edit-list").css('visibility', 'visible');
			});
			$(".edit-hidden").mouseleave(function() {
				$(this).children().find(".edit-list").css('visibility', 'hidden');
			});
			$(".cursor_pointer").click(function() {
				$(this).parent().remove();
			})

			$("form[name='searchForm'] .btn-primary").on('click', function(e) {
				e.preventDefault();
				var url = $("form[name='searchForm']").attr('action');
				var keywords = $("input[name='keywords']").val();
				if (keywords != '') {
					url += '&keywords=' + keywords;
				}
				ecjia.pjax(url);
			});

			app.mh_comment.comment_reply();
		},

		comment_reply: function() {
			$(".comment_reply").on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('data-url');
				var comment_id = $(this).attr('data-id');
				var data = {
					reply_content: $("input[name='reply_content']").val(),
					comment_id: comment_id
				};
				$.get(url, data, function(data) {
					ecjia.merchant.showmessage(data);
				}, 'json');
			});
		},

		comment_info: function() {
			var $form = $("form[name='theForm']");
			var option = {
				submitHandler: function() {
					$form.ajaxSubmit({
						dataType: "json",
						success: function(data) {
							ecjia.merchant.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
			$form.validate(options);

			app.mh_comment.image_preview();

		},

		image_preview: function() {
			var initPhotoSwipeFromDOM = function(gallerySelector) {
					var parseThumbnailElements = function(el) {
							var thumbElements = el.childNodes,
								numNodes = thumbElements.length,
								items = [],
								figureEl, linkEl, size, item, divEl;
							for (var i = 0; i < numNodes; i++) {
								figureEl = thumbElements[i];
								if (figureEl.nodeType !== 1) {
									continue
								}
								divEl = figureEl.children[0];
								linkEl = divEl.children[0];
								//			            size = linkEl.getAttribute('data-size').split('x');
								size = [linkEl.children[0].naturalWidth, linkEl.children[0].naturalHeight];
								item = {
									src: linkEl.getAttribute('href'),
									w: parseInt(size[0], 10),
									h: parseInt(size[1], 10)
								};
								if (figureEl.children.length > 1) {
									item.title = figureEl.children[1].innerHTML
								}
								if (linkEl.children.length > 0) {
									item.msrc = linkEl.children[0].getAttribute('src')
								}
								item.el = figureEl;
								items.push(item)
							}
							return items
						};
					var closest = function closest(el, fn) {
							return el && (fn(el) ? el : closest(el.parentNode, fn))
						};
					var onThumbnailsClick = function(e) {
							e = e || window.event;
							e.preventDefault ? e.preventDefault() : e.returnValue = false;
							var eTarget = e.target || e.srcElement;
							var clickedListItem = closest(eTarget, function(el) {
								return (el.tagName && el.tagName.toUpperCase() === 'FIGURE')
							});
							if (!clickedListItem) {
								return
							}
							var clickedGallery = clickedListItem.parentNode,
								childNodes = clickedListItem.parentNode.childNodes,
								numChildNodes = childNodes.length,
								nodeIndex = 0,
								index;
							for (var i = 0; i < numChildNodes; i++) {
								if (childNodes[i].nodeType !== 1) {
									continue
								}
								if (childNodes[i] === clickedListItem) {
									index = nodeIndex;
									break
								}
								nodeIndex++
							}
							if (index >= 0) {
								openPhotoSwipe(index, clickedGallery)
							}
							return false
						};
					var photoswipeParseHash = function() {
							var hash = window.location.hash.substring(1),
								params = {};
							if (hash.length < 5) {
								return params
							}
							var vars = hash.split('&');
							for (var i = 0; i < vars.length; i++) {
								if (!vars[i]) {
									continue
								}
								var pair = vars[i].split('=');
								if (pair.length < 2) {
									continue
								}
								params[pair[0]] = pair[1]
							}
							if (params.gid) {
								params.gid = parseInt(params.gid, 10)
							}
							return params
						};
					var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
							var pswpElement = document.querySelectorAll('.pswp')[0],
								gallery, options, items;
							items = parseThumbnailElements(galleryElement);
							options = {
								barsSize: {
									top: 100,
									bottom: 100
								},
								fullscreenEl: false,
								shareButtons: [{
									id: 'wechat',
									label: js_lang.share_wechat,
									url: '#'
								}, {
									id: 'weibo',
									label: js_lang.sina_weibo,
									url: '#'
								}, {
									id: 'download',
									label: js_lang.save_picture,
									url: '{ { raw_image_url } }',
									download: true
								}],
								galleryUID: galleryElement.getAttribute('data-pswp-uid'),
								getThumbBoundsFn: function(index) {
									var thumbnail = items[index].el.getElementsByTagName('img')[0],
										pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
										rect = thumbnail.getBoundingClientRect();
									return {
										x: rect.left,
										y: rect.top + pageYScroll,
										w: rect.width
									}
								}
							};
							if (fromURL) {
								if (options.galleryPIDs) {
									for (var j = 0; j < items.length; j++) {
										if (items[j].pid == index) {
											options.index = j;
											break
										}
									}
								} else {
									options.index = parseInt(index, 10) - 1
								}
							} else {
								options.index = parseInt(index, 10)
							}
							if (isNaN(options.index)) {
								return
							}
							if (disableAnimation) {
								options.showAnimationDuration = 0
							}
							gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
							gallery.init()
						};
					var galleryElements = document.querySelectorAll(gallerySelector);
					for (var i = 0, l = galleryElements.length; i < l; i++) {
						galleryElements[i].setAttribute('data-pswp-uid', i + 1);
						galleryElements[i].onclick = onThumbnailsClick
					}
					var hashData = photoswipeParseHash();
					if (hashData.pid && hashData.gid) {
						openPhotoSwipe(hashData.pid, galleryElements[hashData.gid - 1], true, true)
					}
				};
			initPhotoSwipeFromDOM('.img-pwsp-list');
			$(".my-gallery>figure>div").each(function() {
				$(this).height($(this).width())
			});

			function more(obj, id) {
				if ($('#txt' + id).is(":hidden")) {
					$('#p' + id).hide();
					$('#txt' + id).show();
					obj.innerHTML = js_lang.collapse
				} else {
					$('#p' + id).show();
					$('#txt' + id).hide();
					obj.innerHTML = js_lang.full_text
				}
			}
		}
	}
})(ecjia.merchant, jQuery);