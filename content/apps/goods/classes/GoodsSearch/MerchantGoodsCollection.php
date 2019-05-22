<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-25
 * Time: 09:10
 */

namespace Ecjia\App\Goods\GoodsSearch;


use Ecjia\App\Goods\GoodsSearch\Formats\GoodsAdminFormatted;
use Royalcms\Component\Database\Eloquent\Builder;
use Royalcms\Component\Http\Request;
use Closure;

class MerchantGoodsCollection
{

    protected $input = [];

    protected $request;

    /**
     * @var \ecjia_merchant_page
     */
    protected $ecjia_merchant_page;

    public function __construct(array $input)
    {
        $this->input = $input;

        $this->request = Request::create('', 'GET', $input);
    }

    public function getCollection(Closure $callback = null)
    {
        $page = $this->request->input('page', 1);
        $size = $this->request->input('size', 15);

        if ($page) {
            $input = $this->request->input();
            if (array_key_exists('size', $input)) {
                unset($input['size']);
            }
            if (array_key_exists('user_rank_discount', $input)) {
                unset($input['user_rank_discount']);
            }
            if (array_key_exists('user_rank', $input)) {
                unset($input['user_rank']);
            }
            if (array_key_exists('page', $input)) {
                unset($input['page']);
            }
            $count = GoodsSearch::singleton()->applyCount($this->request, $callback);

            $this->ecjia_merchant_page = new \ecjia_merchant_page($count, $size, null, '', $page);

            $start = $this->ecjia_merchant_page->start_id - 1;

            $input['current_page'] = [$start, $size];

            $this->request->replace($input);
        }

        if (is_null($callback)) {
            $callback = function($query) {
                /**
                 * @var Builder $query
                 */
                $query->with('store_franchisee_model');
            };
        }

        $collection = GoodsSearch::singleton()->apply($this->request, $callback);

        return $collection;
    }

    public function getData(Closure $callback = null)
    {

        $collection = $this->getCollection($callback);

        $user_rank_discount = $this->request->input('user_rank_discount', 1);
        $user_rank = $this->request->input('user_rank', 0);

        $collection = $collection->map(function($item) use ($user_rank_discount, $user_rank) {
            return (new GoodsAdminFormatted($item, $user_rank_discount, $user_rank))->toArray();
        });

        $data = $collection->toArray();

        return [
            'goods'     => $data,
            'filter'	=> $this->request->all(),
            'page'		=> $this->ecjia_merchant_page->show(2),
            'desc'		=> $this->ecjia_merchant_page->page_desc()
        ];
    }

    public static function test()
    {

         $input = [
             'store_id'             => 63,
             'product'              => true,
             'keywords'             => '西马渔场东星斑',
             'store_unclosed'       => 0,
         	 'is_delete'		    => 0,
         	 'is_on_sale'	        => 1,
         	 'is_alone_sale'	    => 1,
         	 'review_status'        => 2,
 			 'store_best'           => 1,
         	 'store_hot'            => 1,
         	 'store_new'            => 1,
         	 'promotion'            => 0,
         	 'is_best'		        => 1,
         	 'is_hot'		        => 1,
         	 'is_new'		        => 1,
             'cat_id'               => 1036,
             'shop_price_less_than' => 10,
             'shop_price_more_than' => 5,
 			 'no_need_cashier_goods' => true,
         	 'page'                 => 1,
         ];

         $collection = (new MerchantGoodsCollection($input))->getData();

         return $collection;
    }

}