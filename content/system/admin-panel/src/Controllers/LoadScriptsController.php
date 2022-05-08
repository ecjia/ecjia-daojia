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
use RC_Script;
use RC_File;

class LoadScriptsController extends ecjia_admin
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

        $expires_offset = 31536000; // 1 year
        $out            = '';


        foreach ($load as $handle) {
            if (!array_key_exists($handle, RC_Script::instance()->registered))
                continue;

            $path = RC_SYSTEM_PATH . 'statics' . RC_Script::instance()->registered[$handle]->src;
            $out  .= RC_File::get($path) . "\n";
        }

        header("Etag: " . ecjia::VERSION);
        header('Content-Type: text/css; charset=UTF-8');
        header('Expires: ' . gmdate("D, d M Y H:i:s", time() + $expires_offset) . ' GMT');
        header("Cache-Control: public, max-age=$expires_offset");

        echo $out;
        exit;

    }

}