;(function($) {

  $.fn.koala = function(selector, options) {
    var defaults = {
      delay: 200
    };

    var events = ["keydown", "keypress", "keyup"];

    if (arguments.length === 1 && (typeof(options) === 'undefined' || selector === null)) {
      options = selector;
      selector = null;
    }
    var opts = $.extend(defaults, options);

    var koala = function(obj, func) {
      return function(event) {
        var $obj = $(obj);
        var koala = $obj.data('koala-timer');
        if (typeof(koala) !== 'undefined' && koala !== null) {
          var now = (new Date()).getTime();
          if (now - koala.time < opts.delay) {
            clearTimeout(koala.timer);
          }
        }
        var _this = this;
        var timer = setTimeout(function(){
          func.call(_this, event);
          $obj.removeData('koala-timer');
        }, opts.delay);
        $obj.data('koala-timer', {timer: timer, time: (new Date()).getTime()});
      };
    };

    this.each(function(){
      var $this = $(this);
      $.each(events, function(i, e){
        if (opts[e] && typeof(opts[e]) === "function") {
          if (selector !== null) {
            $this.on(e, selector, koala($this, opts[e]));
          }else {
            $this.on(e, koala($this, opts[e]));
          }
        }
      });
    });

  };

})(jQuery);
