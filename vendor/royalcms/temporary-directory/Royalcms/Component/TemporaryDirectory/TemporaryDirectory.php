<?php

namespace Royalcms\Component\TemporaryDirectory;

use Exception;
use InvalidArgumentException;

class TemporaryDirectory
{
    /** @var string */
    protected $location;

    /** @var string */
    protected $name;

    /** @var bool */
    protected $forceCreate = false;

    /**
     * @var \Royalcms\Component\Filesystem\Filesystem
     */
    protected $filesystem;

    public function __construct($location = null)
    {
        $this->location = $this->sanitizePath($location);

        $this->filesystem = royalcms('files');
    }

    /**
     * @return $this
     */
    public function create()
    {
        if (empty($this->location)) {
            $this->location = $this->getSystemTemporaryDirectory();
        }

        if (empty($this->name)) {
            $this->name = str_replace([' ', '.'], '', microtime());
        }

        if ($this->forceCreate && $this->filesystem->exists($this->getFullPath())) {
            $this->deleteDirectory($this->getFullPath());
        }

        if ($this->filesystem->exists($this->getFullPath())) {
            throw new InvalidArgumentException("Path `{$this->getFullPath()}` already exists.");
        }

        $this->filesystem->makeDirectory($this->getFullPath(), 0777, true, true);

        return $this;
    }

    /**
     * @return $this
     */
    public function force()
    {
        $this->forceCreate = true;

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function name($name)
    {
        $this->name = $this->sanitizeName($name);

        return $this;
    }

    /**
     * @param string $location
     * @return $this
     */
    public function location($location)
    {
        $this->location = $this->sanitizePath($location);

        return $this;
    }

    /**
     * @param string $pathOrFilename
     * @return string
     */
    public function path($pathOrFilename = '')
    {
        if (empty($pathOrFilename)) {
            return $this->getFullPath();
        }

        $path = $this->getFullPath().DIRECTORY_SEPARATOR.trim($pathOrFilename, '/');

        $directoryPath = $this->removeFilenameFromPath($path);

        if (! $this->filesystem->exists($directoryPath)) {
            $this->filesystem->makeDirectory($directoryPath, 0777, true, true);
        }

        return $path;
    }

    /**
     * @return $this
     */
    public function clean()
    {
        $this->deleteDirectory($this->getFullPath());
        $this->filesystem->makeDirectory($this->getFullPath());

        return $this;
    }

    /**
     * @return bool
     */
    public function delete()
    {
        return $this->deleteDirectory($this->getFullPath());
    }

    /**
     * @return string
     */
    protected function getFullPath()
    {
        return $this->location.($this->name ? DIRECTORY_SEPARATOR.$this->name : '');
    }

    /**
     * @param string $directoryName
     * @return bool
     */
    protected function isValidDirectoryName($directoryName)
    {
        return strpbrk($directoryName, '\\/?%*:|"<>') === false;
    }

    /**
     * @return string
     */
    protected function getSystemTemporaryDirectory()
    {
        return rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR);
    }

    /**
     * @param $path
     * @return string
     */
    protected function sanitizePath($path)
    {
        $path = rtrim($path);

        return rtrim($path, DIRECTORY_SEPARATOR);
    }

    /**
     * @param string $name
     * @return string
     * @throws Exception
     */
    protected function sanitizeName($name)
    {
        if (! $this->isValidDirectoryName($name)) {
            throw new Exception("The directory name `$name` contains invalid characters.");
        }

        return trim($name);
    }

    /**
     * @param string $path
     * @return bool|string
     */
    protected function removeFilenameFromPath($path)
    {
        if (! $this->isFilePath($path)) {
            return $path;
        }

        return substr($path, 0, strrpos($path, DIRECTORY_SEPARATOR));
    }

    /**
     * @param string $path
     * @return bool
     */
    protected function isFilePath($path)
    {
        return strpos($path, '.') !== false;
    }

    /**
     * @param string $path
     * @return bool
     */
    protected function deleteDirectory($path)
    {
        if (! $this->filesystem->exists($path)) {
            return true;
        }

        if (! $this->filesystem->isDirectory($path)) {
            return $this->filesystem->delete($path);
        }

        foreach (scandir($path) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (! $this->deleteDirectory($path.DIRECTORY_SEPARATOR.$item)) {
                return false;
            }
        }

        return rmdir($path);
    }
}
