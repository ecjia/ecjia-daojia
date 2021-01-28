<?php


namespace Ecjia\System\Hookers;

use ecjia_app;

/**
 * 是否开启开店向导
 * Class DispalyShopGuideAction
 * @package Ecjia\System\Hookers
 */
class DispalyShopGuideAction
{

    public function handle($model)
    {
        //是否开启开店向导
        $result = ecjia_app::validate_application('shopguide');
        if (!is_ecjia_error($result)) {
            if ($model->action_list == 'all' && empty($model->last_login)) {
                $_SESSION['shop_guide'] = true;
            }
        }
    }

}