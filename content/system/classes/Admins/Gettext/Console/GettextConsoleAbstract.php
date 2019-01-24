<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/14
 * Time: 17:48
 */

namespace Ecjia\System\Admins\Gettext\Console;


abstract class GettextConsoleAbstract
{

    /**
     * @var \Royalcms\Component\Console\Command
     */
    protected $console;

    /**
     * @param $command \Royalcms\Component\Console\Command
     */
    public function __construct($console)
    {
        $this->console = $console;
    }

}