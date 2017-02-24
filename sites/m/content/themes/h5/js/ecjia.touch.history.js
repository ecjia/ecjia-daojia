/**
 * Touch历史管理插件
 * 使用HTML5本地话存储localStorage
 * history = {0:'xxx',1:'xxx1',2:'xxx2'}
 */
;(function(ecjia, $) {
    ecjia.touch.history = {

        /**
         * 返回
         */
        back : function() {
            history.go(-1);
        },

        /**
         * 获取最后一个历史url
         * @return {[string]} [最后一个历史url]
         */
        get : function() {
            var history_arr = this.get_all();
            url = JSON.parse(history_arr[history_arr.length - 1]);
            return url;
		},

        /**
         * 获取历史树
         * @return {[array]} [历史树数组]
         */
        get_all : function() {
            var history = localStorage.getItem('history');
            history_arr = history ? history.split("|") : [];
            if (history_arr.length > 10) history_arr = history_arr.slice(-10);
            return history_arr;
        },

        /**
         * 探家url进历史树中
         * @param  {[string]} url [url]
         */
		set : function(url) {
            var history_arr = this.get_all();
            if (history_arr.length) {

            } else {
                history_arr = [];
            }
            history_arr.push(url);
            url = JSON.stringify(history_arr);
            localStorage.setItem('history',url)
		},

        clear : function() {
            localStorage.removeItem('history')
        }

	};
})(ecjia, jQuery);

//end
