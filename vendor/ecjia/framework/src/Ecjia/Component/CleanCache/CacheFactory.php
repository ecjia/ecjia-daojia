<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
namespace Ecjia\Component\CleanCache;

use RC_Hook;
use InvalidArgumentException;

/**
 * ecjia 清除缓存类
 * @author royalwang
 *
 */
class CacheFactory
{
    
    protected static $factories = [];

    /**
     * @var CacheComponentAbstract[]
     */
    protected static $registered = [];
    
    public function __construct()
    {
        self::$factories = $this->getFactories();
    }
    
    public function getFactories()
    {
        $cache_key = 'clean_cache_component_factories';
    
        $factories = ecjia_cache('system')->get($cache_key);
        if (empty($factories)) {
    
            $dir = __DIR__ . '/Components';
    
            $platforms = royalcms('files')->files($dir);

            $factories = [];
    
            foreach ($platforms as $key => $value) {
                $value = str_replace($dir . DIRECTORY_SEPARATOR, '', $value);
                $value = str_replace('.php', '', $value);
                $className = __NAMESPACE__ . '\Components\\' . $value;
                
                $key = (new $className)->getCode();
                $factories[$key] = $className;
            }
    
            ecjia_cache('system')->put($cache_key, $factories, 10080);
        }
    
        return RC_Hook::apply_filters('ecjia_clean_cache_component_filter', $factories);
    }
    
    
    public function getComponents()
    {
        foreach (self::$factories as $key => $value) {
            $inst = new $value;
            self::$registered[$key] = $inst;
        }
    
        return self::$registered;
    }
    
    
    public function component($code)
    {
        if (array_key_exists($code, self::$registered)) {
            return self::$registered[$code];
        }

        if (!array_key_exists($code, self::$factories)) {
            throw new InvalidArgumentException(sprintf(__('Component %s is not supported.', 'ecjia'), $code));
        }
    
        $className = self::$factories[$code];

        self::$registered[$code] = new $className();

        return self::$registered[$code];
    }

    /**
     * register an item;
     *
     * @param string $code Unique item name.
     * @param CacheComponentAbstract $cache
     * @return boolean | CacheComponentAbstract
     */
    public function register($code, CacheComponentAbstract $cache)
    {
        if (array_key_exists($code, self::$registered)) {
            return false;
        }

        self::$registered[$code] = $cache;

        return self::$registered[$code];
    }

    /**
     * 执行清除缓存
     * @param $code
     * @return bool | array
     */
    public function clean($code)
    {
        //不存在handle
        if (! array_key_exists($code, self::$registered)) {

            if (array_key_exists($code, self::$factories)) {
                $cache_handel = $this->component($code);
            }
            else {
                return null;
            }

        }
        else {
            $cache_handel = self::$registered[$code];
        }

        $relevances[] = $code;

        if ($cache_handel->hasRelevance()) {
            $this->relevancesBy($cache_handel->getRelevance(), $relevances);
        }

        $result = collect($relevances)->mapWithKeys(function($item) {
            $handle = $this->component($item);
            return [$item => $handle->handle()];
        })->all();

        return $result;
    }

    /**
     * 递归缓存关联数组，找出所有依赖项
     */
    protected function relevancesBy($handles, & $relevances)
    {
        foreach ($handles as $code) {
            if (in_array($code, $relevances)) {
                continue;
            }

            $relevances[] = $code;

            $handle = $this->component($code);

            if ($handle->hasRelevance()) {
                $this->relevancesBy($handle->getRelevance(), $relevances);
            }
        }
    }

    /**
     * 返回所有的缓存Handlers
     * @return CacheComponentAbstract[]
     */
    public function allCacheHandles()
    {
        return self::$registered;
    }

}
