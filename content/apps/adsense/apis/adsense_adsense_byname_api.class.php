<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/22
 * Time: 10:33
 */

/**
 * 获取分类广告位的广告列表，通过名字查找广告
 *
 * @author royalwang
 */
class adsense_adsense_byname_api extends Component_Event_Api
{

    /**
     *
     * @param int $city 当前城市ID
     * @param string $client  客户端代号
     * @param string $name  广告名称
     *
     * @return array
     */
    public function call(&$options) {

        $city = array_get($options, 'city', 0);
        $name = array_get($options, 'name');
        $client = array_get($options, 'client');

        if (!$client) {
            return array();
        }

        $repository = new \Ecjia\App\Adsense\Repositories\AdPositionRepository();
        $where = [
            'position_name' => $name,
            'city_id'   => $city,
            'type'  => 'adsense',
        ];

        $model = $repository->findWhereByFirst($where, ['position_id', 'position_name', 'position_code', 'position_desc']);

        if (! empty($model)) {
            $code = $model->position_code;

            $adsense = RC_Api::api('adsense', 'adsense', [
                'city' => $city,
                'code' => $code,
                'client' => $client,
            ]);

            $data = [
                'position_code' => $model->position_code,
                'position_name' => $model->position_name,
                'position_desc' => $model->position_desc,
                'adsenses' => $adsense
            ];

            return $data;
        }

        return [];
    }

}