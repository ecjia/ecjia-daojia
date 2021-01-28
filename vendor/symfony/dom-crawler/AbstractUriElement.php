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

/**
 * Any HTML element that can link to an URI.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class AbstractUriElement
{
    /**
     * @var \DOMElement
     */
    protected $node;

    /**
     * @var string|null The method to use for the element
     */
    protected $method;

    /**
     * @var string The URI of the page where the element is embedded (or the base href)
     */
    protected $currentUri;

    /**
     * @param \DOMElement $node       A \DOMElement instance
     * @param string      $currentUri The URI of the page where the link is embedded (or the base href)
     * @param string|null $method     The method to use for the link (GET by default)
     *
     * @throws \InvalidArgumentException if the node is not a link
     */
    public function __construct(\DOMElement $node, string $currentUri = null, ?string $method = 'GET')
    {
        $this->setNode($node);
        $this->method = $method ? strtoupper($method) : null;
        $this->currentUri = $currentUri;

        $elementUriIsRelative = null === parse_url(trim($this->getRawUri()), \PHP_URL_SCHEME);
        $baseUriIsAbsolute = \in_array(strtolower(substr($this->currentUri, 0, 4)), ['http', 'file']);
        if ($elementUriIsRelative && !$baseUriIsAbsolute) {
            throw new \InvalidArgumentException(sprintf('The URL of the element is relative, so you must define its base URI passing an absolute URL to the constructor of the "%s" class ("%s" was passed).', __CLASS__, $this->currentUri));
        }
    }

    /**
     * Gets the node associated with this link.
     *
     * @return \DOMElement A \DOMElement instance
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * Gets the method associated with this link.
     *
     * @return string The method
     */
    public function getMethod()
    {
        return $this->method ?? 'GET';
    }

    /**
     * Gets the URI associated with this link.
     *
     * @return string The URI
     */
    public function getUri()
    {
        return UriResolver::resolve($this->getRawUri(), $this->currentUri);
    }

    /**
     * Returns raw URI data.
     *
     * @return string
     */
    abstract protected function getRawUri();

    /**
     * Returns the canonicalized URI path (see RFC 3986, section 5.2.4).
     *
     * @param string $path URI path
     *
     * @return string
     */
    protected function canonicalizePath(string $path)
    {
        if ('' === $path || '/' === $path) {
            return $path;
        }

        if ('.' === substr($path, -1)) {
            $path .= '/';
        }

        $output = [];

        foreach (explode('/', $path) as $segment) {
            if ('..' === $segment) {
                array_pop($output);
            } elseif ('.' !== $segment) {
                $output[] = $segment;
            }
        }

        return implode('/', $output);
    }

    /**
     * Sets current \DOMElement instance.
     *
     * @param \DOMElement $node A \DOMElement instance
     *
     * @throws \LogicException If given node is not an anchor
     */
    abstract protected function setNode(\DOMElement $node);
}
