<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-05-17
 * Time: 09:29
 */

namespace Ecjia\App\Store\Repositories;

use Royalcms\Component\Database\Eloquent\Collection;
use Royalcms\Component\Repository\Repositories\AbstractRepository;

class MerchantConfigRepository extends AbstractRepository
{

    protected $model = 'Ecjia\App\Store\Models\MerchantConfigModel';


    protected $store_id;

    /**
     * Create a new Repository instance
     * @throws \Royalcms\Component\Repository\Exceptions\RepositoryException
     */
    public function __construct($store_id)
    {
        parent::__construct();

        $this->store_id = $store_id;
    }

    /**
     * 添加选项值
     * @param $name
     * @param $value
     */
    public function addOption($code, $value, $option = [])
    {
        $insert_data = [
            'store_id'    => $this->store_id,
            'code'        => $code,
            'value'       => $value,
            'group'       => array_get($option, 'group', 0),
            'type'        => array_get($option, 'type', ''),
            'store_range' => array_get($option, 'store_range', ''),
            'store_dir'   => array_get($option, 'store_dir', ''),
            'sort_order'  => array_get($option, 'sort_order', '1'),
        ];

        $update_data = [
            'group'       => 0,
            'value'       => $value,
            'type'        => array_get($option, 'type', ''),
            'store_range' => array_get($option, 'store_range', ''),
            'store_dir'   => array_get($option, 'store_dir', ''),
            'sort_order'  => array_get($option, 'sort_order', ''),
        ];

        $result = $this->getModel()->insertOnDuplicateKey($insert_data, $update_data);

        return $result;
    }

    /**
     * @return \Royalcms\Component\Database\Eloquent\Collection
     */
    public function getAllOptions()
    {
        $options = $this->getModel()->where('store_id', $this->store_id)
            ->orderBy('sort_order', 'asc')->get();

        return $options;
    }

    public function getCount()
    {
        $count = $this->getModel()->where('store_id', $this->store_id)
            ->count();

        return $count;
    }

}