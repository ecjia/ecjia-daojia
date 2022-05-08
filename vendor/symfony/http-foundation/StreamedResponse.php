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
 * StreamedResponse represents a streamed HTTP response.
 *
 * A StreamedResponse uses a callback for its content.
 *
 * The callback should use the standard PHP functions like echo
<<<<<<< HEAD
 * to stream the response back to the client. The flush() method
=======
 * to stream the response back to the client. The flush() function
>>>>>>> v2-test
 * can also be used if needed.
 *
 * @see flush()
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class StreamedResponse extends Response
{
    protected $callback;
    protected $streamed;
<<<<<<< HEAD

    /**
     * Constructor.
     *
     * @param callable|null $callback A valid PHP callback or null to set it later
     * @param int           $status   The response status code
     * @param array         $headers  An array of response headers
     */
    public function __construct($callback = null, $status = 200, $headers = array())
=======
    private $headersSent;

    public function __construct(callable $callback = null, int $status = 200, array $headers = [])
>>>>>>> v2-test
    {
        parent::__construct(null, $status, $headers);

        if (null !== $callback) {
            $this->setCallback($callback);
        }
        $this->streamed = false;
<<<<<<< HEAD
=======
        $this->headersSent = false;
>>>>>>> v2-test
    }

    /**
     * Factory method for chainability.
     *
     * @param callable|null $callback A valid PHP callback or null to set it later
<<<<<<< HEAD
     * @param int           $status   The response status code
     * @param array         $headers  An array of response headers
     *
     * @return StreamedResponse
     */
    public static function create($callback = null, $status = 200, $headers = array())
    {
=======
     *
     * @return static
     *
     * @deprecated since Symfony 5.1, use __construct() instead.
     */
    public static function create($callback = null, int $status = 200, array $headers = [])
    {
        trigger_deprecation('symfony/http-foundation', '5.1', 'The "%s()" method is deprecated, use "new %s()" instead.', __METHOD__, static::class);

>>>>>>> v2-test
        return new static($callback, $status, $headers);
    }

    /**
     * Sets the PHP callback associated with this Response.
     *
<<<<<<< HEAD
     * @param callable $callback A valid PHP callback
     *
     * @throws \LogicException
     */
    public function setCallback($callback)
    {
        if (!is_callable($callback)) {
            throw new \LogicException('The Response callback must be a valid PHP callable.');
        }
        $this->callback = $callback;
=======
     * @return $this
     */
    public function setCallback(callable $callback)
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * This method only sends the headers once.
     *
     * @return $this
     */
    public function sendHeaders()
    {
        if ($this->headersSent) {
            return $this;
        }

        $this->headersSent = true;

        return parent::sendHeaders();
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     *
     * This method only sends the content once.
<<<<<<< HEAD
=======
     *
     * @return $this
>>>>>>> v2-test
     */
    public function sendContent()
    {
        if ($this->streamed) {
<<<<<<< HEAD
            return;
=======
            return $this;
>>>>>>> v2-test
        }

        $this->streamed = true;

        if (null === $this->callback) {
            throw new \LogicException('The Response callback must not be null.');
        }

<<<<<<< HEAD
        call_user_func($this->callback);
=======
        ($this->callback)();

        return $this;
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
     *
     * @throws \LogicException when the content is not null
<<<<<<< HEAD
     */
    public function setContent($content)
=======
     *
     * @return $this
     */
    public function setContent(?string $content)
>>>>>>> v2-test
    {
        if (null !== $content) {
            throw new \LogicException('The content cannot be set on a StreamedResponse instance.');
        }
<<<<<<< HEAD
=======

        $this->streamed = true;

        return $this;
>>>>>>> v2-test
    }

    /**
     * {@inheritdoc}
<<<<<<< HEAD
     *
     * @return false
=======
>>>>>>> v2-test
     */
    public function getContent()
    {
        return false;
    }
}
