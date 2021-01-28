<?php

namespace Royalcms\Component\Image\Imagick\Commands;

class SharpenCommand extends \Royalcms\Component\Image\Commands\AbstractCommand
{
    /**
     * Sharpen image
     *
     * @param  \Royalcms\Component\Image\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $amount = $this->argument(0)->between(0, 100)->value(10);

        return $image->getCore()->unsharpMaskImage(1, 1, $amount / 6.25, 0);
    }
}
