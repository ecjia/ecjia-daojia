/**
 * EcjiaMiddleware简单使用一下：
 var middleware = new EcjiaMiddleware(); // ecjia.middleware();
 middleware.use(function(next){console.log(1);next();})
 middleware.use(function(next){console.log(2);next();})
 middleware.use(function(next){console.log(3);})
 middleware.use(function(next){console.log(4);next();})
 middleware.handleRequest();
 */

;(function(ecjia) {
    function EcjiaMiddleware() {
        this.cache = [];
    }

    EcjiaMiddleware.prototype.use = function (fn) {
        if (typeof fn !== 'function') {
            throw 'middleware must be a function';
        }
        this.cache.push(fn);
        return this;
    }
    EcjiaMiddleware.prototype.next = function (fn) {
        if (this.middlewares && this.middlewares.length > 0) {
            var ware = this.middlewares.shift();
            ware.call(this, this.next.bind(this));
        }
    }
    EcjiaMiddleware.prototype.handleRequest = function () {//执行请求
        this.middlewares = this.cache.map(function (fn) {//复制
            return fn;
        });
        this.next();
    }

    ecjia.middleware = function () {
        return new EcjiaMiddleware();
    }

})(ecjia);


