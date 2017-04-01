<?php

namespace Royalcms\Component\Image\Gd\Commands;

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
        return imagefilter($image->getCore(), IMG_FILTER_GRAYSCALE);
    }
}
