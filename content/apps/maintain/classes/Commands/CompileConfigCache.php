<?php


namespace Ecjia\App\Maintain\Commands;


use Ecjia\App\Maintain\AbstractCommand;

class CompileConfigCache extends AbstractCommand
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'compile_config_cache';

    /**
     * 图标
     * @var string
     */
    protected $icon = '/statics/images/setting_shop.png';

    public function __construct()
    {
        $this->name = __('更新框架配置缓存', 'maintain');
        $this->description = __('执行用于更新框架配置缓存，加速网站访问速度', 'maintain');
    }


    public function run()
    {
        \Artisan::call('config:clear');

        \Artisan::call('config:cache', ['-e' => true]);

        return true;
    }

}