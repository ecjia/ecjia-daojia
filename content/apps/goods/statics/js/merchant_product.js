// JavaScript Document
;
(function(app, $) {
	app.product = {
		init: function() {
			$('input[name="submit"]').on('click', function(e) {
				e.preventDefault();
				var $form = $("form[name='theForm']");
				$form.ajaxSubmit({
					dataType: "json",
					success: function(data) {
						ecjia.merchant.showmessage(data);
					}
				});
			});
		},

		/**
		 * clone_product 克隆添加一个节点的方法
		 */
		clone_product: function(options) {
			var tmpObj = options.parentobj.clone();

			tmpObj.find('[data-toggle="clone_product"]').attr('data-toggle', 'remove_product').on('click', function() {
				tmpObj.remove()
			}).find('i').attr('class', 'fa fa-times ecjiafc-red');

			$('.product_list').children('tbody').append(tmpObj);
			tmpObj.find('.chzn-container').remove();
			tmpObj.find('select').removeClass('chosen_hide').removeClass('chzn-done').attr({
				'id': ''
			}).chosen();
		},
	};

	/**
	 * clone_product触发器
	 * data-parent 		要复制的父级节点
	 */
	$(document).on('click', '.add_item', function(e) {
		e.preventDefault();
		var $this = $(this),
			$parentobj = $('.clone_div').children().find('.attr_row'),
			option = {
				parentobj: $parentobj
			};
		app.product.clone_product(option);
	})

	/**
	 * remove_product 删除节点obj
	 * data-parent 要删除的父级节点
	 */
	$(document).on('click', '[data-toggle="remove_product"]', function(e) {
		e.preventDefault();
		var $this = $(this),
			$parentobj = $this.parents($this.attr('data-parent'));
		$parentobj.remove();
	})

})(ecjia.merchant, jQuery);

// end