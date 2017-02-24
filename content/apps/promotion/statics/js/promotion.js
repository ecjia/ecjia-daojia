// JavaScript Document
;(function(app, $) {
	app.promotion_list = {
		init : function() {
			app.promotion_list.search();
		},
		search : function() {
			$("form[name='searchForm']").on('submit', function(e) {
				e.preventDefault();
				var merchant_keywords = $("input[name='merchant_keywords']").val();
				var keywords = $("input[name='keywords']").val();
				var url = $("form[name='searchForm']").attr('action'); 

				if (merchant_keywords) {
					url += '&merchant_keywords=' + merchant_keywords;
				}
				if (keywords) {
					url += '&keywords=' + keywords;
				}
				ecjia.pjax(url);
			});
		}
	}
	
	app.promotion_info = {
		init : function() {
            /* 加载日期控件 */
			$.fn.datetimepicker.dates['zh'] = {  
                days:       ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六","星期日"],  
                daysShort:  ["日", "一", "二", "三", "四", "五", "六","日"],  
                daysMin:    ["日", "一", "二", "三", "四", "五", "六","日"],  
                months:     ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月","十二月"],  
                monthsShort:  ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月","十二月"], 
                meridiem:    ["上午", "下午"],  
                today:       "今天"  
	        };
            $(".date").datetimepicker({
                format: "yyyy-mm-dd hh:ii",
                language: 'zh',  
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0,
                minuteStep: 1,
                container: '.main_content',
            });
			app.promotion_info.search_goods();
			app.promotion_info.submit_form();
		},
		search_goods : function () {
			$('.searchGoods').on('click',function(e){
				var keyword = $("input[name='keywords']").val();
				var goods_id = $("input[name='goods_id']").val();
				var searchURL = $('.searchGoods').attr('data-url');
				var filters = {
					'keyword'	: keyword,
					'goods_id'	: goods_id,
				};
				$.post(searchURL, filters, function(data) {
					app.promotion_info.goods_list(data);
				}, "JSON");
			});
		},
		goods_list : function (data) {
			$('.goods_list').html('');
			if (data.content.length > 0) {
				for (var i = 0; i < data.content.length; i++) {
					var opt = '<option value="'+data.content[i].value+'">'+data.content[i].text+'</option>'
					$('.goods_list').append(opt);
				};
			} else {
				$('.goods_list').append('<option value="-1">未搜索到商品信息</option>');
			}
			
			$('.goods_list').trigger("liszt:updated").trigger("change");
			
		},
		submit_form : function() {
			var $form = $("form[name='theForm']");
			var option = {
					rules : {
						goods_id : { required : true , min : 1},
						start_time : {required:true, date:false},
						end_time : {required:true, date:false},
						price : {required : true, min : 0.01}
					},
					messages : {
						goods_id : { min : '请先选择活动商品'},
						start_time : {
							required : "请选择活动开始时间",
						},
						end_time : {
							required : "请选择活动结束时间",
						},
						price : {
							required : "请填写活动价格",
							min : '活动价格最低为1分钱'
						},
					},
					submitHandler : function() {
						$form.ajaxSubmit({
							dataType : "json",
							success : function(data) {
								ecjia.admin.showmessage(data);
							}
						});
					}
				}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$form.validate(options);
		}
	}

})(ecjia.admin, jQuery);

// end
