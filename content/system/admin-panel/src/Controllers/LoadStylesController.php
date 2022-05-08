<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-20
 * Time: 09:38
 */

namespace Ecjia\System\AdminPanel\Controllers;

use ecjia;
use ecjia_admin;
use RC_Style;
use RC_File;

class LoadStylesController extends ecjia_admin
{

    public function __construct()
    {
        parent::__construct();

    }


    public function init()
    {

        $load = $this->request->input('load');
        if (is_array($load)) {
            $load = implode('', $load);
        }
        $load = preg_replace('/[^a-z0-9,_-]+/i', '', $load);
        $load = array_unique(explode(',', $load));

        if (empty($load)) {
            exit;
        }

        $dir = $this->request->input('dir');

        if ($dir == 'rtl') {
            $rtl = true;
        }

        $expires_offset = 31536000; // 1 year
        $out            = '';


        foreach ($load as $handle) {
            if (!array_key_exists($handle, RC_Style::instance()->registered)) {
                continue;
            }

            $style = RC_Style::instance()->registered[$handle];

            if (empty($style->src)) {
                continue;
            }

            $path = RC_SYSTEM_PATH . 'statics' . $style->src;

            if ($rtl && !empty($style->extra['rtl'])) {
                // All default styles have fully independent RTL files.
                $path = str_replace('.min.css', '-rtl.min.css', $path);
            }

            $content  = RC_File::get($path) . "\n";
            $base_url = RC_Style::instance()->content_url;

            //处理styles目录下的样式内嵌链接
            if (strpos($style->src, '/styles/') === 0) {
                $content = str_replace('../images/', $base_url . '/images/', $content);
                $content = str_replace('../fonts/', $base_url . '/fonts/', $content);

                $out .= $content;
            } //处理images目录下的样式内嵌链接
            elseif (strpos($style->src, '/images/') === 0) {
                $src_base_url = $base_url . dirname($style->src);

                $content = str_replace('flags.png', $src_base_url . '/flags.png', $content);
                $content = str_replace('splashy.png', $src_base_url . '/splashy.png', $content);

                $out .= $content;
            } //处理其它目录下的样式内嵌链接
            else {

                $src_base_url = $base_url . dirname($style->src);

                $content = str_replace('../Images/', $src_base_url . '/../Images/', $content);
                $content = str_replace('../images/', $src_base_url . '/../images/', $content);
                $content = str_replace('../font/', $src_base_url . '/../font/', $content);
                $content = str_replace('../fonts/', $src_base_url . '/../fonts/', $content);
                $content = str_replace('../img/', $src_base_url . '/../img/', $content);

                $out .= $content;
            }
        }

        header("Etag: " . ecjia::VERSION);
        header('Content-Type: text/css; charset=UTF-8');
        header('Expires: ' . gmdate("D, d M Y H:i:s", time() + $expires_offset) . ' GMT');
        header("Cache-Control: public, max-age=$expires_offset");

        echo $out;
        exit;

    }

}