<?php


namespace Ecjia\App\Maintain\Commands;


use Ecjia\App\Maintain\AbstractCommand;

class CompileFrameworkOptimize extends AbstractCommand
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'compile_framework_optimize';

    /**
     * 图标
     * @var string
     */
    protected $icon = '/statics/images/setting_shop.png';

    public function __construct()
    {
        $this->name = __('编译框架代码优化', 'maintain');
        $this->description = __('编译框架代码，加速加载性能', 'maintain');
    }


    public function run()
    {
        \Artisan::call('optimize', ['--force' => true]);

        return true;
    }

}