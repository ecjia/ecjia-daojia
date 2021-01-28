<?php

namespace Royalcms\Component\Image\Gd\Commands;

use Royalcms\Component\Image\Gd\Decoder;
use Royalcms\Component\Image\Gd\Color;

class FillCommand extends \Royalcms\Component\Image\Commands\AbstractCommand
{
    /**
     * Fills image with color or pattern
     *
     * @param  \Royalcms\Component\Image\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $filling = $this->argument(0)->value();
        $x = $this->argument(1)->type('digit')->value();
        $y = $this->argument(2)->type('digit')->value();

        $width = $image->getWidth();
        $height = $image->getHeight();
        $resource = $image->getCore();

        try {

            // set image tile filling
            $source = new Decoder;
            $tile = $source->init($filling);
            imagesettile($image->getCore(), $tile->getCore());
            $filling = IMG_COLOR_TILED;

        } catch (\Royalcms\Component\Image\Exception\NotReadableException $e) {

            // set solid color filling
            $color = new Color($filling);
            $filling = $color->getInt();
        }

        imagealphablending($resource, true);

        if (is_int($x) && is_int($y)) {

            // resource should be visible through transparency
            $base = $image->getDriver()->newImage($width, $height)->getCore();
            imagecopy($base, $resource, 0, 0, 0, 0, $width, $height);

            // floodfill if exact position is defined
            imagefill($resource, $x, $y, $filling);

            // copy filled original over base
            imagecopy($base, $resource, 0, 0, 0, 0, $width, $height);

            // set base as new resource-core
            $image->setCore($base);
            imagedestroy($resource);

        } else {
            // fill whole image otherwise
            imagefilledrectangle($resource, 0, 0, $width - 1, $height - 1, $filling);
        }

        isset($tile) ? imagedestroy($tile->getCore()) : null;

        return true;
    }
}
