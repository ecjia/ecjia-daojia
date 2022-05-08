<?php

namespace Royalcms\Component\Pinyin\Facades;

use Royalcms\Component\Support\Facades\Facade;
<<<<<<< HEAD
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
=======
use Royalcms\Component\Pinyin\Pinyin as MyPinyin;

class Pinyin extends Facade
{

    const POLICY_CAMEL = MyPinyin::POLICY_CAMEL;

    const POLICY_STUDLY = MyPinyin::POLICY_STUDLY;

    const POLICY_UNDERSCORE = MyPinyin::POLICY_UNDERSCORE;

    const POLICY_HYPHEN = MyPinyin::POLICY_HYPHEN;

    const POLICY_BLANK = MyPinyin::POLICY_BLANK;

    const POLICY_SHRINK = MyPinyin::POLICY_SHRINK;

    /**
     * Get the registered name of the component.
>>>>>>> v2-test
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'pinyin';
    }
}