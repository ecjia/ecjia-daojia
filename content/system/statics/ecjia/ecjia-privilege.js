;(function(admin, $) {
	admin.privilege = {
		init : function() {
			admin.privilege.search_admin();
			admin.privilege.no_edit();
		},
		edit : function() {
			admin.privilege.edit_admin();
			admin.privilege.change_pwd();
		},
		allto : function() {
			admin.privilege.edit_allto();
		},
		modif : function() {
			admin.privilege.addToNav();
			admin.privilege.movemod();
			admin.privilege.removeNav();
			admin.privilege.searchNav();
			admin.privilege.check_pwd();
		},

		/* list JS START */
		search_admin : function() {
			$("form[name='searchForm']").on('submit', function(e) {
				e.preventDefault();
				var $this 		= $(this);
				var key_type 	= $this.find("select[name='key_type']").val();
				var keyword 	= $this.find("input[name='keyword']").val();
				var url 		= $this.attr('action');

				if(keyword == "undefind")keyword='';
				ecjia.pjax(url + "&key_type=" + key_type + "&keyword=" + keyword);
			});
		},
		no_edit : function(){
			$('.nodel').on('click', function(e) {
				e.preventDefault();
				ecjia.admin.showmessage({message : admin_privilege.no_edit, state : 'error'});
			});
		},
		/* list JS END */

		/* edit JS START */
		edit_admin : function() {
			var $this = $('form[name="theForm"]');
			var is_add = $this.hasClass('add');
			var option = {
				rules:{
					user_name 		: {required : true, minlength : 2},
					email 			: {required : true, email : true},
					password 		: is_add ? {required : true, minlength : 6} : {minlength : 0},
//					old_password 	: is_add ? {minlength : 0} : {minlength : 6},
					new_password 	: is_add ? {minlength : 0} : {minlength : 6},
					pwd_confirm 	: is_add ? {minlength : 6, equalTo : '#password'} : {minlength : 6, equalTo : '#new_password'}
				},
				messages:{
					user_name 		: {required : admin_privilege.pls_name, minlength : admin_privilege.name_length_check},
					email 			: {required : admin_privilege.pls_email, email : admin_privilege.email_check},
					password 		: is_add ? {required : admin_privilege.pls_password, minlength : admin_privilege.password_length_check} : '',
//					old_password 	: is_add ? '' : '密码长度不能小于6',
					new_password 	: is_add ? admin_privilege.password_length_check : '',
					pwd_confirm 	: {minlength : admin_privilege.password_length_check, equalTo : admin_privilege.check_password}
				},
				submitHandler:function(){
					$this.ajaxSubmit({
						type:"post",
						dataType:"json",
						success:function(data){
							ecjia.admin.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$this.validate(options);
		},
		change_pwd : function(){
			$('#old_password').on('change', function(){
				var change_area = $('#change-password');
				if($(this).val()){
					change_area.removeClass('hide');
				}else{
					!change_area.hasClass('hide') && change_area.addClass('hide');
				}
			})
		},
		/* edit JS END */

		/* allto JS START */
		edit_allto : function() {
			$("form[name='theForm']").submit(function(e) {
				$("form[name='theForm']").ajaxSubmit({
					type:"post",
					dataType:"json",
					success:function(data){
						ecjia.admin.showmessage(data);
					}
				});
				e.preventDefault();
			});
		},
		/* allto JS END */

		/* modif JS START */


		movemod : function() {
			$( ".nav-list-content" )
			.sortable({
				placeholder: 'ui-sortable-placeholder',
				items: "li:not(.ms-elem-selection1)",
				sort: function() {
					$( this ).removeClass( "ui-state-default" );
				}
			});
			$( ".nav-list-ready ,.ms-selection .nav-list-content" ).disableSelection();
		},

		addToNav : function() {
			$( ".nav-list-ready li" ).not('.ms-optgroup-label')
			.on('click', function() {
				var $this = $(this),
					tmpobj = $( '<li class="ms-elem-selection"><input type="hidden" name="nav_list[]" value="' + $this.text() + '|' + $this.attr('data-val') + '" />' + $this.text() + '<span class="edit-list"><i class="fontello-icon-minus-circled ecjiafc-red"></i></span></li>' );

				if (!$this.hasClass('disabled')) {
					tmpobj.appendTo( $( ".ms-selection .nav-list-content" ) );
					$this.addClass('disabled');
				}
				/* 给新元素添加点击事件 */
				tmpobj.on('dblclick', function() {
					$this.removeClass('disabled');
					tmpobj.remove();
				})
				.find('i').on('click', function() {
					tmpobj.trigger('dblclick');
				});
			});
		},

		removeNav : function() {
			/* 给右侧元素添加点击事件 */
			$('.nav-list-content .ms-elem-selection').on('dblclick', function() {
				var $this = $(this);
				$( ".nav-list-ready li" ).each(function(index) {
					if ($( ".nav-list-ready li" ).eq(index).text() + '|' + $( ".nav-list-ready li" ).eq(index).attr('data-val') == $this.find('input').val()) {
						$( ".nav-list-ready li" ).eq(index).removeClass('disabled');
					}
				});
				$this.remove();
			})
			.find('i').on('click', function() {
				$(this).parents('li').trigger('dblclick');
			});
		},

		searchNav : function() {
			/* 给右侧元素添加点击事件 */
			if($('#ms-search').length) {
				$('#ms-search').quicksearch(
					$('.ms-elem-selectable', '#ms-custom-navigation' ), 
					{
						onAfter : function(){
							$('.ms-group').each(function(index) {
								$(this).find('.isShow').length ? $(this).css('display','block') : $(this).css('display','none');
							});
							return;
						},
						show: function () {
							this.style.display = "";
							$(this).addClass('isShow');
						},
						hide: function () {
							this.style.display = "none";
							$(this).removeClass('isShow');
						},
					}
				);
			}
		},

	/* password strength checker */
		check_pwd : function() {
			$("#new_password").complexify({
				minimumChars: '5',
				strengthScaleFactor: '0.5'
			}, function (valid, complexity) {
				if (!valid) {
					$('#pass_progress .bar').css({'width':complexity + '%'}).parent().removeClass('progress-success').addClass('progress-danger');
				} else {
					$('#pass_progress .bar').css({'width':complexity + '%'}).parent().removeClass('progress-danger').addClass('progress-success');
				}
			});
		}

	}
})(ecjia.admin, $);
