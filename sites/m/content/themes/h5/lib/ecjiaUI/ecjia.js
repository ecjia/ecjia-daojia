/**
* Created by royalwang on 14-3-20.
*/
(function(window, jQuery) {
	var class2type = {};
	var toString = class2type.toString;
	var hasOwn = class2type.hasOwnProperty;
	var
	document = window.document,

	version = "1.0.0",

	ecjia = function() {
		return new ecjia.fn.init();
	};


	ecjia.fn = ecjia.prototype = {
		ver: version,

		jquery: jQuery,

		constructor: ecjia
	}

	ecjia.extend = ecjia.fn.extend = function() {
		var options, name, src, copy, copyIsArray, clone,
		target = arguments[0] || {},
		i = 1,
		length = arguments.length,
		deep = false;

		if (typeof target === "boolean") {
			deep = target;

			target = arguments[i] || {};
			i++;
		}

		if (typeof  target != "object" && !ecjia.isFunction(target)) {
			target = {};
		}

		if (i === length) {
			target = this;
			i--;
		}

		for ( ; i < length; i++) {
			if ((options = arguments[i]) != null) {
				for (name in options) {
					src = target[name];
					copy = options[name];

					if (target === copy) {
						continue;
					}

					if (deep && copy && (ecjia.isPlainObject(copy) || (copyIsArray = ecjia.isArray(copy)))) {
						if (copyIsArray) {
							copyIsArray = false;
							clone = src && ecjia.isArray(src) ? src : [];
						}
						else {
							clone = src && ecjia.isPlainObject(src) ? src : {};
						}

						target[name] = ecjia.extend(deep, clone, copy);
					}
					else if (copy != undefined) {
						target[name] = copy;
					}
				}
			}
		}

		return target;
	};

	ecjia.extend({
		isFunction: function(obj) {
			return ecjia.type(obj) === "function";
		},

		isArray: Array.isArray,

		isPlainObject: function(obj) {
			if (ecjia.type(obj) != "object" || ecjia.isWindow(obj)) {
				return false;
			}

			try {
				if (obj.constructor && !hasOwn.call(obj.constructor.prototype, "isPrototypeOf")) {
					return false;
				}
			} catch (e) {
				return false;
			}

			return true;
		},

		type: function(obj) {
			if (obj == null) {
				return obj + "";
			}

			return typeof obj === "object" || typeof obj === "function" ?
			class2type[toString.call(obj)] || "object" :
			typeof obj;
		},

		alert: function(obj) {
			alert(obj);
		}
	});

// function
init = ecjia.fn.init = function() {
	return this;
};

init.prototype = ecjia.fn;


ecjia.version = function(isalert) {

	if (typeof isalert === "undefined") {
		isalert = false;
	}

	if (isalert) {
		alert(this.prototype.ver);
	}
	else {
		console.log(this.prototype.ver);
	}
};


/*
ecjia.$ = ecjia.jquery = function() {
return ecjia.prototype.jquery;
}
*/
ecjia.$ = ecjia.jquery = ecjia.prototype.jquery;

var _ecjia = window.ecjia,

_ej = window.ej;

if (window.ej === ecjia) {
	window.ej = _ej;
}

if (window.ecjia === ecjia) {
	window.ecjia = _ecjia;
}

window.ecjia = window.ej = ecjia;

return ecjia;

})(window, jQuery);