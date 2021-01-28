<?php


namespace Royalcms\Component\App;


class ApplicationDiscover
{

    /**
     * The royalcms implementation.
     *
     * @var \Royalcms\Component\Contracts\Foundation\Royalcms
     */
    protected $royalcms;

    /**
     * The filesystem instance.
     *
     * @var \Royalcms\Component\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The path to the manifest file.
     *
     * @var string
     */
    protected $manifestPath;

    /**
     * Create a new service repository instance.
     *
     * @param  \Royalcms\Component\Contracts\Foundation\Royalcms  $royalcms
     * @param  \Royalcms\Component\Filesystem\Filesystem  $files
     * @param  string  $manifestPath
     * @return void
     */
    public function __construct(RoyalcmsContract $royalcms, Filesystem $files, $manifestPath)
    {
        $this->royalcms = $royalcms;
        $this->files = $files;
        $this->manifestPath = $manifestPath;
    }

}