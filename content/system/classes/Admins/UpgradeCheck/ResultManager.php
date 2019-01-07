<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/21
 * Time: 17:03
 */

namespace Ecjia\System\Admins\UpgradeCheck;


class ResultManager
{

    protected $result;

    public function __construct(array $result)
    {

        foreach ($result as $version) {
            $this->result[] = new FormatterResult($version);
        }

    }


    public function formatter()
    {
        return $this->result;
    }



}