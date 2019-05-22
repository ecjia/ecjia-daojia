<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-01
 * Time: 18:20
 */

namespace Ecjia\App\Goodslib\GoodsSearch;

use Ecjia\App\Goodslib\Models\GoodslibModel;
use Ecjia\System\Frameworks\SuperSearch\SuperSearch;

class GoodsSearch extends SuperSearch
{

    public function __construct()
    {
        $this->model = new GoodslibModel();
    }

    protected static function filterNamespace()
    {
        return __NAMESPACE__;
    }

}