// JavaScript Document
;(function(app, $) {

	app.push_event = {
        init: function () {
			$('#danger-toggle-button').toggleButtons({
			  style: {
			      enabled: "danger",
			      disabled: "info"
			  }
			});
        	  
	    	$('.change_status').on('click', function() {
				var $this = $(this);
				var message = $this.attr('data-msg');
				var url = $this.attr('data-href');
				if (message != undefined) {
					smoke.confirm(message, function(e) {
						if (e) {
							$.get(url, function(data){
								ecjia.admin.showmessage(data);
							})
						}
					}, {ok:"确定", cancel:"取消"});
				} 
			});
        },
        
		info : function() {
			app.push_event.codesubmit();
			app.push_event.insertsubmit();
			app.push_event.updatesubmit();
			$('.info-toggle-button').toggleButtons({
				label: {  
                     enabled: "开启",  
                     disabled: "关闭"  
                },  
                style: {
                    enabled: "info",
                    disabled: "success"
                }
            });
			$('[href="#editevent"]').on('click', function() {
				var name	= $("input[name='name']").val(),
					id		= $(this).attr('value');
					appid	= $(this).attr('data-appid');
					tempalteid = $(this).attr('data-templateid');
					
				$(".app_id").find("option").attr('selected', false);
				$(".app_id").find("option[value='"+appid+"']").attr("selected", true);
				$(".tempalteid").find("option").attr('selected', false);
				$(".tempalteid").find("option[value='"+tempalteid+"']").attr("selected", true);
				
				$("input[name='event_name']").val(name);
				$("input[name='id']").val(id);
				$('select').trigger("liszt:updated").trigger("change");
			});
			
		},
		
		codesubmit : function() {
			var $this = $("form[name='codeForm']");
			var option = {
					rules:{
						name : {
							required : true
						},
						code : {
							required : true
						},
					},
					messages:{
						name : {
							required : "请填写消息事件名称！" 
						},
						code : {
							required : "请填写消息事件code！" 
						},
					},
					submitHandler:function(){
						$this.ajaxSubmit({
							dataType:"json",
							success:function(data){
								ecjia.admin.showmessage(data);
							}
						});
					}
				}
				
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
		},
		
		insertsubmit : function() {
			var $this = $("form[name='addForm']");
			var option = {
					rules:{
						app_id : {
							required : true
						},
						template_id : {
							required : true
						},
					},
					messages:{
						app_id : {
							required : "请选择推送应用！" 
						},
						template_id : {
							required : "请选择推送模板！" 
						},
					},
					submitHandler:function(){
						var name = $("input[name='name']").val(),
						code = $("input[name='code']").val();
						if (name == '') {
							$('#addevent').modal('hide');
							var data = {
								message : "请填写消息事件名称！",
								state : "error",
							};
							ecjia.admin.showmessage(data);
							return false;
						}
						$("input[name='event_name']").val(name);
						$("input[name='event_code']").val(code);
						$this.ajaxSubmit({
							dataType:"json",
							success:function(data){
								ecjia.admin.showmessage(data);
							}
						});
					}
				}
				
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
		},
		updatesubmit : function() {
			var $this = $("form[name='updateForm']");
			var option = {
					rules:{
						app_id : {
							required : true
						},
						template_id : {
							required : true
						},
					},
					messages:{
						app_id : {
							required : "请选择推送应用！" 
						},
						template_id : {
							required : "请选择推送模板！" 
						},
					},
					submitHandler:function(){
						var name = $("input[name='name']").val(),
							code = $("input[name='code']").val();
						if (name == '') {
							$('#editevent').modal('hide');
							var data = {
								message : "请填写消息事件名称！",
								state : "error",
							};
							ecjia.admin.showmessage(data);
							return false;
						}
						$("input[name='event_name']").val(name);
						$("input[name='event_code']").val(code);
						$this.ajaxSubmit({
							dataType:"json",
							success:function(data){
								ecjia.admin.showmessage(data);
							}
						});
					}
				}
				
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
		}
	};

})(ecjia.admin, jQuery);

// end
