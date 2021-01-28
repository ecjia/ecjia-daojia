<?php

namespace Royalcms\Component\Image\Imagick\Commands;

class GammaCommand extends \Royalcms\Component\Image\Commands\AbstractCommand
{
    /**
     * Applies gamma correction to a given image
     *
     * @param  \Royalcms\Component\Image\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $gamma = $this->argument(0)->type('numeric')->required()->value();

        return $image->getCore()->gammaImage($gamma);
    }
}
