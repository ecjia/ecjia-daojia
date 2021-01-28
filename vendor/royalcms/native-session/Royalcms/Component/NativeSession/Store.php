<?php

namespace Royalcms\Component\NativeSession;

use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionBagInterface;
use Symfony\Component\HttpFoundation\Session\Storage\MetadataBag;
use Royalcms\Component\Session\StoreInterface;
use Royalcms\Component\Support\Str;
use Illuminate\Contracts\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Store extends \Royalcms\Component\Session\Store implements SessionInterface
{
    use CompatibleTrait;

    /**
     * Load the session data from the handler.
     *
     * @return void
     */
    protected function loadSession()
    {
        parent::loadSession();

        session_id($this->getId());

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $this->mergeNativeSession();
    }

    /**
     * Merge Native session data
     *
     * @return void
     */
    protected function mergeNativeSession()
    {
        foreach ($_SESSION as $name => $value) {
            if (! is_array($name)) {
                $key = [$name => $value];
            }

            foreach ($key as $arrayKey => $arrayValue) {
                Arr::set($this->attributes, $arrayKey, $arrayValue);
            }
        }
    }

    /**
     * Sets the session name.
     *
     * @param string $name
     */
    public function setName($name)
    {
        parent::setName($name);

        session_name($name);
    }

    /**
     * Invalidates the current session.
     *
     * Clears all session attributes and flashes and regenerates the
     * session and deletes the old session from persistence.
     *
     *
     * @return bool True if session invalidated, false if error
     */
    public function invalidate($lifetime = null)
    {
        session_destroy();

        $this->regenerate(true);
        
        return parent::invalidate();
    }

    /**
     * Force the session to be saved and closed.
     *
     * This method is generally not required for real sessions as
     * the session will be automatically saved at the end of
     * code execution.
     */
    public function save()
    {
        //把 $this->attributes = $_SESSION 数据同步
        $mergeData = array_merge($_SESSION, $this->attributes);
        $this->replace($mergeData);

        session_write_close();

        parent::save();
    }

    /**
     * Sets an attribute.
     *
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value)
    {
        Arr::set($_SESSION, $name, $value);

        parent::set($name, $value);
    }

    /**
     * Put a key / value pair or array of key / value pairs in the session.
     *
     * @param  string|array  $key
     * @param  mixed       $value
     * @return void
     */
    public function put($key, $value = null)
    {
        parent::put($key, $value);

        if (! is_array($key)) {
            $key = [$key => $value];
        }

        foreach ($key as $arrayKey => $arrayValue) {
            Arr::set($_SESSION, $arrayKey, $arrayValue);
        }
    }


    /**
     * Checks if an attribute exists.
     *
     * @param  string|array $name
     * @return bool
     */
    public function exists($name)
    {
        return $this->has($name);
    }

    /**
     * Sets the session ID.
     *
     * @param string $id
     */
    public function setId($id)
    {
        session_id($id);

        return parent::setId($id);
    }
    
    /**
     * Generate a new session identifier.
     *
     * @param  bool  $destroy
     * @return bool
     */
    public function regenerate($destroy = false)
    {
        parent::migrate($destroy);
        
        // Finish session
        session_commit();
        // Make sure to accept user defined session ID
        // NOTE: You must enable use_strict_mode for normal operations.
        ini_set('session.use_strict_mode', 0);
        // Set new custome session ID
        session_id($this->getId());
        // Start with custome session ID
        session_start();
        
        return true;
    }

    /**
     * Returns an attribute.
     *
     * @param string $name The attribute name
     * @param mixed $default The default value if not found
     *
     * @return mixed
     */
    public function get($name, $default = null)
    {
        $this->mergeNativeSession();

        return parent::get($name, $default);
    }

    /**
     * Sets attributes.
     *
     * @param array $attributes Attributes
     */
    public function replace(array $attributes)
    {
        $_SESSION = $attributes;

        parent::replace($attributes);
    }

    /**
     * Removes an attribute.
     *
     * @param string $key
     *
     * @return mixed The removed value or null when it does not exist
     */
    public function remove($key)
    {
        Arr::pull($_SESSION, $key);

        return parent::remove($key);
    }

    /**
     * Get a new, random session ID.
     *
     * @return string
     */
    protected function generateSessionId()
    {
        return sha1(uniqid('', true).Str::random(25).microtime(true));
    }

    /**
     * Clears all attributes.
     */
    public function clear()
    {
        $_SESSION = [];

        //PHP Native session unset
        session_unset();
        session_destroy();
        session_write_close();

        parent::clear();
    }
    
    /**
     * Remove all of the items from the session.
     *
     * @return void
     */
    public function flush()
    {
        $this->clear();
    }


    /**
     * Get the CSRF token value.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token();
    }

}

// end