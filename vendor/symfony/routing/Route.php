<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing;

/**
 * A Route describes a route and its parameters.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Tobias Schultze <http://tobion.de>
 */
class Route implements \Serializable
{
<<<<<<< HEAD
    /**
     * @var string
     */
    private $path = '/';

    /**
     * @var string
     */
    private $host = '';

    /**
     * @var array
     */
    private $schemes = array();

    /**
     * @var array
     */
    private $methods = array();

    /**
     * @var array
     */
    private $defaults = array();

    /**
     * @var array
     */
    private $requirements = array();

    /**
     * @var array
     */
    private $options = array();

    /**
     * @var null|CompiledRoute
=======
    private $path = '/';
    private $host = '';
    private $schemes = [];
    private $methods = [];
    private $defaults = [];
    private $requirements = [];
    private $options = [];
    private $condition = '';

    /**
     * @var CompiledRoute|null
>>>>>>> v2-test
     */
    private $compiled;

    /**
<<<<<<< HEAD
     * @var string
     */
    private $condition = '';

    /**
=======
>>>>>>> v2-test
     * Constructor.
     *
     * Available options:
     *
     *  * compiler_class: A class name able to compile this route instance (RouteCompiler by default)
<<<<<<< HEAD
     *
     * @param string       $path         The path pattern to match
     * @param array        $defaults     An array of default parameter values
     * @param array        $requirements An array of requirements for parameters (regexes)
     * @param array        $options      An array of options
     * @param string       $host         The host pattern to match
     * @param string|array $schemes      A required URI scheme or an array of restricted schemes
     * @param string|array $methods      A required HTTP method or an array of restricted methods
     * @param string       $condition    A condition that should evaluate to true for the route to match
     */
    public function __construct($path, array $defaults = array(), array $requirements = array(), array $options = array(), $host = '', $schemes = array(), $methods = array(), $condition = '')
    {
        $this->setPath($path);
        $this->setDefaults($defaults);
        $this->setRequirements($requirements);
        $this->setOptions($options);
        $this->setHost($host);
        // The conditions make sure that an initial empty $schemes/$methods does not override the corresponding requirement.
        // They can be removed when the BC layer is removed.
        if ($schemes) {
            $this->setSchemes($schemes);
        }
        if ($methods) {
            $this->setMethods($methods);
        }
        $this->setCondition($condition);
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize(array(
=======
     *  * utf8:           Whether UTF-8 matching is enforced ot not
     *
     * @param string          $path         The path pattern to match
     * @param array           $defaults     An array of default parameter values
     * @param array           $requirements An array of requirements for parameters (regexes)
     * @param array           $options      An array of options
     * @param string|null     $host         The host pattern to match
     * @param string|string[] $schemes      A required URI scheme or an array of restricted schemes
     * @param string|string[] $methods      A required HTTP method or an array of restricted methods
     * @param string|null     $condition    A condition that should evaluate to true for the route to match
     */
    public function __construct(string $path, array $defaults = [], array $requirements = [], array $options = [], ?string $host = '', $schemes = [], $methods = [], ?string $condition = '')
    {
        $this->setPath($path);
        $this->addDefaults($defaults);
        $this->addRequirements($requirements);
        $this->setOptions($options);
        $this->setHost($host);
        $this->setSchemes($schemes);
        $this->setMethods($methods);
        $this->setCondition($condition);
    }

    public function __serialize(): array
    {
        return [
>>>>>>> v2-test
            'path' => $this->path,
            'host' => $this->host,
            'defaults' => $this->defaults,
            'requirements' => $this->requirements,
            'options' => $this->options,
            'schemes' => $this->schemes,
            'methods' => $this->methods,
            'condition' => $this->condition,
            'compiled' => $this->compiled,
<<<<<<< HEAD
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
=======
        ];
    }

    /**
     * @internal
     */
    final public function serialize(): string
    {
        return serialize($this->__serialize());
    }

    public function __unserialize(array $data): void
    {
>>>>>>> v2-test
        $this->path = $data['path'];
        $this->host = $data['host'];
        $this->defaults = $data['defaults'];
        $this->requirements = $data['requirements'];
        $this->options = $data['options'];
        $this->schemes = $data['schemes'];
        $this->methods = $data['methods'];

        if (isset($data['condition'])) {
            $this->condition = $data['condition'];
        }
        if (isset($data['compiled'])) {
            $this->compiled = $data['compiled'];
        }
    }

    /**
<<<<<<< HEAD
     * Returns the pattern for the path.
     *
     * @return string The pattern
     *
     * @deprecated since version 2.2, to be removed in 3.0. Use getPath instead.
     */
    public function getPattern()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 2.2 and will be removed in 3.0. Use the getPath() method instead.', E_USER_DEPRECATED);

        return $this->path;
    }

    /**
     * Sets the pattern for the path.
     *
     * This method implements a fluent interface.
     *
     * @param string $pattern The path pattern
     *
     * @return Route The current Route instance
     *
     * @deprecated since version 2.2, to be removed in 3.0. Use setPath instead.
     */
    public function setPattern($pattern)
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 2.2 and will be removed in 3.0. Use the setPath() method instead.', E_USER_DEPRECATED);

        return $this->setPath($pattern);
=======
     * @internal
     */
    final public function unserialize($serialized)
    {
        $this->__unserialize(unserialize($serialized));
>>>>>>> v2-test
    }

    /**
     * Returns the pattern for the path.
     *
     * @return string The path pattern
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets the pattern for the path.
     *
     * This method implements a fluent interface.
     *
<<<<<<< HEAD
     * @param string $pattern The path pattern
     *
     * @return Route The current Route instance
     */
    public function setPath($pattern)
    {
=======
     * @return $this
     */
    public function setPath(string $pattern)
    {
        $pattern = $this->extractInlineDefaultsAndRequirements($pattern);

>>>>>>> v2-test
        // A pattern must start with a slash and must not have multiple slashes at the beginning because the
        // generated path for this route would be confused with a network path, e.g. '//domain.com/path'.
        $this->path = '/'.ltrim(trim($pattern), '/');
        $this->compiled = null;

        return $this;
    }

    /**
     * Returns the pattern for the host.
     *
     * @return string The host pattern
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Sets the pattern for the host.
     *
     * This method implements a fluent interface.
     *
<<<<<<< HEAD
     * @param string $pattern The host pattern
     *
     * @return Route The current Route instance
     */
    public function setHost($pattern)
    {
        $this->host = (string) $pattern;
=======
     * @return $this
     */
    public function setHost(?string $pattern)
    {
        $this->host = $this->extractInlineDefaultsAndRequirements((string) $pattern);
>>>>>>> v2-test
        $this->compiled = null;

        return $this;
    }

    /**
     * Returns the lowercased schemes this route is restricted to.
     * So an empty array means that any scheme is allowed.
     *
<<<<<<< HEAD
     * @return array The schemes
=======
     * @return string[] The schemes
>>>>>>> v2-test
     */
    public function getSchemes()
    {
        return $this->schemes;
    }

    /**
     * Sets the schemes (e.g. 'https') this route is restricted to.
     * So an empty array means that any scheme is allowed.
     *
     * This method implements a fluent interface.
     *
<<<<<<< HEAD
     * @param string|array $schemes The scheme or an array of schemes
     *
     * @return Route The current Route instance
=======
     * @param string|string[] $schemes The scheme or an array of schemes
     *
     * @return $this
>>>>>>> v2-test
     */
    public function setSchemes($schemes)
    {
        $this->schemes = array_map('strtolower', (array) $schemes);
<<<<<<< HEAD

        // this is to keep BC and will be removed in a future version
        if ($this->schemes) {
            $this->requirements['_scheme'] = implode('|', $this->schemes);
        } else {
            unset($this->requirements['_scheme']);
        }

=======
>>>>>>> v2-test
        $this->compiled = null;

        return $this;
    }

    /**
     * Checks if a scheme requirement has been set.
     *
<<<<<<< HEAD
     * @param string $scheme
     *
     * @return bool true if the scheme requirement exists, otherwise false
     */
    public function hasScheme($scheme)
    {
        return in_array(strtolower($scheme), $this->schemes, true);
=======
     * @return bool true if the scheme requirement exists, otherwise false
     */
    public function hasScheme(string $scheme)
    {
        return \in_array(strtolower($scheme), $this->schemes, true);
>>>>>>> v2-test
    }

    /**
     * Returns the uppercased HTTP methods this route is restricted to.
     * So an empty array means that any method is allowed.
     *
<<<<<<< HEAD
     * @return array The methods
=======
     * @return string[] The methods
>>>>>>> v2-test
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * Sets the HTTP methods (e.g. 'POST') this route is restricted to.
     * So an empty array means that any method is allowed.
     *
     * This method implements a fluent interface.
     *
<<<<<<< HEAD
     * @param string|array $methods The method or an array of methods
     *
     * @return Route The current Route instance
=======
     * @param string|string[] $methods The method or an array of methods
     *
     * @return $this
>>>>>>> v2-test
     */
    public function setMethods($methods)
    {
        $this->methods = array_map('strtoupper', (array) $methods);
<<<<<<< HEAD

        // this is to keep BC and will be removed in a future version
        if ($this->methods) {
            $this->requirements['_method'] = implode('|', $this->methods);
        } else {
            unset($this->requirements['_method']);
        }

=======
>>>>>>> v2-test
        $this->compiled = null;

        return $this;
    }

    /**
     * Returns the options.
     *
     * @return array The options
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Sets the options.
     *
     * This method implements a fluent interface.
     *
<<<<<<< HEAD
     * @param array $options The options
     *
     * @return Route The current Route instance
     */
    public function setOptions(array $options)
    {
        $this->options = array(
            'compiler_class' => 'Symfony\\Component\\Routing\\RouteCompiler',
        );
=======
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = [
            'compiler_class' => 'Symfony\\Component\\Routing\\RouteCompiler',
        ];
>>>>>>> v2-test

        return $this->addOptions($options);
    }

    /**
     * Adds options.
     *
     * This method implements a fluent interface.
     *
<<<<<<< HEAD
     * @param array $options The options
     *
     * @return Route The current Route instance
=======
     * @return $this
>>>>>>> v2-test
     */
    public function addOptions(array $options)
    {
        foreach ($options as $name => $option) {
            $this->options[$name] = $option;
        }
        $this->compiled = null;

        return $this;
    }

    /**
     * Sets an option value.
     *
     * This method implements a fluent interface.
     *
<<<<<<< HEAD
     * @param string $name  An option name
     * @param mixed  $value The option value
     *
     * @return Route The current Route instance
     */
    public function setOption($name, $value)
=======
     * @param mixed $value The option value
     *
     * @return $this
     */
    public function setOption(string $name, $value)
>>>>>>> v2-test
    {
        $this->options[$name] = $value;
        $this->compiled = null;

        return $this;
    }

    /**
     * Get an option value.
     *
<<<<<<< HEAD
     * @param string $name An option name
     *
     * @return mixed The option value or null when not given
     */
    public function getOption($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : null;
=======
     * @return mixed The option value or null when not given
     */
    public function getOption(string $name)
    {
        return $this->options[$name] ?? null;
>>>>>>> v2-test
    }

    /**
     * Checks if an option has been set.
     *
<<<<<<< HEAD
     * @param string $name An option name
     *
     * @return bool true if the option is set, false otherwise
     */
    public function hasOption($name)
    {
        return array_key_exists($name, $this->options);
=======
     * @return bool true if the option is set, false otherwise
     */
    public function hasOption(string $name)
    {
        return \array_key_exists($name, $this->options);
>>>>>>> v2-test
    }

    /**
     * Returns the defaults.
     *
     * @return array The defaults
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * Sets the defaults.
     *
     * This method implements a fluent interface.
     *
     * @param array $defaults The defaults
     *
<<<<<<< HEAD
     * @return Route The current Route instance
     */
    public function setDefaults(array $defaults)
    {
        $this->defaults = array();
=======
     * @return $this
     */
    public function setDefaults(array $defaults)
    {
        $this->defaults = [];
>>>>>>> v2-test

        return $this->addDefaults($defaults);
    }

    /**
     * Adds defaults.
     *
     * This method implements a fluent interface.
     *
     * @param array $defaults The defaults
     *
<<<<<<< HEAD
     * @return Route The current Route instance
     */
    public function addDefaults(array $defaults)
    {
=======
     * @return $this
     */
    public function addDefaults(array $defaults)
    {
        if (isset($defaults['_locale']) && $this->isLocalized()) {
            unset($defaults['_locale']);
        }

>>>>>>> v2-test
        foreach ($defaults as $name => $default) {
            $this->defaults[$name] = $default;
        }
        $this->compiled = null;

        return $this;
    }

    /**
     * Gets a default value.
     *
<<<<<<< HEAD
     * @param string $name A variable name
     *
     * @return mixed The default value or null when not given
     */
    public function getDefault($name)
    {
        return isset($this->defaults[$name]) ? $this->defaults[$name] : null;
=======
     * @return mixed The default value or null when not given
     */
    public function getDefault(string $name)
    {
        return $this->defaults[$name] ?? null;
>>>>>>> v2-test
    }

    /**
     * Checks if a default value is set for the given variable.
     *
<<<<<<< HEAD
     * @param string $name A variable name
     *
     * @return bool true if the default value is set, false otherwise
     */
    public function hasDefault($name)
    {
        return array_key_exists($name, $this->defaults);
=======
     * @return bool true if the default value is set, false otherwise
     */
    public function hasDefault(string $name)
    {
        return \array_key_exists($name, $this->defaults);
>>>>>>> v2-test
    }

    /**
     * Sets a default value.
     *
<<<<<<< HEAD
     * @param string $name    A variable name
     * @param mixed  $default The default value
     *
     * @return Route The current Route instance
     */
    public function setDefault($name, $default)
    {
=======
     * @param mixed $default The default value
     *
     * @return $this
     */
    public function setDefault(string $name, $default)
    {
        if ('_locale' === $name && $this->isLocalized()) {
            return $this;
        }

>>>>>>> v2-test
        $this->defaults[$name] = $default;
        $this->compiled = null;

        return $this;
    }

    /**
     * Returns the requirements.
     *
     * @return array The requirements
     */
    public function getRequirements()
    {
        return $this->requirements;
    }

    /**
     * Sets the requirements.
     *
     * This method implements a fluent interface.
     *
     * @param array $requirements The requirements
     *
<<<<<<< HEAD
     * @return Route The current Route instance
     */
    public function setRequirements(array $requirements)
    {
        $this->requirements = array();
=======
     * @return $this
     */
    public function setRequirements(array $requirements)
    {
        $this->requirements = [];
>>>>>>> v2-test

        return $this->addRequirements($requirements);
    }

    /**
     * Adds requirements.
     *
     * This method implements a fluent interface.
     *
     * @param array $requirements The requirements
     *
<<<<<<< HEAD
     * @return Route The current Route instance
     */
    public function addRequirements(array $requirements)
    {
=======
     * @return $this
     */
    public function addRequirements(array $requirements)
    {
        if (isset($requirements['_locale']) && $this->isLocalized()) {
            unset($requirements['_locale']);
        }

>>>>>>> v2-test
        foreach ($requirements as $key => $regex) {
            $this->requirements[$key] = $this->sanitizeRequirement($key, $regex);
        }
        $this->compiled = null;

        return $this;
    }

    /**
     * Returns the requirement for the given key.
     *
<<<<<<< HEAD
     * @param string $key The key
     *
     * @return string|null The regex or null when not given
     */
    public function getRequirement($key)
    {
        if ('_scheme' === $key) {
            @trigger_error('The "_scheme" requirement is deprecated since version 2.2 and will be removed in 3.0. Use getSchemes() instead.', E_USER_DEPRECATED);
        } elseif ('_method' === $key) {
            @trigger_error('The "_method" requirement is deprecated since version 2.2 and will be removed in 3.0. Use getMethods() instead.', E_USER_DEPRECATED);
        }

        return isset($this->requirements[$key]) ? $this->requirements[$key] : null;
=======
     * @return string|null The regex or null when not given
     */
    public function getRequirement(string $key)
    {
        return $this->requirements[$key] ?? null;
>>>>>>> v2-test
    }

    /**
     * Checks if a requirement is set for the given key.
     *
<<<<<<< HEAD
     * @param string $key A variable name
     *
     * @return bool true if a requirement is specified, false otherwise
     */
    public function hasRequirement($key)
    {
        return array_key_exists($key, $this->requirements);
=======
     * @return bool true if a requirement is specified, false otherwise
     */
    public function hasRequirement(string $key)
    {
        return \array_key_exists($key, $this->requirements);
>>>>>>> v2-test
    }

    /**
     * Sets a requirement for the given key.
     *
<<<<<<< HEAD
     * @param string $key   The key
     * @param string $regex The regex
     *
     * @return Route The current Route instance
     */
    public function setRequirement($key, $regex)
    {
=======
     * @return $this
     */
    public function setRequirement(string $key, string $regex)
    {
        if ('_locale' === $key && $this->isLocalized()) {
            return $this;
        }

>>>>>>> v2-test
        $this->requirements[$key] = $this->sanitizeRequirement($key, $regex);
        $this->compiled = null;

        return $this;
    }

    /**
     * Returns the condition.
     *
     * @return string The condition
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * Sets the condition.
     *
     * This method implements a fluent interface.
     *
<<<<<<< HEAD
     * @param string $condition The condition
     *
     * @return Route The current Route instance
     */
    public function setCondition($condition)
=======
     * @return $this
     */
    public function setCondition(?string $condition)
>>>>>>> v2-test
    {
        $this->condition = (string) $condition;
        $this->compiled = null;

        return $this;
    }

    /**
     * Compiles the route.
     *
     * @return CompiledRoute A CompiledRoute instance
     *
     * @throws \LogicException If the Route cannot be compiled because the
     *                         path or host pattern is invalid
     *
     * @see RouteCompiler which is responsible for the compilation process
     */
    public function compile()
    {
        if (null !== $this->compiled) {
            return $this->compiled;
        }

        $class = $this->getOption('compiler_class');

        return $this->compiled = $class::compile($this);
    }

<<<<<<< HEAD
    private function sanitizeRequirement($key, $regex)
    {
        if (!is_string($regex)) {
            throw new \InvalidArgumentException(sprintf('Routing requirement for "%s" must be a string.', $key));
        }

        if ('' !== $regex && '^' === $regex[0]) {
            $regex = (string) substr($regex, 1); // returns false for a single character
=======
    private function extractInlineDefaultsAndRequirements(string $pattern): string
    {
        if (false === strpbrk($pattern, '?<')) {
            return $pattern;
        }

        return preg_replace_callback('#\{(!?\w++)(<.*?>)?(\?[^\}]*+)?\}#', function ($m) {
            if (isset($m[3][0])) {
                $this->setDefault($m[1], '?' !== $m[3] ? substr($m[3], 1) : null);
            }
            if (isset($m[2][0])) {
                $this->setRequirement($m[1], substr($m[2], 1, -1));
            }

            return '{'.$m[1].'}';
        }, $pattern);
    }

    private function sanitizeRequirement(string $key, string $regex)
    {
        if ('' !== $regex) {
            if ('^' === $regex[0]) {
                $regex = substr($regex, 1);
            } elseif (0 === strpos($regex, '\\A')) {
                $regex = substr($regex, 2);
            }
>>>>>>> v2-test
        }

        if ('$' === substr($regex, -1)) {
            $regex = substr($regex, 0, -1);
<<<<<<< HEAD
=======
        } elseif (\strlen($regex) - 2 === strpos($regex, '\\z')) {
            $regex = substr($regex, 0, -2);
>>>>>>> v2-test
        }

        if ('' === $regex) {
            throw new \InvalidArgumentException(sprintf('Routing requirement for "%s" cannot be empty.', $key));
        }

<<<<<<< HEAD
        // this is to keep BC and will be removed in a future version
        if ('_scheme' === $key) {
            @trigger_error('The "_scheme" requirement is deprecated since version 2.2 and will be removed in 3.0. Use the setSchemes() method instead.', E_USER_DEPRECATED);

            $this->setSchemes(explode('|', $regex));
        } elseif ('_method' === $key) {
            @trigger_error('The "_method" requirement is deprecated since version 2.2 and will be removed in 3.0. Use the setMethods() method instead.', E_USER_DEPRECATED);

            $this->setMethods(explode('|', $regex));
        }

        return $regex;
    }
=======
        return $regex;
    }

    private function isLocalized(): bool
    {
        return isset($this->defaults['_locale']) && isset($this->defaults['_canonical_route']) && ($this->requirements['_locale'] ?? null) === preg_quote($this->defaults['_locale']);
    }
>>>>>>> v2-test
}
