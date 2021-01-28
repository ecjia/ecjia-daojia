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
 *
 * @internal
 */
class FormFieldRegistry
{
    private $fields = [];

    private $base = '';

    /**
     * Adds a field to the registry.
     */
    public function add(FormField $field)
    {
        $segments = $this->getSegments($field->getName());

        $target = &$this->fields;
        while ($segments) {
            if (!\is_array($target)) {
                $target = [];
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
     * Removes a field based on the fully qualifed name and its children from the registry.
     */
    public function remove(string $name)
    {
        $segments = $this->getSegments($name);
        $target = &$this->fields;
        while (\count($segments) > 1) {
            $path = array_shift($segments);
            if (!\is_array($target) || !\array_key_exists($path, $target)) {
                return;
            }
            $target = &$target[$path];
        }
        unset($target[array_shift($segments)]);
    }

    /**
     * Returns the value of the field based on the fully qualifed name and its children.
     *
     * @return FormField|FormField[]|FormField[][] The value of the field
     *
     * @throws \InvalidArgumentException if the field does not exist
     */
    public function &get(string $name)
    {
        $segments = $this->getSegments($name);
        $target = &$this->fields;
        while ($segments) {
            $path = array_shift($segments);
            if (!\is_array($target) || !\array_key_exists($path, $target)) {
                throw new \InvalidArgumentException(sprintf('Unreachable field "%s".', $path));
            }
            $target = &$target[$path];
        }

        return $target;
    }

    /**
     * Tests whether the form has the given field based on the fully qualified name.
     *
     * @return bool Whether the form has the given field
     */
    public function has(string $name): bool
    {
        try {
            $this->get($name);

            return true;
        } catch (\InvalidArgumentException $e) {
            return false;
        }
    }

    /**
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
                $this->set($k, $v);
            }
        } else {
            throw new \InvalidArgumentException(sprintf('Cannot set value on a compound field "%s".', $name));
        }
    }

    /**
     * Returns the list of field with their value.
     *
     * @return FormField[] The list of fields as [string] Fully qualified name => (mixed) value)
     */
    public function all(): array
    {
        return $this->walk($this->fields, $this->base);
    }

    /**
     * Transforms a PHP array in a list of fully qualified name / value.
     */
    private function walk(array $array, ?string $base = '', array &$output = []): array
    {
        foreach ($array as $k => $v) {
            $path = empty($base) ? $k : sprintf('%s[%s]', $base, $k);
            if (\is_array($v)) {
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
     *     getSegments('base[foo][3][]') = ['base', 'foo, '3', ''];
     *
     * @return string[] The list of segments
     */
    private function getSegments(string $name): array
    {
        if (preg_match('/^(?P<base>[^[]+)(?P<extra>(\[.*)|$)/', $name, $m)) {
            $segments = [$m['base']];
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

        return [$name];
    }
}
