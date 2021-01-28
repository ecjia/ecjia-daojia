<?php


namespace Ecjia\Component\CleanCache\Components;


use Ecjia\Component\CleanCache\CacheComponentAbstract;

class ServiceProviderCache extends CacheComponentAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'service_provider_cache';

    protected $app = 'system';

    /**
     * 排序
     * @var int
     */
    protected $sort = 1;

    public function __construct()
    {
        $this->name = __('框架组件缓存', 'ecjia');
        $this->description = __('框架组件加载缓存是查找框架内使用的ServiceProvider缓存后分析出来的结果，若更新了Composer.json，则需要更新框架组件缓存重新加载才可以查看最新效果。', 'ecjia');
    }

    public function handle()
    {
        $servicesPath = royalcms()->getCachedServicesPath();

        if (file_exists($servicesPath)) {
            @unlink($servicesPath);
        }

        return true;
    }

}