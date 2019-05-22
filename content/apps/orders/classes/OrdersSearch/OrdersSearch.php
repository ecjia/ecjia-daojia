<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-01
 * Time: 18:20
 */

namespace Ecjia\App\Orders\OrdersSearch;

use Ecjia\App\Orders\Models\OrdersModel;
use Ecjia\System\Frameworks\SuperSearch\SuperSearch;

class OrdersSearch extends SuperSearch
{

    public function __construct()
    {
        $this->model = new OrdersModel();
    }

    protected static function filterNamespace()
    {
        return __NAMESPACE__;
    }

}