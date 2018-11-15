// JavaScript Document
;
(function(app, $) {
    app.customer = {
        init: function() {
            app.customer.theForm();
            app.customer.userForm();
			app.customer.adviserForm();
        },
        //添加必填项js
        theForm: function() {
        	$(".date").datepicker({
				format: "yyyy-mm-dd"
			});
            var $form = $("form[name='theForm']");
            var option = {
//                rules: {
//                    customer_name: 	{required: true},
//                    link_man: 		{required: true},
//                },
//                messages: {
//                	customer_name:	{required: "请填写公司名称！"},
//                	link_man: 		{required: "请填写主联系人！"},
//                },
                submitHandler: function() {
                    $form.ajaxSubmit({
                        dataType: "json",
                        success: function(data) {
                            ecjia.admin.showmessage(data);
                        }
                    });
                }
            }
            var options = $.extend(ecjia.admin.defaultOptions.validate, option);
            $form.validate(options);
        },
        userForm: function() {
            $(".search_users").on("click", function() {
                var keyword = $("input[name='keyword']").val();
                var url = $("input[name='url']").val();
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {keyword: keyword},
                    dataType: "json",
                    success: function(data) {
                        $('.nav-list-ready').html('');
                        if (data.user.length > 0) {
                            for (var i = 0; i < data.user.length; i++) {
                                var disable = $('.nav-list-content .ms-elem-selection').find('input[value="' + data.user[i].value + '"]').length ? 'disabled' : '';
                                
                                var color = data.user[i].has_order ? '' : 'color999';
                                var opt = '<li class="ms-elem-selectable ' + disable + color + '" id="articleId_' + data.user[i].value + '" data-id="' + data.user[i].value 
                                + '" data-name="' + data.user[i].user_name+ '" data-email="' + data.user[i].email+ '" data-mobile_phone="'+ data.user[i].mobile_phone
                                + '" data-home_phone="' + data.user[i].home_phone +'" data-qq="' + data.user[i].qq +'" data-sex="'  + data.user[i].sex+'" data-hasorder="' + data.user[i].has_order 
                                + '" data-adviser_id="' + data.user[i].adviser_id+'" data-adviser_username="' + data.user[i].adviser_username+ '"><span>' + data.user[i].text + '</span></li>'
                                
                                $('.nav-list-ready').append(opt);
                            }

                        } else {
                            $('.nav-list-ready').html('<li class="ms-elem-selectable disabled"><span>未搜索到用户信息</span></li>');
                        }
                       app.customer.search_opt();
                       app.customer.click_search_user();
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
                var hasorder = $this.attr('data-hasorder');
            	if(hasorder<1){
            		return false;
            	}
                $('.select_user li').removeClass('selected');
                $this.addClass('selected');
                var user_id = $('.select_user .selected').attr('data-id');
                var user_name = $('.select_user .selected').attr('data-name');
                var email = $('.select_user .selected').attr('data-email');
                var home_phone=$('.select_user .selected').attr('data-home_phone');
                var mobile_phone=$('.select_user .selected').attr('data-mobile_phone');
                var qq=$('.select_user .selected').attr('data-qq');
                var sex=$('.select_user .selected').attr('data-sex');
                var adviser_id=$('.select_user .selected').attr('data-adviser_id');
                var adviser_name=$('.select_user .selected').attr('data-adviser_username');
                
                $('.new_userinfo_wrap').show();
                $('.new_userinfo').text(user_name + '(' + user_id + ')');
                $('input[name="user_id"]').val(user_id);
                $('input[name="email"]').val(email);
                $('input[name="mobile"]').val(mobile_phone);
                $('input[name="tel"]').val(home_phone);
                $('input[name="qq"]').val(qq);      

                $('.uni-checked').removeClass('uni-checked');
                $('input[name="sex"]').attr('checked', false);
                $('input[name="sex"]').each(function() {
                    if ($(this).val() == sex)
                    {
                        $(this).attr('checked', true);
                        $(this).parent().addClass('uni-checked');
                    }
                })
                //顾问
                if(adviser_id>0) {
                	$('.adviser_display').css('display','none');
                	$('.new_adviserinfo_wrap').show();
                    $('.new_adviserinfo').text(adviser_name + '(' + adviser_id + ')');
                    $('input[name="adviser_id"]').val(adviser_id);
                }
                else{
                	$('.adviser_display').css('display','block');
                	$('.new_adviserinfo_wrap').show();
                	$('.new_adviserinfo').text('无');
                    $('input[name="adviser_id"]').val(0);
                }
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

        adviserForm: function() {
            $(".search_advisers").on("click", function() {
                var keywords = $("input[name='keywords']").val();	
                var url = $("input[name='urls']").val();
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {keywords: keywords},
                    dataType: "json",
                    success: function(data) {
                        $('.nav-list-readys').html('');
                        if (data.user.length > 0) {
                            for (var i = 0; i < data.user.length; i++) {
                                var disable = $('.nav-list-content .ms-elem-selection').find('input[value="' + data.user[i].value + '"]').length ? 'disabled' : '';
                                var opt = '<li class="ms-elem-selectables ' + disable + '" id="articleId_' + data.user[i].value + '" data-id="' + data.user[i].value + '" data-name="' + data.user[i].username+ '" data-email="' + data.user[i].email+ '"  data-username="' + data.user[i].username +'" data-qq="' + data.user[i].qq +'" data-tel="' + data.user[i].tel +'"><span>' + data.user[i].text + '</span></li>'
                                $('.nav-list-readys').append(opt);
                            }
                        } else {
                            $('.nav-list-readys').html('<li class="ms-elem-selectables disabled"><span>未搜索到顾问信息</span></li>');
                        }
                       app.customer.search_adviser_opt();
                       app.customer.click_search_adviser();
                    },
                    error: function()
                    {
                        alert('请求失败');
                    }
                })
            })

        },
        click_search_adviser: function() {
			//点击搜索列表效果
            $('.select_adviser li').on('click', function() {
            	var $this = $(this);
                $('.select_adviser li').removeClass('selected');
                $this.addClass('selected');
                var adviser_id = $('.select_adviser .selected').attr('data-id');
                var adviser_name = $('.select_adviser .selected').attr('data-name');
                var email = $('.select_adviser .selected').attr('data-email');
                var qq=$('.select_adviser .selected').attr('data-qq');
                $('.new_adviserinfo_wrap').show();
                $('.new_adviserinfo').text(adviser_name + '(' + adviser_id + ')');
                $('input[name="adviser_id"]').val(adviser_id);
            })
        },
        search_adviser_opt: function() {
            //li搜索筛选功能
            $('#ms-search_adviser').quicksearch(
                    $('.ms-elem-selectables', '#serarch_adviser_list'),
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
        get_customer : function() {
        	$('.get_customer').on('click', function(e) {
    			$this = $(this);
    			var id				= $this.attr('data-id');  //id
    			var url				= $this.attr('data-url'); //请求链接
    			if(id				== 'undefined')id ='';
    			if(url        		== 'undefined')url ='';
    			$.ajax({
                    type: "GET",
                    url: url,
                    dataType: "json",
                    success: function(data) {
                    	ecjia.admin.showmessage(data);
                    },
                    error: function() {
                        alert('请求失败');
                    }
                })
    		});
        },
        cancel_share : function() {
        	$('.cancel_share').on('click', function(e) {
    			$this = $(this);
    			var id				= $this.attr('data-id');  //id
    			var url				= $this.attr('data-url'); //请求链接
    			if(id				== 'undefind')id ='';
    			if(url        		== 'undefind')url ='';
    			$.ajax({
                    type: "GET",
                    url: url,
                    dataType: "json",
                    success: function(data) {
                    	ecjia.admin.showmessage(data);
                    },
                    error: function() {
                        alert('请求失败');
                    }
                })
    		});
        },
    }
    app.excel_upload = {
		init: function() {
            app.excel_upload.submit_form();
        },
		submit_form : function(formobj) {
			var $form = $("form[name='theForm']");
			var option = {
				rules : {
					file : { required : true },
				},
				messages : {
					file : { required : "请选择上传的文件" },
				},
				submitHandler : function() {
					$form.ajaxSubmit({
                        dataType: "json",
                        success: function(data) {
                            ecjia.admin.showmessage(data);
                        }
                    });
				}
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$form.validate(options);
		}
    }
})(ecjia.admin, jQuery);

// end
