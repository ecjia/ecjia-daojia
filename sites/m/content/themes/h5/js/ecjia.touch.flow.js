/**
 * 后台综合js文件
 */
;(function(ecjia, $) {

	ecjia.touch.flow = {
		init : function(){
			ecjia.touch.flow.change_number_click();
			ecjia.touch.flow.selectShipping();
			ecjia.touch.flow.selectPayment();
			ecjia.touch.flow.change_need_inv();
			ecjia.touch.flow.change_bonus();
			ecjia.touch.flow.change_surplus();
			ecjia.touch.flow.change_integral();
			ecjia.touch.flow.select_inv();
			ecjia.touch.flow.select_attr();
			ecjia.touch.flow.fold_area();
			ecjia.touch.flow.check_goods();
			ecjia.touch.flow.form_submit();
			$('[data-toggle="selectShipping"]:checked').trigger('click');
			$('[data-toggle="selectPayment"]:checked').trigger('click');
			$('[data-toggle="change_bonus"]:checked').trigger('click');
			$('[data-toggle="change_surplus"]').blur();
			$('[data-toggle="change_integral"]').blur();
			function back_goods_number(id){
				var goods_number = document.getElementById('goods_number'+id).value;
				document.getElementById('back_number'+id).value = goods_number;
			}

            $(document).winderCheck();
		},
		
		form_submit: function () {
            $('.flow-done-sub').on('click', function () {
            	ecjia.touch.pjaxloadding();
            	$("input[type='submit']").click();
            });
        },

		change_number_click : function (){
			$('[data-toggle="change_goods_number"]').on('click', function(){
 				var $this 		= $(this),
					options		= {
						rec_id 	: $this.attr('data-rec_id'),
						url 	: $this.attr('data-url'),
						status 	: $this.attr('data-status')
					};
				var goods_number =$('#goods_number'+options.rec_id).val();
				if (options.status =='del') {
					if (goods_number == 1) {
						goods_number =1;
					} else {
						goods_number = parseInt(goods_number) - 1;
						$('#goods_number'+options.rec_id).val(goods_number);
					}
				} else {
 					goods_number = parseInt(goods_number) + 1;
 					$('#goods_number'+options.rec_id).val(goods_number);
 				}
 				ecjia.touch.flow._change_goods(options,goods_number);
 			});

			$('[data-toggle="change_goods_number_blur"]').on('blur', function(){
 				var $this 		= $(this),
					options		= {
						rec_id 	: $this.attr('data-rec_id'),
						url 	: $this.attr('data-url'),
						status 	: $this.attr('data-status')
					};
				var goods_number =$('#goods_number'+options.rec_id).val();
				if (goods_number <= 0) {
					goods_number = 1;
					$('#goods_number'+options.rec_id).val(1);
				}
 				ecjia.touch.flow._change_goods(options,goods_number);
 			});
		},

		_change_goods : function(options,goods_number){
			$.post(
				options.url, 
				{'rec_id':options.rec_id ,'goods_number': goods_number }, 
				function(data){
					if (data.state == "success") {
						$('#total_number').html(data.total_number);
						$('#goods_subtotal').html(data.total_desc);
					} else {
						if (data.error == "1") {
							alert(data.message);
							$('#goods_number'+options.rec_id).val(data.err_max_number);
						}
					}
				}, 'json'
			);
		},

		selectShipping : function() {
			$(document).off('click', '[data-toggle="selectShipping"]');
			$(document).on('click', '[data-toggle="selectShipping"]', function(){
 				var $this = $(this),
					rec_id = $('.hidden_rec_id').val(),
 				options = {
 					shipping	: $this.val(),
					rec_id		: rec_id
 				},
 				url = $this.attr('data-url');
 				$.get(url, options, function(data){
 					if (data.state == "success") {
 						$('#total_number').html(data.content);
 					} else {
 						if (data.error == "1") {
 							alert(data.message);
 						}
 					}
				});
 			});
		},

		selectPayment : function() {
			$(document).off('click', '[data-toggle="selectPayment"]');
			$(document).on('click', '[data-toggle="selectPayment"]', function(){
 				var $this = $(this),
					rec_id = $('.hidden_rec_id').val(),
 				options = {
 					payment	: $this.val(),
					rec_id	: rec_id
 				},
 				url = $this.attr('data-url');
 				$.get(url, options, function(data){
 					if (data.state == "success") {
                        $('#total_number').html(data.content);
 						//$('#goods_subtotal').html(data.total_desc);
 					} else {
 						if (data.error == "1") {
 							alert(data.message);
 							$('#goods_number'+options.rec_id).val(data.err_max_number);
 						}
 					}
				});
 			});
		},
		
		select_attr :function(){
			$('.flow-checkout .checkout-select label').on('click',function(){
				var pay = $.trim($(this).text());
				$(this).parents('div').prev('a').find('.select_nav').text(pay);
			});
		},

		change_need_inv : function(){
			$('[data-toggle="click_need_inv"]').on('click', function(){
 				var $this = $(this),
					rec_id = $('.hidden_rec_id').val(),
 				options = {
 					need_inv : $this.val(),
					rec_id	 : rec_id
 				},
 				url = $this.attr('data-url');
 				$.get(url, options, function(data){
 					if (data.state == "success") {
 						$('#total_number').html(data.total_number);
 						$('#goods_subtotal').html(data.total_desc);
 					} else {
 						if (data.error == "1") {
 							alert(data.message);
 							$('#goods_number'+options.rec_id).val(data.err_max_number);
 						}
 					}
				});
 			});
 			$('[data-toggle="change_need_inv"]').on('change', function(){
 				var $this 	= $(this),
					rec_id 	= $('.hidden_rec_id').val(),
 				options 	= {
 					inv_type : $this.val(),
					rec_id 	 : rec_id
 				},
 				url = $this.attr('data-url');
 				$.get(url, options, function(data){
 					if (data.state == "success") {
 						$('#total_number').html(data.total_number);
 						$('#goods_subtotal').html(data.total_desc);
 					} else {
 						if (data.error == "1") {
 							alert(data.message);
 							$('#goods_number'+options.rec_id).val(data.err_max_number);
 						}
 					}
				});
 			});
 			$('[data-toggle="blur_need_inv"]').on('blur', function(){
 				var $this = $(this),
 				options = {
 					inv_payee : $this.val()
 				},
 				url = $this.attr('data-url');
 				$.get(url, options, function(data){
 					if (data.state == "success") {
 						$('#total_number').html(data.total_number);
 						$('#goods_subtotal').html(data.total_desc);
 					} else {
 						if (data.error == "1") {
 							alert(data.message);
 							$('#goods_number'+options.rec_id).val(data.err_max_number);
 						}
 					}
				});
 			});
		},

		change_bonus : function(){
			$('[data-toggle="change_bonus"]').on('click', function(){
 				var $this = $(this),
					rec_id = $('.hidden_rec_id').val(),
 				options = {
 					bonus : $this.val(),
					rec_id: rec_id
 				},
 				url = $this.attr('data-url');
 				$.get(url, options, function(data){
 					if (data.state == "success") {
 						$('#total_number').html(data.content);
 					} else {
 						if (data.error == "1") {
 							alert(data.message);
 							$('#goods_number'+options.rec_id).val(data.err_max_number);
 						}
 					}
				});
 			});
		},

		change_surplus : function(){
			$('[data-toggle="change_surplus"]').on('blur', function(){
 				var $this = $(this),
					rec_id = $('.hidden_rec_id').val(),
 				options = {
 					surplus : $this.val(),
					rec_id : rec_id
 				},
 				url = $this.attr('data-url');
 				$.get(url, options, function(data){
 					if (data.state == "success") {
 						$('#total_number').html(data.content);
 					} else {
 						if (data.error == "1") {
 							alert(data.message);
 							$('#goods_number'+options.rec_id).val(data.err_max_number);
 						}
 					}
				});
 			});
		},

		change_integral : function(){
			$('[data-toggle="change_integral"]').on('blur', function(){
 				var $this = $(this),
					rec_id = $('.hidden_rec_id').val(),
 				options = {
 					integral : $this.val(),
					rec_id : rec_id
 				},
 				url = $this.attr('data-url');
 				$.get(url, options, function(data){
					if (data.message.message) {
						ecjia.touch.showmessage(data.message);
					} else {
						$('#total_number').html(data.message.content);
					}
				});
 			});
		},

		select_inv : function(){
			$('[data-flag="need_inv_i"]').on('click',function(){
				if ($(this).hasClass("fl")) {
					$(this).removeClass("fl").addClass("fr");
					$(this).siblings("ins").text("是");
					$(this).parent().parent("li").siblings().hide();
				} else if ($(this).hasClass("fr")) {
					$(this).removeClass("fr").addClass("fl");
					$(this).siblings("ins").text("否");
					$(this).parent().parent("li").siblings().show();
				}
			});
		},

		fold_area : function() {
			$(document).off('click', '.flow-checkout .checkout-select .select');
			$(document).on('click', '.flow-checkout .checkout-select .select', function(e){
				e.preventDefault();
				$(this).next().toggle();
			});
		},

        init_pay : function() {
            if (!$('input[name="shipping"]:checked').val()) {
                $('input[name="shipping"]').eq(0).prop('checked','true');
            }
            if (!$('input[name="payment"]:checked').val()) {
                $('input[name="payment"]').eq(0).prop('checked','true');
            }
        },

		check_goods : function() {
			$('.checkbox').on('change',function(){
				var $id = $(".checkbox:checked");
				var id = [],
					url = $('.goods-checkout').attr('data-url')+'&rec_id=';
				$id.each(function() {
					id = $(this).val();
					url = url + id + ',';
				});
				url = url.substring(0,url.length-1);
				$('.goods-checkout').attr('href',url);
			});
		}

	};

})(ecjia, jQuery);
