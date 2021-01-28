<?php


namespace Ecjia\System\Business\Goods;


use ecjia;
use Ecjia\System\Frameworks\Contracts\GoodsSnGenerationInterface;

class GoodsSnGeneration
{

    /**
     * @var GoodsSnGenerationInterface
     */
    protected $model;

    /**
     * @var string
     */
    protected $sn_prefix;

    /**
     * @var int
     */
    protected $sn_length = 6;

    /**
     * GoodsSnGeneration constructor.
     * @param GoodsSnGenerationInterface $model
     * @param string|null $sn_prefix
     */
    public function __construct(GoodsSnGenerationInterface $model, $sn_prefix = null)
    {
        if (is_null($sn_prefix)) {
            $this->sn_prefix = ecjia::config('sn_prefix');
        } else {
            $this->sn_prefix = $sn_prefix;
        }

        $this->model = $model;
    }

    /**
     * 生成商品缩略号
     * @param int $goods_id
     * @return string
     */
    public function generation($goods_id = null)
    {
        if (is_null($goods_id)) {
            $goods_id = $this->model->getMaxId();
        }

        $goods_sn = str_repeat('0', $this->sn_length - strlen($goods_id)) . $goods_id;

        $goods_sn = $this->addSnPrefix($goods_sn);

        $same_sn_list = $this->model->getSameGoodsSN($goods_sn, $goods_id);

        if (in_array($goods_sn, $same_sn_list)) {
            $first_sn = $same_sn_list[0];
            $exp = strlen($first_sn) - strlen($goods_sn) + 1;

            $max = pow(10, $exp) - 1;

            $new_goods_sn = $goods_sn . mt_rand(0, $max);

            while (in_array($new_goods_sn, $same_sn_list)) {
                $new_goods_sn = $goods_sn . mt_rand(0, $max);
            }

            $goods_sn = $new_goods_sn;
        }

        return $goods_sn;
    }

    /**
     * 添加商品编号前缀
     * @param $goods_sn
     * @return string
     */
    protected function addSnPrefix($goods_sn)
    {
        $sn_prefix = $this->sn_prefix . $this->model->getSnPrefix();
        return $sn_prefix . $goods_sn;
    }

}