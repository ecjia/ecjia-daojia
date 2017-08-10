/**
 * 后台综合js文件
 */
;
(function(ecjia, $) {

	ecjia.touch.flow = {
		init: function() {
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
			ecjia.touch.flow.select_inv_type();
			ecjia.touch.flow.inv_img();
			$('[data-toggle="selectShipping"]:checked').trigger('click');
			$('[data-toggle="selectPayment"]:checked').trigger('click');
			$('[data-toggle="change_bonus"]:checked').trigger('click');
			$('[data-toggle="change_surplus"]').blur();
			$('[data-toggle="change_integral"]').blur();

			function back_goods_number(id) {
				var goods_number = document.getElementById('goods_number' + id).value;
				document.getElementById('back_number' + id).value = goods_number;
			}

			$(document).winderCheck();
		},
		
		inv_img :function(){
			$('.inv_img').on('click', function () {
				alert('<div style="height: 100%;">' +
						'<div style="position:fixed;background: #FFF;width: 100%;height: 3em;border-bottom: 1px solid #eee;z-index: 100;">' +
						'<h2 style="line-height: 2em;position: absolute;right: 0;left: 0;height: 2em;">发票税号说明</h2>' +
						'</div>' +
						'<div style="padding:15px;overflow-y: scroll;padding-top: 3em;text-align: left;width: 100%;height: 100%;">' +
						'<p><b>1、什么是纳税人识别号／统一社会信用代码？</b></p>' +
						'<p style="color:#838383">纳税人识别号，通常简称为“税号”，就是税务登记证上的号，每个企业的识别号都是唯一的，相当于税务局颁发给企业的“身份证”号。统一社会信用代码，是一组长度为18位的用于法人和其他组织身份识别的代码。统一社会信用代码由国家标准委发布。2015年10月1日起，国家启动将企业依次申请的工商营业执照，组织机构代码和税务登记证三证合为一证，并将三证号码合并为统一社会信用代码，目前大部分企业均已完成合并，另外有少部分企业其纳税人识别号仍然有效。</p>' +
						'<p><b>2、如何获取／知晓纳税人识别号／统一社会信用代码？</b></p>' +
						'<p style="color:#838383">您可向贵单位的财务部门索取；另外也可以根据单位名称在国家企业信用信息公示系统（https://www.gsxt.gov.cn/index.html）查询统一社会信用代码。</p>' +
						'<p><b>3、为什么要填写纳税人识别号／统一社会信用代码？</b></p>' +
						'<p style="color:#838383">根据国家税务总局2017年16号公告，从7月1日起企业（包括公司、非公司制企业法人、企业分支机构、个人独资企业、合伙企业和其他企业）索取票面带有“购买方纳税人识别号”栏目的发票时，应向销售方提供纳税人识别号或统一社会信用代码。因此，当您选择开具单位抬头增值税普通发票时，请根据提示准确填写贵单位号码，以免影响您的发票报销。请注意此公告并不适用于政府机构及事业单位中的非企业单位，因此，如贵单位属于这种类型，可无需填写纳税人识别号／统一社会信用代码，谨慎起见，请您与贵单位财务部门联系确认。</p>' + 
						'</div>' +
						'</div>')
			    $(".modal-overlay").css('transition-duration', "0ms");
			    $(".modal-in").css("position", "fixed");
			    $(".modal-in").css("top", "30%");
			    $(".modal-in").css("height", "70%");
			    $(".modal-inner").css("background-color", "#FFF");
			    $(".modal-inner").css("width", "100%");
			    $(".modal-inner").css("padding", "0");
			    $(".modal-inner").css("height", "85%");
			    $(".modal-button-bold").css("background-color", "#FFF");
			    $(".modal-button-bold").css("border-top", "1px solid #eee");
			    $(".modal-inner").append("<style>.modal-inner::after{ width:0 }</style>");
			    $(".modal-text").css("height","100%");
			});
		},
		
		select_inv_type: function() {
			$('.personal').on('click', function(e){
				e.preventDefault();
				$(this).addClass('action');
				$('.enterprise').removeClass('action');
				$('.inv_input').addClass('inv_none');
				$('.inv_type_input').val("");
				$('input[name="inv_type_name"]').val("personal")
				$('.ecjia-bill-img').hide();
				$(this).children('.ecjia-bill-img').show();
			});
			$('.enterprise').on('click', function(e){
				e.preventDefault();
				$(this).addClass('action');
				$('.personal').removeClass('action');
				$('.inv_input').removeClass('inv_none');
				$('input[name="inv_type_name"]').val("enterprise")
				$('.ecjia-bill-img').hide();
				$(this).children('.ecjia-bill-img').show();
			});
		},

		form_submit: function() {
			$('.flow-done-sub').on('click', function() {
				ecjia.touch.pjaxloadding();
				$("input[type='submit']").click();
			});

			$('.check_address').off('click').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					href = $this.attr('href');
				$.post(href, function(data) {
					if (data.state == 'error') {
						alert(data.message);
						return false;
					}
					ecjia.pjax(href);
				})
			});
		},

		change_number_click: function() {
			$('[data-toggle="change_goods_number"]').on('click', function() {
				var $this = $(this),
					options = {
						rec_id: $this.attr('data-rec_id'),
						url: $this.attr('data-url'),
						status: $this.attr('data-status')
					};
				var goods_number = $('#goods_number' + options.rec_id).val();
				if (options.status == 'del') {
					if (goods_number == 1) {
						goods_number = 1;
					} else {
						goods_number = parseInt(goods_number) - 1;
						$('#goods_number' + options.rec_id).val(goods_number);
					}
				} else {
					goods_number = parseInt(goods_number) + 1;
					$('#goods_number' + options.rec_id).val(goods_number);
				}
				ecjia.touch.flow._change_goods(options, goods_number);
			});

			$('[data-toggle="change_goods_number_blur"]').on('blur', function() {
				var $this = $(this),
					options = {
						rec_id: $this.attr('data-rec_id'),
						url: $this.attr('data-url'),
						status: $this.attr('data-status')
					};
				var goods_number = $('#goods_number' + options.rec_id).val();
				if (goods_number <= 0) {
					goods_number = 1;
					$('#goods_number' + options.rec_id).val(1);
				}
				ecjia.touch.flow._change_goods(options, goods_number);
			});
		},

		_change_goods: function(options, goods_number) {
			$.post(
			options.url, {
				'rec_id': options.rec_id,
				'goods_number': goods_number
			}, function(data) {
				if (data.state == "success") {
					$('#total_number').html(data.total_number);
					$('#goods_subtotal').html(data.total_desc);
				} else {
					if (data.error == "1") {
						alert(data.message);
						$('#goods_number' + options.rec_id).val(data.err_max_number);
					}
				}
			}, 'json');
		},

		selectShipping: function() {
			$(document).off('click', '[data-toggle="selectShipping"]');
			$(document).on('click', '[data-toggle="selectShipping"]', function() {
				var $this = $(this),
					rec_id = $('.hidden_rec_id').val(),
					options = {
						shipping: $this.val(),
						rec_id: rec_id
					},
					url = $this.attr('data-url');
				$.get(url, options, function(data) {
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

		selectPayment: function() {
			$(document).off('click', '[data-toggle="selectPayment"]');
			$(document).on('click', '[data-toggle="selectPayment"]', function() {
				var $this = $(this),
					rec_id = $('.hidden_rec_id').val(),
					options = {
						payment: $this.val(),
						rec_id: rec_id
					},
					url = $this.attr('data-url');
				$.get(url, options, function(data) {
					if (data.state == "success") {
						$('#total_number').html(data.content);
						//$('#goods_subtotal').html(data.total_desc);
					} else {
						if (data.error == "1") {
							alert(data.message);
							$('#goods_number' + options.rec_id).val(data.err_max_number);
						}
					}
				});
			});
		},

		select_attr: function() {
			$('.flow-checkout .checkout-select label').on('click', function() {
				var pay = $.trim($(this).text());
				$(this).parents('div').prev('a').find('.select_nav').text(pay);
			});
		},

		change_need_inv: function() {
			$('[data-toggle="click_need_inv"]').on('click', function() {
				var $this = $(this),
					rec_id = $('.hidden_rec_id').val(),
					options = {
						need_inv: $this.val(),
						rec_id: rec_id
					},
					url = $this.attr('data-url');
				$.get(url, options, function(data) {
					if (data.state == "success") {
						$('#total_number').html(data.total_number);
						$('#goods_subtotal').html(data.total_desc);
					} else {
						if (data.error == "1") {
							alert(data.message);
							$('#goods_number' + options.rec_id).val(data.err_max_number);
						}
					}
				});
			});
			$('[data-toggle="change_need_inv"]').on('change', function() {
				var $this = $(this),
					rec_id = $('.hidden_rec_id').val(),
					options = {
						inv_type: $this.val(),
						rec_id: rec_id
					},
					url = $this.attr('data-url');
				$.get(url, options, function(data) {
					if (data.state == "success") {
						$('#total_number').html(data.total_number);
						$('#goods_subtotal').html(data.total_desc);
					} else {
						if (data.error == "1") {
							alert(data.message);
							$('#goods_number' + options.rec_id).val(data.err_max_number);
						}
					}
				});
			});
			$('[data-toggle="blur_need_inv"]').on('blur', function() {
				var $this = $(this),
					options = {
						inv_payee: $this.val()
					},
					url = $this.attr('data-url');
				$.get(url, options, function(data) {
					if (data.state == "success") {
						$('#total_number').html(data.total_number);
						$('#goods_subtotal').html(data.total_desc);
					} else {
						if (data.error == "1") {
							alert(data.message);
							$('#goods_number' + options.rec_id).val(data.err_max_number);
						}
					}
				});
			});
		},

		change_bonus: function() {
			$('[data-toggle="change_bonus"]').on('click', function() {
				var $this = $(this),
					rec_id = $('.hidden_rec_id').val(),
					options = {
						bonus: $this.val(),
						rec_id: rec_id
					},
					url = $this.attr('data-url');
				$.get(url, options, function(data) {
					if (data.state == "success") {
						$('#total_number').html(data.content);
					} else {
						if (data.error == "1") {
							alert(data.message);
							$('#goods_number' + options.rec_id).val(data.err_max_number);
						}
					}
				});
			});
		},

		change_surplus: function() {
			$('[data-toggle="change_surplus"]').on('blur', function() {
				var $this = $(this),
					rec_id = $('.hidden_rec_id').val(),
					options = {
						surplus: $this.val(),
						rec_id: rec_id
					},
					url = $this.attr('data-url');
				$.get(url, options, function(data) {
					if (data.state == "success") {
						$('#total_number').html(data.content);
					} else {
						if (data.error == "1") {
							alert(data.message);
							$('#goods_number' + options.rec_id).val(data.err_max_number);
						}
					}
				});
			});
		},

		change_integral: function() {
			$('[data-toggle="change_integral"]').on('blur', function() {
				var $this = $(this),
					rec_id = $('.hidden_rec_id').val(),
					options = {
						integral: $this.val(),
						rec_id: rec_id
					},
					url = $this.attr('data-url');
				$.get(url, options, function(data) {
					if (data.message.message) {
						ecjia.touch.showmessage(data.message);
					} else {
						$('#total_number').html(data.message.content);
					}
				});
			});
		},
		
		select_inv: function() {
			$('[data-flag="need_inv_i"]').on('click', function() {
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

		fold_area: function() {
			$(document).off('click', '.flow-checkout .checkout-select .select');
			$(document).on('click', '.flow-checkout .checkout-select .select', function(e) {
				e.preventDefault();
				$(this).next().toggle();
			});
		},

		init_pay: function() {
			if (!$('input[name="shipping"]:checked').val()) {
				$('input[name="shipping"]').eq(0).prop('checked', 'true');
			}
			if (!$('input[name="payment"]:checked').val()) {
				$('input[name="payment"]').eq(0).prop('checked', 'true');
			}
		},

		check_goods: function() {
			$('.checkbox').on('change', function() {
				var $id = $(".checkbox:checked");
				var id = [],
					url = $('.goods-checkout').attr('data-url') + '&rec_id=';
				$id.each(function() {
					id = $(this).val();
					url = url + id + ',';
				});
				url = url.substring(0, url.length - 1);
				$('.goods-checkout').attr('href', url);
			});
		}

	};

})(ecjia, jQuery);

//end