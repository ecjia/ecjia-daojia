<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-01
 * Time: 18:20
 */

namespace Ecjia\App\Goods\GoodsSearch;

use Ecjia\App\Goods\Models\GoodsModel;
use Ecjia\System\Frameworks\SuperSearch\SuperSearch;

class GoodsSearch extends SuperSearch
{

    public function __construct()
    {
        $this->model = new GoodsModel();
    }

    protected static function filterNamespace()
    {
        return __NAMESPACE__;
    }

}