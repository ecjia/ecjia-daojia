<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Fragment;

<<<<<<< HEAD
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ControllerReference;
=======
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Controller\ControllerReference;
use Symfony\Component\HttpKernel\Exception\HttpException;
>>>>>>> v2-test

/**
 * Renders a URI that represents a resource fragment.
 *
 * This class handles the rendering of resource fragments that are included into
 * a main resource. The handling of the rendering is managed by specialized renderers.
 *
<<<<<<< HEAD
 * This listener works in 2 modes:
 *
 *  * 2.3 compatibility mode where you must call setRequest whenever the Request changes.
 *  * 2.4+ mode where you must pass a RequestStack instance in the constructor.
 *
=======
>>>>>>> v2-test
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @see FragmentRendererInterface
 */
class FragmentHandler
{
    private $debug;
<<<<<<< HEAD
    private $renderers = array();
    private $request;
    private $requestStack;

    /**
     * Constructor.
     *
     * RequestStack will become required in 3.0.
     *
     * @param FragmentRendererInterface[] $renderers    An array of FragmentRendererInterface instances
     * @param bool                        $debug        Whether the debug mode is enabled or not
     * @param RequestStack|null           $requestStack The Request stack that controls the lifecycle of requests
     */
    public function __construct(array $renderers = array(), $debug = false, RequestStack $requestStack = null)
=======
    private $renderers = [];
    private $requestStack;

    /**
     * @param FragmentRendererInterface[] $renderers An array of FragmentRendererInterface instances
     * @param bool                        $debug     Whether the debug mode is enabled or not
     */
    public function __construct(RequestStack $requestStack, array $renderers = [], bool $debug = false)
>>>>>>> v2-test
    {
        $this->requestStack = $requestStack;
        foreach ($renderers as $renderer) {
            $this->addRenderer($renderer);
        }
        $this->debug = $debug;
    }

    /**
     * Adds a renderer.
<<<<<<< HEAD
     *
     * @param FragmentRendererInterface $renderer A FragmentRendererInterface instance
=======
>>>>>>> v2-test
     */
    public function addRenderer(FragmentRendererInterface $renderer)
    {
        $this->renderers[$renderer->getName()] = $renderer;
    }

    /**
<<<<<<< HEAD
     * Sets the current Request.
     *
     * This method was used to synchronize the Request, but as the HttpKernel
     * is doing that automatically now, you should never call it directly.
     * It is kept public for BC with the 2.3 version.
     *
     * @param Request|null $request A Request instance
     *
     * @deprecated since version 2.4, to be removed in 3.0.
     */
    public function setRequest(Request $request = null)
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 2.4 and will be removed in 3.0.', E_USER_DEPRECATED);

        $this->request = $request;
    }

    /**
=======
>>>>>>> v2-test
     * Renders a URI and returns the Response content.
     *
     * Available options:
     *
     *  * ignore_errors: true to return an empty string in case of an error
     *
<<<<<<< HEAD
     * @param string|ControllerReference $uri      A URI as a string or a ControllerReference instance
     * @param string                     $renderer The renderer name
     * @param array                      $options  An array of options
=======
     * @param string|ControllerReference $uri A URI as a string or a ControllerReference instance
>>>>>>> v2-test
     *
     * @return string|null The Response content or null when the Response is streamed
     *
     * @throws \InvalidArgumentException when the renderer does not exist
     * @throws \LogicException           when no master request is being handled
     */
<<<<<<< HEAD
    public function render($uri, $renderer = 'inline', array $options = array())
=======
    public function render($uri, string $renderer = 'inline', array $options = [])
>>>>>>> v2-test
    {
        if (!isset($options['ignore_errors'])) {
            $options['ignore_errors'] = !$this->debug;
        }

        if (!isset($this->renderers[$renderer])) {
            throw new \InvalidArgumentException(sprintf('The "%s" renderer does not exist.', $renderer));
        }

<<<<<<< HEAD
        if (!$request = $this->getRequest()) {
=======
        if (!$request = $this->requestStack->getCurrentRequest()) {
>>>>>>> v2-test
            throw new \LogicException('Rendering a fragment can only be done when handling a Request.');
        }

        return $this->deliver($this->renderers[$renderer]->render($uri, $request, $options));
    }

    /**
     * Delivers the Response as a string.
     *
     * When the Response is a StreamedResponse, the content is streamed immediately
     * instead of being returned.
     *
<<<<<<< HEAD
     * @param Response $response A Response instance
     *
=======
>>>>>>> v2-test
     * @return string|null The Response content or null when the Response is streamed
     *
     * @throws \RuntimeException when the Response is not successful
     */
    protected function deliver(Response $response)
    {
        if (!$response->isSuccessful()) {
<<<<<<< HEAD
            throw new \RuntimeException(sprintf('Error when rendering "%s" (Status code is %s).', $this->getRequest()->getUri(), $response->getStatusCode()));
=======
            $responseStatusCode = $response->getStatusCode();
            throw new \RuntimeException(sprintf('Error when rendering "%s" (Status code is %d).', $this->requestStack->getCurrentRequest()->getUri(), $responseStatusCode), 0, new HttpException($responseStatusCode));
>>>>>>> v2-test
        }

        if (!$response instanceof StreamedResponse) {
            return $response->getContent();
        }

        $response->sendContent();
<<<<<<< HEAD
    }

    private function getRequest()
    {
        return $this->requestStack ? $this->requestStack->getCurrentRequest() : $this->request;
=======

        return null;
>>>>>>> v2-test
    }
}
