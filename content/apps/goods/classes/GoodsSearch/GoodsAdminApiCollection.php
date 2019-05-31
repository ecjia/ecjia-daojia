<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-03
 * Time: 19:52
 */

namespace Ecjia\App\Goods\GoodsSearch;


use Ecjia\App\Goods\GoodsSearch\Formats\GoodsAdminApiFormatted;
use Royalcms\Component\Http\Request;

class GoodsAdminApiCollection
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
            $count = GoodsSearch::singleton()->applyCount($this->request);
       
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

        $collection = GoodsSearch::singleton()->apply($this->request, function($query){
            /**
             * @var \Royalcms\Component\Database\Eloquent\Builder $query
             */
            $query->with([
//                             'store_franchisee_model',
//                             'member_price_collection',
//                             'store_franchisee_model.merchants_config_collection',
//                             'goods_type_model',
//                             'goods_attr_collection',
//                             'goods_attr_collection.attribute_model'
                        ]);
        });
        
        $collection = $collection->map(function($item) {
            return (new GoodsAdminApiFormatted($item))->toArray();
        });
        
        $data = $collection->toArray();

        return ['goods_list' => $data, 'pager' => $pager];
    }


    public static function test()
    {

     	$aa = MerchantGoodsCategory::getChildrenCategoryId('16', '63');

         $input = [
             'store_id'             => 63,
             'product'              => true,
             'keywords'             => '西马渔场东星斑',
         	 'store_unclosed'       => 0,
         	 'is_delete'		    => 0,
         	 'is_on_sale'	        => 1,
         	 'is_alone_sale'	    => 1,
         	 'review_status'        => 2,
         	 'merchant_cat_id_and_store_id' => [$aa, '63'],  //PC未定义分类$aa传0
 			 'store_best'           => 1,
         	 'store_hot'            => 1,
         	 'store_new'            => 1,
         	 'promotion'            => 0,
         	 'is_best'		        => 1,
         	 'is_hot'		        => 1,
         	 'is_new'		        => 1,
             'cat_id'               => 1032,
             'shop_price_less_than' => 10,
             'shop_price_more_than' => 5,
 			 'no_need_cashier_goods' => true,
         	 'page'                 => 1,

         ];

         $collection = (new GoodsAdminApiCollection($input))->getData();

         return $collection;
    }

}