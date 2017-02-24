// JavaScript Document
;(function(app, $) {
	app.get_password = {
		init : function () {
			app.get_password.user_name();
			app.get_password.cancel_btn();
			app.get_password.show_password();
			app.get_password.error_msg();
			app.get_password.change_captcha();
			
			app.get_password.answer_submitbtn();
			app.get_password.code_submitbtn();
			
			//倒计
			app.get_password.code_time_down();
			
			app.get_password.code_repeat();
			
			app.get_password.password_input();
			app.get_password.choose();
			app.get_password.checkcode();
		},
		
		user_name : function () {
			$("input[name='user_name']").keyup(function(){
				if ($(this).val().length > 0) {
					$(this).siblings("span").removeClass('display-none')
				} else {
					$(this).siblings("span").addClass('display-none')
				}
			});
			$("input[name='email']").keyup(function(){
				if ($(this).val().length > 0) {
					$(this).siblings("span").removeClass('display-none')
				} else {
					$(this).siblings("span").addClass('display-none')
				}
			});
		},
		
		cancel_btn : function () {
			$(".cancel-btn").click(function() {
				$(this).siblings("input").val('');
				$(this).addClass('display-none')
			});
		},
		
		show_password : function () {
			$(".show-password span").click(function(){
				var type = $("input[name='new_password']").attr('type');
				var img_src = $(this).attr("data-img");
				if (type === 'password') {
					var img = "<img src='"+img_src+"/images/right_circle.png'/>";
					$(this).html(img);
					$("input[name='new_password']").attr('type', 'text');
					$("input[name='confirm_password']").attr('type', 'text');
				} else {
					var img = "<img src='"+img_src+"/images/empty_circle.png'/>";
					$(this).html(img);
					$("input[name='new_password']").attr('type', 'password');
					$("input[name='confirm_password']").attr('type', 'password');
				}
			});
		},
		
		error_msg : function () {
			if ($("div").hasClass("error_msg")) {
				$(".error_msg").fadeOut(2000);
			}
		},
		
		choose : function() {
			$('button.choose').on('click', function(e) {
				var url = $(this).attr('data-href');
				$(this).attr('disabled', true);
				window.location.href = url;
			});
		},
		
		change_captcha : function () {
			$('[data-toggle="change_captcha"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					this_src = $this.attr('data-src') + Math.random();
				$this.attr('src', this_src);
			});
		},
		
		answer_submitbtn : function () {
			$("input[name='passwd_answer']").keyup(function(){
				if ($(this).val().length > 0 ) {
					$(".app-button button[type='submit']").addClass("button").removeClass('disabled-btn');
					$(".app-button button[type='submit']").attr("disabled", false);
				} else {
					$(".app-button button[type='submit']").addClass("disabled-btn").removeClass('button');
					$(".app-button button[type='submit']").attr("disabled", true);
				}
			});
		},
		
		code_submitbtn : function () {
			$("input[name='code']").keyup(function(){
				if ($(this).val().length == 6 && !isNaN($(this).val())) {
					$(".app-button button[type='submit']").addClass("button").removeClass('disabled-btn');
					$(".app-button button[type='submit']").attr("disabled", false);
				} else {
					$(".app-button button[type='submit']").addClass("disabled-btn").removeClass('button');
					$(".app-button button[type='submit']").attr("disabled", true);
				}
			});
		},
		
		checkcode : function() {
			$("form[name='checkcode']").on('submit', function(e){
				if ($("input[name='code']").val().length != 6 || isNaN($("input[name='code']").val())) {
					return false;
				} else {
					return true;
				}
			});
		},
		
		code_time_down : function () {
			setInterval(app.get_password.code_change_time,1000)
		},
		
		code_change_time : function () {
			var time = $(".code-span").attr("data-time");
			time--;
			if (time > 0) {
				var str = time + '秒后重发';
				$(".code-span").attr("data-time", time);
				$(".code-span").html(str);
			} else {
				$(".code-span").addClass("display-none");
				$(".code-repeat").removeClass("display-none");
			}
		},
		
		//重发效验码
		code_repeat : function () {
			$(".code-repeat").click(function() {
				var url = $(this).attr("data-url");
				$.ajax({
					type: "POST",
					url: url,
					dataType: "json",
					success: function(data){
						if (data.state == "success") {
							var str = '60秒后重发';
							$(".code-span").attr("data-time", 60);
							$(".code-span").html(str);
							$(".code-span").removeClass("display-none");
							$(".code-repeat").addClass("display-none");
						}
					}
				});
			});
			
		},
		
		password_input : function () {
			$("input[name='new_password']").keyup(function(){
				if ($(this).val().length > 0) {
					$(this).siblings("span").removeClass('display-none')
				} else {
					$(this).siblings("span").addClass('display-none')
				}
			});
			$("input[name='confirm_password']").keyup(function(){
				if ($(this).val().length > 0) {
					$(this).siblings("span").removeClass('display-none')
				} else {
					$(this).siblings("span").addClass('display-none')
				}
			});
		},
	};
})(ecjia.front, jQuery);
