/**
 * ecjiaUI组件模块
 */
;(function(ecjia, $) {

	ecjia.ui = {
		editor_info : '',
		init : function(){
			if($('.admin-editor-container').length>0){
				$('.admin-editor-container').css({ clear: "none"});
			}
            ecjia.ui.check_pjax();
            ecjia.ui.set_sortable();
		},
		
		alert : function(msg) {
			return smoke.alert(msg);
		},
		
		confirm : function(msg, callback) {
			return smoke.confirm(msg, callback, {ok:admin_lang.ok, cancel:admin_lang.cancel});
		},

        /**
         * 检查PJAX
         */
        check_pjax : function() {
			if (!!(window.history && history.pushState)){
				// 支持History API
			} else {
				// 不支持
                console.log('您使用的浏览器并不能很好的支持我们的效果，请更换浏览器访问或开启浏览器history.pushState扩展。');
			}
        },

        /**
         * 设置排序
         */
        set_sortable : function() {
			if( jQuery.isFunction(jQuery.fn.sortable) ){
				$('.move-mod').not('.nomove').sortable({
					connectWith: '.move-mod',
					// delay: 2,
					distance: 5,
					handle: '.move-mod-head',
					placeholder: 'ui-sortable-placeholder',
					items: ".move-mod-group:not(.not-move)",
					activate: function(event, ui) {
						$(".move-mod").addClass('sort_ph');
					},
					stop: function(event, ui) {
						$(".move-mod").removeClass('sort_ph');
					},
					sort: function() {
						$( this ).removeClass( "ui-state-default" );
					},
					update: function(e, ui) {
						var name = ui.item.find('.move-mod-head').attr('data-sortname');
						if (name) {
							ecjia.admin.save_sortIndex(name);
						}
					}
				});
				$( ".move-mod-head" ).disableSelection();
			}
        },

		/**
		 * AJAX删除数据方法
		 */
		ajax_remove : function(options){
			var defaults = {
				url	: false,					//url 删除访问的url地址
				id	: '',						//id  删除的数据id
//				msg	: '您确定要删除这条记录吗？',	//msg 删除时的提示信息
				msg	: admin_lang.confirm_del,	//msg 删除时的提示信息
				obj : '',						//obj 删除后要移除的元素
			}

			var options = $.extend({}, defaults, options);
			// options.url, options.id ,options.msg ,options.obj
			if(!options.url){
//				smoke.alert('参数错误，无法删除！');
				smoke.alert(admin_lang.error);
				return false;
			}

			smoke.confirm(options.msg,function(e){
				if (e){
					$.get(options.url, options.id, function(data){
						// if(data.state == 'success'){
							// options.obj.remove();
							ecjia.pjax(window.location.href, function(){
								ecjia.admin.showmessage(data);
							});
						// }
					}, 'json');
				}
//			}, {ok:"确定", cancel:"取消"});
			}, {ok:admin_lang.ok, cancel:admin_lang.cancel});
		},

		/**
		 * batch 批量操作方法
		 */
		batch : function(options) {
			var defaults = {
				url			: false,					//url 			批量操作访问的url地址
//				msg			: '您确定要操作所有选中项吗？',	//msg 			批量操作的提示信息
//				noSelectMsg	: '请先选中操作项！',			//noSelectMsg	没有选中项的提示信息
				msg			: admin_lang.confirm,		//msg 			批量操作的提示信息
				noSelectMsg	: admin_lang.please_select,	//noSelectMsg	没有选中项的提示信息
				name		: 'checkboxes',				//name 			对应PHP操作中获取的name
				id			: [],						//obj 			批量操作的用户id数组
			}

			var options = $.extend({}, defaults, options);
			if(!options.url || options.id.length == 0)return console.log(admin_lang.batch_error);
			var ajaxinfo = "{" + options.name + ":'" + options.id + "'}";
			ajaxinfo=eval("("+ajaxinfo+")");
			smoke.confirm(options.msg,function(e){
				if (e) {
					$.ajax({
						type: "POST",
						url: options.url,
						data: ajaxinfo,
						dataType: "json",
						success: function(data){
							ecjia.admin.showmessage(data);
						}
					});
				}
//			}, {ok:'确定', cancel:'取消'});
			}, {ok:admin_lang.ok, cancel:admin_lang.cancel});
		},

		/**
		 * sort 排序方法
		 */
		sort : function(options){
			ecjia.pjax(options.url + "&sort_by=" + options.sort_by + "&sort_order=" + options.sort_order, function(){
				$('[data-sortby="'+options.sort_by+'"]').addClass(options.sortclass);
			});
		},

		/**
		 * clone_obj 克隆添加一个节点的方法
		 */
		clone_obj : function(options) {
//			if(!options.parentobj)return console.log('批量操作缺少参数！');
			if(!options.parentobj)return console.log(admin_lang.batch_error);
			var tmpObj = options.parentobj.clone();
			tmpObj.find('[data-toggle="clone-obj"]')
			.attr('data-toggle','remove-obj').on('click',function(){tmpObj.remove()})
			.find('i').attr('class','fontello-icon-cancel ecjiafc-red');

			(options.before == 'before') ? options.parentobj.before(tmpObj) : options.parentobj.after(tmpObj);

			tmpObj.find('.chzn-container').remove();
			tmpObj.find('select').removeClass('chosen_hide').removeClass('chzn-done').attr({'id' : ''}).chosen();
			//清空默认数据
			options.parentobj.find('input').not(":hidden").val('');
		},

		/*
		 * 通过父级复选框，更改子集状态
		 */
		select_all : function(options){
			var defaults = {
				thisobj	: false,					//url 删除访问的url地址
				children	: false,						//id  删除的数据id
			}
			var options = $.extend({}, defaults, options);

			if(!options.thisobj){
//				console.log('参数错误，无法选择！');
				console.log(admin_lang.parameter_error);
				return false;
			}
			if(!options.children) options.children = 'input[type="checkbox"]';
			options.allobj = $(options.children);

			if(!options.thisobj.prop("checked"))
			{
				options.allobj.prop("checked",false);
			} else
			{
				options.allobj.prop("checked",true);
			}
			if($.uniform.update) $.uniform.update(options.allobj);

		},

		/*
		 * 通过子集复选框，更改父级状态
		 */
		re_select_all : function(){
			$('input[data-toggle="selectall"]').each(function(i){
				var parents = $(this).eq(i).attr('data-toggle') ? $(this).eq(i) : $(this).eq(i).prevObject,
					children = parents.attr('data-children'),
					$children = $(children);
				if(children && $children.length){
					$children.filter(":checked").length == $children.length ?
					parents.prop("checked", true) :
					parents.prop("checked", false);
				}
				$.uniform.update && parents && $.uniform.update(parents);
			});
			//对全选的扩展 TODO:寻找更合理的方法检测
			if($('.checkbox').filter(":checked").length == $('.checkbox').length){
				$('input[name="checkall"]').prop("checked", true);
			}else{
				$('input[name="checkall"]').prop("checked", false);
			}
			$.uniform.update && $.uniform.update($('input[name="checkall"]'));
		},

		removefile : function(options){
			var defaults = {
				url	: false,					//url 删除访问的url地址
				id	: '',						//id  删除的数据id
//				msg	: '您确定要删除此文件吗？',	//msg 删除时的提示信息
				msg	: admin_lang.confirm_delete_file,	//msg 删除时的提示信息
				obj : ''
			}
			var options = $.extend({}, defaults, options);
			if($(options.obj).attr("data-removefile")!="true"){
				$(options.obj).parent().removeClass("fileupload-exists");
				$(options.obj).parent().addClass("fileupload-new");
				$(options.obj).parent().children(".fileupload-preview").children().remove();
				return false;
			}
			if(!options.url){
//				smoke.alert('参数错误，无法删除！');
				smoke.alert(admin_lang.error);
				return false;
			}
			smoke.confirm(options.msg,function(e){
				if (e){
					$.get(options.url, options.id, function(data){
						if(data.state == 'success'){
							$(options.obj).parent().children("div:first-child").find("img").attr("src","");
							$(options.obj).parent().children("div:first-child").find("a").attr("href","");
							$(options.obj).parent().removeClass("fileupload-exists");
							$(options.obj).parent().addClass("fileupload-new");
							$(options.obj).removeAttr("data-removefile");
							ecjia.admin.showmessage(data);
						}
									//ecjia.admin.showmessage(data);
					}, 'json');
				}
//			}, {ok:"确定", cancel:"取消"});
			}, {ok:admin_lang.ok, cancel:admin_lang.cancel});
		},

		//toggleState快速切换状态的方法
		toggleState : function(option){
			$.ajax({
				url: option.url,
				data: {id : option.id , val : option.val},

				type: option.type,
				dataType: "json",
				success: function(data){
					if(data.state == 'error'){
						ecjia.admin.showmessage(data);
					}else{
						data.content ? option.obj.removeClass('fontello-icon-cancel').addClass('fontello-icon-ok') : option.obj.removeClass('fontello-icon-ok').addClass('fontello-icon-cancel');
//						data.pjaxurl ? ecjia.admin.showmessage(data) : ecjia.admin.showmessage('状态修改成功！');
						data.pjaxurl ? ecjia.admin.showmessage(data) : ecjia.admin.showmessage(admin_lang.status_success);
					}
				}
			});
		}
	};

	/**
	 * ajaxremove触发器
	 * data-toggle
	 * data-href
	 * data-id
	 * data-msg
	 * data-removeClass
	 */
	$(document).on('click', '[data-toggle="ajaxremove"]', function(e){
		var $this	= $(this);
		var url		= $this.attr('data-href') || $this.attr('href');
		var id		= $this.attr('data-id');
		var msg		= $this.attr('data-msg');
		var $obj		= $this.attr('data-removeClass') ? $('.' + $this.attr('data-removeClass')) : $this.closest('tr');
		var option	= {url : url, id : id, msg : msg, obj : $obj};

		e.preventDefault();
		ecjia.ui.ajax_remove(option);
	})

	/**
	 * ecjiabatch触发器
	 * data-url 		批量操作访问的url地址
	 * data-msg 		批量操作的提示信息
	 * data-name		批量操作对应php中的name信息
	 * data-idClass 	批量操作的用户id数组
	 * data-noSelectMsg 未选择的时候提示信息
	 */
	$(document).on('click', '[data-toggle="ecjiabatch"]', function(e){
		var $this	= $(this);
		e.preventDefault();

		var $id = $($this.attr('data-idClass')) || $(".checkbox:checked");
		var id = [];
		$id.each(function () {
			id.push($(this).val());
		});
		var name		= $this.attr('data-name') || 'checkboxes';
		var url 		= $this.attr('data-url');
//		var msg 		= $this.attr('data-msg') || '您确定要操作所有选中项吗？';
//		var noSelectMsg = $this.attr('data-noSelectMsg') || '请先选中操作项！';
		var msg 		= $this.attr('data-msg') || admin_lang.confirm;
		var noSelectMsg = $this.attr('data-noSelectMsg') || admin_lang.please_select;
		var option 		= {id : id, url : url, msg : msg, name : name}
		id.length == 0 ? smoke.alert(noSelectMsg) : ecjia.ui.batch(option);
	})

	/**
	 * sortby触发器
	 * data-sorthref 	批量操作访问的url地址（加在父级tr上）
	 * data-sortby 		排序参考字段
	 */
	$(document).on('click', '[data-toggle="sortby"]', function(e) {
		e.preventDefault();
		var $this		= $(this),
		url			= $this.parent('tr').attr('data-sorthref'),
		sort_by		= $this.attr('data-sortby'),
		sort_order	= $this.hasClass('sorting-asc') ? 'desc' : 'asc',
		sortclass	= $this.hasClass('sorting-asc') ? 'sorting-desc' : 'sorting-asc',
		option		= {url : url, sort_by : sort_by, sort_order : sort_order,thisobj : $this, sortclass : sortclass};
//		(!option.url || !option.sort_by || !option.sort_order) && console.log('缺少参数');
		(!option.url || !option.sort_by || !option.sort_order) && console.log(admin_lang.missing_parameters);

		ecjia.ui.sort(option);
	});

	/**
	 * clone-obj触发器
	 * data-parent 		要复制的父级节点
	 */
	$(document).on('click', '[data-toggle="clone-obj"]', function(e){
		e.preventDefault();

		var $this		= $(this),
			$parentobj	= $this.parents($this.attr('data-parent')),
			before		= $this.attr('data-before') || 'after',
			option		= {parentobj : $parentobj, before : before};
			console.log(before);
//		!$parentobj ? console.log('clone-obj方法未设置data-parent参数。') : ecjia.ui.clone_obj(option);
		!$parentobj ? console.log(admin_lang.clone) : ecjia.ui.clone_obj(option);
	})

	/**
	 * remove-obj删除节点obj
	 * data-parent 		要删除的父级节点
	 */
	$(document).on('click', '[data-toggle="remove-obj"]', function(e){
		e.preventDefault();

		var $this		= $(this),
			$parentobj	= $this.parents($this.attr('data-parent'));
		$parentobj.remove();
	})

	/**
     * toggleState触发器
     * url      当前请求地址
     * id       当前元素的id号
     * val      改变的值
     * type     发送方式
     *
     */
	$(document).on('click', '[data-trigger="toggleState"]', function(e){
		var $this   = $(this);
		var url     = $this.attr('data-url');
		var id      = $this.attr('data-id');
		var val     = $this.hasClass('fontello-icon-cancel') ? 1 : 0;
		var type    = $this.attr('data-type') ? $this.attr('data-type') : "POST";

		var option  = {obj : $this, url : url, id : id, val : val, type : type};
		e.preventDefault();
		ecjia.ui.toggleState(option);
	})

	/**
	 * removefile触发器
	 * data-href
	 * data-msg
	 */
	$(document).on('click', '[data-toggle="removefile"]', function(e){
		var $this	= $(this);
		var url		= $this.attr('data-href') || $this.attr('href');
		var msg		= $this.attr('data-msg');
		var option	= {url : url, msg : msg ,obj : $this};

		e.preventDefault();
		ecjia.ui.removefile(option);
	});

	/**
	 * checkall触发器
	 * data-toggle
	 * data-children
	 */
	$(document).on('change', 'input[type="checkbox"]', function(){
		var $this		= $(this);
		if ($this.attr('data-toggle') == 'selectall') {
			var children	= $this.attr('data-children');
			var option	= {thisobj : $this, children : children};
			ecjia.ui.select_all(option);
		}
		ecjia.ui.re_select_all();
	});
	$(ecjia.ui.init).on('pjax.end', '.main_content', ecjia.ui.init);
})(ecjia, jQuery);
