<?php

namespace Royalcms\Component\Uploader;

use Closure;
use BadMethodCallException;
use Royalcms\Component\Support\Str;
use Royalcms\Component\Config\Repository as Config;
use Royalcms\Component\Uploader\Contracts\Provider;
use Royalcms\Component\Filesystem\FilesystemManager;
use Royalcms\Component\Uploader\Contracts\Uploader as UploaderContract;

class Uploader implements UploaderContract
{
    /**
     * The file storage where the file will be uploaded.
     *
     * @var string
     */
    public $disk;

    /**
     * The name of file.
     *
     * @var string
     */
    public $filename;

    /**
     * The file visibility.
     *
     * @var string|null
     */
    public $visibility;

    /**
     * The file exists is allow replaced.
     *
     * @var bool
     */
    public $replace = true;

    /**
     * The folder where the file will be stored.
     *
     * @var string
     */
    public $folder = '';

    /**
     * The Config implementation.
     *
     * @var \Royalcms\Component\Config\Repository
     */
    protected $config;

    /**
     * The file provider implementation.
     *
     * @var \Royalcms\Component\Uploader\Contracts\Provider
     */
    protected $provider;

    /**
     * The FilesystemManager implementation.
     *
     * @var \Royalcms\Component\Filesystem\FilesystemManager
     */
    protected $filesystem;

    /**
     * @var callable
     */
    protected $uploadSavingCallback;

    /**
     * Create a new Uploader instance.
     *
     * @param  \Royalcms\Component\Config\Repository  $config
     * @param  \Royalcms\Component\Filesystem\FilesystemManager  $filesystem
     * @param  \Royalcms\Component\Uploader\Contracts\Provider  $provider
     * @return void
     */
    public function __construct(Config $config, FilesystemManager $filesystem, Provider $provider)
    {
        $this->config = $config;
        $this->provider = $provider;
        $this->filesystem = $filesystem;
    }

    /**
     * Specify the file storage where the file will be uploaded.
     *
     * @param  string  $disk
     * @return \Royalcms\Component\Uploader\Contracts\Uploader
     */
    public function uploadTo($disk)
    {
        $this->disk = $disk;

        return $this;
    }

    /**
     * Specify the folder where the file will be stored.
     *
     * @param  string  $folder
     * @return \Royalcms\Component\Uploader\Contracts\Uploader
     */
    public function toFolder($folder)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * Rename the uploaded file to given new name.
     *
     * @param  string  $newName
     * @return \Royalcms\Component\Uploader\Contracts\Uploader
     */
    public function renameTo($newName)
    {
        $this->filename = $newName;

        return $this;
    }

    /**
     * Set the replace of the exists file.
     *
     * @param  bool  $replace
     * @return \Royalcms\Component\Uploader\Contracts\Uploader
     */
    public function setReplace($replace)
    {
        $this->replace = $replace;

        return $this;
    }

    /**
     * Set the replace of the exists file.
     *
     * @param  callable  $callback
     * @return \Royalcms\Component\Uploader\Contracts\Uploader
     */
    public function setUploadSavingCallback($callback)
    {
        $this->uploadSavingCallback = $callback;

        return $this;
    }

    /**
     * Set the visibility of the file.
     *
     * @param  string  $visibility
     * @return \Royalcms\Component\Uploader\Contracts\Uploader
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * Upload the file on a file storage.
     *
     * @param  string  $file
     * @param  \Closure|null $callback
     * @return bool
     */
    public function upload($file, Closure $callback = null)
    {
        $uploadedFile = $this->runUpload($file);

        if (! $uploadedFile) {
            return false;
        }

        if ($callback) {
            $callback($uploadedFile);
        }

        return true;
    }

    /**
     * Get the file visibility.
     *
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility ?: $this->getDefaultVisibility();
    }

    /**
     * Get the default file visibility.
     *
     * @return string
     */
    public function getDefaultVisibility()
    {
        return $this->config->get('uploader.visibility') ?: 'private';
    }

    /**
     * Upload the given file and returns the filename if succeed.
     *
     * @param  string  $file
     * @return string|bool
     *
     * @throws \Royalcms\Component\Uploader\InvalidFileException
     */
    protected function runUpload($file)
    {
        $this->provider->setFile($file);

        if (! $this->provider->isValid()) {
            throw new InvalidFileException("Given file [{$file}] is invalid.");
        }

        $filename = $this->getFullFileName($this->provider);

        if (! $this->replace) {
            if ($this->filesystem->disk($this->disk)->exists($filename)) {
                throw new InvalidFileException("Given file [{$filename}] is exists.");
            }
        }

        /* Saving file */
        if (is_callable($this->uploadSavingCallback)) {

            $saving_callback = $this->uploadSavingCallback;

            return $saving_callback($this->provider, $filename);
        }
        else {

            if ($this->putDiskFile($filename)) {
                return $filename;
            }

            return false;

        }
    }

    /**
     * Put the filename to disk storage.
     * @param $filename
     * @return bool
     */
    protected function putDiskFile($filename)
    {
        return $this->filesystem
            ->disk($this->disk)
            ->put($filename, $this->provider->getContents(), $this->getVisibility());
    }

    /**
     * Get the full filename.
     *
     * @param  \Royalcms\Component\Uploader\Contracts\Provider  $provider
     * @return string
     */
    protected function getFullFileName(Provider $provider)
    {
        $folder = $this->folder ? rtrim($this->folder, '/').'/' : '';

        if ($this->filename) {
            $filename = $this->filename;
        } else {
            $filename = md5(uniqid(microtime(true), true));
        }

        return $folder.$filename.'.'.$provider->getExtension();
    }

    /**
     * Handle dynamic "uploadTo" method calls.
     *
     * @param  string  $uploadTo
     * @return \Royalcms\Component\Uploader\Contracts\Uploader
     */
    protected function dynamicUploadTo($uploadTo)
    {
        $disk = Str::snake(substr($uploadTo, 8));

        return $this->uploadTo($disk);
    }

    /**
     * Handle dynamic method calls into the method.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if (Str::startsWith($method, 'uploadTo')) {
            return $this->dynamicUploadTo($method);
        }

        $className = static::class;

        throw new BadMethodCallException("Call to undefined method {$className}::{$method}()");
    }
}
