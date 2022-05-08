<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\DependencyInjection;

<<<<<<< HEAD
use Symfony\Component\DependencyInjection\ContainerInterface;
=======
use Psr\Container\ContainerInterface;
>>>>>>> v2-test
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Fragment\FragmentHandler;

/**
 * Lazily loads fragment renderers from the dependency injection container.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class LazyLoadingFragmentHandler extends FragmentHandler
{
    private $container;
<<<<<<< HEAD
    private $rendererIds = array();

    public function __construct(ContainerInterface $container, $debug = false, RequestStack $requestStack = null)
    {
        $this->container = $container;

        parent::__construct(array(), $debug, $requestStack);
    }

    /**
     * Adds a service as a fragment renderer.
     *
     * @param string $name     The service name
     * @param string $renderer The render service id
     */
    public function addRendererService($name, $renderer)
    {
        $this->rendererIds[$name] = $renderer;
=======
    private $initialized = [];

    public function __construct(ContainerInterface $container, RequestStack $requestStack, bool $debug = false)
    {
        $this->container = $container;

        parent::__construct($requestStack, [], $debug);
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     */
<<<<<<< HEAD
    public function render($uri, $renderer = 'inline', array $options = array())
    {
        if (isset($this->rendererIds[$renderer])) {
            $this->addRenderer($this->container->get($this->rendererIds[$renderer]));

            unset($this->rendererIds[$renderer]);
=======
    public function render($uri, string $renderer = 'inline', array $options = [])
    {
        if (!isset($this->initialized[$renderer]) && $this->container->has($renderer)) {
            $this->addRenderer($this->container->get($renderer));
            $this->initialized[$renderer] = true;
>>>>>>> v2-test
        }

        return parent::render($uri, $renderer, $options);
    }
}
