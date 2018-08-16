<?php

namespace Ecjia\System\Sessions\Handler;

use Ecjia\System\Sessions\EcjiaSessionInterface;
use Royalcms\Component\Memcache\Repository as MemcacheRepository;

/**
 * MemcacheSessionHandler.
 *
 * @author Drak <drak@zikula.org>
 */
class MemcacheSessionHandler implements \SessionHandlerInterface, EcjiaSessionInterface
{
    /**
     * @var \Memcache Memcache driver.
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
    public function __construct(MemcacheRepository $memcache, array $options = array())
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
     * {@inheritdoc}
     */
    public function open($savePath, $sessionName)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function read($sessionId)
    {
        return $this->memcache->get($this->sessionId($sessionId)) ?: '';
    }

    /**
     * {@inheritdoc}
     */
    public function write($sessionId, $data)
    {
        $sessionData = \Royalcms\Component\Session\Serialize::unserialize($data);
        $user_type = array_get($sessionData, 'session_user_type');
        $user_id = array_get($sessionData, 'session_user_id');
        if ($user_type) {
            $this->updateStatsUsers($user_type, 1);
            if ($user_id) {
                if (! $this->userGetKey($user_id, $user_type)) 
                    $this->userAddKey($user_id, $user_type, $this->sessionId($sessionId));
                else 
                    $this->userUpdateKey($user_id, $user_type, $this->sessionId($sessionId));
            }
        }

        return $this->memcache->set($this->sessionId($sessionId), $data, SYS_TIME + $this->ttl);
    }

    /**
     * {@inheritdoc}
     */
    public function destroy($sessionId)
    {
        $data = $this->memcache->get($this->sessionId($sessionId));
        $sessionData = \Royalcms\Component\Session\Serialize::unserialize($data);
        $user_type = array_get($sessionData, 'session_user_type');
        $user_id = array_get($sessionData, 'session_user_id');
        if ($user_type) {
            $this->updateStatsUsers($user_type, -1);
            if ($user_id) {
                $this->userDeleteKey($user_id, $user_type);
            }
        }
        
        return $this->memcache->delete($this->sessionId($sessionId));
    }

    /**
     * {@inheritdoc}
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
    public function getMemcache()
    {
        return $this->memcache;
    }
    
    
    protected function sessionId($sessionId)
    {
        return $this->prefix.'session:'.$sessionId;
    }
    
    protected function userAddKey($user_id, $user_type, $key) 
    {
        return $this->memcache->set("{$this->prefix}sessionkey:{$user_type}:{$user_id}", $key, SYS_TIME + $this->ttl);
    }
    
    protected function userUpdateKey($user_id, $user_type, $key) 
    {
        return $this->memcache->replace("{$this->prefix}sessionkey:{$user_type}:{$user_id}", $key, SYS_TIME + $this->ttl);
    }
    
    protected function userGetKey($user_id, $user_type) 
    {
        return $this->memcache->get("{$this->prefix}sessionkey:{$user_type}:{$user_id}");
    }
    
    protected function userDeleteKey($user_id, $user_type) 
    {
        return $this->memcache->delete("{$this->prefix}sessionkey:{$user_type}:{$user_id}");
    }
    
    /**
     * 统计在线会员数
     * @param string $incre 自增量，可以正负
     */
    protected function updateStatsUsers($user_type, $incre = null) {
        $user_count = $this->memcache->get("{$this->prefix}sessioncount:onlineusers:{$user_type}");
        if (empty($user_count)) {
            $this->memcache->set("{$this->prefix}sessioncount:onlineusers:{$user_type}", 1);
        } else {
            $user_count = $user_count + $incre;
            $user_count = $user_count > 0 ? $user_count : 0;
            $this->memcache->replace("{$this->prefix}sessioncount:onlineusers:{$user_type}", $user_count);
        }
    }
    
    /**
     * 删除指定用户的session
     * @param int $user_id 用户ID
     * @param int $user_type 用户类型user,admin,merchant
     * @return boolean
     */
    public function deleteSpecSession($user_id, $user_type)
    {
        $userid_key = $this->userGetKey($user_id, $user_type);
        if ($userid_key) {
            $this->userDeleteKey($user_id, $user_type);
            $this->memcache->delete($userid_key);
            $this->updateStatsUsers($user_type, -1);
        }
    }
    
    /**
     * 获取当前在线用户总数
     * @return number
     */
    public function getUserCount($user_type)
    {
        return $this->memcache->get("{$this->prefix}sessioncount:onlineusers:{$user_type}");
    }
    
    /**
     * 获取指定session_id的数据
     * @param string $session_id
     */
    public function getSessionData($sessionId)
    {
        $data = $this->memcache->get($this->sessionId($sessionId));
        $sessionData = \Royalcms\Component\Session\Serialize::unserialize($data);
        if (empty($sessionData)) {
            $session = array();
        }
    
        return $sessionData;
    }
    
}

// end