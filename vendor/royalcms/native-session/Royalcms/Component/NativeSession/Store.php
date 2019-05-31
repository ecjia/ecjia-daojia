<?php

namespace Royalcms\Component\NativeSession;

use Royalcms\Component\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionBagInterface;
use Symfony\Component\HttpFoundation\Session\Storage\MetadataBag;
use Royalcms\Component\Session\StoreInterface;
use Royalcms\Component\Support\Str;

class Store implements SessionInterface, StoreInterface
{
    use CompatibleTrait;
    
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Starts the session storage.
     *
     * @return bool True if session started
     *
     * @throws \RuntimeException If session fails to start.
     */
    public function start()
    {
        $this->loadSession();

        if (! $this->has('_token')) {
            $this->regenerateToken();
        }

        return $this->session->start();
    }

    protected function loadSession()
    {
        session_id($this->session->getId());
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $this->mergeNativeSession();
    }

    protected function mergeNativeSession()
    {
        foreach ($_SESSION as $name => $value) {
            $this->session->set($name, $value);
        }
    }

    /**
     * Returns the session ID.
     *
     * @return string The session ID
     */
    public function getId()
    {
        return $this->session->getId();
    }
    
    /**
     * Returns the session name.
     *
     * @return mixed The session name
     */
    public function getName()
    {
        return $this->session->getName();
    }

    /**
     * Sets the session name.
     *
     * @param string $name
     */
    public function setName($name)
    {
        session_name($name);
        $this->session->setName($name);
    }

    /**
     * Invalidates the current session.
     *
     * Clears all session attributes and flashes and regenerates the
     * session and deletes the old session from persistence.
     *
     * @param int $lifetime Sets the cookie lifetime for the session cookie. A null value
     *                      will leave the system settings unchanged, 0 sets the cookie
     *                      to expire with browser session. Time is in seconds, and is
     *                      not a Unix timestamp.
     *
     * @return bool True if session invalidated, false if error
     */
    public function invalidate($lifetime = null)
    {
        session_destroy();
        
        $this->session->invalidate($lifetime);
        $this->regenerate(true);
        
        return true;
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
        $this->session->save();

        //把 $this->attributes = $_SESSION 数据同步
        $mergeData = array_merge($_SESSION, $this->session->all());
        $this->replace($mergeData);

        session_write_close();
    }

    /**
     * Sets an attribute.
     *
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value)
    {
        array_set($_SESSION, $name, $value);

        $this->session->set($name, $value);
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
        if (! is_array($key)) {
            $key = [$key => $value];
        }

        foreach ($key as $arrayKey => $arrayValue) {
            $this->set($arrayKey, $arrayValue);
        }
    }

    /**
     * Push a value onto a session array.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function push($key, $value)
    {
        $array = $this->get($key, []);

        $array[] = $value;

        $this->put($key, $array);
    }

    /**
     * Returns attributes.
     *
     * @return array Attributes
     */
    public function all()
    {
        return $this->session->all();
    }

    /**
     * Checks if an attribute exists.
     *
     * @param  string|array $name
     * @return bool
     */
    public function exists($name)
    {
        return $this->session->has($name);
    }

    /**
     * Determine if the session handler needs a request.
     *
     * @return bool
     */
    public function handlerNeedsRequest()
    {
        return $this->session->handlerNeedsRequest();
    }

    /**
     * Set the request on the handler instance.
     *
     * @param  \Symfony\Component\HttpFoundation\Request $request
     * @return void
     */
    public function setRequestOnHandler(Request $request)
    {
        $this->session->setRequestOnHandler($request);
    }

    /**
     * Sets the session ID.
     *
     * @param string $id
     */
    public function setId($id)
    {
        session_id($id);
        return $this->session->setId($id);
    }

    /**
     * Migrates the current session to a new session id while maintaining all
     * session attributes.
     *
     * @param bool $destroy Whether to delete the old session or leave it to garbage collection
     * @param int $lifetime Sets the cookie lifetime for the session cookie. A null value
     *                       will leave the system settings unchanged, 0 sets the cookie
     *                       to expire with browser session. Time is in seconds, and is
     *                       not a Unix timestamp.
     *
     * @return bool True if session migrated, false if error
     */
    public function migrate($destroy = false, $lifetime = null)
    {
        return $this->session->migrate($destroy, $lifetime);
    }
    
    /**
     * Generate a new session identifier.
     *
     * @param  bool  $destroy
     * @return bool
     */
    public function regenerate($destroy = false)
    {
        $this->migrate($destroy);
        
        // Finish session
        session_commit();
        // Make sure to accept user defined session ID
        // NOTE: You must enable use_strict_mode for normal operations.
        ini_set('session.use_strict_mode', 0);
        // Set new custome session ID
        session_id($this->session->getId());
        // Start with custome session ID
        session_start();
        
        return true;
    }

    /**
     * Checks if an attribute is defined.
     *
     * @param string $name The attribute name
     *
     * @return bool true if the attribute is defined, false otherwise
     */
    public function has($name)
    {
        return $this->session->has($name);
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

        return $this->session->get($name, $default);
    }

    /**
     * Sets attributes.
     *
     * @param array $attributes Attributes
     */
    public function replace(array $attributes)
    {
        $_SESSION = $attributes;
        $this->session->replace($attributes);
    }

    /**
     * Removes an attribute.
     *
     * @param string $name
     *
     * @return mixed The removed value or null when it does not exist
     */
    public function remove($name)
    {
        unset($_SESSION[$name]);
        return $this->session->remove($name);
    }

    /**
     * Clears all attributes.
     */
    public function clear()
    {
        $_SESSION = [];
        $this->session->clear();
    }
    
    /**
     * Remove all of the items from the session.
     *
     * @return void
     */
    public function flush()
    {
        $this->clear();
    
        //PHP Native session unset
        session_unset();
        session_destroy();
        session_write_close();
    }

    /**
     * Checks if the session was started.
     *
     * @return bool
     */
    public function isStarted()
    {
        return $this->session->isStarted();
    }

    /**
     * Registers a SessionBagInterface with the session.
     *
     * @param SessionBagInterface $bag
     */
    public function registerBag(SessionBagInterface $bag)
    {
        $this->session->registerBag($bag);
    }

    /**
     * Gets a bag instance by name.
     *
     * @param string $name
     *
     * @return SessionBagInterface
     */
    public function getBag($name)
    {
        return $this->session->getBag($name);
    }

    /**
     * Gets session meta.
     *
     * @return MetadataBag
     */
    public function getMetadataBag()
    {
        return $this->session->getMetadataBag();
    }

    /**
     * Get the session handler instance.
     *
     * @return \SessionHandlerInterface
     */
    public function getHandler()
    {
        return $this->session->getHandler();
    }

    /**
     * ====================================
     * session class compatible
     * ====================================
     */

    /**
     * Age the flash data for the session.
     *
     * @return void
     */
    public function ageFlashData()
    {
        $this->session->forget($this->get('flash.old', []));

        $this->put('flash.old', $this->get('flash.new', []));

        $this->put('flash.new', []);
    }

    /**
     * Flash a key / value pair to the session.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function flash($key, $value)
    {
        $this->put($key, $value);

        $this->push('flash.new', $key);

        $this->removeFromOldFlashData([$key]);
    }

    /**
     * Flash a key / value pair to the session
     * for immediate use.
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function now($key, $value)
    {
        $this->put($key, $value);

        $this->push('flash.old', $key);
    }

    /**
     * Flash an input array to the session.
     *
     * @param  array  $value
     * @return void
     */
    public function flashInput(array $value)
    {
        $this->flash('_old_input', $value);
    }

    /**
     * Reflash all of the session flash data.
     *
     * @return void
     */
    public function reflash()
    {
        $this->mergeNewFlashes($this->get('flash.old', []));

        $this->put('flash.old', []);
    }

    /**
     * Reflash a subset of the current flash data.
     *
     * @param  array|mixed  $keys
     * @return void
     */
    public function keep($keys = null)
    {
        $keys = is_array($keys) ? $keys : func_get_args();

        $this->mergeNewFlashes($keys);

        $this->removeFromOldFlashData($keys);
    }

    /**
     * Merge new flash keys into the new flash array.
     *
     * @param  array  $keys
     * @return void
     */
    protected function mergeNewFlashes(array $keys)
    {
        $values = array_unique(array_merge($this->get('flash.new', []), $keys));

        $this->put('flash.new', $values);
    }

    /**
     * Remove the given keys from the old flash data.
     *
     * @param  array  $keys
     * @return void
     */
    protected function removeFromOldFlashData(array $keys)
    {
        $this->put('flash.old', array_diff($this->get('flash.old', []), $keys));
    }

    /**
     * Get the CSRF token value.
     *
     * @return string
     */
    public function token()
    {
        return $this->get('_token');
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

    /**
     * Regenerate the CSRF token value.
     *
     * @return void
     */
    public function regenerateToken()
    {
        $this->put('_token', Str::random(40));
    }

    /**
     * Set the "previous" URL in the session.
     *
     * @param  string  $url
     * @return void
     */
    public function setPreviousUrl($url)
    {
        $this->put('_previous.url', $url);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->session, $name], $arguments);
    }

}

// end