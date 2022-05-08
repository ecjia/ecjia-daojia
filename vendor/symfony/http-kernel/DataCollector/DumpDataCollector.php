<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
<<<<<<< HEAD
=======
use Symfony\Component\HttpKernel\Debug\FileLinkFormatter;
>>>>>>> v2-test
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\VarDumper\Cloner\Data;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
<<<<<<< HEAD
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;

/**
 * @author Nicolas Grekas <p@tchwork.com>
=======
use Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Server\Connection;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @final
>>>>>>> v2-test
 */
class DumpDataCollector extends DataCollector implements DataDumperInterface
{
    private $stopwatch;
    private $fileLinkFormat;
    private $dataCount = 0;
    private $isCollected = true;
    private $clonesCount = 0;
    private $clonesIndex = 0;
    private $rootRefs;
    private $charset;
    private $requestStack;
    private $dumper;
<<<<<<< HEAD
    private $dumperIsInjected;

    public function __construct(Stopwatch $stopwatch = null, $fileLinkFormat = null, $charset = null, RequestStack $requestStack = null, DataDumperInterface $dumper = null)
=======
    private $sourceContextProvider;

    /**
     * @param string|FileLinkFormatter|null       $fileLinkFormat
     * @param DataDumperInterface|Connection|null $dumper
     */
    public function __construct(Stopwatch $stopwatch = null, $fileLinkFormat = null, string $charset = null, RequestStack $requestStack = null, $dumper = null)
>>>>>>> v2-test
    {
        $this->stopwatch = $stopwatch;
        $this->fileLinkFormat = $fileLinkFormat ?: ini_get('xdebug.file_link_format') ?: get_cfg_var('xdebug.file_link_format');
        $this->charset = $charset ?: ini_get('php.output_encoding') ?: ini_get('default_charset') ?: 'UTF-8';
        $this->requestStack = $requestStack;
        $this->dumper = $dumper;
<<<<<<< HEAD
        $this->dumperIsInjected = null !== $dumper;

        // All clones share these properties by reference:
        $this->rootRefs = array(
=======

        // All clones share these properties by reference:
        $this->rootRefs = [
>>>>>>> v2-test
            &$this->data,
            &$this->dataCount,
            &$this->isCollected,
            &$this->clonesCount,
<<<<<<< HEAD
        );
=======
        ];

        $this->sourceContextProvider = $dumper instanceof Connection && isset($dumper->getContextProviders()['source']) ? $dumper->getContextProviders()['source'] : new SourceContextProvider($this->charset);
>>>>>>> v2-test
    }

    public function __clone()
    {
        $this->clonesIndex = ++$this->clonesCount;
    }

    public function dump(Data $data)
    {
        if ($this->stopwatch) {
            $this->stopwatch->start('dump');
        }
<<<<<<< HEAD
        if ($this->isCollected) {
            $this->isCollected = false;
        }

        $trace = DEBUG_BACKTRACE_PROVIDE_OBJECT | DEBUG_BACKTRACE_IGNORE_ARGS;
        if (PHP_VERSION_ID >= 50400) {
            $trace = debug_backtrace($trace, 7);
        } else {
            $trace = debug_backtrace($trace);
        }

        $file = $trace[0]['file'];
        $line = $trace[0]['line'];
        $name = false;
        $fileExcerpt = false;

        for ($i = 1; $i < 7; ++$i) {
            if (isset($trace[$i]['class'], $trace[$i]['function'])
                && 'dump' === $trace[$i]['function']
                && 'Symfony\Component\VarDumper\VarDumper' === $trace[$i]['class']
            ) {
                $file = $trace[$i]['file'];
                $line = $trace[$i]['line'];

                while (++$i < 7) {
                    if (isset($trace[$i]['function'], $trace[$i]['file']) && empty($trace[$i]['class']) && 0 !== strpos($trace[$i]['function'], 'call_user_func')) {
                        $file = $trace[$i]['file'];
                        $line = $trace[$i]['line'];

                        break;
                    } elseif (isset($trace[$i]['object']) && $trace[$i]['object'] instanceof \Twig_Template) {
                        $info = $trace[$i]['object'];
                        $name = $info->getTemplateName();
                        $src = method_exists($info, 'getSource') ? $info->getSource() : $info->getEnvironment()->getLoader()->getSource($name);
                        $info = $info->getDebugInfo();
                        if (null !== $src && isset($info[$trace[$i - 1]['line']])) {
                            $file = false;
                            $line = $info[$trace[$i - 1]['line']];
                            $src = explode("\n", $src);
                            $fileExcerpt = array();

                            for ($i = max($line - 3, 1), $max = min($line + 3, count($src)); $i <= $max; ++$i) {
                                $fileExcerpt[] = '<li'.($i === $line ? ' class="selected"' : '').'><code>'.$this->htmlEncode($src[$i - 1]).'</code></li>';
                            }

                            $fileExcerpt = '<ol start="'.max($line - 3, 1).'">'.implode("\n", $fileExcerpt).'</ol>';
                        }
                        break;
                    }
                }
                break;
            }
        }

        if (false === $name) {
            $name = str_replace('\\', '/', $file);
            $name = substr($name, strrpos($name, '/') + 1);
        }

        if ($this->dumper) {
            $this->doDump($data, $name, $file, $line);
        }

=======

        ['name' => $name, 'file' => $file, 'line' => $line, 'file_excerpt' => $fileExcerpt] = $this->sourceContextProvider->getContext();

        if ($this->dumper instanceof Connection) {
            if (!$this->dumper->write($data)) {
                $this->isCollected = false;
            }
        } elseif ($this->dumper) {
            $this->doDump($this->dumper, $data, $name, $file, $line);
        } else {
            $this->isCollected = false;
        }

        if (!$this->dataCount) {
            $this->data = [];
        }
>>>>>>> v2-test
        $this->data[] = compact('data', 'name', 'file', 'line', 'fileExcerpt');
        ++$this->dataCount;

        if ($this->stopwatch) {
            $this->stopwatch->stop('dump');
        }
    }

<<<<<<< HEAD
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
=======
    public function collect(Request $request, Response $response, \Throwable $exception = null)
    {
        if (!$this->dataCount) {
            $this->data = [];
        }

>>>>>>> v2-test
        // Sub-requests and programmatic calls stay in the collected profile.
        if ($this->dumper || ($this->requestStack && $this->requestStack->getMasterRequest() !== $request) || $request->isXmlHttpRequest() || $request->headers->has('Origin')) {
            return;
        }

        // In all other conditions that remove the web debug toolbar, dumps are written on the output.
        if (!$this->requestStack
            || !$response->headers->has('X-Debug-Token')
            || $response->isRedirection()
            || ($response->headers->has('Content-Type') && false === strpos($response->headers->get('Content-Type'), 'html'))
            || 'html' !== $request->getRequestFormat()
            || false === strripos($response->getContent(), '</body>')
        ) {
            if ($response->headers->has('Content-Type') && false !== strpos($response->headers->get('Content-Type'), 'html')) {
<<<<<<< HEAD
                $this->dumper = new HtmlDumper('php://output', $this->charset);
            } else {
                $this->dumper = new CliDumper('php://output', $this->charset);
            }

            foreach ($this->data as $dump) {
                $this->doDump($dump['data'], $dump['name'], $dump['file'], $dump['line']);
=======
                $dumper = new HtmlDumper('php://output', $this->charset);
                $dumper->setDisplayOptions(['fileLinkFormat' => $this->fileLinkFormat]);
            } else {
                $dumper = new CliDumper('php://output', $this->charset);
                if (method_exists($dumper, 'setDisplayOptions')) {
                    $dumper->setDisplayOptions(['fileLinkFormat' => $this->fileLinkFormat]);
                }
            }

            foreach ($this->data as $dump) {
                $this->doDump($dumper, $dump['data'], $dump['name'], $dump['file'], $dump['line']);
>>>>>>> v2-test
            }
        }
    }

<<<<<<< HEAD
    public function serialize()
    {
        if ($this->clonesCount !== $this->clonesIndex) {
            return 'a:0:{}';
=======
    public function reset()
    {
        if ($this->stopwatch) {
            $this->stopwatch->reset();
        }
        $this->data = [];
        $this->dataCount = 0;
        $this->isCollected = true;
        $this->clonesCount = 0;
        $this->clonesIndex = 0;
    }

    /**
     * @internal
     */
    public function __sleep(): array
    {
        if (!$this->dataCount) {
            $this->data = [];
        }

        if ($this->clonesCount !== $this->clonesIndex) {
            return [];
>>>>>>> v2-test
        }

        $this->data[] = $this->fileLinkFormat;
        $this->data[] = $this->charset;
<<<<<<< HEAD
        $ser = serialize($this->data);
        $this->data = array();
        $this->dataCount = 0;
        $this->isCollected = true;
        if (!$this->dumperIsInjected) {
            $this->dumper = null;
        }

        return $ser;
    }

    public function unserialize($data)
    {
        parent::unserialize($data);
        $charset = array_pop($this->data);
        $fileLinkFormat = array_pop($this->data);
        $this->dataCount = count($this->data);
        self::__construct($this->stopwatch, $fileLinkFormat, $charset);
    }

    public function getDumpsCount()
=======
        $this->dataCount = 0;
        $this->isCollected = true;

        return parent::__sleep();
    }

    /**
     * @internal
     */
    public function __wakeup()
    {
        parent::__wakeup();

        $charset = array_pop($this->data);
        $fileLinkFormat = array_pop($this->data);
        $this->dataCount = \count($this->data);

        self::__construct($this->stopwatch, \is_string($fileLinkFormat) || $fileLinkFormat instanceof FileLinkFormatter ? $fileLinkFormat : null, \is_string($charset) ? $charset : null);
    }

    public function getDumpsCount(): int
>>>>>>> v2-test
    {
        return $this->dataCount;
    }

<<<<<<< HEAD
    public function getDumps($format, $maxDepthLimit = -1, $maxItemsPerDepth = -1)
    {
        $data = fopen('php://memory', 'r+b');

        if ('html' === $format) {
            $dumper = new HtmlDumper($data, $this->charset);
        } else {
            throw new \InvalidArgumentException(sprintf('Invalid dump format: %s', $format));
        }
        $dumps = array();

        foreach ($this->data as $dump) {
            if (method_exists($dump['data'], 'withMaxDepth')) {
                $dumper->dump($dump['data']->withMaxDepth($maxDepthLimit)->withMaxItemsPerDepth($maxItemsPerDepth));
            } else {
                // getLimitedClone is @deprecated, to be removed in 3.0
                $dumper->dump($dump['data']->getLimitedClone($maxDepthLimit, $maxItemsPerDepth));
            }
=======
    public function getDumps($format, $maxDepthLimit = -1, $maxItemsPerDepth = -1): array
    {
        $data = fopen('php://memory', 'r+');

        if ('html' === $format) {
            $dumper = new HtmlDumper($data, $this->charset);
            $dumper->setDisplayOptions(['fileLinkFormat' => $this->fileLinkFormat]);
        } else {
            throw new \InvalidArgumentException(sprintf('Invalid dump format: "%s".', $format));
        }
        $dumps = [];

        if (!$this->dataCount) {
            return $this->data = [];
        }

        foreach ($this->data as $dump) {
            $dumper->dump($dump['data']->withMaxDepth($maxDepthLimit)->withMaxItemsPerDepth($maxItemsPerDepth));
>>>>>>> v2-test
            $dump['data'] = stream_get_contents($data, -1, 0);
            ftruncate($data, 0);
            rewind($data);
            $dumps[] = $dump;
        }

        return $dumps;
    }

<<<<<<< HEAD
    public function getName()
=======
    public function getName(): string
>>>>>>> v2-test
    {
        return 'dump';
    }

    public function __destruct()
    {
<<<<<<< HEAD
        if (0 === $this->clonesCount-- && !$this->isCollected && $this->data) {
=======
        if (0 === $this->clonesCount-- && !$this->isCollected && $this->dataCount) {
>>>>>>> v2-test
            $this->clonesCount = 0;
            $this->isCollected = true;

            $h = headers_list();
<<<<<<< HEAD
            $i = count($h);
=======
            $i = \count($h);
>>>>>>> v2-test
            array_unshift($h, 'Content-Type: '.ini_get('default_mimetype'));
            while (0 !== stripos($h[$i], 'Content-Type:')) {
                --$i;
            }

<<<<<<< HEAD
            if ('cli' !== PHP_SAPI && stripos($h[$i], 'html')) {
                $this->dumper = new HtmlDumper('php://output', $this->charset);
            } else {
                $this->dumper = new CliDumper('php://output', $this->charset);
=======
            if (!\in_array(\PHP_SAPI, ['cli', 'phpdbg'], true) && stripos($h[$i], 'html')) {
                $dumper = new HtmlDumper('php://output', $this->charset);
                $dumper->setDisplayOptions(['fileLinkFormat' => $this->fileLinkFormat]);
            } else {
                $dumper = new CliDumper('php://output', $this->charset);
                if (method_exists($dumper, 'setDisplayOptions')) {
                    $dumper->setDisplayOptions(['fileLinkFormat' => $this->fileLinkFormat]);
                }
>>>>>>> v2-test
            }

            foreach ($this->data as $i => $dump) {
                $this->data[$i] = null;
<<<<<<< HEAD
                $this->doDump($dump['data'], $dump['name'], $dump['file'], $dump['line']);
            }

            $this->data = array();
=======
                $this->doDump($dumper, $dump['data'], $dump['name'], $dump['file'], $dump['line']);
            }

            $this->data = [];
>>>>>>> v2-test
            $this->dataCount = 0;
        }
    }

<<<<<<< HEAD
    private function doDump($data, $name, $file, $line)
    {
        if (PHP_VERSION_ID >= 50400 && $this->dumper instanceof CliDumper) {
            $contextDumper = function ($name, $file, $line, $fileLinkFormat) {
                if ($this instanceof HtmlDumper) {
                    if ('' !== $file) {
                        $s = $this->style('meta', '%s');
                        $name = strip_tags($this->style('', $name));
                        $file = strip_tags($this->style('', $file));
                        if ($fileLinkFormat) {
                            $link = strtr(strip_tags($this->style('', $fileLinkFormat)), array('%f' => $file, '%l' => (int) $line));
                            $name = sprintf('<a href="%s" title="%s">'.$s.'</a>', $link, $file, $name);
                        } else {
                            $name = sprintf('<abbr title="%s">'.$s.'</abbr>', $file, $name);
=======
    private function doDump(DataDumperInterface $dumper, $data, string $name, string $file, int $line)
    {
        if ($dumper instanceof CliDumper) {
            $contextDumper = function ($name, $file, $line, $fmt) {
                if ($this instanceof HtmlDumper) {
                    if ($file) {
                        $s = $this->style('meta', '%s');
                        $f = strip_tags($this->style('', $file));
                        $name = strip_tags($this->style('', $name));
                        if ($fmt && $link = \is_string($fmt) ? strtr($fmt, ['%f' => $file, '%l' => $line]) : $fmt->format($file, $line)) {
                            $name = sprintf('<a href="%s" title="%s">'.$s.'</a>', strip_tags($this->style('', $link)), $f, $name);
                        } else {
                            $name = sprintf('<abbr title="%s">'.$s.'</abbr>', $f, $name);
>>>>>>> v2-test
                        }
                    } else {
                        $name = $this->style('meta', $name);
                    }
                    $this->line = $name.' on line '.$this->style('meta', $line).':';
                } else {
                    $this->line = $this->style('meta', $name).' on line '.$this->style('meta', $line).':';
                }
                $this->dumpLine(0);
            };
<<<<<<< HEAD
            $contextDumper = $contextDumper->bindTo($this->dumper, $this->dumper);
            $contextDumper($name, $file, $line, $this->fileLinkFormat);
        } else {
            $cloner = new VarCloner();
            $this->dumper->dump($cloner->cloneVar($name.' on line '.$line.':'));
        }
        $this->dumper->dump($data);
    }

    private function htmlEncode($s)
    {
        $html = '';

        $dumper = new HtmlDumper(function ($line) use (&$html) {$html .= $line;}, $this->charset);
        $dumper->setDumpHeader('');
        $dumper->setDumpBoundaries('', '');

        $cloner = new VarCloner();
        $dumper->dump($cloner->cloneVar($s));

        return substr(strip_tags($html), 1, -1);
=======
            $contextDumper = $contextDumper->bindTo($dumper, $dumper);
            $contextDumper($name, $file, $line, $this->fileLinkFormat);
        } else {
            $cloner = new VarCloner();
            $dumper->dump($cloner->cloneVar($name.' on line '.$line.':'));
        }
        $dumper->dump($data);
>>>>>>> v2-test
    }
}
