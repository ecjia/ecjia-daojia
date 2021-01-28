<?php

namespace Royalcms\Component\Image\Imagick\Commands;

use Royalcms\Component\Image\Imagick\Color;

class RotateCommand extends \Royalcms\Component\Image\Commands\AbstractCommand
{
    /**
     * Rotates image counter clockwise
     *
     * @param  \Royalcms\Component\Image\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $angle = $this->argument(0)->type('numeric')->required()->value();
        $color = $this->argument(1)->value();
        $color = new Color($color);

        // rotate image
        $image->getCore()->rotateImage($color->getPixel(), ($angle * -1));

        return true;
    }
}
