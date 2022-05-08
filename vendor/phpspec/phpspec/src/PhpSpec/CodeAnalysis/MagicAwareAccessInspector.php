<?php

/*
 * This file is part of PhpSpec, A php toolset to drive emergent
 * design by specification.
 *
 * (c) Marcello Duarte <marcello.duarte@gmail.com>
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpSpec\CodeAnalysis;

<<<<<<< HEAD
final class MagicAwareAccessInspector implements AccessInspectorInterface
{
    /**
     * @var AccessInspectorInterface
=======
final class MagicAwareAccessInspector implements AccessInspector
{
    /**
     * @var AccessInspector
>>>>>>> v2-test
     */
    private $accessInspector;

    /**
<<<<<<< HEAD
     * @param AccessInspectorInterface $accessInspector
     */
    public function __construct(AccessInspectorInterface $accessInspector)
=======
     * @param AccessInspector $accessInspector
     */
    public function __construct(AccessInspector $accessInspector)
>>>>>>> v2-test
    {
        $this->accessInspector = $accessInspector;
    }

    /**
     * @param object $object
<<<<<<< HEAD
     * @param string $property
     *
     * @return bool
     */
    public function isPropertyReadable($object, $property)
=======
     */
    public function isPropertyReadable($object, string $property): bool
>>>>>>> v2-test
    {
        return method_exists($object, '__get') || $this->accessInspector->isPropertyReadable($object, $property);
    }

    /**
     * @param object $object
<<<<<<< HEAD
     * @param string $property
     *
     * @return bool
     */
    public function isPropertyWritable($object, $property)
=======
     */
    public function isPropertyWritable($object, string $property): bool
>>>>>>> v2-test
    {
        return method_exists($object, '__set') || $this->accessInspector->isPropertyWritable($object, $property);
    }

    /**
     * @param object $object
<<<<<<< HEAD
     * @param string $method
     *
     * @return bool
     */
    public function isMethodCallable($object, $method)
=======
     */
    public function isMethodCallable($object, string $method): bool
>>>>>>> v2-test
    {
        return method_exists($object, '__call') || $this->accessInspector->isMethodCallable($object, $method);
    }
}
