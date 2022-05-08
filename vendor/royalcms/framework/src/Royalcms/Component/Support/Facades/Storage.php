<?php

namespace Royalcms\Component\Support\Facades;

/**
 * @method static \Illuminate\Contracts\Filesystem\Filesystem disk(string $name = null)
 * @method static bool exists(string $path)
 * @method static string get(string $path)
 * @method static resource|null readStream(string $path)
 * @method static bool put(string $path, string|resource $contents, mixed $options = [])
 * @method static bool writeStream(string $path, resource $resource, array $options = [])
 * @method static string getVisibility(string $path)
 * @method static bool setVisibility(string $path, string $visibility)
 * @method static bool prepend(string $path, string $data)
 * @method static bool append(string $path, string $data)
 * @method static bool delete(string|array $paths)
 * @method static bool copy(string $from, string $to)
 * @method static bool move(string $from, string $to)
 * @method static int size(string $path)
 * @method static int lastModified(string $path)
 * @method static array files(string|null $directory = null, bool $recursive = false)
 * @method static array allFiles(string|null $directory = null)
 * @method static array directories(string|null $directory = null, bool $recursive = false)
 * @method static array allDirectories(string|null $directory = null)
 * @method static bool makeDirectory(string $path)
 * @method static bool deleteDirectory(string $directory)
 * @method static \Illuminate\Contracts\Filesystem\Filesystem assertExists(string|array $path)
 * @method static \Illuminate\Contracts\Filesystem\Filesystem assertMissing(string|array $path)
 * 
 * @see \Royalcms\Component\Storage\FilesystemManager
 */
class Storage extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'storage';
    }
}
