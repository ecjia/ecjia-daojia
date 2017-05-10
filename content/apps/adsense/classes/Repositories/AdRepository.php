<?php

namespace Ecjia\App\Adsense\Repositories;

use Royalcms\Component\Repository\Repositories\AbstractRepository;
use Ecjia\App\Adsense\Client;

class AdRepository extends AbstractRepository
{
    protected $model = 'Ecjia\App\Adsense\Models\AdModel';
    
    protected $orderBy = ['sort_order' => 'asc'];
    
    protected $type;
    
    public function __construct($type)
    {
        parent::__construct();
        
        $this->type = $type;
    }
    
    /**
     * 获取所有的客户端列表
     * 
     * @return array
     */
    public function getAllClients() {
        $clients = array(
            'iPhone' => Client::IPHONE,
            'Android'=> Client::ANDROID,
            'H5' 	 => Client::H5,
            'PC'     => Client::PC
        );
        return $clients;
    }
    
    
    public function getAvailableClients($position) {
        if (empty($position)) {
            return [];
        }
        
        $clients = $this->getAllClients();
        
        $available = collect($clients)->mapWithKeys(function ($item, $key) use ($position) {
            $where = [
                'position_id' => $position,
                'show_client' => ['show_client', '&', $item],
                ];
        	$count = $this->findWhere($where, ['ad_id'])->count();
        	if ($count > 0)
        	   return [$key => $count];
        	return [];
        });

        return $available->toArray();
    }
    
    public function getAdClients($position, $filter = []) {
    	if (empty($position)) {
    		return [];
    	}
    
    	$clients = $this->getAllClients();
    
    	$available = collect($clients)->mapWithKeys(function ($item, $key) use ($position, $filter) {
    		$where = [
	    		'position_id' => $position,
	    		'show_client' => ['show_client', '&', $item],
    		];
    		
    		if ( ! empty($filter)) {
    			$where = array_merge($where, $filter);
    		}
    		
    		$count = $this->findWhere($where, ['ad_id'])->count();
    		if ($count > 0)
    			return [$key => $count];
    		
    		return [];
    	});
    
    		return $available->toArray();
    }
    
    /**
     * 获取特殊广告列表
     * @param string $position
     * @param integer $client
     * @param integer $maxNum
     * @return array
     */
    public function getSpecialAds($position, $client, $maxNum = null) {
        if (empty($client))
        {
            return [];
        }
    
        $where = [
            'position_id' => $position,
            'show_client' => ['show_client', '&', $client],
            ];
        $result = $this->findWhereLimit($where, ['ad_id', 'ad_name', 'ad_code', 'ad_link', 'enabled', 'sort_order'], $maxNum);
    
        return $result->toArray();
    }
    
    /**
     * 获取广告列表
     * @param string $position
     * @param integer $client
     * @param integer $maxNum
     * @return array
     */
    public function getAds($position, $client, $maxNum = null) {
        if (empty($client))
        {
            return [];
        }
        
        $where = [
        	'position_id' => $position,
            'show_client' => ['show_client', '&', $client],
        ];
        $result = $this->findWhereLimit($where, ['ad_id', 'ad_name', 'ad_code', 'ad_link', 'media_type', 'start_time', 'end_time', 'enabled', 'sort_order', 'click_count'], $maxNum);

        return $result->toArray();
    }
    
    
    /**
     * 获取广告列表
     * @param string $position
     * @param integer $client
     * @param integer $maxNum
     * @param integer $filter
     * @return integer 
     */
    public function getAdsFilter($position, $client, $maxNum = null, $filter = []) {
    	if (empty($client))
    	{
    		return [];
    	}
    	$where = [
	    	'position_id' => $position,
	    	'show_client' => ['show_client', '&', $client],
    	];
    	
    	if ( ! empty($filter)) {
    		$where = array_merge($where, $filter);
    	}
    	
    	$result = $this->findWhereLimit($where, ['ad_id', 'ad_name', 'ad_code', 'ad_link', 'media_type', 'start_time', 'end_time', 'enabled', 'sort_order', 'click_count'], $maxNum);
    
    	return $result->toArray();
    }
   
    public function findWhereLimit(array $where, $columns = ['*'], $limit = null)
    {
        $this->newQuery();
    
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->query->where($field, $condition, $val);
            }
            else {
                $this->query->where($field, '=', $value);
            }
        }
        
        if ($limit) {
            $this->query->take($limit);
        }
        
        return $this->query->get($columns);
    }
    
}