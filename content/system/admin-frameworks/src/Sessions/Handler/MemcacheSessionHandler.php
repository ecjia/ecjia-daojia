<?php

namespace Ecjia\System\Frameworks\Sessions\Handler;

use Ecjia\System\Frameworks\Contracts\EcjiaSessionInterface;
use Ecjia\System\Frameworks\Sessions\Traits\EcjiaSessionSpecTrait;

/**
 * Class MemcacheSessionHandler
 * @package Ecjia\System\Frameworks\Sessions\Handler
 */
class MemcacheSessionHandler implements \SessionHandlerInterface, EcjiaSessionInterface
{

    use EcjiaSessionSpecTrait;

    /**
     * @var \Royalcms\Component\Memcache\Repository Memcache driver.
     */
    private $memcache;

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
     *  * prefix: The prefix to use for the memcache keys in order to avoid collision
     *  * expiretime: The time to live in seconds
     *
     * @param \Memcache $memcache A \Memcache instance
     * @param array     $options  An associative array of Memcache options
     *
     * @throws \InvalidArgumentException When unsupported options are passed
     */
    public function __construct($memcache, array $options = array())
    {
        $diff = array_diff(array_keys($options), array('prefix', 'expiretime'));
        if ($diff) {
            throw new \InvalidArgumentException(sprintf(
                'The following options are not supported "%s"', implode(', ', $diff)
            ));
        }

        $this->memcache = $memcache;
        $this->ttl = isset($options['expiretime']) ? (int) $options['expiretime'] : 86400;
        $this->prefix = isset($options['prefix']) ? $options['prefix'] : 'sf2s';
    }

    /**
     * @param string $savePath
     * @param string $sessionName
     * @return bool
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
//        ecjia_log_debug('memcache read' , $sessionId, 'session');
        return $this->memcache->get($this->sessionId($sessionId)) ?: '';
    }

    /**
     * 会话存储的返回值（通常成功返回 0，失败返回 1）。
     * @param string $sessionId
     * @param string $data
     * @return bool 0 or 1
     */
    public function write($sessionId, $data)
    {
//        ecjia_log_debug('memcache write', $data, 'session');
        $result = $this->memcache->set($this->sessionId($sessionId), $data, SYS_TIME + $this->ttl);
        return $result ? 0 : 1;
    }

    /**
     * @param string $sessionId
     * @return bool
     */
    public function destroy($sessionId)
    {
        return $this->memcache->delete($this->sessionId($sessionId));
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
     * Return a Memcache instance
     *
     * @return \Memcache
     */
    public function getDriver()
    {
        return $this->memcache;
    }
    
    
    protected function sessionId($sessionId)
    {
        return $this->prefix.'session:'.$sessionId;
    }

}

// end