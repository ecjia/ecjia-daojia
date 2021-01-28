<?php

namespace Royalcms\Component\Image\Gd\Commands;

use Royalcms\Component\Image\Size;

class GetSizeCommand extends \Royalcms\Component\Image\Commands\AbstractCommand
{
    /**
     * Reads size of given image instance in pixels
     *
     * @param  \Royalcms\Component\Image\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $this->setOutput(new Size(
            imagesx($image->getCore()),
            imagesy($image->getCore())
        ));

        return true;
    }
}
