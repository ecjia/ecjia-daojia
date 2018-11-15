<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/7
 * Time: 5:57 PM
 */

/**
 * 获取分类广告位的广告列表
 *
 * @author royalwang
 */
class adsense_category_adsense_api extends Component_Event_Api
{

    /**
     *
     * @param int $city 当前城市ID
     * @param string $client  客户端代号
     * @param string $cat_id  分类ID
     *
     * @return array
     */
    public function call(&$options) {

        $city = array_get($options, 'city', 0);
        $client = array_get($options, 'client', Ecjia\App\Adsense\Client::H5);
        $cat_id = array_get($options, 'cat_id');

        if (empty($cat_id)) {
            return [];
        }

        $code = $this->get_category_ad($cat_id);
        if (empty($code)) {
            return [];
        }

        return RC_Api::api('adsense', 'adsense', [
            'city' => $city,
            'code' => $code,
            'client' => $client,
        ]);
    }


    private function get_category_ad($category_id)
    {
        $ad_position_id = RC_DB::table('term_meta')->where('object_type', 'ecjia.goods')->where('object_group', 'category')->where('object_id', $category_id)->where('meta_key', 'category_ad')->pluck('meta_value');
        if ($ad_position_id) {
            $ad_info = RC_DB::table('ad_position')->where('position_id', $ad_position_id)->first();
            if ($ad_info) {
                return $ad_info['position_code'];
            }
        }

        return null;
    }

}