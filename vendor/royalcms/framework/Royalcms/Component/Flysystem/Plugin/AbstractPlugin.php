<?php namespace Royalcms\Component\Flysystem\Plugin;

use Royalcms\Component\Flysystem\FilesystemInterface;
use Royalcms\Component\Flysystem\PluginInterface;

abstract class AbstractPlugin implements PluginInterface
{
    /**
     * @var FilesystemInterface
     */
    protected $filesystem;

    /**
     * Set the Filesystem object.
     *
     * @param FilesystemInterface $filesystem
     */
    public function setFilesystem(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }
}
