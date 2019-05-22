<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-22
 * Time: 13:00
 */

namespace Ecjia\System\Frameworks\CleanCache\Components;

use Ecjia\System\Frameworks\CleanCache\CacheComponentAbstract;

class TemplateCache extends CacheComponentAbstract
{
    /**
     * 代号标识
     * @var string
     */
    protected $code = 'template_cache';

    protected $app = 'system';

    protected $relevance = [
    ];

    /**
     * 排序
     * @var int
     */
    protected $sort = 10;

    public function __construct()
    {
        $this->name = __('模板缓存');
        $this->description = __('模板缓存是模板的数据缓存文件。若模板显示的数据有变动，则需要更新模板缓存后才可以查看最新效果。');
    }

    public function handle()
    {
        $files = royalcms('files');

        try {
            if ($files->isDirectory(SITE_CACHE_PATH . 'template' . DS . 'caches'))
            {
                $files->deleteDirectory(SITE_CACHE_PATH . 'template' . DS . 'caches');
            }

            return true;
        }
        catch (\UnexpectedValueException $e) {
            ecjia_log_notice($e->getMessage());
        }
    }

}