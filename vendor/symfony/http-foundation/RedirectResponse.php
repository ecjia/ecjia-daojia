<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation;

/**
 * RedirectResponse represents an HTTP response doing a redirect.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class RedirectResponse extends Response
{
    protected $targetUrl;

    /**
     * Creates a redirect response so that it conforms to the rules defined for a redirect status code.
     *
     * @param string $url     The URL to redirect to. The URL should be a full URL, with schema etc.,
     *                        but practically every browser redirects on paths only as well
     * @param int    $status  The status code (302 by default)
     * @param array  $headers The headers (Location is always set to the given URL)
     *
     * @throws \InvalidArgumentException
     *
<<<<<<< HEAD
     * @see http://tools.ietf.org/html/rfc2616#section-10.3
     */
    public function __construct($url, $status = 302, $headers = array())
=======
     * @see https://tools.ietf.org/html/rfc2616#section-10.3
     */
    public function __construct(string $url, int $status = 302, array $headers = [])
>>>>>>> v2-test
    {
        parent::__construct('', $status, $headers);

        $this->setTargetUrl($url);

        if (!$this->isRedirect()) {
            throw new \InvalidArgumentException(sprintf('The HTTP status code is not a redirect ("%s" given).', $status));
        }
<<<<<<< HEAD
    }

    /**
     * {@inheritdoc}
     */
    public static function create($url = '', $status = 302, $headers = array())
    {
=======

        if (301 == $status && !\array_key_exists('cache-control', array_change_key_case($headers, \CASE_LOWER))) {
            $this->headers->remove('cache-control');
        }
    }

    /**
     * Factory method for chainability.
     *
     * @param string $url The URL to redirect to
     *
     * @return static
     *
     * @deprecated since Symfony 5.1, use __construct() instead.
     */
    public static function create($url = '', int $status = 302, array $headers = [])
    {
        trigger_deprecation('symfony/http-foundation', '5.1', 'The "%s()" method is deprecated, use "new %s()" instead.', __METHOD__, static::class);

>>>>>>> v2-test
        return new static($url, $status, $headers);
    }

    /**
     * Returns the target URL.
     *
     * @return string target URL
     */
    public function getTargetUrl()
    {
        return $this->targetUrl;
    }

    /**
     * Sets the redirect target of this response.
     *
<<<<<<< HEAD
     * @param string $url The URL to redirect to
     *
     * @return RedirectResponse The current response
     *
     * @throws \InvalidArgumentException
     */
    public function setTargetUrl($url)
    {
        if (empty($url)) {
=======
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setTargetUrl(string $url)
    {
        if ('' === $url) {
>>>>>>> v2-test
            throw new \InvalidArgumentException('Cannot redirect to an empty URL.');
        }

        $this->targetUrl = $url;

        $this->setContent(
            sprintf('<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
<<<<<<< HEAD
        <meta http-equiv="refresh" content="1;url=%1$s" />
=======
        <meta http-equiv="refresh" content="0;url=\'%1$s\'" />
>>>>>>> v2-test

        <title>Redirecting to %1$s</title>
    </head>
    <body>
        Redirecting to <a href="%1$s">%1$s</a>.
    </body>
<<<<<<< HEAD
</html>', htmlspecialchars($url, ENT_QUOTES, 'UTF-8')));
=======
</html>', htmlspecialchars($url, \ENT_QUOTES, 'UTF-8')));
>>>>>>> v2-test

        $this->headers->set('Location', $url);

        return $this;
    }
}
