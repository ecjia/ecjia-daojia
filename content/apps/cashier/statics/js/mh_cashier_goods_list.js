// JavaScript Document
;(function (app, $) {
	var bath_url;
    app.cashier_goods_list = {
        init: function () {
        	bath_url = $("a[name=move_cat_ture]").attr("data-url");
        	$("form[name='search_form']").on('submit', function(e) {
				e.preventDefault();
				var keywords = $("input[name='keywords']").val(); //关键字
				var url = $("form[name='search_form']").attr('action');

				if (keywords == 'undefind') keywords = '';
				if (keywords != '') {
					url += '&keywords=' + keywords;
				}
				ecjia.pjax(url);
			});
            app.cashier_goods_list.batch_move_cat();
            app.cashier_goods_list.toggle_on_sale();
        },
		batch_move_cat: function() {
			$(".batch-move-btn").on('click', function(e) {
				var checkboxes = [];
				$(".checkbox:checked").each(function() {
					checkboxes.push($(this).val());
				});
				if (checkboxes == '') {
					smoke.alert(js_lang.choose_select_goods);
					return false;
				} else {
					$('#movetype').modal('show');
				}
			});
			$("a[name=move_cat_ture]").on('click', function(e) {
				$('#movetype').modal('hide');
				$(".modal-backdrop").remove();
			});
			$("select[name=target_cat]").on('change', function(e) {
				var target_cat = $(this).val();
				if (target_cat == 0) {
					$('a[name="move_cat_ture"]').addClass('disabled');
					return false;
				} else {
					$('a[name="move_cat_ture"]').removeClass('disabled');
				}
				$("a[name=move_cat_ture]").attr("data-url", bath_url + '&target_cat=' + target_cat);
			});
		},
		toggle_on_sale: function() {
			$('[data-trigger="toggle_on_sale"]').on('click', function(e) {
				e.preventDefault();
				var $this = $(this);
				var url = $this.attr('data-url');
				var id = $this.attr('data-id');
				var val = $this.hasClass('fa-times') ? 1 : 0;
				var type = $this.attr('data-type') ? $this.attr('data-type') : "POST";
				var pjaxurl = $this.attr('refresh-url');

				var option = {
					obj: $this,
					url: url,
					id: id,
					val: val,
					type: type
				};

				$.ajax({
					url: option.url,
					data: {
						id: option.id,
						val: option.val
					},
					type: option.type,
					dataType: "json",
					success: function(data) {
						data.content ? option.obj.removeClass('fa-times').addClass('fa-check') : option.obj.removeClass('fa-check').addClass('fa-times');
						ecjia.pjax(pjaxurl, function() {
							ecjia.merchant.showmessage(data);
						});
					}
				});
			})
		}
    };
    
})(ecjia.merchant, jQuery);
 
// end