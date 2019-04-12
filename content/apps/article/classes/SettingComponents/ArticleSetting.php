<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-28
 * Time: 10:04
 */

namespace Ecjia\App\Article\SettingComponents;


use Ecjia\App\Setting\ComponentAbstract;

class ArticleSetting extends ComponentAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'article';

    public function __construct()
    {
        $this->name = __('文章设置', 'article');
    }


    public function handle()
    {

        $data = [
            ['code' => 'article_title_length', 'value' => '20', 'options' => ['type' => 'text']],
            ['code' => 'article_page_size', 'value' => '20', 'options' => ['type' => 'text']],
            ['code' => 'help_open', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '0,1']],
            ['code' => 'article_number', 'value' => '8', 'options' => ['type' => 'text']],

        ];

        return $data;
    }

    public function getConfigs()
    {
        $config = [
            [
                'cfg_code' => 'article_title_length',
                'cfg_name' => __('文章标题的长度', 'article'),
                'cfg_desc' => __('与商品名称长度一样的原理，例如:设置“16”，当文章列表文字的字符数超过16，则用“...”代替', 'article'),
                'cfg_range' => '',
            ],

            [
                'cfg_code' => 'article_page_size',
                'cfg_name' => __('文章分类页列表的数量', 'article'),
                'cfg_desc' => __('限制文章分类页文章显示数量，不填写，则代表没有限制', 'article'),
                'cfg_range' => '',
            ],

            [
                'cfg_code' => 'help_open',
                'cfg_name' => __('用户帮助是否打开', 'article'),
                'cfg_desc' => __('设置“打开”后，此帮助会在后台顶部出现帮助信息', 'article'),
                'cfg_range' => array(
                    '0' => __('关闭', 'article'),
                    '1' => __('打开', 'article'),
                ),
            ],

            [
                'cfg_code' => 'article_number',
                'cfg_name' => __('最新文章显示数量', 'article'),
                'cfg_desc' => '',
                'cfg_range' => '',
            ],

        ];

        return $config;

    }
}