;(function(admin, $) {
	admin.upgrade = {
		init : function(){
			admin.upgrade.check_upload();
		},
		check_upload : function(){
			$('.checkUpdate').on('click', function(e){
				e.preventDefault();
				var $this = $(this);
				if($this.find('i').length >0){
					smoke.alert(admin_upgrade_lang.checking);
				}else{
					$this.prepend('<i class="animate-spin fontello-icon-spin3"></i>');
					var url = $('form[name="checkUpdate"]').attr('action');
					$.post(url, '', function(data){
						/* 时间 */
						// var d = new Date(),str = '';
						// str += d.getFullYear()+'年';
						// str += d.getMonth() + 1+'月';
						// str += d.getDate()+'日  ';
						// str += d.getHours()+':';
						// var minutes = d.getMinutes()
						// str += minutes > 9 ? minutes +'' : '0' + minutes +'';
						
						// $this.find('i').remove();
						// $('form[name="checkUpdate"] .oldTime').html('最后检查于: ' + str + '&nbsp;');
						
						// /* 有更新 */
						// if(data.state){
						// 	// $('.newVer , .upgrade_go , .alert').removeClass('hide');
						// 	$('.alert').removeClass('hide');
						// /* 无更新 */
						// }else{
						// 	/* 方法体 */
						// }
						ecjia.admin.showmessage(data);
					});
				}
			});
		}
	}

})(ecjia.admin, $);
