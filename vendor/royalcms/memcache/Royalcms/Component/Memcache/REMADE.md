## 用法示例 ##
	
	use Royalcms\Component\Memcache\FactoryUtils;
	use Royalcms\Component\Memcache\AnalysisUtils;
	
	$items = FactoryUtils::instance('items_api')->items($server['hostname'], $server['port'], $_GET['slab']);
	
	# Spliting server in hostname:port
	$slabs = FactoryUtils::instance('slabs_api')->slabs($server['hostname'], $server['port']);
	
	$stats = FactoryUtils::instance('stats_api')->stats($server['hostname'], $server['port']);
	$slabs = AnalysisUtils::slabs(FactoryUtils::instance('slabs_api')->slabs($server['hostname'], $server['port']));
	$stats = AnalysisUtils::merge($stats, $data['stats']);
	
	$settings = FactoryUtils::instance('stats_api')->settings($server['hostname'], $server['port']);
	
	# Analysis
	$stats = AnalysisUtils::stats($stats);