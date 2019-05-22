<?php

namespace Royalcms\Component\Storage;

use InvalidArgumentException;
use League\Flysystem\Directory;
use League\Flysystem\File;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem as BaseFilesystem;
use League\Flysystem\Handler;
use League\Flysystem\RootViolationException;
use League\Flysystem\Util;
use League\Flysystem\Util\ContentListingFormatter;
use RC_Log;
use Royalcms\Component\Storage\Contracts\StorageInterface;
use Royalcms\Component\Storage\Exceptions\AdapterNotStorageInterfaceException;

class Filesystem extends BaseFilesystem
{
    /**
     * @inheritdoc
     */
    public function has($path)
    {
        return strlen($path) === 0 ? false : (bool) $this->getAdapter()->has($path);
    }

    /**
     * @inheritdoc
     */
    public function write($path, $contents, array $config = [])
    {
        $this->assertAbsent($path);
        $config = $this->prepareConfig($config);

        return (bool) $this->getAdapter()->write($path, $contents, $config);
    }

    /**
     * @inheritdoc
     */
    public function writeStream($path, $resource, array $config = [])
    {
        if ( ! is_resource($resource)) {
            throw new InvalidArgumentException(__METHOD__ . ' expects argument #2 to be a valid resource.');
        }

        $this->assertAbsent($path);
        $config = $this->prepareConfig($config);

        Util::rewindStream($resource);

        return (bool) $this->getAdapter()->writeStream($path, $resource, $config);
    }

    /**
     * @inheritdoc
     */
    public function put($path, $contents, array $config = [])
    {
        $config = $this->prepareConfig($config);

        if ($this->has($path)) {
            return (bool) $this->getAdapter()->update($path, $contents, $config);
        }

        return (bool) $this->getAdapter()->write($path, $contents, $config);
    }

    /**
     * @inheritdoc
     */
    public function putStream($path, $resource, array $config = [])
    {
        if ( ! is_resource($resource)) {
            throw new InvalidArgumentException(__METHOD__ . ' expects argument #2 to be a valid resource.');
        }

        $config = $this->prepareConfig($config);
        Util::rewindStream($resource);

        if ($this->has($path)) {
            return (bool) $this->getAdapter()->updateStream($path, $resource, $config);
        }

        return (bool) $this->getAdapter()->writeStream($path, $resource, $config);
    }

    /**
     * @inheritdoc
     */
    public function readAndDelete($path)
    {
        $this->assertPresent($path);
        $contents = $this->read($path);

        if ($contents === false) {
            return false;
        }

        $this->delete($path);

        return $contents;
    }

    /**
     * @inheritdoc
     */
    public function update($path, $contents, array $config = [])
    {
        $config = $this->prepareConfig($config);

        $this->assertPresent($path);

        return (bool) $this->getAdapter()->update($path, $contents, $config);
    }

    /**
     * @inheritdoc
     */
    public function updateStream($path, $resource, array $config = [])
    {
        if ( ! is_resource($resource)) {
            throw new InvalidArgumentException(__METHOD__ . ' expects argument #2 to be a valid resource.');
        }

        $config = $this->prepareConfig($config);
        $this->assertPresent($path);
        Util::rewindStream($resource);

        return (bool) $this->getAdapter()->updateStream($path, $resource, $config);
    }

    /**
     * @inheritdoc
     */
    public function read($path)
    {
        $this->assertPresent($path);

        if ( ! ($object = $this->getAdapter()->read($path))) {
            return false;
        }

        return $object['contents'];
    }

    /**
     * @inheritdoc
     */
    public function readStream($path)
    {
        $this->assertPresent($path);

        if ( ! $object = $this->getAdapter()->readStream($path)) {
            return false;
        }

        return $object['stream'];
    }

    /**
     * @inheritdoc
     */
    public function rename($path, $newpath)
    {
        $this->assertPresent($path);
        $this->assertAbsent($newpath);

        return (bool) $this->getAdapter()->rename($path, $newpath);
    }

    /**
     * @inheritdoc
     */
    public function copy($path, $newpath)
    {
        $this->assertPresent($path);
        $this->assertAbsent($newpath);

        return $this->getAdapter()->copy($path, $newpath);
    }

    /**
     * @inheritdoc
     */
    public function delete($path)
    {
        try {
            $this->assertPresent($path);

            return $this->getAdapter()->delete($path);
        }
        catch (FileNotFoundException $e) {
            RC_Log::warning($e);
        }
    }

    /**
     * @inheritdoc
     */
    public function deleteDir($dirname)
    {
        if ($dirname === '') {
            throw new RootViolationException('Root directories can not be deleted.');
        }

        return (bool) $this->getAdapter()->deleteDir($dirname);
    }

    /**
     * @inheritdoc
     */
    public function createDir($dirname, array $config = [])
    {
        $config = $this->prepareConfig($config);

        return (bool) $this->getAdapter()->createDir($dirname, $config);
    }

    /**
     * @inheritdoc
     */
    public function listContents($directory = '', $recursive = false)
    {
        $contents = $this->getAdapter()->listContents($directory, $recursive);

        return (new ContentListingFormatter($directory, $recursive))->formatListing($contents);
    }

    /**
     * @inheritdoc
     */
    public function getMimetype($path)
    {
        $this->assertPresent($path);

        if ( ! $object = $this->getAdapter()->getMimetype($path)) {
            return false;
        }

        return $object['mimetype'];
    }

    /**
     * @inheritdoc
     */
    public function getTimestamp($path)
    {
        $this->assertPresent($path);

        if ( ! $object = $this->getAdapter()->getTimestamp($path)) {
            return false;
        }

        return $object['timestamp'];
    }

    /**
     * @inheritdoc
     */
    public function getVisibility($path)
    {
        $this->assertPresent($path);

        if (($object = $this->getAdapter()->getVisibility($path)) === false) {
            return false;
        }

        return $object['visibility'];
    }

    /**
     * @inheritdoc
     */
    public function getSize($path)
    {
        if (($object = $this->getAdapter()->getSize($path)) === false || ! isset($object['size'])) {
            return false;
        }

        return (int) $object['size'];
    }

    /**
     * @inheritdoc
     */
    public function setVisibility($path, $visibility)
    {
        return (bool) $this->getAdapter()->setVisibility($path, $visibility);
    }

    /**
     * @inheritdoc
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function getMetadata($path)
    {
        $this->assertPresent($path);

        return $this->getAdapter()->getMetadata($path);
    }

    /**
     * @inheritdoc
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function get($path, Handler $handler = null)
    {
        if ( ! $handler) {
            $metadata = $this->getMetadata($path);
            $handler = $metadata['type'] === 'file' ? new File($this, $path) : new Directory($this, $path);
        }

        $handler->setPath($path);
        $handler->setFilesystem($this);

        return $handler;
    }


    /**
     * Assert a adapter is StorageInterface instance.
     *
     * @throws AdapterNotStorageInterfaceException
     *
     * @return void
     */
    public function assertStorageInterface()
    {
        if (! ($this->getAdapter() instanceof StorageInterface)) {
            throw new AdapterNotStorageInterfaceException('This adapter not `StorageInterface` instance.');
        }
    }


    public function move_uploaded_file($filename, $destination)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->move_uploaded_file($filename, $destination);
    }

    /**
     * Reads entire file into a string
     * @param string $file
     *            Name of the file to read.
     * @return string bool function returns the read data or false on failure.
     */
    public function get_contents($file)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->get_contents($file);
    }

    /**
     * Reads entire file into an array
     * @param string $file
     *            Path to the file.
     * @return array bool file contents in an array or false on failure.
     */
    public function get_contents_array($file)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->get_contents_array($file);
    }

    /**
     * Write a string to a file
     * @param string $file
     *            Remote path to the file where to write the data.
     * @param string $contents
     *            The data to write.
     * @param int $mode
     *            (optional) The file permissions as octal number, usually 0644.
     * @return bool False upon failure.
     */
    public function put_contents($file, $contents, $mode = false)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->put_contents($file, $contents, $mode);
    }

    /**
     * Gets the current working directory
     * @return string bool current working directory on success, or false on failure.
     */
    public function cwd()
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->cwd();
    }

    /**
     * Change directory
     * @param string $dir The new current directory.
     * @return bool Returns true on success or false on failure.
     */
    public function chdir($dir)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->chdir($dir);
    }

    /**
     * Changes file group
     * @param string $file Path to the file.
     * @param mixed $group A group name or number.
     * @param bool $recursive (optional) If set True changes file group recursively. Defaults to False.
     * @return bool Returns true on success or false on failure.
     */
    public function chgrp($file, $group, $recursive = false)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->chgrp($file, $group, $recursive);
    }


    /**
     * Changes filesystem permissions
     * @param string $file
     *            Path to the file.
     * @param int $mode
     *            (optional) The permissions as octal number, usually 0644 for files, 0755 for dirs.
     * @param bool $recursive
     *            (optional) If set True changes file group recursively. Defaults to False.
     * @return bool Returns true on success or false on failure.
     */
    public function chmod($file, $mode = false, $recursive = false)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->chmod($file, $mode, $recursive);
    }


    /**
     * Changes file owner
     * @param string $file
     *            Path to the file.
     * @param mixed $owner
     *            A user name or number.
     * @param bool $recursive
     *            (optional) If set True changes file owner recursively. Defaults to False.
     * @return bool Returns true on success or false on failure.
     */
    public function chown($file, $owner, $recursive = false)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->chmod($file, $owner, $recursive);
    }

    /**
     * Gets file owner
     * @param string $file
     *            Path to the file.
     * @return string bool of the user or false on error.
     */
    public function owner($file)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->owner($file);
    }

    public function group($file)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->group($file);
    }

    public function move($source, $destination, $overwrite = false, $mode = false)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->move($source, $destination, $overwrite, $mode);
    }

    /**
     * @param $path
     * @return array|bool|null
     */
    public function exists($path)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->exists($path);
    }

    /**
     * @param $path
     * @return bool
     */
    public function is_file($path)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->is_file($path);
    }

    /**
     * @param $path
     * @return bool
     */
    public function is_dir($path)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->is_dir($path);
    }

    /**
     * @param $path
     * @return bool
     */
    public function is_readable($path)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->is_readable($path);
    }

    /**
     * @param $path
     * @return bool
     */
    public function is_writable($path)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->is_writable($path);
    }

    /**
     * @param $path
     * @return bool|int
     */
    public function atime($path)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->atime($path);
    }

    /**
     * @param $path
     * @return bool|int
     */
    public function mtime($path)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->mtime($path);
    }

    /**
     * @param $path
     * @return int
     */
    public function size($path)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->size($path);
    }

    /**
     * @param $file
     * @param int $time
     * @param int $atime
     * @return bool
     */
    public function touch($path, $time = 0, $atime = 0)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->touch($path, $time, $atime);
    }

    public function mkdir($path, $chmod = false, $chown = false, $chgrp = false)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->mkdir($path, $chmod, $chown, $chgrp);
    }

    public function rmdir($path, $recursive = false)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->rmdir($path, $recursive);
    }

    public function dirlist($path, $include_hidden = true, $recursive = false)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->dirlist($path, $include_hidden, $recursive);
    }

    /**
     * 获取目录下的指定类型的文件列表
     * @param $path
     * @param array $files
     * @return array
     */
    public function filelist($path, $allowFiles, $start, $size)
    {
        $this->assertStorageInterface();

        return $this->getAdapter()->filelist($path, $allowFiles, $start, $size);
    }

}