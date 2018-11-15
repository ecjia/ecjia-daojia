// JavaScript Document
;
(function(app, $) {
    app.bind_adviser = {
        init: function() {
            app.bind_adviser.binding();
            app.bind_adviser.submit();
            app.bind_adviser.search();
        },
        binding: function() {
            $(".search_users").on("click", function() {
                var keywords = $("input[name='keywords']").val();
                var url = $("input[name='url']").val();
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {keywords: keywords},
                    dataType: "json",
                    success: function(data) {
                        $('.nav-list-ready').html('');
                        if (data.user.length > 0) {
                            for (var i = 0; i < data.user.length; i++) {
                                var disable = $('.nav-list-content .ms-elem-selection').find('input[value="' + data.user[i].value + '"]').length ? 'disabled' : '';
                                var opt = '<li class="ms-elem-selectable ' + disable + '" id="articleId_' + data.user[i].value + '" data-id="' + data.user[i].value + '" data-name="' + data.user[i].username+ '" data-email="' + data.user[i].email+ '"  data-username="' + data.user[i].username +'" data-qq="' + data.user[i].qq +'" data-tel="' + data.user[i].tel +'"><span>' + data.user[i].text + '</span></li>'
                                $('.nav-list-ready').append(opt);
                            }
                        } else {
                            $('.nav-list-ready').html('<li class="ms-elem-selectable disabled"><span>未搜索到顾问信息</span></li>');
                        }
                       app.bind_adviser.search_opt();
                       app.bind_adviser.click_search_user();
                    },
                    error: function()
                    {
                        alert('请求失败');
                    }
                })
            })

        },
        click_search_user: function() {
			//点击搜索列表效果
            $('.select_user li').on('click', function() {
                var $this = $(this);
                $('.select_user li').removeClass('selected');
                $this.addClass('selected');
                var adviser_id = $('.selected').attr('data-id');
                var adviser_name = $('.selected').attr('data-name');
                var email = $('.selected').attr('data-email');
                var qq=$('.selected').attr('data-qq');
                
                $('.new_userinfo_wrap').show();
                $('.new_userinfo').text(adviser_name + '(' + adviser_id + ')');
                $('input[name="adviser_id"]').val(adviser_id);
                
            })
        },
        search_opt: function() {
            //li搜索筛选功能
            $('#ms-search').quicksearch(
                    $('.ms-elem-selectable', '#serarch_user_list'),
                    {
                        onAfter: function() {
                            $('.ms-group').each(function() {
                                $(this).find('.isShow').length ? $(this).css('display', 'block') : $(this).css('display', 'none');
                            });
                            return;
                        },
                        show: function() {
                            this.style.display = "";
                            $(this).addClass('isShow');
                        },
                        hide: function() {
                            this.style.display = "none";
                            $(this).removeClass('isShow');
                        },
                    }
            );
        },
        submit : function () {
			var $this = $('form[name="theForm"]');
			$this.on('submit', function(e) {
				e.preventDefault();
			})
			var option = {
				submitHandler: function() {
					$this.ajaxSubmit({
						dataType:"json",
						success:function(data) {
							ecjia.admin.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
		},
		search : function () {
			var $this = $('form[name="queryinfo"]');
			$this.on('submit', function(e) {
				e.preventDefault();
			})
			var option = {
				submitHandler: function() {
					$this.ajaxSubmit({
						dataType:"json",
						success:function(data) {
							ecjia.admin.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
		},
    }
})(ecjia.admin, jQuery);

// end
