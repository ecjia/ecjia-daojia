// JavaScript Document
;(function(admin, $) {
	admin.admin_region = {
		init : function() {
			$('[href="#editArea"]').on('click', function() {
				var name	= $(this).attr('data-name'),
						val		= $(this).attr('value');
				$('#editArea .parent_name').text(name);
				$('#editArea input[name="id"]').val(val);
			});

			$('form').on('submit', function(e) {
				e.preventDefault();
				$(this).ajaxSubmit({
					dataType : "json",
					success : function(data) {
						$('#editArea').modal('hide');
						$('#addArea').modal('hide');
						ecjia.admin.showmessage(data);
					}
				});
			});
		}
	}
})(ecjia.admin, $);

//end