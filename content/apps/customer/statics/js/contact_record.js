// JavaScript Document
;(function(app, $) {
	app.contact_record = {
		init : function() {
			app.contact_record.add();
			app.contact_record.click_linkman();
		},
		add : function () {
			$(".start_date,.end_date").datetimepicker({
				format: "yyyy-mm-dd hh:ii",
				todayBtn: true,
				minuteStep: 2
			});
			var $this = $('form[name="theForm"]');
			$this.on('submit', function(e) {
				e.preventDefault();
			})
			var option = {
					rules:{
						/*必填*/
						summary: 			{required : true},
						link_man: 			{required : true},
					},
					messages:{
						/*必填*/
						summary:	 	{required : "请填写联系内容！"},
						link_man: 		{required : "请选择联系人！" },
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
        click_linkman: function() {
			//点击联系人效果
            $('select[name="link_man"]').on('change', function() {
                var $this = $(this);
                var tel = $this.find("option:selected").attr('data-telphone');
                $('input[name="telphone"]').val(tel);
            });
          //点击联系方式效果
            $('select[name="contact_way"]').on('change', function() {
                var $this = $(this);
                var type_name = $this.find("option:selected").html();
                $('.change-type').html(type_name+'：');
            });
        },
	}
})(ecjia.admin, jQuery);

// end
