<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

<<<<<<< HEAD
namespace Symfony\Component\HttpKernel\Exception;

use Symfony\Component\Debug\Exception\FlattenException as DebugFlattenException;

/**
 * FlattenException wraps a PHP Exception to be able to serialize it.
 *
 * Basically, this class removes all objects from the trace.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @deprecated Deprecated in 2.3, to be removed in 3.0. Use the same class from the Debug component instead.
 */
class FlattenException
{
    private $handler;

    public static function __callStatic($method, $args)
    {
        if (!method_exists('Symfony\Component\Debug\Exception\FlattenException', $method)) {
            throw new \BadMethodCallException(sprintf('Call to undefined method %s::%s()', get_called_class(), $method));
        }

        return call_user_func_array(array('Symfony\Component\Debug\Exception\FlattenException', $method), $args);
    }

    public function __call($method, $args)
    {
        if (!isset($this->handler)) {
            $this->handler = new DebugFlattenException();
        }

        if (!method_exists($this->handler, $method)) {
            throw new \BadMethodCallException(sprintf('Call to undefined method %s::%s()', get_class($this), $method));
        }

        return call_user_func_array(array($this->handler, $method), $args);
    }
}

namespace Symfony\Component\Debug\Exception;

use Symfony\Component\HttpKernel\Exception\FlattenException as LegacyFlattenException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * FlattenException wraps a PHP Exception to be able to serialize it.
=======
namespace Symfony\Component\Debug\Exception;

use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * FlattenException wraps a PHP Error or Exception to be able to serialize it.
>>>>>>> v2-test
 *
 * Basically, this class removes all objects from the trace.
 *
 * @author Fabien Potencier <fabien@symfony.com>
<<<<<<< HEAD
 */
class FlattenException extends LegacyFlattenException
=======
 *
 * @deprecated since Symfony 4.4, use Symfony\Component\ErrorHandler\Exception\FlattenException instead.
 */
class FlattenException
>>>>>>> v2-test
{
    private $message;
    private $code;
    private $previous;
    private $trace;
<<<<<<< HEAD
=======
    private $traceAsString;
>>>>>>> v2-test
    private $class;
    private $statusCode;
    private $headers;
    private $file;
    private $line;

<<<<<<< HEAD
    public static function create(\Exception $exception, $statusCode = null, array $headers = array())
=======
    /**
     * @return static
     */
    public static function create(\Exception $exception, $statusCode = null, array $headers = [])
    {
        return static::createFromThrowable($exception, $statusCode, $headers);
    }

    /**
     * @return static
     */
    public static function createFromThrowable(\Throwable $exception, int $statusCode = null, array $headers = [])
>>>>>>> v2-test
    {
        $e = new static();
        $e->setMessage($exception->getMessage());
        $e->setCode($exception->getCode());

        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
            $headers = array_merge($headers, $exception->getHeaders());
<<<<<<< HEAD
=======
        } elseif ($exception instanceof RequestExceptionInterface) {
            $statusCode = 400;
>>>>>>> v2-test
        }

        if (null === $statusCode) {
            $statusCode = 500;
        }

        $e->setStatusCode($statusCode);
        $e->setHeaders($headers);
<<<<<<< HEAD
        $e->setTraceFromException($exception);
        $e->setClass(get_class($exception));
=======
        $e->setTraceFromThrowable($exception);
        $e->setClass($exception instanceof FatalThrowableError ? $exception->getOriginalClassName() : get_debug_type($exception));
>>>>>>> v2-test
        $e->setFile($exception->getFile());
        $e->setLine($exception->getLine());

        $previous = $exception->getPrevious();

<<<<<<< HEAD
        if ($previous instanceof \Exception) {
            $e->setPrevious(static::create($previous));
        } elseif ($previous instanceof \Throwable) {
            $e->setPrevious(static::create(new FatalThrowableError($previous)));
=======
        if ($previous instanceof \Throwable) {
            $e->setPrevious(static::createFromThrowable($previous));
>>>>>>> v2-test
        }

        return $e;
    }

    public function toArray()
    {
<<<<<<< HEAD
        $exceptions = array();
        foreach (array_merge(array($this), $this->getAllPrevious()) as $exception) {
            $exceptions[] = array(
                'message' => $exception->getMessage(),
                'class' => $exception->getClass(),
                'trace' => $exception->getTrace(),
            );
=======
        $exceptions = [];
        foreach (array_merge([$this], $this->getAllPrevious()) as $exception) {
            $exceptions[] = [
                'message' => $exception->getMessage(),
                'class' => $exception->getClass(),
                'trace' => $exception->getTrace(),
            ];
>>>>>>> v2-test
        }

        return $exceptions;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

<<<<<<< HEAD
    public function setStatusCode($code)
    {
        $this->statusCode = $code;
=======
    /**
     * @return $this
     */
    public function setStatusCode($code)
    {
        $this->statusCode = $code;

        return $this;
>>>>>>> v2-test
    }

    public function getHeaders()
    {
        return $this->headers;
    }

<<<<<<< HEAD
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
=======
    /**
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
>>>>>>> v2-test
    }

    public function getClass()
    {
        return $this->class;
    }

<<<<<<< HEAD
    public function setClass($class)
    {
        $this->class = $class;
=======
    /**
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = false !== strpos($class, "@anonymous\0") ? (get_parent_class($class) ?: key(class_implements($class)) ?: 'class').'@anonymous' : $class;

        return $this;
>>>>>>> v2-test
    }

    public function getFile()
    {
        return $this->file;
    }

<<<<<<< HEAD
    public function setFile($file)
    {
        $this->file = $file;
=======
    /**
     * @return $this
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
>>>>>>> v2-test
    }

    public function getLine()
    {
        return $this->line;
    }

<<<<<<< HEAD
    public function setLine($line)
    {
        $this->line = $line;
=======
    /**
     * @return $this
     */
    public function setLine($line)
    {
        $this->line = $line;

        return $this;
>>>>>>> v2-test
    }

    public function getMessage()
    {
        return $this->message;
    }

<<<<<<< HEAD
    public function setMessage($message)
    {
        $this->message = $message;
=======
    /**
     * @return $this
     */
    public function setMessage($message)
    {
        if (false !== strpos($message, "@anonymous\0")) {
            $message = preg_replace_callback('/[a-zA-Z_\x7f-\xff][\\\\a-zA-Z0-9_\x7f-\xff]*+@anonymous\x00.*?\.php(?:0x?|:[0-9]++\$)[0-9a-fA-F]++/', function ($m) {
                return class_exists($m[0], false) ? (get_parent_class($m[0]) ?: key(class_implements($m[0])) ?: 'class').'@anonymous' : $m[0];
            }, $message);
        }

        $this->message = $message;

        return $this;
>>>>>>> v2-test
    }

    public function getCode()
    {
        return $this->code;
    }

<<<<<<< HEAD
    public function setCode($code)
    {
        $this->code = $code;
=======
    /**
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
>>>>>>> v2-test
    }

    public function getPrevious()
    {
        return $this->previous;
    }

<<<<<<< HEAD
    public function setPrevious(FlattenException $previous)
    {
        $this->previous = $previous;
=======
    /**
     * @return $this
     */
    public function setPrevious(self $previous)
    {
        $this->previous = $previous;

        return $this;
>>>>>>> v2-test
    }

    public function getAllPrevious()
    {
<<<<<<< HEAD
        $exceptions = array();
=======
        $exceptions = [];
>>>>>>> v2-test
        $e = $this;
        while ($e = $e->getPrevious()) {
            $exceptions[] = $e;
        }

        return $exceptions;
    }

    public function getTrace()
    {
        return $this->trace;
    }

<<<<<<< HEAD
    public function setTraceFromException(\Exception $exception)
    {
        $this->setTrace($exception->getTrace(), $exception->getFile(), $exception->getLine());
    }

    public function setTrace($trace, $file, $line)
    {
        $this->trace = array();
        $this->trace[] = array(
=======
    /**
     * @deprecated since 4.1, use {@see setTraceFromThrowable()} instead.
     */
    public function setTraceFromException(\Exception $exception)
    {
        @trigger_error(sprintf('The "%s()" method is deprecated since Symfony 4.1, use "setTraceFromThrowable()" instead.', __METHOD__), \E_USER_DEPRECATED);

        $this->setTraceFromThrowable($exception);
    }

    public function setTraceFromThrowable(\Throwable $throwable)
    {
        $this->traceAsString = $throwable->getTraceAsString();

        return $this->setTrace($throwable->getTrace(), $throwable->getFile(), $throwable->getLine());
    }

    /**
     * @return $this
     */
    public function setTrace($trace, $file, $line)
    {
        $this->trace = [];
        $this->trace[] = [
>>>>>>> v2-test
            'namespace' => '',
            'short_class' => '',
            'class' => '',
            'type' => '',
            'function' => '',
            'file' => $file,
            'line' => $line,
<<<<<<< HEAD
            'args' => array(),
        );
=======
            'args' => [],
        ];
>>>>>>> v2-test
        foreach ($trace as $entry) {
            $class = '';
            $namespace = '';
            if (isset($entry['class'])) {
                $parts = explode('\\', $entry['class']);
                $class = array_pop($parts);
                $namespace = implode('\\', $parts);
            }

<<<<<<< HEAD
            $this->trace[] = array(
                'namespace' => $namespace,
                'short_class' => $class,
                'class' => isset($entry['class']) ? $entry['class'] : '',
                'type' => isset($entry['type']) ? $entry['type'] : '',
                'function' => isset($entry['function']) ? $entry['function'] : null,
                'file' => isset($entry['file']) ? $entry['file'] : null,
                'line' => isset($entry['line']) ? $entry['line'] : null,
                'args' => isset($entry['args']) ? $this->flattenArgs($entry['args']) : array(),
            );
        }
    }

    private function flattenArgs($args, $level = 0, &$count = 0)
    {
        $result = array();
        foreach ($args as $key => $value) {
            if (++$count > 1e4) {
                return array('array', '*SKIPPED over 10000 entries*');
            }
            if ($value instanceof \__PHP_Incomplete_Class) {
                // is_object() returns false on PHP<=7.1
                $result[$key] = array('incomplete-object', $this->getClassNameFromIncomplete($value));
            } elseif (is_object($value)) {
                $result[$key] = array('object', get_class($value));
            } elseif (is_array($value)) {
                if ($level > 10) {
                    $result[$key] = array('array', '*DEEP NESTED ARRAY*');
                } else {
                    $result[$key] = array('array', $this->flattenArgs($value, $level + 1, $count));
                }
            } elseif (null === $value) {
                $result[$key] = array('null', null);
            } elseif (is_bool($value)) {
                $result[$key] = array('boolean', $value);
            } elseif (is_resource($value)) {
                $result[$key] = array('resource', get_resource_type($value));
            } else {
                $result[$key] = array('string', (string) $value);
=======
            $this->trace[] = [
                'namespace' => $namespace,
                'short_class' => $class,
                'class' => $entry['class'] ?? '',
                'type' => $entry['type'] ?? '',
                'function' => $entry['function'] ?? null,
                'file' => $entry['file'] ?? null,
                'line' => $entry['line'] ?? null,
                'args' => isset($entry['args']) ? $this->flattenArgs($entry['args']) : [],
            ];
        }

        return $this;
    }

    private function flattenArgs(array $args, int $level = 0, int &$count = 0): array
    {
        $result = [];
        foreach ($args as $key => $value) {
            if (++$count > 1e4) {
                return ['array', '*SKIPPED over 10000 entries*'];
            }
            if ($value instanceof \__PHP_Incomplete_Class) {
                // is_object() returns false on PHP<=7.1
                $result[$key] = ['incomplete-object', $this->getClassNameFromIncomplete($value)];
            } elseif (\is_object($value)) {
                $result[$key] = ['object', \get_class($value)];
            } elseif (\is_array($value)) {
                if ($level > 10) {
                    $result[$key] = ['array', '*DEEP NESTED ARRAY*'];
                } else {
                    $result[$key] = ['array', $this->flattenArgs($value, $level + 1, $count)];
                }
            } elseif (null === $value) {
                $result[$key] = ['null', null];
            } elseif (\is_bool($value)) {
                $result[$key] = ['boolean', $value];
            } elseif (\is_int($value)) {
                $result[$key] = ['integer', $value];
            } elseif (\is_float($value)) {
                $result[$key] = ['float', $value];
            } elseif (\is_resource($value)) {
                $result[$key] = ['resource', get_resource_type($value)];
            } else {
                $result[$key] = ['string', (string) $value];
>>>>>>> v2-test
            }
        }

        return $result;
    }

<<<<<<< HEAD
    private function getClassNameFromIncomplete(\__PHP_Incomplete_Class $value)
=======
    private function getClassNameFromIncomplete(\__PHP_Incomplete_Class $value): string
>>>>>>> v2-test
    {
        $array = new \ArrayObject($value);

        return $array['__PHP_Incomplete_Class_Name'];
    }
<<<<<<< HEAD
=======

    public function getTraceAsString()
    {
        return $this->traceAsString;
    }

    public function getAsString()
    {
        $message = '';
        $next = false;

        foreach (array_reverse(array_merge([$this], $this->getAllPrevious())) as $exception) {
            if ($next) {
                $message .= 'Next ';
            } else {
                $next = true;
            }
            $message .= $exception->getClass();

            if ('' != $exception->getMessage()) {
                $message .= ': '.$exception->getMessage();
            }

            $message .= ' in '.$exception->getFile().':'.$exception->getLine().
                "\nStack trace:\n".$exception->getTraceAsString()."\n\n";
        }

        return rtrim($message);
    }
>>>>>>> v2-test
}
