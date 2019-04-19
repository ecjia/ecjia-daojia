/**
* Created by royalwang on 14-3-20.
*/
(function(window) {
	var class2type = {};
	var toString = class2type.toString;
	var hasOwn = class2type.hasOwnProperty;
	var document = window.document;
	var version = "1.0.0";
	var ecjia = function() {
		return new ecjia.fn.init();
	};

	ecjia.fn = ecjia.prototype = {
		ver: version,
		constructor: ecjia
	};

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

		if (typeof target !== "object" && !ecjia.isFunction(target)) {
			target = {};
		}

		if (i === length) {
			target = this;
			i--;
		}

		for ( ; i < length; i++) {
			if ((options = arguments[i]) !== null) {
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
					else if (copy !== undefined) {
						target[name] = copy;
					}
				}
			}
		}

		return target;
	};

	ecjia.extend({
		isFunction: function(object) {
			return ecjia.type(object) === "function";
		},

		isArray: Array.isArray,

		isPlainObject: function(object) {
			if (ecjia.type(object) !== "object" || ecjia.isWindow(object)) {
				return false;
			}

			try {
				if (obj.constructor && !hasOwn.call(object.constructor.prototype, "isPrototypeOf")) {
					return false;
				}
			} catch (e) {
				return false;
			}

			return true;
		},

		type: function(object) {
			if (object === null) {
				return object + "";
			}

			return typeof object === "object" || typeof object === "function" ?
			class2type[toString.call(object)] || "object" :
			typeof object;
		},

		alert: function(object) {
			alert(object);
		},

        modules: function(start, modules) { // webpackBootstrap

            // The module cache
            var installedModules = {};

            // The require function
            function __webpack_require__(moduleId) {

                // Check if module is in cache
                if(installedModules[moduleId]) {
                    return installedModules[moduleId].exports;
                }
                // Create a new module (and put it into the cache)
                var module = installedModules[moduleId] = {
                    id: moduleId,
                    loaded: false,
                    exports: {}
                };

                // Execute the module function
                modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

                // Flag the module as loaded
                module.loaded = true;

                // Return the exports of the module
                return module.exports;
            };

			// expose the modules object (__webpack_modules__)
			__webpack_require__.modules = modules;

			// expose the module cache
			__webpack_require__.cache = installedModules;

			// define getter function for harmony exports
            __webpack_require__.define = function(exports, name, getter) {
				if(!__webpack_require__.object(exports, name)) {
					Object.defineProperty(exports, name, {
						configurable: false,
						enumerable: true,
						get: getter
					});
				}
			};

			// getDefaultExport function for compatibility with non-harmony modules
            __webpack_require__.non_harmony = function(module) {
				var getter = module && module.__esModule ?
					function getDefault() { return module['default']; } :
					function getModuleExports() { return module; };
                __webpack_require__.define(getter, 'a', getter);
				return getter;
			};

			// Object.prototype.hasOwnProperty.call
            __webpack_require__.object = function(object, property) {
				return Object.prototype.hasOwnProperty.call(object, property);
			};

			// __webpack_public_path__
            __webpack_require__.path = "";

			// Load entry module and return exports
			return __webpack_require__(__webpack_require__.start = start);
		},

		_default: function($value, $default) {
			return (typeof $value !== 'undefined') ?  $value : $default;
		},

		version: function(isalert) {

			if (typeof isalert === "undefined") {
				isalert = false;
			}

			if (isalert) {
				alert(this.prototype.ver);
			}
			else {
				console.log(this.prototype.ver);
			}
		}

	});

// function
init = ecjia.fn.init = function() {
	return this;
};

init.prototype = ecjia.fn;

var _ecjia = window.ecjia;

if (window.ecjia === ecjia) {
	window.ecjia = _ecjia;
} else {
    window.ecjia = ecjia;
}

return ecjia;

})(window);