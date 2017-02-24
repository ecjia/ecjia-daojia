;(function(admin, $) {
	admin.plugin_list = {
		init : function() {
			$('#plugin-table').dataTable({
				sDom: "<'row page'<'span6'<'dt_actions'>l><'span6'f>r>t<'row page pagination'<'span6'i><'span6'p>>",
				sPaginationType: "bootstrap",
				aaSorting: [[ 1, "asc" ]],

				bPaginate : true,
				sPaginationType: "bootstrap",
				oLanguage : {
					oPaginate: {
						sFirst    : admin_plugin_lang.home,
						sLast     : admin_plugin_lang.last_page,
						sPrevious : admin_plugin_lang.previous,
						sNext     : admin_plugin_lang.next_page,
					},
					sInfo        : admin_plugin_lang.count_num,
					sZeroRecords : admin_plugin_lang.no_record,
					sEmptyTable  :admin_plugin_lang.no_record,
					sInfoEmpty	 : admin_plugin_lang.total,
					sInfoFiltered: admin_plugin_lang.retrieval,
				},
				aoColumns: [
				{ sType: "string" },
				{ bSortable: false },
				]
			});
			admin.plugin_list.install();
			admin.plugin_list.uninstall();
			admin.plugin_list.del();
		},
		install : function() {
			/* 插件安装 */
			$(document).off('click.install').on('click.install', '.plugin-install', function(e) {
				e.preventDefault();
				var $this	= $(this);
				var href	= $this.attr('data-href') || $this.attr('href');
				var id		= parseInt($this.attr('data-id')) || parseInt($this.attr('href'));
				if (!href) {
					smoke.alert(admin_plugin_lang.error_intasll);
					return false;
				}
				$.get(href, id, function(data) {
					ecjia.admin.showmessage(data);
				});
			})
		},

		uninstall : function() {
			/* 插件卸载 */
			$(document).off('click.uninstall').on('click.uninstall', '.plugin-uninstall', function(e) {
				e.preventDefault();
				var $this	= $(this);
				var href	= $this.attr('data-href') || $this.attr('href');
				var id		= parseInt($this.attr('data-id')) || parseInt($this.attr('href'));
				if (!href) {
					smoke.alert(admin_plugin_lang.error_unintasll);
					return false;
				}
				smoke.confirm(admin_plugin_lang.confirm_unintall,function(e) {
					if (e) {
						$.get(href, id, function(data) {
							ecjia.admin.showmessage(data);
						});
					}
				}, {ok:admin_plugin_lang.ok, cancel:admin_plugin_lang.cancel});
			})
		},

		del : function() {
			/* 插件删除 */
			$(document).off('click.del').on('click.del', '.plugin-del', function(e) {
				e.preventDefault();
				smoke.confirm(admin_plugin_lang.delete_unintall,function(e) {
					if (e) {
						smoke.alert(admin_plugin_lang.no_delete);
					}
				}, {ok:admin_plugin_lang.ok, cancel:admin_plugin_lang.cancel});
			})
		},
	}

})(ecjia.admin, $);
