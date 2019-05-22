<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-01
 * Time: 18:20
 */

namespace Ecjia\App\Goodslib\GoodsSearch;

use Ecjia\App\User\Models\UserModel;
use Ecjia\System\Frameworks\SuperSearch\SuperSearch;

class UserSearch extends SuperSearch
{

    public function __construct()
    {
        $this->model = new UserModel();
    }

    protected static function filterNamespace()
    {
        return __NAMESPACE__;
    }

}