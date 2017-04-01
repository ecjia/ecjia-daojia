<?php

namespace Royalcms\Component\Image\Gd\Commands;

class BrightnessCommand extends \Royalcms\Component\Image\Commands\AbstractCommand
{
    /**
     * Changes image brightness
     *
     * @param  \Royalcms\Component\Image\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $level = $this->argument(0)->between(-100, 100)->required()->value();

        return imagefilter($image->getCore(), IMG_FILTER_BRIGHTNESS, ($level * 2.55));
    }
}
