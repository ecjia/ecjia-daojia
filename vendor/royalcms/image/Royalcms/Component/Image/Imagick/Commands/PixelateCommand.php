<?php

namespace Royalcms\Component\Image\Imagick\Commands;

class PixelateCommand extends \Royalcms\Component\Image\Commands\AbstractCommand
{
    /**
     * Applies a pixelation effect to a given image
     *
     * @param  \Royalcms\Component\Image\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $size = $this->argument(0)->type('digit')->value(10);

        $width = $image->getWidth();
        $height = $image->getHeight();

        $image->getCore()->scaleImage(max(1, ($width / $size)), max(1, ($height / $size)));
        $image->getCore()->scaleImage($width, $height);

        return true;
    }
}
