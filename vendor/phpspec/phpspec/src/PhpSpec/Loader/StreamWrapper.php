<?php

/*
 * This file is part of PhpSpec, A php toolset to drive emergent
 * design by specification.
 *
 * (c) Marcello Duarte <marcello.duarte@gmail.com>
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpSpec\Loader;

class StreamWrapper
{
    private $realPath;
    private $fileResource;

    private static $specTransformers = array();

<<<<<<< HEAD
    public static function register()
    {
        if (in_array('phpspec', stream_get_wrappers())) {
=======
    public static function register(): void
    {
        if (\in_array('phpspec', stream_get_wrappers())) {
>>>>>>> v2-test
            stream_wrapper_unregister('phpspec');
        }
        stream_wrapper_register('phpspec', 'PhpSpec\Loader\StreamWrapper');
    }

<<<<<<< HEAD
    public static function reset()
=======
    public static function reset(): void
>>>>>>> v2-test
    {
        static::$specTransformers = array();
    }

<<<<<<< HEAD
    public static function addTransformer(SpecTransformer $specTransformer)
=======
    public static function addTransformer(SpecTransformer $specTransformer): void
>>>>>>> v2-test
    {
        static::$specTransformers[] = $specTransformer;
    }

<<<<<<< HEAD
    public static function wrapPath($path)
    {
        if (!defined('HHVM_VERSION'))
=======
    public static function wrapPath($path): string
    {
        if (!\defined('HHVM_VERSION'))
>>>>>>> v2-test
        {
            return 'phpspec://' . $path;
        }

        return $path;
    }

<<<<<<< HEAD
    public function stream_open($path, $mode, $options, &$opened_path)
=======
    public function stream_open($path, $mode, $options, &$opened_path): bool
>>>>>>> v2-test
    {
        if ($mode != 'rb') {
            throw new \RuntimeException('Cannot open phpspec url in mode "$mode"');
        }

        $this->realPath = preg_replace('|^phpspec://|', '', $path);

        if (!file_exists($this->realPath)) {
            return false;
        }

        $content = file_get_contents($this->realPath);

        foreach (static::$specTransformers as $specTransformer) {
            $content = $specTransformer->transform($content);
        }

        $this->fileResource = fopen('php://memory', 'w+');
        fwrite($this->fileResource, $content);
        rewind($this->fileResource);

        $opened_path = $this->realPath;
        return true;
    }

<<<<<<< HEAD
    public function stream_stat()
=======
    public function stream_stat(): array
>>>>>>> v2-test
    {
        return stat($this->realPath);
    }

    public function stream_read($count)
    {
        return fread($this->fileResource, $count);
    }

<<<<<<< HEAD
    public function stream_eof()
    {
        return feof($this->fileResource);
    }
=======
    public function stream_eof(): bool
    {
        return feof($this->fileResource);
    }

    public function stream_set_option(int $option, int $arg1, int $arg2): bool
    {
        return false;
    }
>>>>>>> v2-test
}
