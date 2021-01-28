<?php

namespace Royalcms\Component\Image\Imagick\Commands;

use Royalcms\Component\Image\Size;

class GetSizeCommand extends \Royalcms\Component\Image\Commands\AbstractCommand
{
    /**
     * Reads size of given image instance in pixels
     *
     * @param  \Royalcms\Component\Image\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        /** @var \Imagick $core */
        $core = $image->getCore();

        $this->setOutput(new Size(
            $core->getImageWidth(),
            $core->getImageHeight()
        ));

        return true;
    }
}
