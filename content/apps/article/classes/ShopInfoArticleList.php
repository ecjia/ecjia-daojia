<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/13
 * Time: 16:48
 */

namespace Ecjia\App\Article;

use Ecjia\App\Article\Enums\ArticleTypeEnum;
use RC_Uri;

class ShopInfoArticleList extends BaseArticleList
{

    public function __construct()
    {
        $this->type = ArticleTypeEnum::TYPE_SHOP_INFO;

        parent::__construct($this->type);
    }

    public function getArticleLists()
    {

        $collect = $this->article_model->where('cat_id', 0)
            ->where('article_type', $this->type)
            ->select('article_id', 'title')
            ->orderby('article_id', 'asc')
            ->get();

        $data = $collect->map(function($item) {
            $item = $item->toArray();
            $item['link'] = $this->transformHelpLink($item['article_id']);

            return $item;
        })->toArray();

        return $data;
    }


    public function outputHtml(\Closure $callback = null)
    {
        $lists = $this->getArticleLists();

        if (is_null($callback)) {
            $callback = [$this, 'formatHtmlOutput'];
        }

        $html = '';
        $count = count($lists);
        foreach ($lists as $key => $item) {
            $html .= $callback($item, $key, $count);
        }

        return $html;
    }

    /**
     * @param $item
     * @param $key
     * @param $count
     * @return string
     */
    public function formatHtmlOutput($item, $key, $count)
    {
        $html = '<a class="nopjax" target="_blank" href="' .$item['link']. '">' .$item['title']. '</a>' . PHP_EOL;

        return $html;
    }

    protected function transformHelpLink($id)
    {
        $url = RC_Uri::url('article/info/init', ['aid' => $id]);

        $url = str_replace(RC_Uri::site_url(), '', $url);

        return RC_Uri::home_url() . '/sites/help' . $url;
    }

}