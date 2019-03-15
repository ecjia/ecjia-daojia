// JavaScript Document
;
(function (app, $) {
	app.platform_activity = {
		init: function () {
			/* 加载日期控件 */
			$.fn.datetimepicker.dates['zh'] = {
				days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日"],
				daysShort: ["日", "一", "二", "三", "四", "五", "六", "日"],
				daysMin: ["日", "一", "二", "三", "四", "五", "六", "日"],
				months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
				monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
				meridiem: ["上午", "下午"],
				today: "今天"
			};
			$(".time").datetimepicker({
				format: "yyyy-mm-dd hh:ii",
				language: 'zh',
				weekStart: 1,
				todayBtn: 1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 2,
				forceParse: 0,
				minuteStep: 1
			});
			app.platform_activity.submit();
			app.platform_activity.prize_init();
			app.platform_activity.change_type();
		},
		submit: function (formobj) {
			var $form = $("form[name='theForm']");
			var option = {
				rules: {
					'activity_name': {
						required: true
					},
					'start_time': {
						required: true
					},
					'end_time': {
						required: true
					},

					'prize_level': {
						required: true
					},
					'prize_name': {
						required: true
					},
					'prize_type': {
						required: true
					},
					'prize_value': {
						required: true
					},
					'prize_value_other': {
						required: true
					},
					'prize_number': {
						required: true
					},
					'prize_prob': {
						required: true
					},
				},
				messages: {
					'activity_name': {
						required: js_lang.market_activity_name
					},
					'start_time': {
						required: js_lang.market_start_time
					},
					'end_time': {
						required: js_lang.market_end_time
					},

					'prize_level': {
						required: js_lang.market_prize_level
					},
					'prize_name': {
						required: js_lang.market_prize_name
					},
					'prize_type': {
						required: js_lang.market_prize_type
					},
					'prize_value': {
						required: js_lang.market_prize_value
					},
					'prize_value_other': {
						required: js_lang.market_prize_value_other
					},
					'prize_number': {
						required: js_lang.market_prize_number
					},
					'prize_prob': {
						required: js_lang.market_prize_prob
					},
				},
				submitHandler: function () {
					$form.ajaxSubmit({
						dataType: "json",
						success: function (data) {
							ecjia.platform.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.platform.defaultOptions.validate, option);
			$form.validate(options);
		},

		prize_init: function () {
			$('select').select2();
			$("input[type='submit']").on('click', function () {
				var $this = $("form[name='editForm']");
				var option = {
					submitHandler: function () {
						$this.ajaxSubmit({
							dataType: "json",
							success: function (data) {
								ecjia.platform.showmessage(data);
							}
						});
					}
				}
				var options = $.extend(ecjia.platform.defaultOptions.validate, option);
				$this.validate(options);
			});
		},

		change_type: function () {
			$('select[name="prize_type"]').off('change').on('change', function () {
				var $this = $(this),
					val = $this.val();
				var html = '';
				//0未中奖 4商品展示 5店铺展示
				if (val == 0 || val == 4 || val == 5) {
					$('.prize_value_bonus').addClass('display-dn');
					$('.prize_value_other').addClass('display-dn');
				}
				//1礼券红包 下拉选择红包
				if (val == 1) {
					$('.prize_value_bonus').removeClass('display-dn').find('select').select2();
					$('.prize_value_other').addClass('display-dn');
				}
				//2实物奖品 3积分奖品 6现金红包 手动填写
				if (val == 2 || val == 3 || val == 6) {
					$('.prize_value_other').find('.help-block').remove();
					$('.prize_value_other').find('input').val('');
					html += '<span class="help-block">';
					if (val == 2) {
						html += js_lang.winning_physical_prize;
					}
					if (val == 3) {
						html += js_lang.number_of_points_consumed;
					}
					if (val == 6) {
						html += js_lang.cash_red_envelope_amount;
					}
					html += '</span>'
					$('.prize_value_bonus').addClass('display-dn');
					$('.prize_value_other').removeClass('display-dn');
					$('.prize_value_other').find('.controls').append(html);
				}

			})
		}
	};
})(ecjia.platform, jQuery);

// end