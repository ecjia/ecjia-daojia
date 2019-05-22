<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-01
 * Time: 18:20
 */

namespace Ecjia\App\Goodslib\GoodsSearch;

use Ecjia\App\Store\Models\StoreFranchiseeModel;
use Ecjia\System\Frameworks\SuperSearch\SuperSearch;

class StoreSearch extends SuperSearch
{

    public function __construct()
    {
        $this->model = new StoreFranchiseeModel();
    }

    protected static function filterNamespace()
    {
        return __NAMESPACE__;
    }

}