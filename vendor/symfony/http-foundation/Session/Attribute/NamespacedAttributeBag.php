<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Session\Attribute;

/**
 * This class provides structured storage of session attributes using
 * a name spacing character in the key.
 *
 * @author Drak <drak@zikula.org>
 */
class NamespacedAttributeBag extends AttributeBag
{
<<<<<<< HEAD
    /**
     * Namespace character.
     *
     * @var string
     */
    private $namespaceCharacter;

    /**
     * Constructor.
     *
     * @param string $storageKey         Session storage key
     * @param string $namespaceCharacter Namespace character to use in keys
     */
    public function __construct($storageKey = '_sf2_attributes', $namespaceCharacter = '/')
=======
    private $namespaceCharacter;

    /**
     * @param string $storageKey         Session storage key
     * @param string $namespaceCharacter Namespace character to use in keys
     */
    public function __construct(string $storageKey = '_sf2_attributes', string $namespaceCharacter = '/')
>>>>>>> v2-test
    {
        $this->namespaceCharacter = $namespaceCharacter;
        parent::__construct($storageKey);
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function has($name)
=======
    public function has(string $name)
>>>>>>> v2-test
    {
        // reference mismatch: if fixed, re-introduced in array_key_exists; keep as it is
        $attributes = $this->resolveAttributePath($name);
        $name = $this->resolveKey($name);

        if (null === $attributes) {
            return false;
        }

<<<<<<< HEAD
        return array_key_exists($name, $attributes);
=======
        return \array_key_exists($name, $attributes);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function get($name, $default = null)
=======
    public function get(string $name, $default = null)
>>>>>>> v2-test
    {
        // reference mismatch: if fixed, re-introduced in array_key_exists; keep as it is
        $attributes = $this->resolveAttributePath($name);
        $name = $this->resolveKey($name);

        if (null === $attributes) {
            return $default;
        }

<<<<<<< HEAD
        return array_key_exists($name, $attributes) ? $attributes[$name] : $default;
=======
        return \array_key_exists($name, $attributes) ? $attributes[$name] : $default;
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function set($name, $value)
=======
    public function set(string $name, $value)
>>>>>>> v2-test
    {
        $attributes = &$this->resolveAttributePath($name, true);
        $name = $this->resolveKey($name);
        $attributes[$name] = $value;
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function remove($name)
=======
    public function remove(string $name)
>>>>>>> v2-test
    {
        $retval = null;
        $attributes = &$this->resolveAttributePath($name);
        $name = $this->resolveKey($name);
<<<<<<< HEAD
        if (null !== $attributes && array_key_exists($name, $attributes)) {
=======
        if (null !== $attributes && \array_key_exists($name, $attributes)) {
>>>>>>> v2-test
            $retval = $attributes[$name];
            unset($attributes[$name]);
        }

        return $retval;
    }

    /**
     * Resolves a path in attributes property and returns it as a reference.
     *
     * This method allows structured namespacing of session attributes.
     *
     * @param string $name         Key name
     * @param bool   $writeContext Write context, default false
     *
<<<<<<< HEAD
     * @return array
     */
    protected function &resolveAttributePath($name, $writeContext = false)
    {
        $array = &$this->attributes;
        $name = (strpos($name, $this->namespaceCharacter) === 0) ? substr($name, 1) : $name;
=======
     * @return array|null
     */
    protected function &resolveAttributePath(string $name, bool $writeContext = false)
    {
        $array = &$this->attributes;
        $name = (0 === strpos($name, $this->namespaceCharacter)) ? substr($name, 1) : $name;
>>>>>>> v2-test

        // Check if there is anything to do, else return
        if (!$name) {
            return $array;
        }

        $parts = explode($this->namespaceCharacter, $name);
<<<<<<< HEAD
        if (count($parts) < 2) {
=======
        if (\count($parts) < 2) {
>>>>>>> v2-test
            if (!$writeContext) {
                return $array;
            }

<<<<<<< HEAD
            $array[$parts[0]] = array();
=======
            $array[$parts[0]] = [];
>>>>>>> v2-test

            return $array;
        }

<<<<<<< HEAD
        unset($parts[count($parts) - 1]);

        foreach ($parts as $part) {
            if (null !== $array && !array_key_exists($part, $array)) {
                $array[$part] = $writeContext ? array() : null;
=======
        unset($parts[\count($parts) - 1]);

        foreach ($parts as $part) {
            if (null !== $array && !\array_key_exists($part, $array)) {
                if (!$writeContext) {
                    $null = null;

                    return $null;
                }

                $array[$part] = [];
>>>>>>> v2-test
            }

            $array = &$array[$part];
        }

        return $array;
    }

    /**
     * Resolves the key from the name.
     *
     * This is the last part in a dot separated string.
     *
<<<<<<< HEAD
     * @param string $name
     *
     * @return string
     */
    protected function resolveKey($name)
=======
     * @return string
     */
    protected function resolveKey(string $name)
>>>>>>> v2-test
    {
        if (false !== $pos = strrpos($name, $this->namespaceCharacter)) {
            $name = substr($name, $pos + 1);
        }

        return $name;
    }
}
