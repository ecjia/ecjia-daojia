<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/15
 * Time: 15:15
 */

namespace Ecjia\System\Admins\Gettext\Console;

use Ecjia\System\Admins\Gettext\Smarty\SmartyGettextCompiler;
use Ecjia\System\Admins\Gettext\Smarty\CompileDirectory;

class MakeEcjiaAppPOT extends MakeEcjiaGenericPOT
{

    protected $app;

    protected $meta = array(
        'description'      => 'Translation of frontend strings in Ecjia App {app} {version}',
        'copyright-holder' => 'Ecjia',
        'package-name'     => 'Ecjia App {app}',
        'package-version'  => '{version}',
    );


    protected function getVersion()
    {
        return config('app-'.$this->app.'::package.version');
    }


    protected function getPHPPotPath($dir, $realpath = false)
    {
        if ($realpath) {
            return realpath($dir . "/languages/zh_CN/{$this->app}.pot");
        } else {
            return $dir . "/languages/zh_CN/{$this->app}.pot";
        }
    }

    protected function getTemplatePotPath($dir)
    {
        $pot = $this->getPHPPotPath($dir);

        return str_replace('.pot', '_template.pot', $pot);
    }

    protected function getAppName()
    {
        return $this->app.'应用';
    }

    public function make($dir, $output)
    {
        $dir = rtrim($dir, '/\\');

        $this->app = basename($dir);

        $this->placeholders['app'] = $this->app;

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
            'default_output' => $this->getPHPPotPath($dir),
        ));

        $this->console->info(sprintf(__("提取%sPHP中语言包成功"), $this->getAppName()));

        $template_result = $this->makeTemplate($dir);

        return $result && $template_result;
    }

    public function makeTemplate($dir)
    {
        $php_pot = $this->getPHPPotPath($dir, true);
        if (! file_exists($php_pot)) {
            return false;
        }

        $includes = array(
            $dir . '/templates'
        );

        $template_pot = $this->getTemplatePotPath($dir);

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

        $this->console->info(sprintf(__("提取%s模板语言包成功"), $this->getAppName()));

        return true;
    }

}