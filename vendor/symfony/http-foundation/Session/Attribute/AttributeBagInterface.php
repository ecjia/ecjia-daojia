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

use Symfony\Component\HttpFoundation\Session\SessionBagInterface;

/**
 * Attributes store.
 *
 * @author Drak <drak@zikula.org>
 */
interface AttributeBagInterface extends SessionBagInterface
{
    /**
     * Checks if an attribute is defined.
     *
<<<<<<< HEAD
     * @param string $name The attribute name
     *
     * @return bool true if the attribute is defined, false otherwise
     */
    public function has($name);
=======
     * @return bool true if the attribute is defined, false otherwise
     */
    public function has(string $name);
>>>>>>> v2-test

    /**
     * Returns an attribute.
     *
<<<<<<< HEAD
     * @param string $name    The attribute name
     * @param mixed  $default The default value if not found
     *
     * @return mixed
     */
    public function get($name, $default = null);
=======
     * @param mixed $default The default value if not found
     *
     * @return mixed
     */
    public function get(string $name, $default = null);
>>>>>>> v2-test

    /**
     * Sets an attribute.
     *
<<<<<<< HEAD
     * @param string $name
     * @param mixed  $value
     */
    public function set($name, $value);
=======
     * @param mixed $value
     */
    public function set(string $name, $value);
>>>>>>> v2-test

    /**
     * Returns attributes.
     *
<<<<<<< HEAD
     * @return array Attributes
     */
    public function all();

    /**
     * Sets attributes.
     *
     * @param array $attributes Attributes
     */
=======
     * @return array
     */
    public function all();

>>>>>>> v2-test
    public function replace(array $attributes);

    /**
     * Removes an attribute.
     *
<<<<<<< HEAD
     * @param string $name
     *
     * @return mixed The removed value or null when it does not exist
     */
    public function remove($name);
=======
     * @return mixed The removed value or null when it does not exist
     */
    public function remove(string $name);
>>>>>>> v2-test
}
