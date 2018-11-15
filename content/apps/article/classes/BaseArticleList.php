<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/11/13
 * Time: 16:39
 */

namespace Ecjia\App\Article;


abstract class BaseArticleList
{

    protected $article_model;

    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
        $this->article_model = new Models\ArticleModel();
    }


    abstract public function getArticleLists();


}