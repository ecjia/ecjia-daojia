<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/11
 * Time: 15:45
 */

namespace Ecjia\System\Admins\Gettext\Smarty;

/**
 * go through a directory
 * Class CompileDirectory
 * @package Ecjia\System\Admins\Gettext
 */
class CompileDirectory
{

    protected $dir;

    protected $compiler;

    public function __construct(SmartyGettextCompiler $compiler, $dir)
    {
        $this->compiler = $compiler;
        $this->dir = $dir;
    }


    public function compile()
    {

        $d = dir($this->dir);

        while (false !== ($entry = $d->read())) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            $entry = $this->dir . '/' . $entry;

            // if a directory, go through it
            if (is_dir($entry)) {
                (new static($this->compiler, $entry))->compile();
            }
            // if file, parse only if extension is matched
            else {

                $pi = pathinfo($entry);

                if (isset($pi['extension']) && in_array($pi['extension'], $this->compiler->getExtensions())) {
                    (new CompileFile($this->compiler, $entry))->compile();
                }
            }
        }

        $d->close();

    }

}