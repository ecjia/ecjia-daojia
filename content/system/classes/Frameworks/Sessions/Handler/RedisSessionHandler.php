<?php

namespace Ecjia\System\Frameworks\Sessions\Handler;

use Ecjia\System\Frameworks\Contracts\EcjiaSessionInterface;
use Ecjia\System\Frameworks\Sessions\Traits\EcjiaSessionSpecTrait;

/**
 * 使用 Redis 管理Session 数据
 * Class RedisSessionHandler
 * @package Ecjia\System\Frameworks\Sessions\Handler
 */
class RedisSessionHandler implements \SessionHandlerInterface, EcjiaSessionInterface
{

    use EcjiaSessionSpecTrait;

    /**
     * @var \Redis Redis driver.
     */
    private $redis;
    
    /**
     * @var int     Time to live in seconds
     */
    private $ttl;
    
    /**
     * @var string Key prefix for shared environments.
     */
    private $prefix;

    /**
     * Constructor.
     *
     * List of available options:
     *  * prefix: The prefix to use for the redis keys in order to avoid collision
     *  * expiretime: The time to live in seconds
     *
     * @param \Redis $redis A \Redis instance
     * @param array     $options  An associative array of Redis options
     *
     * @throws \InvalidArgumentException When unsupported options are passed
     */
    public function __construct($redis, array $options = array())
    {
        $diff = array_diff(array_keys($options), array('prefix', 'expiretime'));
        if ($diff) {
            throw new \InvalidArgumentException(sprintf(
                'The following options are not supported "%s"', implode(', ', $diff)
            ));
        }

        $this->redis = $redis;
        $this->ttl = isset($options['expiretime']) ? (int) $options['expiretime'] : 86400;
        $this->prefix = isset($options['prefix']) ? $options['prefix'] : 'sf2s';
    }
    
    /**
     * 默认情况下 Royalcms 对Session 操作如果不是文件存储的话，
     * 不会调用该方法
     * @param string $savePath
     * @param string $sessionName
     * @return boolean
     */
    public function open($savePath, $sessionName)
    {
        return true;
    }

    /**
     * @return bool
     */
    public function close()
    {
        return true;
    }

    /**
     * @param string $sessionId
     * @return string or ''
     */
    public function read($sessionId)
    {
//        ecjia_log_debug('redis read' , $sessionId, 'session');
        return $this->redis->get($this->sessionId($sessionId)) ?: '';
    }

    /**
     * 会话存储的返回值（通常成功返回 0，失败返回 1）。
     * @param string $sessionId
     * @param string $data
     * @return bool 0 or 1
     */
    public function write($sessionId, $data)
    {
//        ecjia_log_debug('redis write', $data, 'session');
        $result = $this->redis->setex($this->sessionId($sessionId), $this->ttl, $data);
        return $result ? 0 : 1;
    }

    /**
     * @param string $sessionId
     * @return bool|int
     */
    public function destroy($sessionId)
    {
        return $this->redis->del($this->sessionId($sessionId));
    }

    /**
     * @param int|string $maxlifetime
     * @return bool
     */
    public function gc($maxlifetime)
    {
        // not required here because memcache will auto expire the records anyhow.
        return true;
    }

    /**
     * @return \Redis
     */
    public function getDriver()
    {
        return $this->redis;
    }
    
    protected function sessionId($sessionId)
    {
        return $this->prefix.'session:'.$sessionId;
    }

}

// end