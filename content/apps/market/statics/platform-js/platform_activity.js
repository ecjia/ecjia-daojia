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
						required: '请输入活动名称'
					},
					'start_time': {
						required: '请输入活动开始时间'
					},
					'end_time': {
						required: '返回选择栏目'
					},

					'prize_level': {
						required: '请选择奖品等级'
					},
					'prize_name': {
						required: '请填写奖品名称'
					},
					'prize_type': {
						required: '请选择奖品类型'
					},
					'prize_value': {
						required: '请选择礼券奖品的红包'
					},
					'prize_value_other': {
						required: '请填写奖品内容'
					},
					'prize_number': {
						required: '请填写奖品数量'
					},
					'prize_prob': {
						required: '请填写获奖概率'
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
						html += '填写中奖的实物奖品，如iPhone X或iPad Pro 2';
					}
					if (val == 3) {
						html += '填写中奖后发放的消费积分数量';
					}
					if (val == 6) {
						html += '填写中奖后发放的现金红包金额，中奖后直接发放到用户帐户余额';
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