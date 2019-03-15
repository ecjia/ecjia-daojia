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

class MakeEcjiaThemePOT extends MakeEcjiaGenericPOT
{

    protected $slug;

    protected $meta = array(
        'description'        => "Translation of the Ecjia theme {name} {version} by {author}",
        'msgid-bugs-address' => "https://www.ecjia.com/support/theme/{slug}",
        'copyright-holder'   => "{author}",
        'package-name'       => "{name}",
        'package-version'    => "{version}",
        'comments'           => "Copyright (C) {year} {author}\nThis file is distributed under the same license as the {package-name} package.",
    );


    public function make($dir, $output, $slug = null)
    {
        $placeholders = array();
        // guess plugin slug
        if (is_null($slug)) {
            $this->slug = $this->guess_plugin_slug($dir);
        } else {
            $this->slug = $slug;
        }

        $main_file = $dir . '/style.css';
        $source    = $this->get_first_lines($main_file, $this->max_header_lines);

        $placeholders['version'] = $this->get_addon_header('Version', $source);
        $placeholders['author']  = $this->get_addon_header('Author', $source);
        $placeholders['name']    = $this->get_addon_header('Template Name', $source);
        $placeholders['slug']    = $this->slug;

        $license = $this->get_addon_header('License', $source);
        if ($license)
        {
            $this->meta['ecjia-theme']['comments'] = "Copyright (C) {year} {author}\nThis file is distributed under the {$license}.";
        }
        else
        {
            $this->meta['ecjia-theme']['comments'] = "Copyright (C) {year} {author}\nThis file is distributed under the same license as the {package-name} package.";
        }

        if (is_null($output)) {
            $output =  $dir . "/languages/zh_CN/{$this->slug}.pot";
        }

        $res    = $this->xgettext('ecjia-theme', $dir, $output, $placeholders);
        if (!$res)
        {
            return false;
        }

        $potextmeta = new PotExtMeta($this->console);
        $res        = $potextmeta->append($main_file, $output, array('Template Name', 'Template URI', 'Description', 'Author', 'Author URI'));
        if (!$res)
        {
            return false;
        }

        /* Adding non-gettexted strings can repeat some phrases */
        $output_shell = escapeshellarg($output);
        system("msguniq $output_shell -o $output_shell");

        $this->console->info(sprintf(__("提取%sPHP中语言包成功"), $this->slug));

        $template_result = $this->makeTemplate($dir);

        return $res && $template_result;
    }


    protected function guess_plugin_slug($dir)
    {
        if ('trunk' == basename($dir)) {
            $slug = basename(dirname($dir));
        } elseif (in_array(basename(dirname($dir)), array('branches', 'tags'))) {
            $slug = basename(dirname(dirname($dir)));
        } else {
            $slug = basename($dir);
        }
        return $slug;
    }

    private function getPHPPotPath($dir, $realpath = false)
    {
        if ($realpath) {
            return realpath($dir . "/languages/zh_CN/{$this->slug}.pot");
        } else {
            return $dir . "/languages/zh_CN/{$this->slug}.pot";
        }
    }

    private function getTemplatePotPath($dir)
    {
        $pot = $this->getPHPPotPath($dir);

        return str_replace('.pot', '_template.pot', $pot);
    }

    public function makeTemplate($dir)
    {
        $php_pot = $this->getPHPPotPath($dir, true);
        if (! file_exists($php_pot)) {
            return false;
        }

        $includes = array(
            $dir
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

        $this->console->info(sprintf(__("提取%s模板语言包成功"), $this->slug));

        return true;
    }


}