<?php

namespace Royalcms\Component\Image\Imagick\Commands;

class ResizeCommand extends \Royalcms\Component\Image\Commands\AbstractCommand
{
    /**
     * Resizes image dimensions
     *
     * @param  \Royalcms\Component\Image\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $width = $this->argument(0)->value();
        $height = $this->argument(1)->value();
        $constraints = $this->argument(2)->type('closure')->value();

        // resize box
        $resized = $image->getSize()->resize($width, $height, $constraints);

        // modify image
        $image->getCore()->scaleImage($resized->getWidth(), $resized->getHeight());

        return true;
    }
}
