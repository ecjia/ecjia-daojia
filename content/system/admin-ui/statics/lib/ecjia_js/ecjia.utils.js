;(function($) {
	$.utils = {
		htmlEncode : function(text) {
			return text.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
		},
		
		trim : function(text) {
			if (typeof(text) == "string")
			{
				return text.replace(/^\s*|\s*$/g, "");
			}
			else
			{
				return text;
			}
		},
		
		isEmpty : function(val) {
			switch (typeof(val)) {
				case 'string':
				return this.trim(val).length == 0 ? true : false;
				break;
				case 'number':
				return val == 0;
				break;
				case 'object':
				return val == null;
				break;
				case 'array':
				return val.length == 0;
				break;
				default:
				return true;
			}
		},
		
		isNumber : function(val) {
			var reg = /^[\d|\.|,]+$/;
			return reg.test(val);
		},
		
		isInt : function(val) {
			if (val == "")
			{
				return false;
			}
			var reg = /\D+/;
			return !reg.test(val);
		},
		
		isEmail : function(email) {
			/*var reg1 = /(([\w-]+\.)+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/;//原始正则，限制太多，不正确
			var reg1 = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;*/
			var reg1 = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
			return reg1.test( email );
		},
		
		isTel : function(val) {
			var reg = /^[\d|\-|\s|\_]+$/; //只允许使用数字-空格等

			return reg.test( tel );
		},
		
		isTime : function(val) {
			var reg = /^\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}$/;

			return reg.test(val);
		},


		fixEvent : function(e) {
			var evt = (typeof e == "undefined") ? window.event : e;
			return evt;
		},


		srcElement : function(e) {
			if (typeof e == "undefined") e = window.event;
			var src = document.all ? e.srcElement : e.target;

			return src;
		},

		/**
		* 当前鼠标X坐标
		* @param e
		*/
		x : function(e) {
			return ecjia.browser.isIE?event.x + document.documentElement.scrollLeft - 2:e.pageX;
		},

		/**
		* 当前鼠标Y坐标
		* @param e
		*/
		y : function(e) {
			return ecjia.browser.isIE?event.y + document.documentElement.scrollTop - 2:e.pageY;
		},


		request : function(url, item) {
			var sValue=url.match(new RegExp("[\?\&]"+item+"=([^\&]*)(\&?)","i"));
			return sValue?sValue[1]:sValue;
		},

		$ : function(name) {
			return document.getElementById(name);
		}

	};
 })(ecjia);