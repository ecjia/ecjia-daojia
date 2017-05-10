;
(function($) {
	var greenCheck = function() {
		var check = {
			//执行初始化
			init: function() {
				this.init_checkbox();
				this.init_radio();
			},

			//初始化复选框
			init_checkbox: function() {},

			//初始化单选框
			init_radio: function() {
				var obj_input = $('label>input[type="radio"]');
				//todo 无选中时默认第一个

				obj_input.on('change', function() {
					var obj_iname = $(this).attr('name'),
						objall_i = $('input[name="' + obj_iname + '"]').parent('label'),
						tmpobj_i = $(this).parent('label');
					objall_i.removeClass('ecjia-check-checked');
					tmpobj_i.addClass('ecjia-check-checked');
				});
				for (var i = obj_input.length - 1; i >= 0; i--) {
					if (obj_input.eq(i).prop('checked')) {
						obj_input.eq(i).parent().addClass('ecjia-check-checked');
					}
				};
			}
		}
		check.init();
	}

	$.fn.greenCheck = greenCheck;
})(jQuery)