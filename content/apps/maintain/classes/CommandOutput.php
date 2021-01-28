<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019/1/18
 * Time: 15:57
 */

namespace Ecjia\App\Maintain;


class CommandOutput
{

    protected $message;


    public function __construct($message)
    {
        $this->message = $message;
    }


    public function getMessage()
    {
        return $this->message;
    }

}