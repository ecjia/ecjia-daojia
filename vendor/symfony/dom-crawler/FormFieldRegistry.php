<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DomCrawler;

use Symfony\Component\DomCrawler\Field\FormField;

/**
 * This is an internal class that must not be used directly.
<<<<<<< HEAD
 */
class FormFieldRegistry
{
    private $fields = array();

    private $base;

    /**
     * Adds a field to the registry.
     *
     * @param FormField $field The field
=======
 *
 * @internal
 */
class FormFieldRegistry
{
    private $fields = [];

    private $base = '';

    /**
     * Adds a field to the registry.
>>>>>>> v2-test
     */
    public function add(FormField $field)
    {
        $segments = $this->getSegments($field->getName());

        $target = &$this->fields;
        while ($segments) {
<<<<<<< HEAD
            if (!is_array($target)) {
                $target = array();
=======
            if (!\is_array($target)) {
                $target = [];
>>>>>>> v2-test
            }
            $path = array_shift($segments);
            if ('' === $path) {
                $target = &$target[];
            } else {
                $target = &$target[$path];
            }
        }
        $target = $field;
    }

    /**
<<<<<<< HEAD
     * Removes a field and its children from the registry.
     *
     * @param string $name The fully qualified name of the base field
     */
    public function remove($name)
    {
        $segments = $this->getSegments($name);
        $target = &$this->fields;
        while (count($segments) > 1) {
            $path = array_shift($segments);
            if (!array_key_exists($path, $target)) {
=======
     * Removes a field based on the fully qualifed name and its children from the registry.
     */
    public function remove(string $name)
    {
        $segments = $this->getSegments($name);
        $target = &$this->fields;
        while (\count($segments) > 1) {
            $path = array_shift($segments);
            if (!\is_array($target) || !\array_key_exists($path, $target)) {
>>>>>>> v2-test
                return;
            }
            $target = &$target[$path];
        }
        unset($target[array_shift($segments)]);
    }

    /**
<<<<<<< HEAD
     * Returns the value of the field and its children.
     *
     * @param string $name The fully qualified name of the field
     *
     * @return mixed The value of the field
     *
     * @throws \InvalidArgumentException if the field does not exist
     */
    public function &get($name)
=======
     * Returns the value of the field based on the fully qualifed name and its children.
     *
     * @return FormField|FormField[]|FormField[][] The value of the field
     *
     * @throws \InvalidArgumentException if the field does not exist
     */
    public function &get(string $name)
>>>>>>> v2-test
    {
        $segments = $this->getSegments($name);
        $target = &$this->fields;
        while ($segments) {
            $path = array_shift($segments);
<<<<<<< HEAD
            if (!array_key_exists($path, $target)) {
                throw new \InvalidArgumentException(sprintf('Unreachable field "%s"', $path));
=======
            if (!\is_array($target) || !\array_key_exists($path, $target)) {
                throw new \InvalidArgumentException(sprintf('Unreachable field "%s".', $path));
>>>>>>> v2-test
            }
            $target = &$target[$path];
        }

        return $target;
    }

    /**
<<<<<<< HEAD
     * Tests whether the form has the given field.
     *
     * @param string $name The fully qualified name of the field
     *
     * @return bool Whether the form has the given field
     */
    public function has($name)
=======
     * Tests whether the form has the given field based on the fully qualified name.
     *
     * @return bool Whether the form has the given field
     */
    public function has(string $name): bool
>>>>>>> v2-test
    {
        try {
            $this->get($name);

            return true;
        } catch (\InvalidArgumentException $e) {
            return false;
        }
    }

    /**
<<<<<<< HEAD
     * Set the value of a field and its children.
     *
     * @param string $name  The fully qualified name of the field
     * @param mixed  $value The value
     *
     * @throws \InvalidArgumentException if the field does not exist
     */
    public function set($name, $value)
    {
        $target = &$this->get($name);
        if ((!is_array($value) && $target instanceof Field\FormField) || $target instanceof Field\ChoiceFormField) {
            $target->setValue($value);
        } elseif (is_array($value)) {
            $fields = self::create($name, $value);
            foreach ($fields->all() as $k => $v) {
=======
     * Set the value of a field based on the fully qualified name and its children.
     *
     * @param mixed $value The value
     *
     * @throws \InvalidArgumentException if the field does not exist
     */
    public function set(string $name, $value)
    {
        $target = &$this->get($name);
        if ((!\is_array($value) && $target instanceof Field\FormField) || $target instanceof Field\ChoiceFormField) {
            $target->setValue($value);
        } elseif (\is_array($value)) {
            $registry = new static();
            $registry->base = $name;
            $registry->fields = $value;
            foreach ($registry->all() as $k => $v) {
>>>>>>> v2-test
                $this->set($k, $v);
            }
        } else {
            throw new \InvalidArgumentException(sprintf('Cannot set value on a compound field "%s".', $name));
        }
    }

    /**
     * Returns the list of field with their value.
     *
<<<<<<< HEAD
     * @return FormField[] The list of fields as array((string) Fully qualified name => (mixed) value)
     */
    public function all()
=======
     * @return FormField[] The list of fields as [string] Fully qualified name => (mixed) value)
     */
    public function all(): array
>>>>>>> v2-test
    {
        return $this->walk($this->fields, $this->base);
    }

    /**
<<<<<<< HEAD
     * Creates an instance of the class.
     *
     * This function is made private because it allows overriding the $base and
     * the $values properties without any type checking.
     *
     * @param string $base   The fully qualified name of the base field
     * @param array  $values The values of the fields
     *
     * @return FormFieldRegistry
     */
    private static function create($base, array $values)
    {
        $registry = new static();
        $registry->base = $base;
        $registry->fields = $values;

        return $registry;
    }

    /**
     * Transforms a PHP array in a list of fully qualified name / value.
     *
     * @param array  $array  The PHP array
     * @param string $base   The name of the base field
     * @param array  $output The initial values
     *
     * @return array The list of fields as array((string) Fully qualified name => (mixed) value)
     */
    private function walk(array $array, $base = '', array &$output = array())
    {
        foreach ($array as $k => $v) {
            $path = empty($base) ? $k : sprintf('%s[%s]', $base, $k);
            if (is_array($v)) {
=======
     * Transforms a PHP array in a list of fully qualified name / value.
     */
    private function walk(array $array, ?string $base = '', array &$output = []): array
    {
        foreach ($array as $k => $v) {
            $path = empty($base) ? $k : sprintf('%s[%s]', $base, $k);
            if (\is_array($v)) {
>>>>>>> v2-test
                $this->walk($v, $path, $output);
            } else {
                $output[$path] = $v;
            }
        }

        return $output;
    }

    /**
     * Splits a field name into segments as a web browser would do.
     *
<<<<<<< HEAD
     * <code>
     *     getSegments('base[foo][3][]') = array('base', 'foo, '3', '');
     * </code>
     *
     * @param string $name The name of the field
     *
     * @return string[] The list of segments
     */
    private function getSegments($name)
    {
        if (preg_match('/^(?P<base>[^[]+)(?P<extra>(\[.*)|$)/', $name, $m)) {
            $segments = array($m['base']);
=======
     *     getSegments('base[foo][3][]') = ['base', 'foo, '3', ''];
     *
     * @return string[] The list of segments
     */
    private function getSegments(string $name): array
    {
        if (preg_match('/^(?P<base>[^[]+)(?P<extra>(\[.*)|$)/', $name, $m)) {
            $segments = [$m['base']];
>>>>>>> v2-test
            while (!empty($m['extra'])) {
                $extra = $m['extra'];
                if (preg_match('/^\[(?P<segment>.*?)\](?P<extra>.*)$/', $extra, $m)) {
                    $segments[] = $m['segment'];
                } else {
                    $segments[] = $extra;
                }
            }

            return $segments;
        }

<<<<<<< HEAD
        return array($name);
=======
        return [$name];
>>>>>>> v2-test
    }
}
