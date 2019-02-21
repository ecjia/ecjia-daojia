<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-02-19
 * Time: 09:22
 */

namespace Ecjia\App\Mobile\Options;

class OptionTypeSerialize
{

    protected $option_type = 'serialize';


    public function getOptionType()
    {
        return $this->option_type;
    }


    public function encodeOptionVaule($value)
    {
        return serialize($value);
    }


    public function decodeOptionVaule($value)
    {
        return unserialize($value);
    }

}