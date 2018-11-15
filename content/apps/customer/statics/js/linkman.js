// JavaScript Document
;(function(app, $) {
	app.linkman = {
		init : function() {
			app.linkman.add();
			app.linkman.check_detail();
		},
		add : function () {
			$(".date").datepicker({
				format: "yyyy-mm-dd"
			});
			var $this = $('form[name="theForm"]');
			$this.on('submit', function(e) {
				e.preventDefault();
			})
			var option = {
					rules:{
						/*必填*/
						link_man_name: 		{required : true},
						mobile: 			{required : true},
						email:	 			{required : true},
					},
					messages:{
						/*必填*/
						link_man_name:	 	{required : "请填写联系人姓名！"},
						mobile: 			{required : "联系人手机不能为空！" },
						email: 				{required : "邮箱不能为空！" },
					},
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
		check_detail : function() {
			$(".linkman-detail").on('click', function(e) {
				var url = $(this).attr('data-url');
				 $('#movetype').modal('show');
				 $('#modal-body_new').show();
				 $('.modal-body').hide();
				$.get(url,'',function(data) {
					 $('#movetype').modal('show');
					 $('#modal-body_new').hide();
					 $('.modal-body').show();
					 $('#link-man').html(data.message.link_man_name + '&nbsp;' + '（' + data.message.sex_new + '）');
					 if((data.message.birthday != '') && (data.message.birth_type_new !='')){
						 $('.birthday').html(data.message.birthday + '&nbsp;' + '（' + data.message.birth_type_new + '）');
					 }
					 $('.department').html(data.message.department);
					 $('.duty').html(data.message.duty);
					 $('.mobile').html(data.message.mobile);
					 $('.telphone').html(data.message.telphone);
					 $('.email').html(data.message.email);
					 $('.qq').html(data.message.qq + '&nbsp;&nbsp;' + data.message.wechat);
					 $('.user_name').html(data.message.user_name);
					 $('.add_time').html(data.message.add_time);
					 $('.summary').html(data.message.summary);
	             } , 'json');
			});
		},
	}
})(ecjia.admin, jQuery);

// end
