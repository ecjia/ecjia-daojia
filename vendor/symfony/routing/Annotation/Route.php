<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Annotation;

/**
 * Annotation class for @Route().
 *
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 *
 * @author Fabien Potencier <fabien@symfony.com>
<<<<<<< HEAD
 */
class Route
{
    private $path;
    private $name;
    private $requirements = array();
    private $options = array();
    private $defaults = array();
    private $host;
    private $methods = array();
    private $schemes = array();
    private $condition;

    /**
     * Constructor.
     *
     * @param array $data An array of key/value parameters
     *
     * @throws \BadMethodCallException
     */
    public function __construct(array $data)
    {
        if (isset($data['value'])) {
            $data['path'] = $data['value'];
            unset($data['value']);
        }

        foreach ($data as $key => $value) {
            $method = 'set'.str_replace('_', '', $key);
            if (!method_exists($this, $method)) {
                throw new \BadMethodCallException(sprintf('Unknown property "%s" on annotation "%s".', $key, get_class($this)));
=======
 * @author Alexander M. Turek <me@derrabus.de>
 */
#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class Route
{
    private $path;
    private $localizedPaths = [];
    private $name;
    private $requirements = [];
    private $options = [];
    private $defaults = [];
    private $host;
    private $methods = [];
    private $schemes = [];
    private $condition;
    private $priority;

    /**
     * @param array|string      $data         data array managed by the Doctrine Annotations library or the path
     * @param array|string|null $path
     * @param string[]          $requirements
     * @param string[]          $methods
     * @param string[]          $schemes
     *
     * @throws \BadMethodCallException
     */
    public function __construct(
        $data = [],
        $path = null,
        string $name = null,
        array $requirements = [],
        array $options = [],
        array $defaults = [],
        string $host = null,
        array $methods = [],
        array $schemes = [],
        string $condition = null,
        int $priority = null,
        string $locale = null,
        string $format = null,
        bool $utf8 = null,
        bool $stateless = null
    ) {
        if (\is_string($data)) {
            $data = ['path' => $data];
        } elseif (!\is_array($data)) {
            throw new \TypeError(sprintf('"%s": Argument $data is expected to be a string or array, got "%s".', __METHOD__, get_debug_type($data)));
        }
        if (null !== $path && !\is_string($path) && !\is_array($path)) {
            throw new \TypeError(sprintf('"%s": Argument $path is expected to be a string, array or null, got "%s".', __METHOD__, get_debug_type($path)));
        }

        $data['path'] = $data['path'] ?? $path;
        $data['name'] = $data['name'] ?? $name;
        $data['requirements'] = $data['requirements'] ?? $requirements;
        $data['options'] = $data['options'] ?? $options;
        $data['defaults'] = $data['defaults'] ?? $defaults;
        $data['host'] = $data['host'] ?? $host;
        $data['methods'] = $data['methods'] ?? $methods;
        $data['schemes'] = $data['schemes'] ?? $schemes;
        $data['condition'] = $data['condition'] ?? $condition;
        $data['priority'] = $data['priority'] ?? $priority;
        $data['locale'] = $data['locale'] ?? $locale;
        $data['format'] = $data['format'] ?? $format;
        $data['utf8'] = $data['utf8'] ?? $utf8;
        $data['stateless'] = $data['stateless'] ?? $stateless;

        $data = array_filter($data, static function ($value): bool {
            return null !== $value;
        });

        if (isset($data['localized_paths'])) {
            throw new \BadMethodCallException(sprintf('Unknown property "localized_paths" on annotation "%s".', static::class));
        }

        if (isset($data['value'])) {
            $data[\is_array($data['value']) ? 'localized_paths' : 'path'] = $data['value'];
            unset($data['value']);
        }

        if (isset($data['path']) && \is_array($data['path'])) {
            $data['localized_paths'] = $data['path'];
            unset($data['path']);
        }

        if (isset($data['locale'])) {
            $data['defaults']['_locale'] = $data['locale'];
            unset($data['locale']);
        }

        if (isset($data['format'])) {
            $data['defaults']['_format'] = $data['format'];
            unset($data['format']);
        }

        if (isset($data['utf8'])) {
            $data['options']['utf8'] = filter_var($data['utf8'], \FILTER_VALIDATE_BOOLEAN) ?: false;
            unset($data['utf8']);
        }

        if (isset($data['stateless'])) {
            $data['defaults']['_stateless'] = filter_var($data['stateless'], \FILTER_VALIDATE_BOOLEAN) ?: false;
            unset($data['stateless']);
        }

        foreach ($data as $key => $value) {
            $method = 'set'.str_replace('_', '', $key);
            if (!method_exists($this, $method)) {
                throw new \BadMethodCallException(sprintf('Unknown property "%s" on annotation "%s".', $key, static::class));
>>>>>>> v2-test
            }
            $this->$method($value);
        }
    }

<<<<<<< HEAD
    /**
     * @deprecated since version 2.2, to be removed in 3.0. Use setPath instead.
     */
    public function setPattern($pattern)
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 2.2 and will be removed in 3.0. Use the setPath() method instead and use the "path" option instead of the "pattern" option in the route definition.', E_USER_DEPRECATED);

        $this->path = $pattern;
    }

    /**
     * @deprecated since version 2.2, to be removed in 3.0. Use getPath instead.
     */
    public function getPattern()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 2.2 and will be removed in 3.0. Use the getPath() method instead and use the "path" option instead of the "pattern" option in the route definition.', E_USER_DEPRECATED);

        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
=======
    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setLocalizedPaths(array $localizedPaths)
    {
        $this->localizedPaths = $localizedPaths;
    }

    public function getLocalizedPaths(): array
    {
        return $this->localizedPaths;
>>>>>>> v2-test
    }

    public function setHost($pattern)
    {
        $this->host = $pattern;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setRequirements($requirements)
    {
<<<<<<< HEAD
        if (isset($requirements['_method'])) {
            if (0 === count($this->methods)) {
                $this->methods = explode('|', $requirements['_method']);
            }

            @trigger_error('The "_method" requirement is deprecated since version 2.2 and will be removed in 3.0. Use the "methods" option instead.', E_USER_DEPRECATED);
        }

        if (isset($requirements['_scheme'])) {
            if (0 === count($this->schemes)) {
                $this->schemes = explode('|', $requirements['_scheme']);
            }

            @trigger_error('The "_scheme" requirement is deprecated since version 2.2 and will be removed in 3.0. Use the "schemes" option instead.', E_USER_DEPRECATED);
        }

=======
>>>>>>> v2-test
        $this->requirements = $requirements;
    }

    public function getRequirements()
    {
        return $this->requirements;
    }

    public function setOptions($options)
    {
        $this->options = $options;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setDefaults($defaults)
    {
        $this->defaults = $defaults;
    }

    public function getDefaults()
    {
        return $this->defaults;
    }

    public function setSchemes($schemes)
    {
<<<<<<< HEAD
        $this->schemes = is_array($schemes) ? $schemes : array($schemes);
=======
        $this->schemes = \is_array($schemes) ? $schemes : [$schemes];
>>>>>>> v2-test
    }

    public function getSchemes()
    {
        return $this->schemes;
    }

    public function setMethods($methods)
    {
<<<<<<< HEAD
        $this->methods = is_array($methods) ? $methods : array($methods);
=======
        $this->methods = \is_array($methods) ? $methods : [$methods];
>>>>>>> v2-test
    }

    public function getMethods()
    {
        return $this->methods;
    }

    public function setCondition($condition)
    {
        $this->condition = $condition;
    }

    public function getCondition()
    {
        return $this->condition;
    }
<<<<<<< HEAD
=======

    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }
>>>>>>> v2-test
}
