(function ($) {
    $.fn.yomi = function () {
        var data = "";
        var _DOM = null;
        var TIMER;
        createdom = function (dom) {
            _DOM = dom;
            data = $(dom).attr("data-time");
            if (data) {
                data = data.replace(/-/g, "/");
                data = Math.round((new Date(data)).getTime() / 1000);
                reflash();
            }
        };
        reflash = function () {
            var range = data - Math.round((new Date()).getTime() / 1000),
                secday = 86400, sechour = 3600,
                days = parseInt(range / secday),
                hours = parseInt((range % secday) / sechour),
                min = parseInt(((range % secday) % sechour) / 60),
                sec = ((range % secday) % sechour) % 60;

            if ($(_DOM).find(".days").length == 0) {
                hours += days * 24;
                $(_DOM).find(".hours").html(nol(hours));
            } else {
                $(_DOM).find(".days").html(nol(days));
                $(_DOM).find(".hours").html(nol(hours));
            }
            $(_DOM).find(".minutes").html(nol(min));
            $(_DOM).find(".seconds").html(nol(sec));
        };
        TIMER = setInterval(reflash, 1000);
        nol = function (h) {
            if (h < 0) {
                h = '0' + '0';
            } else if (h < 10) {
                h = '0' + h;
            }
            return h;
        }
        return this.each(function () {
            var $box = $(this);
            createdom($box);
        });
    }
})(jQuery);