<?php
/**
 * User: royalwang
 * Date: 2019/1/15
 * Time: 10:41
 */

namespace Ecjia\Component\Gettext\Console;

use Ecjia\Component\Framework\Ecjia;
use Ecjia\Component\Gettext\Smarty\SmartyGettextCompiler;
use Ecjia\Component\Gettext\Smarty\CompileDirectory;

class MakeEcjiaFrameworkPOT extends MakeEcjiaGenericPOT
{

    protected $meta = array(
        'description'      => 'Translation of frontend strings in Ecjia Framework {version}',
        'copyright-holder' => 'Ecjia',
        'package-name'     => 'Ecjia Framework',
        'package-version'  => '{version}',
    );

    protected function getVersion()
    {
        return Ecjia::VERSION;
    }

    public function make($dir, $output)
    {
        $dir = rtrim($dir, '/\\');

        $excludes = array(
        );

        $includes = array();

        $result = $this->generic($dir, array(
            'project'        => 'ecjia-framework',
            'output'         => $output,
            'includes'       => $includes,
            'excludes'       => $excludes,
            'default_output' => $dir . '/resources/languages/zh_CN/ecjia.pot',
        ));

        $this->console->info(sprintf(__("提取%sPHP中语言包成功", 'ecjia'), 'ecjia框架'));

        return $result;
    }


}