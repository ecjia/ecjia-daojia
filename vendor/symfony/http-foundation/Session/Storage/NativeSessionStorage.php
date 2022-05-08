<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Session\Storage;

use Symfony\Component\HttpFoundation\Session\SessionBagInterface;
<<<<<<< HEAD
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\Proxy\NativeProxy;
use Symfony\Component\HttpFoundation\Session\Storage\Proxy\AbstractProxy;
use Symfony\Component\HttpFoundation\Session\Storage\Proxy\SessionHandlerProxy;

=======
use Symfony\Component\HttpFoundation\Session\SessionUtils;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\StrictSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\Proxy\AbstractProxy;
use Symfony\Component\HttpFoundation\Session\Storage\Proxy\SessionHandlerProxy;

// Help opcache.preload discover always-needed symbols
class_exists(MetadataBag::class);
class_exists(StrictSessionHandler::class);
class_exists(SessionHandlerProxy::class);

>>>>>>> v2-test
/**
 * This provides a base class for session attribute storage.
 *
 * @author Drak <drak@zikula.org>
 */
class NativeSessionStorage implements SessionStorageInterface
{
    /**
<<<<<<< HEAD
     * Array of SessionBagInterface.
     *
     * @var SessionBagInterface[]
     */
    protected $bags;
=======
     * @var SessionBagInterface[]
     */
    protected $bags = [];
>>>>>>> v2-test

    /**
     * @var bool
     */
    protected $started = false;

    /**
     * @var bool
     */
    protected $closed = false;

    /**
<<<<<<< HEAD
     * @var AbstractProxy
=======
     * @var AbstractProxy|\SessionHandlerInterface
>>>>>>> v2-test
     */
    protected $saveHandler;

    /**
     * @var MetadataBag
     */
    protected $metadataBag;

    /**
<<<<<<< HEAD
     * Constructor.
     *
=======
     * @var string|null
     */
    private $emulateSameSite;

    /**
>>>>>>> v2-test
     * Depending on how you want the storage driver to behave you probably
     * want to override this constructor entirely.
     *
     * List of options for $options array with their defaults.
     *
<<<<<<< HEAD
     * @see http://php.net/session.configuration for options
=======
     * @see https://php.net/session.configuration for options
>>>>>>> v2-test
     * but we omit 'session.' from the beginning of the keys for convenience.
     *
     * ("auto_start", is not supported as it tells PHP to start a session before
     * PHP starts to execute user-land code. Setting during runtime has no effect).
     *
     * cache_limiter, "" (use "0" to prevent headers from being sent entirely).
<<<<<<< HEAD
=======
     * cache_expire, "0"
>>>>>>> v2-test
     * cookie_domain, ""
     * cookie_httponly, ""
     * cookie_lifetime, "0"
     * cookie_path, "/"
     * cookie_secure, ""
<<<<<<< HEAD
     * entropy_file, ""
     * entropy_length, "0"
     * gc_divisor, "100"
     * gc_maxlifetime, "1440"
     * gc_probability, "1"
     * hash_bits_per_character, "4"
     * hash_function, "0"
     * name, "PHPSESSID"
     * referer_check, ""
     * serialize_handler, "php"
=======
     * cookie_samesite, null
     * gc_divisor, "100"
     * gc_maxlifetime, "1440"
     * gc_probability, "1"
     * lazy_write, "1"
     * name, "PHPSESSID"
     * referer_check, ""
     * serialize_handler, "php"
     * use_strict_mode, "0"
>>>>>>> v2-test
     * use_cookies, "1"
     * use_only_cookies, "1"
     * use_trans_sid, "0"
     * upload_progress.enabled, "1"
     * upload_progress.cleanup, "1"
     * upload_progress.prefix, "upload_progress_"
     * upload_progress.name, "PHP_SESSION_UPLOAD_PROGRESS"
     * upload_progress.freq, "1%"
     * upload_progress.min-freq, "1"
     * url_rewriter.tags, "a=href,area=href,frame=src,form=,fieldset="
<<<<<<< HEAD
     *
     * @param array                                                            $options Session configuration options
     * @param AbstractProxy|NativeSessionHandler|\SessionHandlerInterface|null $handler
     * @param MetadataBag                                                      $metaBag MetadataBag
     */
    public function __construct(array $options = array(), $handler = null, MetadataBag $metaBag = null)
    {
        session_cache_limiter(''); // disable by default because it's managed by HeaderBag (if used)
        ini_set('session.use_cookies', 1);

        if (PHP_VERSION_ID >= 50400) {
            session_register_shutdown();
        } else {
            register_shutdown_function('session_write_close');
        }

=======
     * sid_length, "32"
     * sid_bits_per_character, "5"
     * trans_sid_hosts, $_SERVER['HTTP_HOST']
     * trans_sid_tags, "a=href,area=href,frame=src,form="
     *
     * @param AbstractProxy|\SessionHandlerInterface|null $handler
     */
    public function __construct(array $options = [], $handler = null, MetadataBag $metaBag = null)
    {
        if (!\extension_loaded('session')) {
            throw new \LogicException('PHP extension "session" is required.');
        }

        $options += [
            'cache_limiter' => '',
            'cache_expire' => 0,
            'use_cookies' => 1,
            'lazy_write' => 1,
            'use_strict_mode' => 1,
        ];

        session_register_shutdown();

>>>>>>> v2-test
        $this->setMetadataBag($metaBag);
        $this->setOptions($options);
        $this->setSaveHandler($handler);
    }

    /**
     * Gets the save handler instance.
     *
<<<<<<< HEAD
     * @return AbstractProxy
=======
     * @return AbstractProxy|\SessionHandlerInterface
>>>>>>> v2-test
     */
    public function getSaveHandler()
    {
        return $this->saveHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function start()
    {
        if ($this->started) {
            return true;
        }

<<<<<<< HEAD
        if (PHP_VERSION_ID >= 50400 && \PHP_SESSION_ACTIVE === session_status()) {
            throw new \RuntimeException('Failed to start the session: already started by PHP.');
        }

        if (PHP_VERSION_ID < 50400 && !$this->closed && isset($_SESSION) && session_id()) {
            // not 100% fool-proof, but is the most reliable way to determine if a session is active in PHP 5.3
            throw new \RuntimeException('Failed to start the session: already started by PHP ($_SESSION is set).');
        }

        if (ini_get('session.use_cookies') && headers_sent($file, $line)) {
=======
        if (\PHP_SESSION_ACTIVE === session_status()) {
            throw new \RuntimeException('Failed to start the session: already started by PHP.');
        }

        if (filter_var(ini_get('session.use_cookies'), \FILTER_VALIDATE_BOOLEAN) && headers_sent($file, $line)) {
>>>>>>> v2-test
            throw new \RuntimeException(sprintf('Failed to start the session because headers have already been sent by "%s" at line %d.', $file, $line));
        }

        // ok to try and start the session
        if (!session_start()) {
<<<<<<< HEAD
            throw new \RuntimeException('Failed to start the session');
        }

        $this->loadSession();
        if (!$this->saveHandler->isWrapper() && !$this->saveHandler->isSessionHandlerInterface()) {
            // This condition matches only PHP 5.3 with internal save handlers
            $this->saveHandler->setActive(true);
        }

=======
            throw new \RuntimeException('Failed to start the session.');
        }

        if (null !== $this->emulateSameSite) {
            $originalCookie = SessionUtils::popSessionCookie(session_name(), session_id());
            if (null !== $originalCookie) {
                header(sprintf('%s; SameSite=%s', $originalCookie, $this->emulateSameSite), false);
            }
        }

        $this->loadSession();

>>>>>>> v2-test
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->saveHandler->getId();
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function setId($id)
=======
    public function setId(string $id)
>>>>>>> v2-test
    {
        $this->saveHandler->setId($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->saveHandler->getName();
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function setName($name)
=======
    public function setName(string $name)
>>>>>>> v2-test
    {
        $this->saveHandler->setName($name);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function regenerate($destroy = false, $lifetime = null)
    {
        // Cannot regenerate the session ID for non-active sessions.
        if (PHP_VERSION_ID >= 50400 && \PHP_SESSION_ACTIVE !== session_status()) {
            return false;
        }

        // Check if session ID exists in PHP 5.3
        if (PHP_VERSION_ID < 50400 && '' === session_id()) {
            return false;
        }

        if (null !== $lifetime) {
            ini_set('session.cookie_lifetime', $lifetime);
=======
    public function regenerate(bool $destroy = false, int $lifetime = null)
    {
        // Cannot regenerate the session ID for non-active sessions.
        if (\PHP_SESSION_ACTIVE !== session_status()) {
            return false;
        }

        if (headers_sent()) {
            return false;
        }

        if (null !== $lifetime && $lifetime != ini_get('session.cookie_lifetime')) {
            $this->save();
            ini_set('session.cookie_lifetime', $lifetime);
            $this->start();
>>>>>>> v2-test
        }

        if ($destroy) {
            $this->metadataBag->stampNew();
        }

        $isRegenerated = session_regenerate_id($destroy);

<<<<<<< HEAD
        // The reference to $_SESSION in session bags is lost in PHP7 and we need to re-create it.
        // @see https://bugs.php.net/bug.php?id=70013
        $this->loadSession();
=======
        if (null !== $this->emulateSameSite) {
            $originalCookie = SessionUtils::popSessionCookie(session_name(), session_id());
            if (null !== $originalCookie) {
                header(sprintf('%s; SameSite=%s', $originalCookie, $this->emulateSameSite), false);
            }
        }
>>>>>>> v2-test

        return $isRegenerated;
    }

    /**
     * {@inheritdoc}
     */
    public function save()
    {
<<<<<<< HEAD
        session_write_close();

        if (!$this->saveHandler->isWrapper() && !$this->saveHandler->isSessionHandlerInterface()) {
            // This condition matches only PHP 5.3 with internal save handlers
            $this->saveHandler->setActive(false);
=======
        // Store a copy so we can restore the bags in case the session was not left empty
        $session = $_SESSION;

        foreach ($this->bags as $bag) {
            if (empty($_SESSION[$key = $bag->getStorageKey()])) {
                unset($_SESSION[$key]);
            }
        }
        if ([$key = $this->metadataBag->getStorageKey()] === array_keys($_SESSION)) {
            unset($_SESSION[$key]);
        }

        // Register error handler to add information about the current save handler
        $previousHandler = set_error_handler(function ($type, $msg, $file, $line) use (&$previousHandler) {
            if (\E_WARNING === $type && 0 === strpos($msg, 'session_write_close():')) {
                $handler = $this->saveHandler instanceof SessionHandlerProxy ? $this->saveHandler->getHandler() : $this->saveHandler;
                $msg = sprintf('session_write_close(): Failed to write session data with "%s" handler', \get_class($handler));
            }

            return $previousHandler ? $previousHandler($type, $msg, $file, $line) : false;
        });

        try {
            session_write_close();
        } finally {
            restore_error_handler();

            // Restore only if not empty
            if ($_SESSION) {
                $_SESSION = $session;
            }
>>>>>>> v2-test
        }

        $this->closed = true;
        $this->started = false;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        // clear out the bags
        foreach ($this->bags as $bag) {
            $bag->clear();
        }

        // clear out the session
<<<<<<< HEAD
        $_SESSION = array();
=======
        $_SESSION = [];
>>>>>>> v2-test

        // reconnect the bags to the session
        $this->loadSession();
    }

    /**
     * {@inheritdoc}
     */
    public function registerBag(SessionBagInterface $bag)
    {
        if ($this->started) {
            throw new \LogicException('Cannot register a bag when the session is already started.');
        }

        $this->bags[$bag->getName()] = $bag;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function getBag($name)
    {
        if (!isset($this->bags[$name])) {
            throw new \InvalidArgumentException(sprintf('The SessionBagInterface %s is not registered.', $name));
        }

        if ($this->saveHandler->isActive() && !$this->started) {
=======
    public function getBag(string $name)
    {
        if (!isset($this->bags[$name])) {
            throw new \InvalidArgumentException(sprintf('The SessionBagInterface "%s" is not registered.', $name));
        }

        if (!$this->started && $this->saveHandler->isActive()) {
>>>>>>> v2-test
            $this->loadSession();
        } elseif (!$this->started) {
            $this->start();
        }

        return $this->bags[$name];
    }

<<<<<<< HEAD
    /**
     * Sets the MetadataBag.
     *
     * @param MetadataBag $metaBag
     */
=======
>>>>>>> v2-test
    public function setMetadataBag(MetadataBag $metaBag = null)
    {
        if (null === $metaBag) {
            $metaBag = new MetadataBag();
        }

        $this->metadataBag = $metaBag;
    }

    /**
     * Gets the MetadataBag.
     *
     * @return MetadataBag
     */
    public function getMetadataBag()
    {
        return $this->metadataBag;
    }

    /**
     * {@inheritdoc}
     */
    public function isStarted()
    {
        return $this->started;
    }

    /**
     * Sets session.* ini variables.
     *
     * For convenience we omit 'session.' from the beginning of the keys.
     * Explicitly ignores other ini keys.
     *
<<<<<<< HEAD
     * @param array $options Session ini directives array(key => value)
     *
     * @see http://php.net/session.configuration
     */
    public function setOptions(array $options)
    {
        $validOptions = array_flip(array(
            'cache_limiter', 'cookie_domain', 'cookie_httponly',
            'cookie_lifetime', 'cookie_path', 'cookie_secure',
            'entropy_file', 'entropy_length', 'gc_divisor',
            'gc_maxlifetime', 'gc_probability', 'hash_bits_per_character',
            'hash_function', 'name', 'referer_check',
            'serialize_handler', 'use_cookies',
            'use_only_cookies', 'use_trans_sid', 'upload_progress.enabled',
            'upload_progress.cleanup', 'upload_progress.prefix', 'upload_progress.name',
            'upload_progress.freq', 'upload_progress.min-freq', 'url_rewriter.tags',
        ));

        foreach ($options as $key => $value) {
            if (isset($validOptions[$key])) {
                ini_set('session.'.$key, $value);
=======
     * @param array $options Session ini directives [key => value]
     *
     * @see https://php.net/session.configuration
     */
    public function setOptions(array $options)
    {
        if (headers_sent() || \PHP_SESSION_ACTIVE === session_status()) {
            return;
        }

        $validOptions = array_flip([
            'cache_expire', 'cache_limiter', 'cookie_domain', 'cookie_httponly',
            'cookie_lifetime', 'cookie_path', 'cookie_secure', 'cookie_samesite',
            'gc_divisor', 'gc_maxlifetime', 'gc_probability',
            'lazy_write', 'name', 'referer_check',
            'serialize_handler', 'use_strict_mode', 'use_cookies',
            'use_only_cookies', 'use_trans_sid', 'upload_progress.enabled',
            'upload_progress.cleanup', 'upload_progress.prefix', 'upload_progress.name',
            'upload_progress.freq', 'upload_progress.min_freq', 'url_rewriter.tags',
            'sid_length', 'sid_bits_per_character', 'trans_sid_hosts', 'trans_sid_tags',
        ]);

        foreach ($options as $key => $value) {
            if (isset($validOptions[$key])) {
                if ('cookie_samesite' === $key && \PHP_VERSION_ID < 70300) {
                    // PHP < 7.3 does not support same_site cookies. We will emulate it in
                    // the start() method instead.
                    $this->emulateSameSite = $value;
                    continue;
                }
                ini_set('url_rewriter.tags' !== $key ? 'session.'.$key : $key, $value);
>>>>>>> v2-test
            }
        }
    }

    /**
     * Registers session save handler as a PHP session handler.
     *
     * To use internal PHP session save handlers, override this method using ini_set with
     * session.save_handler and session.save_path e.g.
     *
     *     ini_set('session.save_handler', 'files');
     *     ini_set('session.save_path', '/tmp');
     *
<<<<<<< HEAD
     * or pass in a NativeSessionHandler instance which configures session.save_handler in the
     * constructor, for a template see NativeFileSessionHandler or use handlers in
     * composer package drak/native-session
     *
     * @see http://php.net/session-set-save-handler
     * @see http://php.net/sessionhandlerinterface
     * @see http://php.net/sessionhandler
     * @see http://github.com/drak/NativeSession
     *
     * @param AbstractProxy|NativeSessionHandler|\SessionHandlerInterface|null $saveHandler
=======
     * or pass in a \SessionHandler instance which configures session.save_handler in the
     * constructor, for a template see NativeFileSessionHandler.
     *
     * @see https://php.net/session-set-save-handler
     * @see https://php.net/sessionhandlerinterface
     * @see https://php.net/sessionhandler
     *
     * @param AbstractProxy|\SessionHandlerInterface|null $saveHandler
>>>>>>> v2-test
     *
     * @throws \InvalidArgumentException
     */
    public function setSaveHandler($saveHandler = null)
    {
        if (!$saveHandler instanceof AbstractProxy &&
<<<<<<< HEAD
            !$saveHandler instanceof NativeSessionHandler &&
            !$saveHandler instanceof \SessionHandlerInterface &&
            null !== $saveHandler) {
            throw new \InvalidArgumentException('Must be instance of AbstractProxy or NativeSessionHandler; implement \SessionHandlerInterface; or be null.');
=======
            !$saveHandler instanceof \SessionHandlerInterface &&
            null !== $saveHandler) {
            throw new \InvalidArgumentException('Must be instance of AbstractProxy; implement \SessionHandlerInterface; or be null.');
>>>>>>> v2-test
        }

        // Wrap $saveHandler in proxy and prevent double wrapping of proxy
        if (!$saveHandler instanceof AbstractProxy && $saveHandler instanceof \SessionHandlerInterface) {
            $saveHandler = new SessionHandlerProxy($saveHandler);
        } elseif (!$saveHandler instanceof AbstractProxy) {
<<<<<<< HEAD
            $saveHandler = PHP_VERSION_ID >= 50400 ?
                new SessionHandlerProxy(new \SessionHandler()) : new NativeProxy();
        }
        $this->saveHandler = $saveHandler;

        if ($this->saveHandler instanceof \SessionHandlerInterface) {
            if (PHP_VERSION_ID >= 50400) {
                session_set_save_handler($this->saveHandler, false);
            } else {
                session_set_save_handler(
                    array($this->saveHandler, 'open'),
                    array($this->saveHandler, 'close'),
                    array($this->saveHandler, 'read'),
                    array($this->saveHandler, 'write'),
                    array($this->saveHandler, 'destroy'),
                    array($this->saveHandler, 'gc')
                );
            }
=======
            $saveHandler = new SessionHandlerProxy(new StrictSessionHandler(new \SessionHandler()));
        }
        $this->saveHandler = $saveHandler;

        if (headers_sent() || \PHP_SESSION_ACTIVE === session_status()) {
            return;
        }

        if ($this->saveHandler instanceof SessionHandlerProxy) {
            session_set_save_handler($this->saveHandler, false);
>>>>>>> v2-test
        }
    }

    /**
     * Load the session with attributes.
     *
     * After starting the session, PHP retrieves the session from whatever handlers
     * are set to (either PHP's internal, or a custom save handler set with session_set_save_handler()).
     * PHP takes the return value from the read() handler, unserializes it
     * and populates $_SESSION with the result automatically.
<<<<<<< HEAD
     *
     * @param array|null $session
=======
>>>>>>> v2-test
     */
    protected function loadSession(array &$session = null)
    {
        if (null === $session) {
            $session = &$_SESSION;
        }

<<<<<<< HEAD
        $bags = array_merge($this->bags, array($this->metadataBag));

        foreach ($bags as $bag) {
            $key = $bag->getStorageKey();
            $session[$key] = isset($session[$key]) ? $session[$key] : array();
=======
        $bags = array_merge($this->bags, [$this->metadataBag]);

        foreach ($bags as $bag) {
            $key = $bag->getStorageKey();
            $session[$key] = isset($session[$key]) && \is_array($session[$key]) ? $session[$key] : [];
>>>>>>> v2-test
            $bag->initialize($session[$key]);
        }

        $this->started = true;
        $this->closed = false;
    }
}
