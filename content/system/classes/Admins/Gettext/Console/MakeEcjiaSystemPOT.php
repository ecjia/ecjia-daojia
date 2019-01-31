<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/15
 * Time: 10:41
 */

namespace Ecjia\System\Admins\Gettext\Console;

use Ecjia\System\Admins\Gettext\Smarty\SmartyGettextCompiler;
use Ecjia\System\Admins\Gettext\Smarty\CompileDirectory;
use ecjia;

class MakeEcjiaSystemPOT extends MakeEcjiaGenericPOT
{

    protected $meta = array(
        'description'      => 'Translation of frontend strings in Ecjia System {version}',
        'copyright-holder' => 'Ecjia',
        'package-name'     => 'Ecjia System',
        'package-version'  => '{version}',
    );

    protected function getVersion()
    {
        return ecjia::VERSION;
    }

    public function make($dir, $output)
    {
        $dir = rtrim($dir, '/\\');

        $excludes = array(
            'statics/.*',
            'languages/.*',
        );

        $includes = array();

        $result = $this->generic($dir, array(
            'project'        => 'ecjia-system',
            'output'         => $output,
            'includes'       => $includes,
            'excludes'       => $excludes,
            'default_output' => $dir . '/languages/zh_CN/system.pot',
        ));

        $this->console->info(sprintf(__("提取%sPHP中语言包成功"), '系统应用'));

        $template_result = $this->makeTemplate($dir);

        return $result && $template_result;
    }

    public function makeTemplate($dir)
    {
        $php_pot = realpath($dir . '/languages/zh_CN/system.pot');
        if (! file_exists($php_pot)) {
            return false;
        }

        $includes = array(
            $dir . '/templates'
        );

        $template_pot = $dir . '/languages/zh_CN/system_template.pot';

        $compiler = new SmartyGettextCompiler();

        $compiler->setOutFile($template_pot);

        // initialize output
        file_put_contents($template_pot, SmartyGettextCompiler::MSGID_HEADER);

        foreach ($includes as $dir) {
            (new CompileDirectory($compiler, $dir))->compile();
        }

        /* Adding non-gettexted strings can repeat some phrases */
        $output_shell = escapeshellarg($template_pot);
        system("msguniq $output_shell -o $output_shell");

        if (file_exists($template_pot)) {
            system("msgcat --use-first $php_pot $template_pot -o $php_pot");
            unlink($template_pot);
        }

        $this->console->info(sprintf(__("提取%s模板语言包成功"), '系统应用'));

        return true;
    }


}