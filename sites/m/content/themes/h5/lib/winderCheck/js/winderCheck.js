;(function($){
	var winderCheck = function(){
		var check = {
			//执行初始化
			init : function() {
				this.init_checkbox();
				this.init_radio();
			},

			//初始化复选框
			init_checkbox : function() {
				var obj_input = $('label>input[data-trigger="checkbox"]');
					obj_input.css('display','none').parent('label').find('i.checkbox').remove();
				obj_input.on('change', function() {
					var tmpobj_i = $(this).parent('label').find('i.checkbox');
					tmpobj_i.removeClass('checked');
					$(this).prop('checked') && tmpobj_i.addClass('checked');
				});
				for (var i = obj_input.length - 1; i >= 0; i--) {
					var tmpobj_i = obj_input.eq(i).prop('checked') ? $('<i class="checkbox checked"></i>') :  $('<i class="checkbox"></i>');
					obj_input.eq(i).after(tmpobj_i);
				};
			},

			//初始化单选框
			init_radio : function() {
				var obj_input = $('label>input[data-trigger="radio"]');
					obj_input.css('display','none').parent('label').find('i.radio').remove();
				obj_input.on('change', function() {
					var obj_iname = $(this).attr('name'),
						objall_i = $('input[name="'+obj_iname+'"]').parent('label').find('i.radio'),
						tmpobj_i = $(this).parent('label').find('i.radio');
					objall_i.removeClass('checked');
					tmpobj_i.addClass('checked');
				});
				for (var i = obj_input.length - 1; i >= 0; i--) {
					var tmpobj_i = obj_input.eq(i).prop('checked') ? $('<i class="radio checked"></i>') :  $('<i class="radio"></i>');
					obj_input.eq(i).after(tmpobj_i);
				};
			}
		}
		check.init();
	}
	
	$.fn.winderCheck = winderCheck;
})(jQuery)