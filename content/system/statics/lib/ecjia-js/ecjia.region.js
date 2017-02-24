/**
* Created by royalwang on 14-3-24.
*/
;(function(ecjia, $) {

	/**
	* regionSummary触发器【区域总汇-地址联动选择】
	* url      当前使用的源地址（提供查询使用）
	* pid      当前元素的id号（提供下级地区查询）
	* type     当前地区级别
	* target   下一个地区联动select框class名
	* 
	*/
	$(document).on('change', 'select[data-toggle="regionSummary"]', function(e){
		var $this	= $(this);
		var url		= $this.attr('data-url') || $this.attr('href') || $('select[data-toggle="regionSummary"]').eq(0).attr('data-url');
		var pid		= $this.attr('data-pid') || $this.find('option:checked').val();
		var type	= $this.attr('data-type');
		var target	= $this.attr('data-target');

		var option = {url : url, pid : pid, type : type, target : target};
		e.preventDefault();
		ecjia.region.regionSummary(option);
	})

	ecjia.region = {
		isAdmin : false,
		url : '',

		/* *
		* 载入地区数据事件
		*
		* @country integer     国家的编号
		* @selName string      列表框的名称
		*/
		regionSummary : function(options) {
			if(!options.url && !this.url){
				console.log('必须指定地址源');
				return;
			}

			var defaults = {
				pid : 0,
				type : 1,
				target : 'region-summary'
			}

			var options = $.extend({}, defaults, options);
			this.url = options.url ? options.url : this.url;
			this.loadRegions(options.pid, options.type, options.target);
		},

		loadRegions : function(parent, type, target) {
			$.get(this.url, 'type=' + type + '&target=' + target + "&parent=" + parent , this.response, "JSON");
		},

		response : function(result) {
			var sel = $('.'+result.target);
			sel.find('option').eq(0).attr('checked','checked');
			sel.find('option:gt(0)').remove();

			if (result.regions)
			{
				for (i = 0; i < result.regions.length; i ++ )
				{
					var opt		= document.createElement("OPTION");
					opt.value	= result.regions[i].region_id;
					opt.text	= result.regions[i].region_name;
					sel.append(opt);
				}
			}
			sel.trigger("liszt:updated").trigger("change");
		},

		/* *
		* 处理下拉列表改变的函数
		*
		* @obj		object	下拉列表
		* @type		integer	类型
		* @selName	string	目标列表框的名称
		*/
		changed : function(obj, type, selName) {
			var parent = obj.options[obj.selectedIndex].value;

			this.loadRegions(parent, type, selName);
		},

	};

})(ecjia, jQuery);