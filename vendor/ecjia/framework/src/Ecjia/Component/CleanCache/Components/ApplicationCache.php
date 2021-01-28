<?php


namespace Ecjia\Component\CleanCache\Components;


use Ecjia\Component\CleanCache\CacheComponentAbstract;

class ApplicationCache extends CacheComponentAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'application_cache';

    protected $app = 'system';

    /**
     * 排序
     * @var int
     */
    protected $sort = 1;

    public function __construct()
    {
        $this->name = __('应用加载缓存', 'ecjia');
        $this->description = __('应用加载缓存是查找应用目录缓存后分析出来的结果，若要在新应用增加或变化后立即看到变化，则需要更新应用加载缓存后才可以查看最新效果。', 'ecjia');
    }

    public function handle()
    {
        $app = royalcms('app');

        $app->getApplicationLoader()->clearCompiled();

        return true;
    }

}