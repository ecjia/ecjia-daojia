/**
 * 后台综合js文件
 */
;
(function(ecjia, $) {
	ecjia.touch.goods_detail = {
		init: function() {
			ecjia.touch.goods_detail.change();
			ecjia.touch.goods_detail.promote_time();
			ecjia.touch.goods_detail.goods_img();
		},
		change: function() {
			$('.tab2').css("border-bottom", "none");
			$('.tab3').css("border-bottom", "none");

			$('.goods-tab').off('click').on('click', function(e) {
				var id = $(this).attr('data-type');
				if (id == 1) {
					$(".tab1").css("border-bottom", "4px solid #fff")
					$('.tab2').css("border-bottom", "none");
					$('.tab3').css("border-bottom", "none");
					$('#goods-info-one').show();
					$('#goods-info-two').hide();
					$('#goods-info-three').hide();
				} else if (id == 2) {
					$('.tab2').css("border-bottom", "4px solid #fff");
					$('.tab1').css('border-bottom', "none");
					$('.tab3').css("border-bottom", "none");
					$('#goods-info-two').show();
					$('#goods-info-one').hide();
					$('#goods-info-three').hide();
				} else if (id == 3) {
					$('.tab2').css("border-bottom", "none");
					$('.tab1').css('border-bottom', "none");
					$('.tab3').css("border-bottom", "4px solid #fff");
					$('#goods-info-two').hide();
					$('#goods-info-one').hide();
					$('#goods-info-three').show();
				}
				$(window).scrollTop(0);
			});
			$('.goods-desc-li-info').off('click').on('click', function(e) {
				var type = $(this).attr('data-id');
				if (type == 1) {
					$('#one-info').show();
					$('#two-info').hide();
					$('.one-li').addClass('active');
					$('.two-li').removeClass('active');
				} else {
					$('#two-info').show();
					$('#one-info').hide();
					$('.two-li').addClass('active');
					$('.one-li').removeClass('active');
				}
			});
		},
		promote_time: function() {
			var serverTime = Math.round(new Date().getTime() / 1000) * 1000; //服务器时间，毫秒数 
			var dateTime = new Date();
			var difference = dateTime.getTime() - serverTime; //客户端与服务器时间偏移量 
			var InterValObj;
			clearInterval(InterValObj);

			InterValObj = setInterval(function() {
				$(".goods-detail-promote").each(function() {
					var obj = $(this);
					var endTime = new Date((parseInt(obj.attr('value')) + 8 * 3600) * 1000);
					var nowTime = new Date();
					var nMS = endTime.getTime() - nowTime.getTime() + difference;
					var myD = Math.floor(nMS / (1000 * 60 * 60 * 24)); //天 
					var myH = Math.floor(nMS / (1000 * 60 * 60)) % 24; //小时 
					var myM = Math.floor(nMS / (1000 * 60)) % 60; //分钟 
					var myS = Math.floor(nMS / 1000) % 60; //秒 

					var type = obj.attr('data-type');
					var hh = checkTime(myH);
					var mm = checkTime(myM);
					var ss = checkTime(myS);

					if (myD >= 0) {
						if (type == 1) {
							msg = '距结束';
							var str = msg + myD + '天 &nbsp;&nbsp;<span class="end-time">' + hh + '</span> : <span class="end-time">' + mm + '</span> : <span class="end-time">' + ss + '</span>';
						} else {
							msg = '剩余';
							var str = msg + myD + "天&nbsp;" + hh + ":" + mm + ":" + ss;
						}
					} else {
						var str = "已结束！";
					}
					obj.html(str);
				});
			}, 1000); //每隔1秒执行一次 
		},
		goods_img: function() {
			var swiper = new Swiper('.swiper-goods-img', {
				pagination: '.swiper-pagination',
				grabCursor: true,
				centeredSlides: true,
				coverflow: {
					rotate: 50,
					stretch: 0,
					depth: 100,
					modifier: 1,
					slideShadows: true
				},
				//无限滚动
				slidesPerView: 1,
				loop: true,
			});
		},
	};

	function checkTime(i) {
		if (i < 10) {
			i = "0" + i;
		}
		return i;
	}
})(ecjia, jQuery);

//end