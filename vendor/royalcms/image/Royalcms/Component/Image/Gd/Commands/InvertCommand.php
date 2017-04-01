<?php

namespace Royalcms\Component\Image\Gd\Commands;

class InvertCommand extends \Royalcms\Component\Image\Commands\AbstractCommand
{
    /**
     * Inverts colors of an image
     *
     * @param  \Royalcms\Component\Image\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        return imagefilter($image->getCore(), IMG_FILTER_NEGATE);
    }
}
