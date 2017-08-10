// JavaScript Document
;(function (app, $) {
    app.shopguide = {
        init: function () {
            app.shopguide.submit();
            app.shopguide.range();
            app.shopguide.fileupload();
            app.shopguide.search_cat_opt();
            app.shopguide.load_cat_list();
        },
 
        submit: function () {
            var $form = $("form[name='theForm']");
            var option = {
                rules: {
                	shop_notice: {
                		required: true
                	},
                	shop_description: {
                		required: true
                	},
                    cat_name: {
                        required: true
                    },
                    goods_name: {
                        required: true
                    },
                },
                messages: {
                	shop_notice: {
                		required: '请输入店铺公告',
                	},
                	shop_description: {
                		required: '请输入店铺简介',
                	},
                	cat_name: {
                		required: '请输入商品分类',
                	},
                	goods_name: {
                		required: '请输入商品名称',
                	},
                },
                submitHandler: function () {
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function (data) {
                            if (data.message == '') {
                                ecjia.pjax(data.url);
                            } else {
                                ecjia.merchant.showmessage(data);
                            }
                        }
                    });
                }
            }
            var options = $.extend(ecjia.merchant.defaultOptions.validate, option);
            $form.validate(options);
        },
        
        formatTimeLabelFunc:function(value, type) {
        	var hours = String(value).substr(0,2);
        	var mins = String(value).substr(3,2);

        	if (hours > 24) {
        		hours = hours - 24;
        		hours = (hours < 10 ? "0"+hours : hours);
        		value = hours+':'+mins;
        		var text = String('次日%s').replace('%s', value);
        		return text;
        	}
        	else {
        		return value;
        	}
        },

        range : function(){
            $('.range-slider').jRange({
                from: 0, to: 2880, step:30,
                scale: ['00:00','04:00','08:00','12:00','16:00','20:00','次日00:00','04:00','08:00','12:00','16:00','20:00','24:00'],
                format: app.shopguide.formatTimeLabelFunc,
                width: 700,
                showLabels: true,
                isRange : true
            });
        },
        
		fileupload: function() {
			$(".shop_banner_pic").on('click', function(e) {
				e.preventDefault();
				$(this).parent().find("input").trigger('click');
			})
			$('.shop_logo').on('click', function(e) {
				e.preventDefault();
				$(this).parent().find("input").trigger('click');
			})
		},
		
		search_cat_opt: function() {
			var opt = {
				onAfter: function() {
					$('.ms-group').each(function(index) {
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
			};
			$('#ms-search_zero').quicksearch($('.level_0 .ms-elem-selectable'), opt);
			$('#ms-search_one').quicksearch($('.level_1 .ms-elem-selectable'), opt);
			$('#ms-search_two').quicksearch($('.level_2 .ms-elem-selectable'), opt);
		},

		load_cat_list: function() {
			$('.nav-list-ready li').off().on('click', function() {
				var $this = $(this);
				if (!$this.hasClass('disabled')) {
					$this.addClass('selected').siblings('li').removeClass('selected');
					$this.addClass('disabled').siblings('li').removeClass('disabled');
				} else {
					return false;
				}

				var cat_id = $this.attr('data-id');
				var level = parseInt($this.attr('data-level')) + 1;
				var url = $('.goods_cat_container').attr('data-url');

				if (cat_id == undefined) {
					return false;
				}
				var info = {
					'cat_id': cat_id,
				};

				$('input[name="cat_id"]').val(cat_id);

				if (cat_id != 0 && cat_id != undefined) {
					$('button[type="button"]').prop('disabled', false);
				}
				var no_content = '<li class="ms-elem-selectable disabled"><span>暂无内容</span></li>';
				$.post(url, info, function(data) {
					if (level == 1) {
						$('.level_1').html('');
						$('.level_2').html(no_content);
					} else if (level == 2) {
						$('.level_2').html('');
					}
					var level_div = $('.level_' + level);

					if (data.content.length > 0) {
						for (var i = 0; i < data.content.length; i++) {
							var opt = '<li class = "ms-elem-selectable selectable" data-id=' + data.content[i].cat_id + ' data-level=' + level + '><span>' + data.content[i].cat_name + '</span></li>'
							level_div.append(opt);
						};
						app.shopguide.search_cat_opt();
					} else {
						level_div.html(no_content);
					}
					app.shopguide.load_cat_list();
				});
			});
		},
    }
})(ecjia.merchant, jQuery);

//end