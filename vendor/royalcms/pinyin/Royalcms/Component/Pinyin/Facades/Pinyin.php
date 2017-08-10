<?php

namespace Royalcms\Component\Pinyin\Facades;

use Royalcms\Component\Support\Facades\Facade;
use Royalcms\Component\Pinyin\Pinyin;

class PinyinFacade extends Facade
{

    const POLICY_CAMEL = Pinyin::POLICY_CAMEL;

    const POLICY_STUDLY = Pinyin::POLICY_STUDLY;

    const POLICY_UNDERSCORE = Pinyin::POLICY_UNDERSCORE;

    const POLICY_HYPHEN = Pinyin::POLICY_HYPHEN;

    const POLICY_BLANK = Pinyin::POLICY_BLANK;

    const POLICY_SHRINK = Pinyin::POLICY_SHRINK;

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'pinyin';
    }
}