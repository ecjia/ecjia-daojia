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
 * Response represents an HTTP response in JSON format.
 *
 * Note that this class does not force the returned JSON content to be an
 * object. It is however recommended that you do return an object as it
 * protects yourself against XSSI and JSON-JavaScript Hijacking.
 *
<<<<<<< HEAD
 * @see https://www.owasp.org/index.php/OWASP_AJAX_Security_Guidelines#Always_return_JSON_with_an_Object_on_the_outside
=======
 * @see https://github.com/OWASP/CheatSheetSeries/blob/master/cheatsheets/AJAX_Security_Cheat_Sheet.md#always-return-json-with-an-object-on-the-outside
>>>>>>> v2-test
 *
 * @author Igor Wiedler <igor@wiedler.ch>
 */
class JsonResponse extends Response
{
    protected $data;
    protected $callback;

    // Encode <, >, ', &, and " characters in the JSON, making it also safe to be embedded into HTML.
    // 15 === JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
<<<<<<< HEAD
    protected $encodingOptions = 15;

    /**
     * Constructor.
     *
     * @param mixed $data    The response data
     * @param int   $status  The response status code
     * @param array $headers An array of response headers
     */
    public function __construct($data = null, $status = 200, $headers = array())
    {
        parent::__construct('', $status, $headers);

=======
    public const DEFAULT_ENCODING_OPTIONS = 15;

    protected $encodingOptions = self::DEFAULT_ENCODING_OPTIONS;

    /**
     * @param mixed $data    The response data
     * @param int   $status  The response status code
     * @param array $headers An array of response headers
     * @param bool  $json    If the data is already a JSON string
     */
    public function __construct($data = null, int $status = 200, array $headers = [], bool $json = false)
    {
        parent::__construct('', $status, $headers);

        if ($json && !\is_string($data) && !is_numeric($data) && !\is_callable([$data, '__toString'])) {
            throw new \TypeError(sprintf('"%s": If $json is set to true, argument $data must be a string or object implementing __toString(), "%s" given.', __METHOD__, get_debug_type($data)));
        }

>>>>>>> v2-test
        if (null === $data) {
            $data = new \ArrayObject();
        }

<<<<<<< HEAD
        $this->setData($data);
=======
        $json ? $this->setJson($data) : $this->setData($data);
>>>>>>> v2-test
    }

    /**
     * Factory method for chainability.
     *
     * Example:
     *
<<<<<<< HEAD
     *     return JsonResponse::create($data, 200)
     *         ->setSharedMaxAge(300);
     *
     * @param mixed $data    The json response data
     * @param int   $status  The response status code
     * @param array $headers An array of response headers
     *
     * @return JsonResponse
     */
    public static function create($data = null, $status = 200, $headers = array())
    {
=======
     *     return JsonResponse::create(['key' => 'value'])
     *         ->setSharedMaxAge(300);
     *
     * @param mixed $data    The JSON response data
     * @param int   $status  The response status code
     * @param array $headers An array of response headers
     *
     * @return static
     *
     * @deprecated since Symfony 5.1, use __construct() instead.
     */
    public static function create($data = null, int $status = 200, array $headers = [])
    {
        trigger_deprecation('symfony/http-foundation', '5.1', 'The "%s()" method is deprecated, use "new %s()" instead.', __METHOD__, static::class);

>>>>>>> v2-test
        return new static($data, $status, $headers);
    }

    /**
<<<<<<< HEAD
=======
     * Factory method for chainability.
     *
     * Example:
     *
     *     return JsonResponse::fromJsonString('{"key": "value"}')
     *         ->setSharedMaxAge(300);
     *
     * @param string $data    The JSON response string
     * @param int    $status  The response status code
     * @param array  $headers An array of response headers
     *
     * @return static
     */
    public static function fromJsonString(string $data, int $status = 200, array $headers = [])
    {
        return new static($data, $status, $headers, true);
    }

    /**
>>>>>>> v2-test
     * Sets the JSONP callback.
     *
     * @param string|null $callback The JSONP callback or null to use none
     *
<<<<<<< HEAD
     * @return JsonResponse
     *
     * @throws \InvalidArgumentException When the callback name is not valid
     */
    public function setCallback($callback = null)
    {
        if (null !== $callback) {
            // taken from http://www.geekality.net/2011/08/03/valid-javascript-identifier/
            $pattern = '/^[$_\p{L}][$_\p{L}\p{Mn}\p{Mc}\p{Nd}\p{Pc}\x{200C}\x{200D}]*+$/u';
            $parts = explode('.', $callback);
            foreach ($parts as $part) {
                if (!preg_match($pattern, $part)) {
=======
     * @return $this
     *
     * @throws \InvalidArgumentException When the callback name is not valid
     */
    public function setCallback(string $callback = null)
    {
        if (null !== $callback) {
            // partially taken from https://geekality.net/2011/08/03/valid-javascript-identifier/
            // partially taken from https://github.com/willdurand/JsonpCallbackValidator
            //      JsonpCallbackValidator is released under the MIT License. See https://github.com/willdurand/JsonpCallbackValidator/blob/v1.1.0/LICENSE for details.
            //      (c) William Durand <william.durand1@gmail.com>
            $pattern = '/^[$_\p{L}][$_\p{L}\p{Mn}\p{Mc}\p{Nd}\p{Pc}\x{200C}\x{200D}]*(?:\[(?:"(?:\\\.|[^"\\\])*"|\'(?:\\\.|[^\'\\\])*\'|\d+)\])*?$/u';
            $reserved = [
                'break', 'do', 'instanceof', 'typeof', 'case', 'else', 'new', 'var', 'catch', 'finally', 'return', 'void', 'continue', 'for', 'switch', 'while',
                'debugger', 'function', 'this', 'with', 'default', 'if', 'throw', 'delete', 'in', 'try', 'class', 'enum', 'extends', 'super',  'const', 'export',
                'import', 'implements', 'let', 'private', 'public', 'yield', 'interface', 'package', 'protected', 'static', 'null', 'true', 'false',
            ];
            $parts = explode('.', $callback);
            foreach ($parts as $part) {
                if (!preg_match($pattern, $part) || \in_array($part, $reserved, true)) {
>>>>>>> v2-test
                    throw new \InvalidArgumentException('The callback name is not valid.');
                }
            }
        }

        $this->callback = $callback;

        return $this->update();
    }

    /**
<<<<<<< HEAD
=======
     * Sets a raw string containing a JSON document to be sent.
     *
     * @return $this
     */
    public function setJson(string $json)
    {
        $this->data = $json;

        return $this->update();
    }

    /**
>>>>>>> v2-test
     * Sets the data to be sent as JSON.
     *
     * @param mixed $data
     *
<<<<<<< HEAD
     * @return JsonResponse
     *
     * @throws \InvalidArgumentException
     */
    public function setData($data = array())
    {
        if (defined('HHVM_VERSION')) {
            // HHVM does not trigger any warnings and let exceptions
            // thrown from a JsonSerializable object pass through.
            // If only PHP did the same...
            $data = json_encode($data, $this->encodingOptions);
        } else {
            try {
                if (PHP_VERSION_ID < 50400) {
                    // PHP 5.3 triggers annoying warnings for some
                    // types that can't be serialized as JSON (INF, resources, etc.)
                    // but doesn't provide the JsonSerializable interface.
                    set_error_handler(function () { return false; });
                    $data = @json_encode($data, $this->encodingOptions);
                } else {
                    // PHP 5.4 and up wrap exceptions thrown by JsonSerializable
                    // objects in a new exception that needs to be removed.
                    // Fortunately, PHP 5.5 and up do not trigger any warning anymore.
                    if (PHP_VERSION_ID < 50500) {
                        // Clear json_last_error()
                        json_encode(null);
                        $errorHandler = set_error_handler('var_dump');
                        restore_error_handler();
                        set_error_handler(function () use ($errorHandler) {
                            if (JSON_ERROR_NONE === json_last_error()) {
                                return $errorHandler && false !== call_user_func_array($errorHandler, func_get_args());
                            }
                        });
                    }

                    $data = json_encode($data, $this->encodingOptions);
                }

                if (PHP_VERSION_ID < 50500) {
                    restore_error_handler();
                }
            } catch (\Exception $e) {
                if (PHP_VERSION_ID < 50500) {
                    restore_error_handler();
                }
                if (PHP_VERSION_ID >= 50400 && 'Exception' === get_class($e) && 0 === strpos($e->getMessage(), 'Failed calling ')) {
                    throw $e->getPrevious() ?: $e;
                }
                throw $e;
            }
        }

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException($this->transformJsonError());
        }

        $this->data = $data;

        return $this->update();
=======
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setData($data = [])
    {
        try {
            $data = json_encode($data, $this->encodingOptions);
        } catch (\Exception $e) {
            if ('Exception' === \get_class($e) && 0 === strpos($e->getMessage(), 'Failed calling ')) {
                throw $e->getPrevious() ?: $e;
            }
            throw $e;
        }

        if (\PHP_VERSION_ID >= 70300 && (\JSON_THROW_ON_ERROR & $this->encodingOptions)) {
            return $this->setJson($data);
        }

        if (\JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException(json_last_error_msg());
        }

        return $this->setJson($data);
>>>>>>> v2-test
    }

    /**
     * Returns options used while encoding data to JSON.
     *
     * @return int
     */
    public function getEncodingOptions()
    {
        return $this->encodingOptions;
    }

    /**
     * Sets options used while encoding data to JSON.
     *
<<<<<<< HEAD
     * @param int $encodingOptions
     *
     * @return JsonResponse
     */
    public function setEncodingOptions($encodingOptions)
    {
        $this->encodingOptions = (int) $encodingOptions;
=======
     * @return $this
     */
    public function setEncodingOptions(int $encodingOptions)
    {
        $this->encodingOptions = $encodingOptions;
>>>>>>> v2-test

        return $this->setData(json_decode($this->data));
    }

    /**
     * Updates the content and headers according to the JSON data and callback.
     *
<<<<<<< HEAD
     * @return JsonResponse
=======
     * @return $this
>>>>>>> v2-test
     */
    protected function update()
    {
        if (null !== $this->callback) {
            // Not using application/javascript for compatibility reasons with older browsers.
            $this->headers->set('Content-Type', 'text/javascript');

            return $this->setContent(sprintf('/**/%s(%s);', $this->callback, $this->data));
        }

        // Only set the header when there is none or when it equals 'text/javascript' (from a previous update with callback)
        // in order to not overwrite a custom definition.
        if (!$this->headers->has('Content-Type') || 'text/javascript' === $this->headers->get('Content-Type')) {
            $this->headers->set('Content-Type', 'application/json');
        }

        return $this->setContent($this->data);
    }
<<<<<<< HEAD

    private function transformJsonError()
    {
        if (function_exists('json_last_error_msg')) {
            return json_last_error_msg();
        }

        switch (json_last_error()) {
            case JSON_ERROR_DEPTH:
                return 'Maximum stack depth exceeded.';

            case JSON_ERROR_STATE_MISMATCH:
                return 'Underflow or the modes mismatch.';

            case JSON_ERROR_CTRL_CHAR:
                return 'Unexpected control character found.';

            case JSON_ERROR_SYNTAX:
                return 'Syntax error, malformed JSON.';

            case JSON_ERROR_UTF8:
                return 'Malformed UTF-8 characters, possibly incorrectly encoded.';

            default:
                return 'Unknown error.';
        }
    }
=======
>>>>>>> v2-test
}
