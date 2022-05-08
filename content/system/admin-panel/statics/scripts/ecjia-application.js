;(function(admin, $) {
	admin.application = {
		/* list页面调用的js实例 */
		list : function(){
			$('#plugin-table1, #plugin-table2').dataTable({
				sDom: "<'row page'<'span6'<'dt_actions'>l><'span6'f>r>t<'row page pagination'<'span6'i><'span6'p>>",
				aaSorting: [[ 1, "asc" ]],

				bPaginate : true,
				sPaginationType: "bootstrap",
				oLanguage : {
					oPaginate: {
						sFirst    : admin_application.home,
						sLast     : admin_application.last_page,
						sPrevious : admin_application.previous,
						sNext     : admin_application.next_page,
					},
					sInfo        : admin_application.count_num,
					sZeroRecords : admin_application.no_record,
					sEmptyTable  : admin_application.no_record,
					sInfoEmpty	 : admin_application.total,
					sInfoFiltered: admin_application.retrieval,
				},
				aoColumns : [
				{ sType : "string" },
				{ bSortable : false }
				]
			});

			$("select").not(".noselect").chosen({
				add_class: "down-menu-language",
				no_results_text: admin_application.no_message,
				allow_single_deselect: true,
				disable_search_threshold: 8
			});
		},
		/* install页面调用的js实例 */
		install : function(){
			$('input[name="v_requirestate"]').val('');
			$('#validate_wizard').stepy({
				nextLabel:      admin_application.start_installation,
				backLabel:      '<i class="icon-chevron-left"></i>'+admin_application.retreat,
				block		: true,
				errorImage	: true,
				titleClick	: false,
				finishButton: false,

				validate	: true,
				select: function(index) {
					var page = 1;
					/* 第三个页面的时候处理的js */
					if(index == page+1){
						$('#validate_wizard-back-' + page).remove();
						$.post('', '', function(data){
							$('.successfully-installed .media').css('opacity',1);
						})
					}
				}
			});
			$('#validate_wizard').validate({
				rules: {
					'v_requirestate': 'required'
				},
				messages: {
					'v_requirestate': { required: '' }
				}
			});

			/* 给导航增加图标 */
			$('.stepy-titles').each(function(){
				$(this).children('li').each(function(index){
					var myIndex = index + 1
					$(this).append('<span class="stepNb">'+myIndex+'</span>');
				})
			})

			/* 给安装换图标 */
			$("#validate_wizard-next-0").attr('class','btn btn-primary button-next');

			/* 绑定安装的下一步按钮事件 */
			admin.application.nextButton();
		},

		/* 安装导航的下一步按钮方法 */
		nextButton : function(){
			$('#validate_wizard-next-0').on('click', function(){
				$('.successfully-installed').removeClass("error f_error");
				$('#validate_wizard-title-0').removeClass('error-image');
				var $this = $(this);
				if(!$this.hasClass('disabled')){
					$this.addClass('disabled').text(admin_application.installing);
					/* 这里是url */
					var url = $('#validate_wizard').attr('action');
					/* 这里是参数 */
					var option = {};
					url && $.get(url, option, function(data){
						$this.removeClass('disabled').text(admin_application.start_install);
						if(data.state == 'success'){
							$('input[name="v_requirestate"]').val('1');
							$("#validate_wizard-next-0").trigger("click.next");
						}else{
							ecjia.admin.showmessage(data);
						}
						/* 这里是回调。 */
					}, 'json');
				}
			});
		}
	}

})(ecjia.admin, $);
