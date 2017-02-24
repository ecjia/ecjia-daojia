// JavaScript Document
;(function(app, $) {
	app.loading = {
		init : function () {
			//获取终端的相关信息
			var Terminal = {
			    // 辨别移动终端类型
			    platform : function(){
			        var u = navigator.userAgent, app = navigator.appVersion;
			        return {
			            // android终端或者uc浏览器
			            android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1,
			            // 是否为iPhone或者QQHD浏览器
			            iPhone: u.indexOf('iPhone') > -1 ,
			            // 是否iPad
			            iPad: u.indexOf('iPad') > -1
			        };
			    }(),
			}
			
			if (Terminal.platform.android) {
		        document.getElementById('state2').style.display='block';
		        $('.loading').attr('data-url', $('.android').attr('data-url'));
		    } else if (Terminal.platform.iPhone){
		        document.getElementById('state2').style.display='block';
		        $('.loading').attr('data-url', $('.iphone').attr('data-url'));
		    } else if (Terminal.platform.iPad){
		        // 还可以通过language，区分开多国语言版
		    	document.getElementById('state2').style.display='block';
		    	$('.loading').attr('data-url', $('.iphone').attr('data-url'));
		    } else {
		    	document.getElementById('state1').style.display='block';
			}
		    
	        $("a").click(function(e){
	        	location.href = $(this).attr('data-url');
	        })
			
		},
		
		
	};
})(ecjia.front, jQuery);
