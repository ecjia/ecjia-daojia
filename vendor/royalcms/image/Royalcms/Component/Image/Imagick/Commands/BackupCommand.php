<?php

namespace Royalcms\Component\Image\Imagick\Commands;

class BackupCommand extends \Royalcms\Component\Image\Commands\AbstractCommand
{
    /**
     * Saves a backups of current state of image core
     *
     * @param  \Royalcms\Component\Image\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $backupName = $this->argument(0)->value();

        // clone current image resource
        $image->setBackup(clone $image->getCore(), $backupName);

        return true;
    }
}
