<?php

namespace Royalcms\Component\Image\Imagick\Commands;

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
        return $image->getCore()->negateImage(false);
    }
}
