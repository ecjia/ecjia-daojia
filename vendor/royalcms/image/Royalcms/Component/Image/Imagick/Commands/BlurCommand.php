<?php

namespace Royalcms\Component\Image\Imagick\Commands;

class BlurCommand extends \Royalcms\Component\Image\Commands\AbstractCommand
{
    /**
     * Applies blur effect on image
     *
     * @param  \Royalcms\Component\Image\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $amount = $this->argument(0)->between(0, 100)->value(1);

        return $image->getCore()->blurImage(1 * $amount, 0.5 * $amount);
    }
}
