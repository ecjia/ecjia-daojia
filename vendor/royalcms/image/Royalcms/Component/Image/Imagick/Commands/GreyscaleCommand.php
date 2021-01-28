<?php

namespace Royalcms\Component\Image\Imagick\Commands;

class GreyscaleCommand extends \Royalcms\Component\Image\Commands\AbstractCommand
{
    /**
     * Turns an image into a greyscale version
     *
     * @param  \Royalcms\Component\Image\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        return $image->getCore()->modulateImage(100, 0, 100);
    }
}
