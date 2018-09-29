<?php

namespace Royalcms\Component\Session;

interface StoreInterface
{
    
    /**
     * Starts the session storage.
     *
     * @return bool True if session started
     *
     * @throws \RuntimeException If session fails to start.
     */
    public function start();
    
    
    /**
     * Checks if the session was started.
     *
     * @return bool
     */
    public function isStarted();
    
    
    /**
     * Returns the session ID.
     *
     * @return string The session ID
     */
    public function getId();
    
    
    /**
     * Sets the session ID.
     *
     * @param string $id
     */
    public function setId($id);
    
    
    /**
     * Returns the session name.
     *
     * @return mixed The session name
     */
    public function getName();
    
    
    /**
     * Sets the session name.
     *
     * @param string $name
     */
    public function setName($name);
    
    
    /**
     * Sets an attribute.
     *
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value);
    
    /**
     * Returns an attribute.
     *
     * @param string $name The attribute name
     * @param mixed $default The default value if not found
     *
     * @return mixed
     */
    public function get($name, $default = null);
    
    /**
     * Returns attributes.
     *
     * @return array Attributes
     */
    public function all();
    
    
    /**
     * Sets attributes.
     *
     * @param array $attributes Attributes
    */
    public function replace(array $attributes);
    
    /**
     * Checks if an attribute is defined.
     *
     * @param string $name The attribute name
     *
     * @return bool true if the attribute is defined, false otherwise
     */
    public function has($name);
    
    /**
     * Removes an attribute.
     *
     * @param string $name
     *
     * @return mixed The removed value or null when it does not exist
     */
    public function remove($name);
    
    
    /**
     * Clears all attributes.
     */
    public function clear();
    
    
    /**
     * Get the session handler instance.
     *
     * @return \SessionHandlerInterface
     */
    public function getHandler();
    
}
