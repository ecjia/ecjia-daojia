//页面载入方法和pjax刷新执行方法
$(function(){
	$("select").not(".noselect").chosen({
		add_class: "down-menu-language",
		no_results_text: "未找到搜索内容!",
		allow_single_deselect: true,
		disable_search_threshold: 8
	});
}).on('pjax:end', function(){
	$("select").not(".noselect").chosen({
		add_class: "down-menu-language",
		no_results_text: "未找到搜索内容!",
		allow_single_deselect: true,
		disable_search_threshold: 8
	});
});