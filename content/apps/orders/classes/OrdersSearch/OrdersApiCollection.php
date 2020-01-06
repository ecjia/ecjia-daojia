<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-03
 * Time: 19:52
 */

namespace Ecjia\App\Orders\OrdersSearch;


use Ecjia\App\Orders\OrdersSearch\Formats\OrdersApiFormatted;
use Ecjia\App\Orders\OrdersSearch\Formats\OrdersAdminFormatted;
use Royalcms\Component\Http\Request;

class OrdersApiCollection
{
    protected $input = [];

    protected $request;

    public function __construct(array $input)
    {
        $this->input = $input;

        $this->request = Request::create('', 'GET', $input);
    }

    public function getData()
    {
    	$page = $this->request->input('page', 1);
    	$size = $this->request->input('size', 15);
    	
        if ($page) {
            $input = $this->request->input();
            if (array_key_exists('size', $input)) {
            	unset($input['size']);
            }
            if (array_key_exists('page', $input)) {
            	unset($input['page']);
            }
            $count = OrdersSearch::singleton()->applyCount($this->request);
       
            $ecjia_page = new \ecjia_page($count, $size, 6, '', $page);
            
            $start = $ecjia_page->start_id - 1;
			
            $input['current_page'] = [$start, $size];

            $this->request->replace($input);
            
            $pager = array(
                'total' => $ecjia_page->total_records,
                'count' => $ecjia_page->total_records,
                'more'  => $ecjia_page->total_pages <= $page ? 0 : 1,
            );
        }

        $collection = OrdersSearch::singleton()->apply($this->request, function($query) {
            /**
             * @var \Royalcms\Component\Database\Eloquent\Builder $query
             */
            $query->with([
                            'order_goods_collection',
                            'order_goods_collection.goods_model',
                            'store_franchisee_model',
                            'payment_model',
                            'order_goods_collection.products_model',
                            'order_goods_collection.comment_model'
                        ]);
        });
        
        $collection = $collection->map(function($item){
            return (new OrdersApiFormatted($item))->toArray();
        });
        
        $data = $collection->toArray();

        return ['order_list' => $data, 'pager' => $pager];
    }

    public function getAdminApiData()
    {
    	$page = $this->request->input('page', 1);
    	$size = $this->request->input('size', 15);
    	 
    	if ($page) {
    		$input = $this->request->input();
    		if (array_key_exists('size', $input)) {
    			unset($input['size']);
    		}
    		if (array_key_exists('page', $input)) {
    			unset($input['page']);
    		}
    		$count = OrdersSearch::singleton()->applyCount($this->request);
    		 
    		$ecjia_page = new \ecjia_page($count, $size, 6, '', $page);
    
    		$start = $ecjia_page->start_id - 1;
    			
    		$input['current_page'] = [$start, $size];
    
    		$this->request->replace($input);
    
    		$pager = array(
    				'total' => $ecjia_page->total_records,
    				'count' => $ecjia_page->total_records,
    				'more'  => $ecjia_page->total_pages <= $page ? 0 : 1,
    		);
    	}
    
    	$collection = OrdersSearch::singleton()->apply($this->request, function($query) {
    		/**
    		 * @var \Royalcms\Component\Database\Eloquent\Builder $query
    		 */
    		$query->with([
    				'order_goods_collection',
    				'order_goods_collection.goods_model',
    				'store_franchisee_model',
    				'payment_model',
    				'order_goods_collection.products_model',
    				'order_goods_collection.comment_model'
    				]);
    	});
    
    		$collection = $collection->map(function($item){
    			return (new OrdersAdminFormatted($item))->toArray();
    		});
    
    			$data = $collection->toArray();
    
    			return ['order_list' => $data, 'pager' => $pager];
    }
    
    public static function test()
    {
         $input = [
         	 'is_delete'			=> 0,
             'store_id'             => 63,
             'user_id'              => 1024,
             'extension_code'		=> 'group_buy',
         	 'page'                 => 1,
         ];

         $collection = (new OrdersApiCollection($input))->getData();

         return $collection;
    }

}