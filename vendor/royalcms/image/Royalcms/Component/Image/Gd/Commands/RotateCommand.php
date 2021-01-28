<?php

namespace Royalcms\Component\Image\Gd\Commands;

use Royalcms\Component\Image\Gd\Color;

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
        $image->setCore(imagerotate($image->getCore(), $angle, $color->getInt()));

        return true;
    }
}
