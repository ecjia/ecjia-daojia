<?php


namespace Ecjia\Component\ApiTransformer\Facades;

use Ecjia\Component\ApiTransformer\Contracts\TransformerInterface;
use Ecjia\Component\ApiTransformer\Transformer;
use Ecjia\Component\ApiTransformer\TransformerManager;
use Royalcms\Component\Support\Facades\Facade;

/**
 * Class TransformerManager
 * @package Ecjia\Component\ApiTransformer\Facades
 *
 * @method static TransformerManager registerTransformer($key, TransformerInterface $transformer)
 * @method static TransformerManager unRegisterTransformer($key)
 * @method static array getTransformers()
 * @method static Transformer|null getTransformer($type)
 * @method static array transformerData($type, $data)
 * @method static array transformerHandle($type, $value)
 */
class ApiTransformer extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'ecjia.api.transformer';
    }

}