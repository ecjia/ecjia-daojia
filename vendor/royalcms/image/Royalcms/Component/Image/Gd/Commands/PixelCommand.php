<?php

namespace Royalcms\Component\Image\Gd\Commands;

use Royalcms\Component\Image\Gd\Color;

class PixelCommand extends \Royalcms\Component\Image\Commands\AbstractCommand
{
    /**
     * Draws one pixel to a given image
     *
     * @param  \Royalcms\Component\Image\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $color = $this->argument(0)->required()->value();
        $color = new Color($color);
        $x = $this->argument(1)->type('digit')->required()->value();
        $y = $this->argument(2)->type('digit')->required()->value();

        return imagesetpixel($image->getCore(), $x, $y, $color->getInt());
    }
}
